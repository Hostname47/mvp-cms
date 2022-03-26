$('#sort-categories-components-by-priority').on('click', function() {
    $('.categories-hierarchy-level').each(function() {
        // First check if admin enter an invalide priority value by mistake (character or empty string)
        let invalid_priority = false;
        let categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
        categories.each(function() {
            if(!parseInt($(this).find('.category-priority').first().val())) {
                invalid_priority = true;
                return false;
            }
        });
        if(invalid_priority) {
            print_top_message('A priority value of one of categories is invalid. (priority should be a number)', 'error');
            return;
        }
    
        // Reorder categories based on priority value in ascending order (using bubble sort)
        let count = categories.length;
        let i, j;
        for (i = 0; i < count-1; i++) {
            categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
            // (count-i-1) because last i elements will be in the right place
            for (j = 0; j < count-i-1; j++) {
                let categorya = $(categories[j]);
                let categoryb = $(categories[j+1]);
                let ca = parseInt(categorya.find('.category-priority').first().val());
                let cb = parseInt(categoryb.find('.category-priority').first().val());
    
                if(ca > cb) {
                    categorya.insertAfter(categoryb);
                    categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
                }
            }
        }
    });
});

let update_categories_priorities_lock = true;
$('#update-categories-priorities').on('click', function() {
    let categories = $('.category-box');
    let invalid_priority = false;
    categories.each(function() {
        if(!parseInt($(this).find('.category-priority').first().val())) {
            invalid_priority = true;
            return false;
        }
    });
    if(invalid_priority) {
        print_top_message('A priority value of one of categories is invalid. (priority should be a number)', 'error');
        return;
    }

    if(!update_categories_priorities_lock) return;
    update_categories_priorities_lock = false;

    let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	let categories_ids=[];
	let categories_priorities=[];
	categories.each(function() {
		categories_ids.push($(this).find('.category-id').first().val());
		categories_priorities.push($(this).find('.category-priority').first().val());
	});

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'patch',
        url: '/categories/priorities',
        data: {
            categories_ids: categories_ids,
            categories_priorities: categories_priorities
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            update_categories_priorities_lock = true;
        }
    })
});

let update_category_informations_lock = true;
$('#update-category-informations').on('click', function() {
    if(!verify_category_inputs() || !update_category_informations_lock) return;
    update_category_informations_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    buttonicon.addClass('none');
    button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'patch',
        url: '/admin/category',
        data: {
            category_id: $('#category-id').val(),
            title: $('#category-title').val(),
            title_meta: $('#category-meta-title').val(),
            slug: $('#category-slug').val(),
            description: $('#category-description').val(),
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            update_category_informations_lock = true;
        }
    });
});

let update_category_status_lock = true;
$('.update-category-status').on('click', function() {
    if(!update_category_status_lock || $(this).hasClass('category-status-button-selected')) return;
    update_category_status_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let status = button.find('.status').val();
    let category_id = $('#category-id').val();

    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    button.addClass('category-status-button-selected');

    $.ajax({
        type: 'patch',
        url: '/admin/category/status',
        data: {
            category_id: category_id,
            status: status
        },
        success: function() {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            button.removeClass('category-status-button-selected');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            update_category_status_lock = true;
        }
    })
});

$('#open-category-parent-confirmation-dialog').on('click', function() {
    if(!category_parent_selection_opened) {
        print_top_message('Please open selection viewer and select the new parent category first', 'error');
        return;
    }
    if($('.hierarchy-category-id:checked').length == 0) {
        print_top_message('Please chose a parent category from selection viewer before confirming the change', 'error');
        return;
    }
    
    let selected_category_id = $('.hierarchy-category-id:checked').parent().find('.category-id').val();
    let selected_category_title = $('.hierarchy-category-id:checked').parent().find('.category-title-text').text();
    if($('#category-id').val() == selected_category_id) {
        print_top_message('A category could not be parent to itself. Please choose another parent category', 'error');
        return;
    }

    let viewer = $('#update-category-parent-viewer');
    viewer.find('.new-selected-category-parent').text(selected_category_title);
    viewer.find('.new-parent-category-id').val(selected_category_id);
    viewer.removeClass('none');
});

let update_category_parent_lock = true;
$('#update-category-parent').on('click', function() {
    if(!update_category_parent_lock) return;
    update_category_parent_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
    let category_id = button.find('.category-id').val();
    let new_parent_category_id = button.find('.new-parent-category-id').val();

    spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'patch',
        url: '/admin/category',
        data: {
            category_id: category_id,
            parent_category_id: new_parent_category_id
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            update_category_parent_lock = true;
        }
    });
});

let set_category_as_root_lock = true;
$('#set-category-as-root').on('click', function() {
    if(!set_category_as_root_lock) return;
    set_category_as_root_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

    spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'patch',
        url: '/admin/category/set-as-root',
        data: {
            category_id: button.find('.category-id').val(),
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            set_category_as_root_lock = true;
        }
    });
});
