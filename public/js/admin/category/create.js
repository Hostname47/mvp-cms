$('#sub-category-toggle-button').on('click', function() {
    let button = $(this);
    let state = button.find('.is-sub-category');

    if(state.val() == 'no') {
        button.find('.off-icon').addClass('none');
        button.find('.on-icon').removeClass('none');
        state.val('yes');
    } else {
        button.find('.off-icon').removeClass('none');
        button.find('.on-icon').addClass('none');
        state.val('no');
    }
});