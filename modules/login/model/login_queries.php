<?php

function verify_login($db, $email, $password){
    try{
        $query = 'SELECT password
                    FROM users
                    WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);  // Cambié $email por $user_email
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row) {
            $hash = $row['password'];
            return password_verify($password, $hash);
        } else {
            return false;  // Retorna false si no se encuentra el usuario
        }

    } catch(PDOException $e) {
        error_log("Database error in verify_login: " . $e->getMessage());
        throw $e;
    } catch (Exception $e) {
        error_log("Error in verify_login: " . $e->getMessage());
        throw $e;
    }
}



function fetch_users($db, $email){
    try{
        // Datos del usuario
        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        $stmt->closeCursor();

        if ($user) {
            // Equipos donde es miembro
            $stmt = $db->prepare('SELECT tm.team_id, t.name FROM team_members tm 
                                  JOIN teams t ON tm.team_id = t.id
                                  WHERE tm.user_id = :user_id');
            $stmt->execute([':user_id' => $user['id']]);
            $user['teams'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Equipos donde es líder
            $stmt = $db->prepare('SELECT tm.team_id, t.name FROM team_members tm 
                                  JOIN teams t ON tm.team_id = t.id
                                  WHERE tm.user_id = :user_id AND tm.is_leader = 1');
            $stmt->execute([':user_id' => $user['id']]);
            $user['leader_teams'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $user;

    } catch(PDOException $e) {
        error_log("Database error in fetch_users: " . $e->getMessage());
        throw $e;
    }
}



?>