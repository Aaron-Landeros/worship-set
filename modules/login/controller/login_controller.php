<?php
session_start();
require "../model/login_queries.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_request = filter_input(INPUT_POST, 'user_request');
} else {
    $user_request = filter_input(INPUT_GET, 'user_request');
}

switch ($user_request) {
    case 'verify_login':
        try{
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            
            if (!verify_login($db, $email, $password)) {
                echo json_encode(['status' => 'error', 'message' => 'Email or Password Incorrect']);
                break;  // Exit early if login fails
            } else {
                $user_data = fetch_users($db, $email);
    
                $_SESSION["id"] = $user_data['id'];  // Cambié $data['id'] por $user_data['id']
                $_SESSION["church_id"] = $user_data['church_id'];
                $_SESSION["name"] = $user_data['name'];
                $_SESSION["email"] = $user_data['email'];
                $_SESSION["role"] = $user_data['role'];
                $_SESSION["team_id"] = $user_data['team_id'] ?? null;  // Manejo de team_id si no existe
                $_SESSION["is_leader"] = $user_data['is_leader'] ?? false;  // Manejo de is_leader si no existe
                $_SESSION["position"] = $user_data['position'] ?? null;  // Manejo de position si no existe
                $_SESSION["teams"] = $user_data['teams'] ?? [];
                $_SESSION["leader_teams"] = $user_data['leader_teams'] ?? [];


               
                ob_start();
                include '../components/redirect_user_script.php';
                $content = ob_get_clean(); 
                echo json_encode(['status' => 'success', 'message' => 'Login Successfully', 'view' => $content]);
                  
            }
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        } 
    break;

        
}
?>
