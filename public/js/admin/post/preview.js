$('#display-switch').on('click', function() {
    if($(this).hasClass('0')) {
        $('#raw-post-content').css('max-height', '100%');
        $(this).remove();
    }
});