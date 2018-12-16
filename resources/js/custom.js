/*
 * jQuery interactions
 */
$(document).ready(function () {
    //$('#phone').mask('000-000-0000');

    $('#contact-list').DataTable({
        paging: false,
        info: false
    });

    $('#manage-users-index').DataTable({
        paging: false,
        info: true
    });

    $('.logout-link').click(function (event) {
        event.preventDefault();

        $('#logout-form').submit();
    });

    // Modal JS
    $('form[data-confirm]').submit(function (event) {
        event.preventDefault();
        var modalform = $(this).data('confirm');
        var elem = event.target;
        $(modalform).modal();

        $('.confirmButton').click(function () {
            $(elem).unbind('submit');
            $(elem).submit();
        }).bind(this);
    });

    $('.preloader img').fadeOut();
    $('.preloader').fadeOut();
});