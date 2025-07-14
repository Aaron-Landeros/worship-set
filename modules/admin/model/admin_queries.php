<?php
    function fetch_users($db, $church_id) {
        try {
            $query = "SELECT 
                    users.*, 
                    teams.name AS team_name,
                    team_members.is_leader,
                    team_members.position
                FROM users
                LEFT JOIN team_members ON users.id = team_members.user_id
                LEFT JOIN teams ON team_members.team_id = teams.id
                WHERE users.church_id = :church_id
            ";

            $stmt = $db->prepare($query);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_users: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_users: " . $e->getMessage());
            throw $e;
        }
    }


    function fetch_teams($db, $church_id) {
        try {
            $query = "SELECT 
                    teams.*, 
                    churches.name as church_name
                FROM teams
                LEFT JOIN churches ON teams.church_id = churches.id
                WHERE teams.church_id = :church_id
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_teams: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_teams: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_team_details($db, $team_id, $church_id) {
        try {
            $query = "SELECT 
                    teams.*, 
                    users.name AS leader_name,
                    users.id AS leader_id,
                    churches.name as church_name
                FROM teams
                LEFT JOIN team_members ON teams.id = team_members.team_id AND team_members.is_leader = 1
                LEFT JOIN users ON team_members.user_id = users.id
                LEFT JOIN churches ON teams.church_id = churches.id
                WHERE teams.id = :team_id AND teams.church_id = :church_id
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':team_id', $team_id);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_team_details: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_team_details: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_team_members($db, $team_id) {
        try {
            $query = "SELECT 
                    users.id AS user_id, 
                    users.name AS user_name, 
                    team_members.is_leader,
                    team_members.position
                FROM team_members
                JOIN users ON team_members.user_id = users.id
                WHERE team_members.team_id = :team_id
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':team_id', $team_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_team_members: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_team_members: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_team_leaders($db, $team_id) {
        try {
            $query = "SELECT
                    team_members.position,
                    users.id AS user_id, 
                    users.name AS user_name
                FROM team_members
                JOIN users ON team_members.user_id = users.id
                WHERE team_members.team_id = :team_id AND team_members.is_leader = 1
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':team_id', $team_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_team_leaders: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_team_leaders: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_services($db, $church_id) {
        try {
            $query = "SELECT 
                    services.*, 
                    churches.name as church_name
                FROM services
                LEFT JOIN churches ON services.church_id = churches.id
                WHERE services.church_id = :church_id
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_services: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_services: " . $e->getMessage());
            throw $e;
        }
    }

    function create_service($db, $church_id, $title, $service_date, $start_time, $notes = null, $created_by = null) {
        try {
            $query = "INSERT INTO services (church_id, title, service_date, start_time, notes, created_by) 
                      VALUES (:church_id, :title, :service_date, :start_time, :notes, :created_by)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':service_date', $service_date);
            $stmt->bindValue(':start_time', $start_time);
            $stmt->bindValue(':notes', $notes);
            $stmt->bindValue(':created_by', $created_by);
            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error in create_service: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in create_service: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_service_details($db, $service_id, $church_id) {
        try {
            $query = "SELECT 
                    services.*, 
                    churches.name as church_name
                FROM services
                LEFT JOIN churches ON services.church_id = churches.id
                WHERE services.id = :service_id AND services.church_id = :church_id
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':service_id', $service_id);
            $stmt->bindValue(':church_id', $church_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_service_details: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            error_log("Error in fetch_service_details: " . $e->getMessage());
            throw $e;
        }
    }

    function fetch_segments_by_service_id($db, $service_id) {
        try {
            $query = "SELECT ss.*, 
                    t.name AS team_name
                FROM service_segments ss
                LEFT JOIN teams t ON ss.team_id = t.id
                WHERE ss.service_id = :service_id
                ORDER BY ss.order_index ASC
            ";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':service_id', $service_id);
            $stmt->execute();
            $segments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($segments as &$segment) {
                // Obtener assignments
                $assignment_query = "SELECT sa.*, u.name AS user_name
                    FROM segment_assignments sa
                    LEFT JOIN users u ON sa.user_id = u.id
                    WHERE sa.segment_id = :segment_id
                ";
                $stmt_assign = $db->prepare($assignment_query);
                $stmt_assign->bindValue(':segment_id', $segment['id']);
                $stmt_assign->execute();
                $segment['assignments'] = $stmt_assign->fetchAll(PDO::FETCH_ASSOC);

                // Obtener contenidos extras (opcional)
                $content_query = "SELECT content_type, content
                    FROM segment_content
                    WHERE segment_id = :segment_id
                ";
                $stmt_content = $db->prepare($content_query);
                $stmt_content->bindValue(':segment_id', $segment['id']);
                $stmt_content->execute();
                $segment['extra_contents'] = $stmt_content->fetchAll(PDO::FETCH_ASSOC);
            }

            return $segments;

        } catch (PDOException $e) {
            error_log("Error in fetch_segments_by_service_id: " . $e->getMessage());
            throw $e;
        }
    }


    function fetch_teams_by_user_id($db, $user_id) {
        try {
            $query = "SELECT 
                        teams.id, 
                        teams.name 
                    FROM team_members
                    JOIN teams ON team_members.team_id = teams.id
                    WHERE team_members.user_id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in fetch_teams_by_user_id: " . $e->getMessage());
            throw $e;
        }
    }


    function create_default_segments($db, $service_id, $church_id) {
        // Lista de teams y títulos base
        $segments = [
            ['team_name' => 'Worship Team',         'title' => 'Worship Set',       'order_index' => 1],
            ['team_name' => 'Consola',          'title' => 'Audio Setup',       'order_index' => 2],
            ['team_name' => 'Medios',           'title' => 'Visuals',           'order_index' => 4],
            ['team_name' => 'Redes',            'title' => 'Social Media Post', 'order_index' => 5],
            ['team_name' => 'Pastor/Predicador','title' => 'Mensaje',           'order_index' => 6]
        ];

        foreach ($segments as $seg) {
            // Obtener el ID del equipo según nombre e iglesia
            $stmt = $db->prepare("SELECT id FROM teams WHERE church_id = :church_id AND name = :name");
            $stmt->execute([':church_id' => $church_id, ':name' => $seg['team_name']]);
            $team = $stmt->fetch(PDO::FETCH_ASSOC);

            $team_id = $team ? $team['id'] : null;

            $stmt = $db->prepare("INSERT INTO service_segments (service_id, team_id, title, order_index)
                                VALUES (:service_id, :team_id, :title, :order_index)");
            $stmt->execute([
                ':service_id'   => $service_id,
                ':team_id'      => $team_id,
                ':title'        => $seg['title'],
                ':order_index'  => $seg['order_index']
            ]);
        }
    }
