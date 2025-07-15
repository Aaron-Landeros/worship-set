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
});
