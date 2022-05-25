$('.comment-row').on({
    mouseenter: function() {
        $(this).find('.comment-actions-links').css('opacity', '1');
    },
    mouseleave: function() {
        $(this).find('.comment-actions-links').css('opacity', '0');
    }
})