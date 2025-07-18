<?php
session_start();
$session_user_id = $_SESSION["id"];
$church_id = $_SESSION["church_id"];
$user_role = $_SESSION["role"];
require '../../admin/model/admin_queries.php';
require "../model/songs_queries.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_request = filter_input(INPUT_POST, 'user_request');
} else {
    $user_request = filter_input(INPUT_GET, 'user_request');
}

switch ($user_request) {
    case 'fetch_songs':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $songs = fetch_all_songs($db, $church_id);
            ob_start();
            include '../songs.php';
            $content = ob_get_clean();  
            if (empty($songs)) {
                $content = '<div class="alert alert-info">No songs found.</div>';
            }
            echo json_encode(['status' => 'success', 'message' => 'Songs fetched successfully', 'view' => $content]);
        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        }
        break;
    
    case 'fetch_song_details':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $song_id = filter_input(INPUT_POST, 'song_id', FILTER_SANITIZE_NUMBER_INT);
            
            if (!$song_id) {
                throw new Exception('Invalid song ID provided.');
            }

            $song_details = fetch_song_details($db, $song_id, $church_id);
            if (!$song_details) {
                throw new Exception('Song not found.');
            }

            ob_start();
            include '../components/modal/song_details_modal.php';
            $content = ob_get_clean();
            echo json_encode(['status' => 'success', 'message' => 'Song details fetched successfully', 'view' => $content]);

          } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        }
        break;
    
    case 'fetch_form_song_details':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);

            $song_id = filter_input(INPUT_POST, 'song_id') ?? null;
            
            if (!$song_id) {
               $title_form = 'Add New Song';
               $song_id = null;
            }

            if($song_id) {
                $song_details = fetch_song_details($db, $song_id, $church_id);
            }

            $title_form = $song_id ? 'Edit Song' : 'Add New Song';
            // Prepare the form with existing song details
            $song_title = $song_details['title'] ?? '';
            $song_artist = $song_details['artist'] ?? '';
            $key_signature = $song_details['key_signature'] ?? '';
            $bpm = $song_details['bpm'] ?? '';
            $lyrics = $song_details['lyrics'] ?? '';
            $lyrics_file_url = $song_details['lyrics_file_url'] ?? '';
            $notes = $song_details['notes'] ?? '';
            $notes_file_url = $song_details['notes_file_url'] ?? '';
            $album_art_url = $song_details['album_art_url'] ?? '';
            $created_at = $song_details['created_at'] ?? '';
        
           

            ob_start();
            include '../components/modal/song_form_modal.php';
            $content = ob_get_clean();
            echo json_encode(['status' => 'success', 'message' => 'Song form fetched successfully', 'view' => $content]);

        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        }
        break;
    
    case 'save_song':
        try {
            include '../../../utilities/db_conn.php';
            $db = new PDO($dsn, $username, $password);
            $db->beginTransaction();

            $song_id = filter_input(INPUT_POST, 'song_id') ?? null;
            $title = filter_input(INPUT_POST, 'title');
            $artist = filter_input(INPUT_POST, 'artist');
            $key_signature = filter_input(INPUT_POST, 'key_signature');
            $bpm = filter_input(INPUT_POST, 'bpm', FILTER_SANITIZE_NUMBER_INT);
            $album_art_url = filter_input(INPUT_POST, 'album_art_url', FILTER_SANITIZE_URL);
            $lyrics = filter_input(INPUT_POST, 'lyrics');
            $lyrics_file_url = filter_input(INPUT_POST, 'lyrics_file_url', FILTER_SANITIZE_URL);
            $notes = filter_input(INPUT_POST, 'notes');
            $notes_file_url = filter_input(INPUT_POST, 'notes_file_url', FILTER_SANITIZE_URL);

            if (!$title) {
                throw new Exception('Song title is required.');
            }

            if ($song_id) {
                update_song($db, $song_id, $title, $artist, $key_signature, $bpm, $album_art_url, $lyrics, $lyrics_file_url, $notes, $notes_file_url);
            } else {
               $song_id = create_song($db, $church_id, $session_user_id, $title, $artist, $key_signature, $bpm, $album_art_url, $lyrics, $lyrics_file_url, $notes, $notes_file_url);
            }

            // return card song
            $song = fetch_song_details($db, $song_id, $church_id);

            ob_start();
            include '../components/card/song_card.php';
            $content = ob_get_clean();

            $db->commit();

            echo json_encode(['status' => 'success', 'message' => 'Song saved successfully', 'view' => $content, 'song_id' => $song_id]);


        } catch (PDOException | ErrorException | Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        }
}