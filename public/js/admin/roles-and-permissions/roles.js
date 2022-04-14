$('.open-create-role-dialog').on('click', function() {
    let viewer = $('#create-role-viewer');
	let viewerbox = viewer.find('.viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);
    
	viewer.removeClass('none');
    disable_page_scroll();
});

$('#create-role-confirm-input').on('input', function() {
    if(!create_role_lock) return;

    let confirmation_input = $(this);
    let confirmation_value = $('#create-role-confirm-value').val();
	let button = $('#create-role-button');
    
	create_role_confirmed = false;
    if(confirmation_input.val().trim() == confirmation_value) {
		create_role_confirmed = true;
		button.removeClass('green-bs-disabled');
    } else
        button.addClass('green-bs-disabled');
});

let create_role_confirmed = false;
let create_role_lock = true;
$('#create-role-button').on('click', function() {
    if(!create_role_confirmed) return;

    let title = $('#create-role-title-input');
    let slug = $('#create-role-slug-input');
    let description = $('#create-role-description-input');
    let error_container = $('#create-role-error-container');

    $('#create-role-viewer .error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_role_input(title.val() != '', title, error_container, 'Title field is required')) return;
    if(!validate_role_input(slug.val() != '', slug, error_container, 'Slug field is required')) return;
    if(!validate_role_input(description.val() != '', description, error_container, 'Description field is required')) return;

    if(!create_role_lock) return;
    create_role_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('green-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/roles',
        data: {
            title: title.val(),
            slug: slug.val(),
            description: description.val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function (response) {
            create_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('green-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            validate_role_input(false, false, error_container, error);
        }
    })
});

let update_role_lock = true;
$('#update-role-button').on('click', function() {
    let title = $('#update-role-title-input');
    let slug = $('#update-role-slug-input');
    let description = $('#update-role-description-input');
    let error_container = $('#update-role-error-container');

    $('#update-role-section .error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_role_input(title.val() != '', title, error_container, 'Title field is required')) return;
    if(!validate_role_input(slug.val() != '', slug, error_container, 'Slug field is required')) return;
    if(!validate_role_input(description.val() != '', description, error_container, 'Description field is required')) return;

    if(!update_role_lock) return;
    update_role_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: '/admin/roles',
        data: {
            role_id: $('#role-id').val(),
            title: title.val(),
            slug: slug.val(),
            description: description.val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function (response) {
            update_role_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            validate_role_input(false, false, error_container, error);
        }
    })
});

function validate_role_input(condition, input, error_container, error_message) {
    if(!condition) {
        error_container.find('.message-text').text(error_message);
        error_container.removeClass('none');
        if(input)
            input.parent().find('.error-asterisk').css('display', 'inline');

        return false;
    }
    return true;
}