$(function() {
    $('#scroll_messages').scroll(function () {
        sessionStorage.scrollTop = $(this).scrollTop();

        //Отслеживание скрола - live
        // console.log(sessionStorage.scrollTop);
    });

    $(window).ready(function () {
        if (sessionStorage.scrollTop != "undefined") {
            $('#scroll_messages').scrollTop(sessionStorage.scrollTop);
        }
    });
});