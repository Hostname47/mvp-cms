$('.post-row').on({
    mouseenter: function() {
        if(!$(this).hasClass('prevent-hover-effect'))
            $(this).find('.post-actions-links-container').css('opacity', '1');
    },
    mouseleave: function() {
        if(!$(this).hasClass('prevent-hover-effect'))
            $(this).find('.post-actions-links-container').css('opacity', '0');
    }
})