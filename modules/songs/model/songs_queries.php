<?php 

    function fetch_song_details($db, $song_id, $church_id) {
        try {
            $query = "SELECT * FROM songs WHERE id = :song_id AND church_id = :church_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':song_id', $song_id, PDO::PARAM_INT);
            $stmt->bindValue(':church_id', $church_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    function update_song($db, $song_id, $title, $artist, $key_signature, $bpm, $album_art_url, $lyrics, $lyrics_file_url, $notes, $notes_file_url) {
        try {
            $query = "UPDATE songs SET title = :title, artist = :artist, key_signature = :key_signature, bpm = :bpm, 
                      album_art_url = :album_art_url, lyrics = :lyrics, lyrics_file_url = :lyrics_file_url, 
                      notes = :notes, notes_file_url = :notes_file_url WHERE id = :song_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':artist', $artist);
            $stmt->bindValue(':key_signature', $key_signature);
            $stmt->bindValue(':bpm', $bpm, PDO::PARAM_INT);
            $stmt->bindValue(':album_art_url', $album_art_url);
            $stmt->bindValue(':lyrics', $lyrics);
            $stmt->bindValue(':lyrics_file_url', $lyrics_file_url);
            $stmt->bindValue(':notes', $notes);
            $stmt->bindValue(':notes_file_url', $notes_file_url);
            $stmt->bindValue(':song_id', $song_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            throw new Exception('Failed to update song: ' . $e->getMessage());
        }
    }

    function create_song($db, $church_id, $session_user_id, $title, $artist, $key_signature, $bpm, $album_art_url, $lyrics, $lyrics_file_url, $notes, $notes_file_url) {
        try {
            $query = "INSERT INTO songs (church_id, title, artist, key_signature, bpm, album_art_url, lyrics, lyrics_file_url, notes, notes_file_url) 
                      VALUES (:church_id, :title, :artist, :key_signature, :bpm, :album_art_url, :lyrics, :lyrics_file_url, :notes, :notes_file_url)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':church_id', $church_id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':artist', $artist);
            $stmt->bindValue(':key_signature', $key_signature);
            $stmt->bindValue(':bpm', $bpm, PDO::PARAM_INT);
            $stmt->bindValue(':album_art_url', $album_art_url);
            $stmt->bindValue(':lyrics', $lyrics);
            $stmt->bindValue(':lyrics_file_url', $lyrics_file_url);
            $stmt->bindValue(':notes', $notes);
            $stmt->bindValue(':notes_file_url', $notes_file_url);
            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            throw new Exception('Failed to create song: ' . $e->getMessage());
        }
    }
