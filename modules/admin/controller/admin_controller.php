<?php
session_start();
$session_user_id = $_SESSION["id"];
$church_id = $_SESSION["church_id"];
$user_role = $_SESSION["role"];
require "../model/admin_queries.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_request = filter_input(INPUT_POST, 'user_request');
} else {
    $user_request = filter_input(INPUT_GET, 'user_request');
}

switch ($user_request) {
    case 'fetch_admin_data':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            ob_start();
            include '../admin.php';
            $content = ob_get_clean();

            echo json_encode(['status' => 'success', 'message' => 'Login Successfully', 'view' => $content]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'fetch_users':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $users = fetch_users($db, $church_id);

            ob_start();
            include '../components/users/users.php';
            $content = ob_get_clean();

            if (empty($users)) {
                $content = '<div class="alert alert-info">No users found.</div>';
            }

            echo json_encode(['status' => 'success', 'message' => 'Users fetched successfully', 'view' => $content]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'fetch_teams':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $teams = fetch_teams($db, $church_id);

            ob_start();
            include '../components/teams/teams.php';
            $content = ob_get_clean();

            if (empty($teams)) {
                $content = '<div class="alert alert-info">No Teams found.</div>';
            }

            echo json_encode(['status' => 'success', 'message' => 'Teams fetched successfully', 'view' => $content]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'fetch_team_details':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $team_id = filter_input(INPUT_POST, 'team_id', FILTER_SANITIZE_NUMBER_INT);
            $team = fetch_team_details($db, $team_id, $church_id);
            $team_members = fetch_team_members($db, $team_id, $church_id);


            if ($team) {
                ob_start();
                include '../components/teams/components/modal/team_details_modal.php';
                $content = ob_get_clean();

                echo json_encode(['status' => 'success', 'message' => 'Team details fetched successfully', 'view' => $content]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Team not found']);
            }
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'fetch_services':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $services = fetch_services($db, $church_id);

            ob_start();
            include '../components/services/services.php';
            $content = ob_get_clean();

            // if (empty($users)) {
            //     $content = '<div class="alert alert-info">No users found.</div>';
            // }   

            echo json_encode(['status' => 'success', 'message' => 'Users fetched successfully', 'view' => $content]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'create_service_modal':
        try {
            ob_start();
            include '../components/services/components/modal/create_service_modal.php';
            $content = ob_get_clean();

            echo json_encode(['status' => 'success', 'message' => 'Create service modal loaded', 'view' => $content]);
        } catch (Exception $e) {
            error_log('Error loading create service modal: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Failed to load create service modal']);
        }
        break;

    case 'create_service':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);
            $db->beginTransaction();

            $title = filter_input(INPUT_POST, 'title');
            $service_date = filter_input(INPUT_POST, 'service_date');
            $start_time = filter_input(INPUT_POST, 'start_time');
            $notes = filter_input(INPUT_POST, 'notes');

            if (!$title || !$service_date || !$start_time) {
                throw new Exception('Title, date and start time are required.');
            }

            $service_id = create_service($db, $church_id, $title, $service_date, $start_time, $notes, $session_user_id);
            // Agregar segmentos base automáticamente
            create_default_segments($db, $service_id, $church_id);

            $db->commit();
            echo json_encode(['status' => 'success', 'message' => 'Service created successfully', 'service_id' => $service_id]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'fetch_view_service':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $service_id = filter_input(INPUT_POST, 'service_id');

            // Traer datos del servicio
            $service = fetch_service_details($db, $service_id, $church_id);
            $segments = fetch_segments_by_service_id($db, $service_id);
            $is_admin = $_SESSION['role'] === 'admin';
            $user_teams = fetch_teams_by_user_id($db, $session_user_id);

            if ($service) {
                ob_start();
                include '../components/services/components/modal/service_details.php';
                $content = ob_get_clean();

                echo json_encode(['status' => 'success', 'message' => 'Service details fetched successfully', 'view' => $content, 'is_admin' => $is_admin, 'user_teams' => $user_teams]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Service not found']);
            }
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;
}
