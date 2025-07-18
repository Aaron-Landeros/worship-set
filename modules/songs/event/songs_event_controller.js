const song_controller = 'modules/songs/controller/songs_controller.php';

$(document).on('click', '.view-song', function() {
    let songId = $(this).data('song-id');
    $.ajax({
        url: song_controller,
        type: 'POST',
        data: {
            user_request: 'fetch_song_details',
            song_id: songId
        },
        success: function(data) {
            let response = JSON.parse(data);
            if (response.status == 'success') {
                $('#modal-container').html(response.view);
                $('#songDetailsModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch song details.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch song details.'
                });
        }
    });
});


$(document).on('click', '.edit-song', function() {
    let songId = $(this).data('song-id');
    $.ajax({
        url: song_controller,
        type: 'POST',
        data: {
            user_request: 'fetch_form_song_details',
            song_id: songId
        },
        success: function(data) {
            let response = JSON.parse(data);
            if (response.status == 'success') {
                $('#songDetailsModal').modal('hide');
                $('#modal-container').append(response.view);
                $('#songFormModal').modal('show');
                //trigger input change events to set the initial state of inputs
               $('#album_art_url').trigger('input');

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to fetch song details.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message || 'Failed to fetch song details.'
            });
        }
    });
});

$(document).on('click', '#btn_add_song', function() {
    $.ajax({
        url: song_controller,
        type: 'POST',
        data: {
            user_request: 'fetch_form_song_details'
        },
        success: function(data) {
            let response = JSON.parse(data);
            if (response.status == 'success') {
                $('#modal-container').append(response.view);
                $('#songFormModal').modal('show');
                //trigger input change events to set the initial state of inputs
                $('#album_art_url').trigger('input');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to load song form.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while loading the song form.'
            });
        }
    });
});

// Album Art Mode Switch
$(document).on('change', '#album_mode', function () {
    let mode = $(this).val();
    if (mode === 'link') {
        $('#album_input').html('<input type="text" name="album_art_url" class="form-control" placeholder="Enter image link">');
    } else {
        $('#album_input').html('<input type="file" name="album_art_file" class="form-control">');
    }
});

// Lyrics Mode Switch
$(document).on('change', '#lyrics_mode', function () {
    let mode = $(this).val();
    if (mode === 'text') {
        $('#lyrics_input').html('<textarea name="lyrics" class="form-control" rows="4" placeholder="Enter lyrics"></textarea>');
    } else if (mode === 'link') {
        $('#lyrics_input').html('<input type="text" name="lyrics_link" class="form-control" placeholder="Enter link to lyrics">');
    } else {
        $('#lyrics_input').html('<input type="file" name="lyrics_file" class="form-control">');
    }
});

// Notes Mode Switch
$(document).on('change', '#notes_mode', function () {
    let mode = $(this).val();
    if (mode === 'text') {
        $('#notes_input').html('<textarea name="notes" class="form-control" rows="3" placeholder="Enter notes"></textarea>');
    } else if (mode === 'link') {
        $('#notes_input').html('<input type="text" name="notes_link" class="form-control" placeholder="Enter link to notes">');
    } else {
        $('#notes_input').html('<input type="file" name="notes_file" class="form-control">');
    }
});

// Album Preview
$(document).on('input', '#album_art_url', function () {
    let url = $(this).val();
    $('#album_preview').html(`<img src="${url}" class="w-100 h-100 object-fit-cover rounded">`);
});

$(document).on('click', '#btn_save_song', function () {
    let songId = $(this).data('song-id');
    let formData = new FormData($('#songForm')[0]);
    formData.append('user_request', 'save_song');
    formData.append('song_id', songId);

    $.ajax({
        url: song_controller,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            let response = JSON.parse(data);
            if (response.status === 'success') {
                $('#songFormModal').modal('hide');
                // Optionally, refresh the song list or update the UI
                if(response.song_id){
                    let songCard = $(response.view);
                    if (songId) {
                        $(`.song-card-${songId}`).replaceWith(songCard);
                    } else {
                        $('#songsGrid').prepend(songCard);
                    }
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'Song saved successfully.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to save song.'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the song.'
            });
        }
    });
});