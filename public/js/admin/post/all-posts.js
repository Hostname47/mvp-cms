$('.post-row').on({
    mouseenter: function() {
        $(this).find('.post-actions-links-container').css('opacity', '1');
    },
    mouseleave: function() {
        $(this).find('.post-actions-links-container').css('opacity', '0');
    }
})