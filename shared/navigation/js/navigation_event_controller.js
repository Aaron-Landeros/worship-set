$(function () {

    $(document).on('click', '[data-section]', function() {
        if($('.modal').length){
            $('.modal').modal('hide').remove();
            $('.modal-backdrop').remove();
        }
    });

    $(document).on('hidden.bs.modal', '.modal', function() {
        $('.modal-backdrop').remove();
    });


});




