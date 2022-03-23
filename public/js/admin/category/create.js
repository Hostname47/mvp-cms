$('#sub-category-toggle-button').on('click', function() {
    let button = $(this);
    let state = button.find('.is-sub-category');
    let target_button = $('#open-categories-to-chose-parent');

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
$('#open-categories-to-chose-parent').on('click', function() {
    if($(this).hasClass('action-denied')) return;

    let viewer = $('#select-category-parent-viewer');
    viewer.removeClass('none');
	disable_page_scroll();

	if(!category_parent_selection_opened) {
		if(!open_category_parent_lock) return;
		open_category_parent_lock = false;

		let spinner = viewer.find('.loading-spinner');
        spinner.addClass('inf-rotate');

        $.ajax({
            url: '/admin/categories/viewers/category-parent-selection-viewer',
            success: function(response) {
                viewer.find('.loading-box').remove();
                viewer.find('.global-viewer-content-box').html(response);
            },
            complete: function() {
				category_parent_selection_opened = true;
            }
        });
	}
});

let create_category_lock = true;
$('#create-category').on('click', function() {
    if(!create_category_lock) return;
    create_category_lock = false;
    // verify category inputs (in category.js file)
    if(!verify_category_inputs()) return;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
});
