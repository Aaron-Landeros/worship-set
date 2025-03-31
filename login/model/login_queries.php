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
        $query = 'SELECT *
                    FROM users
                    WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;

    } catch(PDOException $e) {
        error_log("Database error in fetch_users: " . $e->getMessage());
        throw $e;
    } catch (Exception $e) {
        error_log("Error in fetch_users: " . $e->getMessage());
        throw $e;
    }
}

?>