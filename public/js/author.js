$('.post-component').on({
    mouseenter: function() {
        if($(this).hasClass('action-in-progress'))
            return;
        $(this).find('.post-options-container').removeClass('none');
    },
    mouseleave: function() {
        if($(this).hasClass('action-in-progress'))
            return;
        $(this).find('.post-options-container').addClass('none');
    }
})