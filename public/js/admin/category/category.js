function verify_category_inputs() {
    let title = $('#category-title');
    let title_meta = $('#category-meta-title');
    let slug = $('#category-slug');
    let description = $('#category-description');

    /**
     * Before we verify category inputs, we hide the message and all error asterisks and then we 
     * validate the inputs so that If the admin fix a previous issue the error message will not appear
     * when all inputs are verified.
     */
    $('#category-error-container').addClass('none');
    $('.error-asterisk').css('display', 'none');

    if(title.val() == '') {
        display_category_error(title, 'category title field is required');
        return false;
    }
    if(title_meta.val() == '') {
        display_category_error(title_meta, 'category title meta field is required');
        return false;
    }
    if(slug.val() == '') {
        display_category_error(slug, 'category slug field is required');
        return false;
    }
    if(description.val() == '') {
        display_category_error(description, 'category description field is required');
        return false;
    }

    return true;
}

function display_category_error(input, error_message) {
    $('#category-error-container .error-message').text(error_message);
    $('#category-error-container').removeClass('none');
    if(input)
        input.parent().find('.error-asterisk').css('display', 'inline');
    scroll_to_element('category-error-container', -100);
}

$('#category-title').on('input', function() {
    let value = $(this).val().trim();
    let slug = convertToSlug(value);

    $('#category-meta-title').val(value);
    $('#category-slug').val(slug);
});