$(document).ready(function () {
    $(".message").click(function () {
        $(this).fadeOut()
    });
});

$(function () {
    $('[data-toggle="popover"]').popover()
});