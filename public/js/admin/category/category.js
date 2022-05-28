function verify_category_inputs(wrapper) {
    let title = wrapper.find('.title');
    let title_meta = wrapper.find('.meta-title');
    let slug = wrapper.find('.slug');
    let description = wrapper.find('.description');

    /**
     * Before we verify category inputs, we hide the message and all error asterisks and then we 
     * validate the inputs so that If the admin fix a previous issue the error message will not appear
     * when all inputs are verified.
     */
    wrapper.find('.error-container').addClass('none');
    wrapper.find('.error-asterisk').css('display', 'none');

    if(title.val() == '') {
        display_category_error(title, wrapper, 'category title field is required');
        return false;
    }
    if(title_meta.val() == '') {
        display_category_error(title_meta, wrapper, 'category title meta field is required');
        return false;
    }
    if(slug.val() == '') {
        display_category_error(slug, wrapper, 'category slug field is required');
        return false;
    }
    if(description.val() == '') {
        display_category_error(description, wrapper, 'category description field is required');
        return false;
    }

    return true;
}
function verify_category_parent(wrapper) {
    let is_subcategory = wrapper.find('.is-sub-category').val() == 'yes';
    let category_selected = false;
    $('.hierarchy-category-id').each(function() {
        if($(this).is(':checked')) {
            category_selected = true;
            return false;
        }
    });
    
    if(is_subcategory && !category_selected) {
        display_category_error(wrapper.find('.is-sub-category'), wrapper, 'Since the category is a subcategory, you have to select a parent category');
        return false;
    }

    return true;
}

function display_category_error(input, wrapper, error_message) {
    wrapper.find('.error-container .message-text').text(error_message);
    wrapper.find('.error-container').removeClass('none');
    if(input) {
        let input_box = input;
        while(!input_box.hasClass('input-container')) input_box = input_box.parent();
        input_box.find('.error-asterisk').css('display', 'inline');
    }
    $(window).scrollTop(0);
}

$('.title').on('input', function() {
    let wrapper = $(this);
    while(!wrapper.hasClass('category-form')) wrapper = wrapper.parent();
    if(wrapper.find('.live-title-match').is(':checked')) {
        let value = $(this).val().trim();
        let slug = slugify(value);
    
        wrapper.find('.meta-title').val(value);
        wrapper.find('.slug').val(slug);
    }
});

$('.is-sub-category-toggle-button').on('click', function() {
    let button = $(this);
    let wrapper = button;
    while(!wrapper.hasClass('category-form')) wrapper = wrapper.parent();
    let state = wrapper.find('.is-sub-category');
    let target_button = wrapper.find('.open-select-one-category-viewer');

    if(state.val() == 'no') {
        button.find('.off-icon').addClass('none');
        button.find('.on-icon').removeClass('none');
        state.val('yes');
        target_button.removeClass('white-bs-disabled action-denied');
    } else {
        button.find('.off-icon').removeClass('none');
        button.find('.on-icon').addClass('none');
        state.val('no');
        target_button.addClass('white-bs-disabled action-denied');
    }
});

let open_category_parent_lock = true;
$('.open-select-one-category-viewer').on('click', function() {
    if($(this).hasClass('action-denied')) return;

    let viewer = $('#select-one-category-viewer');
    viewer.removeClass('none');
	disable_page_scroll();
});
