function verify_category_inputs() {
    let title = $('#category-title');
    let title_meta = $('#category-meta-title');
    let slug = $('#category-slug');
    let description = $('#category-description');
    let is_subcategory = $('#is-sub-category').val() == 'yes';

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
    
    let category_selected = false;
    $('.hierarchy-category-id').each(function() {
        if($(this).is(':checked')) {
            category_selected = true;
            return false;
        }
    });

    if(is_subcategory && !category_selected) {
        display_category_error($('#is-sub-category'), 'Since the category is a subcategory, you have to select a parent category');
        return false;
    }

    return true;
}

function display_category_error(input, error_message) {
    $('#category-error-container .error-message').text(error_message);
    $('#category-error-container').removeClass('none');
    if(input) {
        let input_box = input;
        while(!input_box.hasClass('input-container')) input_box = input_box.parent();
        input_box.find('.error-asterisk').css('display', 'inline');
    }
    scroll_to_element('category-error-container', -100);
}

$('#category-title').on('input', function() {
    let value = $(this).val().trim();
    let slug = convertToSlug(value);

    $('#category-meta-title').val(value);
    $('#category-slug').val(slug);
});

$('#is-sub-category-toggle-button').on('click', function() {
    let button = $(this);
    let state = $('#is-sub-category');
    let target_button = $('#open-select-one-category-viewer');

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
let category_parent_selection_opened = false;
$('#open-select-one-category-viewer').on('click', function() {
    if($(this).hasClass('action-denied')) return;

    let viewer = $('#select-one-category-viewer');
    viewer.removeClass('none');
	disable_page_scroll();

	if(!category_parent_selection_opened) {
		if(!open_category_parent_lock) return;
		open_category_parent_lock = false;

		let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/categories/hierarchy/select-one-category-viewer',
            success: function(response) {
                viewer.find('.loading-box').remove();
                viewer.find('.global-viewer-content-box').html(response);
                handle_one_level_subcategories_fetch(viewer);
                handle_toggling(viewer);
            },
            complete: function() {
				category_parent_selection_opened = true;
            }
        });
	}
});

/**
 * Handle fetching one level subcategories of a category
 */
$('.fetch-one-level-subcategories').each(function() {
    handle_one_level_subcategories_fetch($(this).parent()); 
});
function handle_one_level_subcategories_fetch(component) {
    component.find('.fetch-one-level-subcategories').each(function() {
        $(this).on('click', function(event) {
            let button = $(this);
            let spinner = button.find('.spinner');
            let arrow = button.find('.toggle-arrow');
            let state = button.find('.state');
        
            let box = button;
            while(!box.hasClass('category-box')) box = box.parent();

            switch(state.val()) {
                case 'init':
                    state.val('pending');
                    arrow.addClass('none');
                    spinner.removeClass('opacity0');
                    spinner.addClass('inf-rotate');
        
                    let category_id = button.find('.category-id').val();
                    $.ajax({
                        url: `/admin/categories/hierarchy/subcategories/one-level-subcategories`,
                        data: {
                            category_id: category_id,
                            type: button.find('.type').val()
                        },
                        success: function(response) {
                            box.find('.subcategories-box').html(response);
                            box.find('.subcategories-box').removeClass('none');
                            box.find('.angle-before-subcategories-box').first().removeClass('none'); // first() important here
                            handle_one_level_subcategories_fetch(box.find('.subcategories-box'));
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
                case 'fetched':
                    return;
            }
        });
    })
}
