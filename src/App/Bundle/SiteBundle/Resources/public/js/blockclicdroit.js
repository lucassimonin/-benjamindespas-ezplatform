$( document ).ready(function() {
    $('body').on('contextmenu', function (e) {
        e.preventDefault();
        return false;
    });
});