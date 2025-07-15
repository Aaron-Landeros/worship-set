$(function () {
    const admin_controller = 'modules/admin/controller/admin_controller.php';


    function fetchAdminData(){
        var user_request = 'fetch_admin_data';

        // Submit admin data request
        $.post(admin_controller, {
            user_request: user_request
        }, function(data) {
            var response = JSON.parse(data);
            if(response.status === 'success') {
                $('#app-content').html(response.view);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.message
                });
            }
        });
    }

    function verifyRole() {
        var user_role = $('body').data('user-role');
        if(user_role !== 'admin') {
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'You do not have permission to access this page.'
            }).then(() => {
                window.location.href = 'index.php';
            });
        } else {
            fetchAdminData();
        }
    }

    verifyRole();

    // Handle form submission for admin
    $(document).on('click', '#btn_admin', function() {
    });

    // Toggle the visibility of a dropdown menu
    const toggleDropdown = (dropdown, menu, isOpen) => {
    dropdown.classList.toggle("open", isOpen);
    menu.style.height = isOpen ? `${menu.scrollHeight}px` : 0;
    };
    // Close all open dropdowns
    const closeAllDropdowns = () => {
    document.querySelectorAll(".dropdown-container.open").forEach((openDropdown) => {
        toggleDropdown(openDropdown, openDropdown.querySelector(".dropdown-menu"), false);
    });
    };
    // Attach click event to all dropdown toggles
    document.querySelectorAll(".dropdown-toggle").forEach((dropdownToggle) => {
    dropdownToggle.addEventListener("click", (e) => {
        e.preventDefault();
        const dropdown = dropdownToggle.closest(".dropdown-container");
        const menu = dropdown.querySelector(".dropdown-menu");
        const isOpen = dropdown.classList.contains("open");
        closeAllDropdowns(); // Close all open dropdowns
        toggleDropdown(dropdown, menu, !isOpen); // Toggle current dropdown visibility
    });
    });
    // Attach click event to sidebar toggle buttons
    document.querySelectorAll(".sidebar-toggler, .sidebar-menu-button").forEach((button) => {
    button.addEventListener("click", () => {
        closeAllDropdowns(); // Close all open dropdowns
        document.querySelector(".sidebar").classList.toggle("collapsed"); // Toggle collapsed class on sidebar
    });
    });
    // Collapse sidebar by default on small screens
    if (window.innerWidth <= 1024) document.querySelector(".sidebar").classList.add("collapsed");


    $(document).on('click', '#fetch_users', function (e) {
        e.preventDefault();
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_users' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#app-content').html(response.view);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching users.'
                });
            }
        });
    });

    $(document).on('click', '#fetch_teams', function (e){
        e.preventDefault();
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_teams' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#app-content').html(response.view);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching teams.'
                });
            }
        });
    });

    $(document).on('click', '.team_card', function () {
        const teamId = $(this).data('team-id');
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_team_details', team_id: teamId },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#modal-container').html(response.view);
                    $('#teamDetailsModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching team details.'
                });
            }
        });
    });

    $(document).on('hide.bs.modal', '#teamDetailsModal', function () {
        $(this).closet('.modal-backdrop').remove();
        $(this).remove();
    });

    $(document).on('click', '#fetch_services', function (e) {
        e.preventDefault();
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_services' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#app-content').html(response.view);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching events.'
                });
            }
        });
    });

    $(document).on('click', '#create_service', function (e) {
        e.preventDefault();
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'create_service_modal' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#modal-container').html(response.view);
                    $('#createServiceModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while loading the create service modal.'
                });
            }
        });
    });

    $(document).on('submit', '#create_service_form', function (e) {
        e.preventDefault();
        var form = $(this)[0];
        var formData = new FormData(form);
        formData.append('user_request', 'create_service');

        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#createServiceModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        $('#app-content').html(response.view);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while creating the service.'
                });
            }
        });
    });

    $(document).on('click', '.btn_view_service', function () {
        const serviceId = $(this).data('service-id');
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_view_service', service_id: serviceId },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#app-content').html(response.view);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching service details.'
                });
            }
        });
    });

    $(document).on('click', '#btn_view_schedule', function () {
        const serviceId = $(this).data('service-id');
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_service_schedule', service_id: serviceId },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#modal-container').append(response.view);
                    $('#viewScheduleModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching the service schedule.'
                });
            }
        });
    });

    $(document).on('hide.bs.modal', '#viewScheduleModal', function () {
        $(this).remove();
        $('#modal-container').empty();
    });

    $(document).on('click', '#btn_manage_setlist', function () {
        const serviceId = $(this).data('service-id');
        const segmentId = $(this).data('segment-id');
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_manage_setlist', service_id: serviceId, segment_id: segmentId },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#modal-container').append(response.view);
                    $('#manageSetlistModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching the setlist.'
                });
            }
        });
    });

    $(document).on('hide.bs.modal', '#manageSetlistModal', function () {
        $(this).remove();
        $(this).closest('.modal-backdrop').remove();
    });

    $(document).on('click', '#btn_add_song_to_setlist', function () {
        const serviceId = $(this).data('service-id');
        const segmentId = $(this).data('segment-id');
        const songId = $('#song_to_select').val();
        let songKey = $('#song_key').val();

        if (!songId) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select a song to add to the setlist.'
            });
            return;
        }

        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'add_song_to_setlist', service_id: serviceId, segment_id: segmentId, song_id: songId, song_key: songKey },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                   $('#setlist_songs').html(response.view);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn_remove_setlist_song', function () {
        const serviceId = $(this).data('service-id');
        const segmentId = $(this).data('segment-id');
        const songId = $(this).data('song-id');

        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'remove_song_from_setlist', service_id: serviceId, segment_id: segmentId, song_id: songId },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#setlist_songs').html(response.view);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                }
            }
        });
    });

    let selectedMember = null;

    // Buscar músicos (AJAX)
    $(document).on('input', '#musician_search', function() {
        let query = $(this).val();
        let church_id = $(this).data('church-id');

        //set timeout to avoid too many requests
        clearTimeout($.data(this, 'timer'));
        $(this).data('timer', setTimeout(() => {
            if (query.length < 1) {
                $('#searchResults').html('<p class="text-muted small text-center mb-0">Start typing to search...</p>');
                return;
            }

            $.ajax({
                url: admin_controller,
                type: 'POST',
                data: { user_request: 'search_musicians', query: query, church_id: church_id },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status === 'success') {
                        if (response.members.length > 0) {
                            let resultsHtml = '';
                            response.members.forEach(member => {
                                resultsHtml += `
                                    <div class="search-result-item p-2" data-user-id="${member.id}" data-name="${member.name}">
                                        <span class="fw-bold">${member.name}</span>
                                        <span class="text-muted small">(${member.position})</span>
                                    </div>
                                `;
                            });
                            $('#searchResults').html(resultsHtml);
                        } else {
                            $('#searchResults').html('<p class="text-muted small text-center mb-0">No results found.</p>');
                        }
                    }
                },
                error: function() {
                    $('#searchResults').html('<p class="text-danger small text-center mb-0">An error occurred while searching.</p>');
                }
            });
        }, 300)); // 300ms delay before sending the request
        
    });

    // Seleccionar resultado
    $(document).on('click', '.search-result-item', function() {
        selectedMember = {
            id: $(this).data('user-id'),
            name: $(this).data('name')
        };
        $('.search-result-item').removeClass('bg-light');
        $(this).addClass('bg-secondary text-white');
        $('#btnAddMusician').prop('disabled', false);
    });

    // Agregar a la lista
    $(document).on('click', '#btnAddMusician', function() {
        if (!selectedMember) return;

        const row = `
                <tr data-user-id="${selectedMember.id}">
                    <td>${selectedMember.name}</td>
                    <td>
                        <select class="form-select form-select-sm musician-role">
                            <option value="">Select Role</option>
                            <option value="Lead Vocal">Lead Vocal</option>
                            <option value="Background Vocal">Background Vocal</option>
                            <option value="Guitar">Guitar</option>
                            <option value="Bass">Bass</option>
                            <option value="Drums">Drums</option>
                            <option value="Keyboard">Keyboard</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select form-select-sm song-select d-none">
                            <option value="">Choose Song</option>
                            <?php foreach ($setlist as $song_item): 
                                $song_data = fetch_song_data($db, $song_item['song_id']); ?>
                                <option value="<?= $song_item['song_id'] ?>"><?= htmlspecialchars($song_data['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input md-checkbox" />
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger btn-remove-member">
                            <i class="material-symbols-rounded">delete</i>
                        </button>
                    </td>
                </tr>
                `;


        if ($('#assignedMusicians tr td').length === 1) {
            $('#assignedMusicians').html(row);
        } else {
            $('#assignedMusicians').append(row);
        }

        selectedMember = null;
        $('#musician_search').val('');
        $('#searchResults').html('<p class="text-muted small text-center mb-0">Start typing to search...</p>');
        $('#btnAddMusician').prop('disabled', true);
    });

    // Mostrar selector de canción si es Vocal
    $(document).on('change', '.musician-role', function () {
        const row = $(this).closest('tr');
        const songSelect = row.find('.song-select');
        const role = $(this).val();

        if (role === 'Lead Vocal') {
            // Obtener IDs del contenedor
            const segmentId = $('#assignedMusicians').data('segment-id');
            const serviceId = $('#assignedMusicians').data('service-id');

            // Mostrar loading
            songSelect.removeClass('d-none').html('<option>Loading...</option>');

            // Hacer petición AJAX
            $.ajax({
                url: admin_controller,
                type: 'POST',
                data: {
                    user_request: 'fetch_setlist_songs',
                    segment_id: segmentId,
                    service_id: serviceId
                },
                success: function (data) {
                    const response = JSON.parse(data);
                    if (response.status === 'success' && response.songs.length > 0) {
                        songSelect.empty();
                        songSelect.append('<option value="">Choose Song</option>');
                        response.songs.forEach(song => {
                            songSelect.append(`<option value="${song.id}">${song.title}</option>`);
                        });
                    } else {
                        songSelect.html('<option>No songs available</option>');
                    }
                },
                error: function () {
                    songSelect.html('<option>Error loading songs</option>');
                }
            });

        } else {
            songSelect.addClass('d-none').val('');
        }
    });

    // Eliminar miembro
    $(document).on('click', '.btn-remove-member', function() {
        $(this).closest('tr').remove();
    });

    // Solo un MD permitido
    $(document).on('change', '.md-checkbox', function() {
        if ($(this).is(':checked')) {
            $('.md-checkbox').not(this).prop('checked', false);
        }
    });


    $(document).on('click', '#btn_save_setlist', function () {
        let service_id = $(this).data('service-id');
        let segment_id = $(this).data('segment-id');
        let assignments = [];

        $('#assignedMusicians tr').each(function () {
            let user_id = $(this).data('user-id');
            let role = $(this).find('.musician-role').val();
            let song_id = $(this).find('.song-select').val() || null;
            let is_md = $(this).find('.is-md-checkbox').is(':checked') ? 1 : 0;

            if (user_id && role) {
                assignments.push({
                    user_id: user_id,
                    role: role,
                    song_id: song_id,
                    is_md: is_md
                });
            }
        });

        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: {
                user_request: 'save_setlist_assignments',
                service_id: service_id,
                segment_id: segment_id,
                assignments: JSON.stringify(assignments)
            },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                    $('#manageSetlistModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unexpected error occurred.'
                });
            }
        });
    });

    // Songs Module Functionality
    $(document).on('click', '#fetch_songs', function (e) {
        e.preventDefault();
        $.ajax({
            url: admin_controller,
            type: 'POST',
            data: { user_request: 'fetch_songs' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    $('#app-content').html(response.view);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching users.'
                });
            }
        });
    });

});