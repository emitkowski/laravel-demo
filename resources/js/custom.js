/*
 * jQuery interactions
 */
$(document).ready(function () {

    $('.logout-link').click(function (event) {
        event.preventDefault();

        $('#logout-form').submit();
    });

    $('.preloader img').fadeOut();
    $('.preloader').fadeOut();
});