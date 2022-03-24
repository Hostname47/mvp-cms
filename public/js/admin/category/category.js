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

$('.get-category-subcategories').each(function() { handle_subcategories_level_fetch_button($(this).parent()); });
function handle_subcategories_level_fetch_button(component) {
    component.find('.get-category-subcategories').each(function() {
        $(this).on('click', function(event) {
            let button = $(this);
            let spinner = button.find('.spinner');
            let arrow = button.find('.toggle-arrow');
            let state = button.find('.state');
        
            let box = button;
            while(!box.hasClass('categories-hierarchy-level')) box = box.parent();

            switch(state.val()) {
                case 'init':
                    state.val('pending');
                    arrow.addClass('none');
                    spinner.removeClass('opacity0');
                    spinner.addClass('inf-rotate');
        
                    let category_id = button.find('.category-id').val();
                    $.ajax({
                        url: `/admin/categories/get_subcategories_level`,
                        data: { category_id: category_id },
                        success: function(response) {
                            box.find('.subcategories-box').html(response);
                            box.find('.subcategories-box').removeClass('none');
                            box.find('.angle-before-subcategories-box').first().removeClass('none'); // first() important here
                            handle_subcategories_level_fetch_button(box.find('.subcategories-box'));
                            handle_toggling(box.find('.subcategories-box'));
                            state.val('fetched');
                            arrow.removeClass('none');
                            spinner.addClass('opacity0');
                            spinner.removeClass('inf-rotate');
                        },
                        error: function(response) {
                            let errorObject = JSON.parse(response.responseText);
                            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                            if(errorObject.errors) {
                                let errors = errorObject.errors;
                                error = errors[Object.keys(errors)[0]][0];
                            }
                            display_category_error(false, error);
                            create_category_lock = true;
                        }
                    })
                    break;
                case 'pending':
                    return;
            }
        });
    })
}