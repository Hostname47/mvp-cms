$('.open-create-permission-dialog').on('click', function() {
	let viewer = $('#create-permission-viewer');
	let viewerbox = viewer.find('.global-viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);

	if($(this).find('.scope').length) { // if admin click on + new button on specific scope we set scope in viewer explicitely
        // First we check the existing scope switch
        $('.permission-scope-switch[value="existing"]').trigger('click');
        // Then we set the option according to the clicked scope
		let scope_value = $(this).find('.scope').val();
		let scope_dropdown = viewer.find('.existing-scope');
        // here we have to unselect all scopes
        scope_dropdown.find('option').attr('selected',false);
        // Then select the clickable one
		scope_dropdown.find('option[value="' + scope_value + '"]').attr('selected','selected');
        // Then we outline the dropdown input to show that the scope will be using is the clickable one
		scope_dropdown.css({
			outline: '4px solid rgba(33, 192, 255, 0.19)',
			border: '1px solid rgb(111, 205, 242)'
		});
        // We scroll down a little to show the highlighted scope 
        $('#create-permission-viewer-scrollable').animate({
            scrollTop: 56
        }, 100);
	}
	viewer.removeClass('none');
    disable_page_scroll();
});

$('.permission-scope-switch').on('change', function() {
    let viewer = $('#create-permission-viewer');
    let type = $(this).val();
    if(type == 'existing') {
        // disable new scope input and enable existing scopes dropdown
		viewer.find('.existing-scope').prop('disabled', false);
		viewer.find('.fresh-scope').prop('disabled', true);
    } else {
        viewer.find('.existing-scope').prop('disabled', true);
		viewer.find('.fresh-scope').prop('disabled', false);
    }
});

function validate_create_permission_inputs() {
    let viewer = $('#create-permission-viewer');
    let vscrollable = $('#create-permission-viewer-scrollable');
    let error_container = $('#create-permission-error-container');

    let title = viewer.find('.title');
    let slug = viewer.find('.slug');
    let description = viewer.find('.description');
    let existing_scope = viewer.find('.exisitng-scope');
    let fresh_scope = viewer.find('.fresh-scope');

    viewer.find('.error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_create_permission(title.val() != '', title, error_container, 'Title field is required.', vscrollable)) return false;
    if(!validate_create_permission(slug.val() != '', slug, error_container, 'Slug field is required.', vscrollable)) return false;
    if(!validate_create_permission(description.val() != '', description, error_container, 'Description field is required.', vscrollable)) return false;

    // Validate scope
    if($('.permission-scope-switch:checked').val() == 'fresh')
        if(!validate_create_permission(fresh_scope.val() != '', fresh_scope, error_container, 'Permission scope field is required', vscrollable)) return false;
    else
        if(!validate_create_permission(!existing_scope.val(), null, error_container, 'Permission scope field is required', vscrollable)) return false;

    return true;
}

function validate_create_permission(condition, input, error_container, error_message, scrollable=null) {
    if(!condition) {
        error_container.find('.message-text').text(error_message);
        error_container.removeClass('none');

        if(input) {
            let input_wrapper = input;
            while(!input_wrapper.hasClass('input-wrapper')) input_wrapper = input_wrapper.parent();
            input_wrapper.find('.error-asterisk').css('display', 'inline');
        }

        if(scrollable)
            scrollable.animate({
                scrollTop: 0
            }, 100);

        return false;
    }
    return true;
}

let create_permission_lock = true;
$('#create-permission-button').on('click', function() {
    if(!validate_create_permission_inputs()) return;
    let viewer = $('#create-permission-viewer');
	let data = {
        title: viewer.find('.title').val(),
        slug: viewer.find('.slug').val(),
        description: viewer.find('.description').val(),
	};

    if($('.permission-scope-switch:checked').val() == 'fresh')
        data.scope = viewer.find('.fresh-scope').val();
    else
        data.scope = viewer.find('.existing-scope').val();

    
    if(!create_permission_lock) return;
    create_permission_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');

    button.addClass('green-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/permissions',
		data: data,
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('green-bs-disabled');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}

            let error_container = $('#create-permission-error-container');
            let vscrollable = $('#create-permission-viewer-scrollable');
            validate_create_permission(false, null, error_container, error, vscrollable)

			create_permission_lock = true;
		}
	});
});