$('.avatar-upload-button').on('change', function(event) {
    // validate uploaded cover
    let avatar_img = $('#avatar');
    let error_container = $('.error-container');
    let uploaded_avatar = event.target.files[0];
    if(!validate_avatar_image_type(uploaded_avatar)) {
        error_container.find('.error').text($('#avatar-file-not-supported').val());
        error_container.removeClass('none');
        $('body').trigger('click');
        return;
    }
    error_container.addClass('none');

    // validating image size and dimensions is done in server side
    avatar_img.attr('src', URL.createObjectURL(event.target.files[0]));
    avatar_img.removeClass('none');
    // Handle uploaded avatar dimensions
    avatar_img.attr('style', '');
    setTimeout(function() {
        fill_image_on_square_container(avatar_img);
    }, 400);

    $('.discard-uploaded-avatar').removeClass('none');
    $('.open-remove-avatar-dialog').addClass('none');

    $('body').trigger('click'); // Hide button parent suboptions-container
    event.stopPropagation();
});

$('.discard-uploaded-avatar').on('click', function(event) {
    $('#avatar-input').val(''); // Discard upload
    let avatar_img = $('#avatar');

    // Discard uploaded avatar from avatar image tag
    if($('#original-avatar').val() != '') {
        avatar_img.attr('src', $('#original-avatar').val());
        avatar_img.removeClass('none');
        $('.open-remove-avatar-dialog').removeClass('none');
    } else
        avatar_img.attr('src', $('#default-avatar').val());
    
    $(this).parent().css('display', 'none');
    event.stopPropagation();

    $('.discard-uploaded-avatar').addClass('none');
    $('.restore-original-avatar').addClass('none');
});

$('.open-remove-avatar-dialog').on('click', function(event) {
    $(this).parent().css('display', 'none');
    event.stopPropagation();

    $('#remove-user-avatar-viewer').removeClass('none');
    disable_page_scroll();
});

$('.remove-avatar-button').on('click', function() {
    // Remove avatar by clearing avatar value, mark avatar removed
    $('#avatar-input').val('');
    $('#avatar-removed').val('1');
    $('#avatar').attr('src', $('#default-avatar').val());

    // Hide remove avatar dialog viewer
    $('#remove-user-avatar-viewer .close-global-viewer').trigger('click');
    // Hide remove avatar dialog opener button because the user remove the avatar
    $('.open-remove-avatar-dialog').addClass('none');
    // Show revert cover deletion - Only show restore cover if user has already a cover
    if($('#original-avatar').val() != '')
        $('.restore-original-avatar').removeClass('none');
});

$('.restore-original-avatar').on('click', function(event) {
    $('#avatar').attr('src', $('#original-avatar').val());
    $('#avatar-removed').val('0');
    $('#avatar-input').val('');
    $(this).addClass('none');
    $('.open-remove-avatar-dialog').removeClass('none');
    $('.discard-uploaded-avatar').addClass('none');

    $(this).parent().css('display', 'none'); // Hide button parent suboptions-container
    event.stopPropagation();
});

let save_user_profile_settings_lock = true;
$('#save-user-profile-settings').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    // First validate inputs
    if(!avatar_condition($('#firstname').val().trim() != '', $('#firstname-required-error-message').val())) return;
    if(!avatar_condition($('#lastname').val().trim() != '', $('#lastname-required-error-message').val())) return;
    if(!avatar_condition($('#username').val().trim() != '', $('#username-required-error-message').val())) return;
    if(!avatar_condition($('#username').val().trim().length >= 6, $('#username-length-error-message').val())) return;

    let data = new FormData();
    data.append('firstname', $('#firstname').val());
    data.append('lastname', $('#lastname').val());
    data.append('username', $('#username').val());
    data.append('about', $('#about').val());
    if($('#avatar-input').val())
        data.append('avatar', $('#avatar-input')[0].files[0]);
    data.append('avatar_removed', $('#avatar-removed').val());

    button.addClass('dark-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    if(!save_user_profile_settings_lock) return;
    save_user_profile_settings_lock = false;

    $.ajax({
        type: 'post',
        url: '/settings/profile',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: data,
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            button.removeClass('dark-bs-disabled');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');

            save_user_profile_settings_lock = true;
        }
    })
    
});

function avatar_condition(condition, error) {
    if(!condition) {
        $('.error-container .message-text').text(error);
        $('.error-container').removeClass('none');
        $(window).scrollTop(0);
        save_user_profile_settings_lock = true;
        return false;
    }

    return true;
}

function validate_avatar_image_type(file){
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];
    let name = file.name;
    var extension = name.substr(name.lastIndexOf(".") + 1, name.length).toLowerCase();
    if(extensions.includes(extension))
        return file;

    return false;
}

/** password settings */

let set_password_lock = true;
$('#set-password').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon');
    let spinner = button.find('.spinner');

	let password = $('#password').val().trim();
	let password_confirmation = $('#password_confirmation').val().trim();

	$('.error-container').addClass('none');

    if(!password_condition(password !== '' && password_confirmation !== '', $('#password-required-error').val())) return;
	if(!password_condition(password.length >= 8, $('#password-length-error').val())) return;
	if(!password_condition(password === password_confirmation, $('#password-confirmation-error').val())) return;

    button.addClass('dark-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    if(!set_password_lock) return;
    set_password_lock = false;

    $.ajax({
        type: 'post',
        url: '/settings/password/set',
        data: {
			password: password,
			password_confirmation: password_confirmation
		},
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            button.removeClass('dark-bs-disabled');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');

            set_password_lock = true;
        }
    });
});

let change_password_lock = true;
$('#change-password').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon');

	let current_password = $('#current-password').val().trim();
	let password = $('#new-password').val().trim();
	let password_confirmation = $('#new-password-confirmation').val().trim();

	$('.error-container').addClass('none');

	if(!password_condition(password !== '' && password_confirmation !== '' && current_password !== '', $('#password-required-error').val())) return;
	if(!password_condition(password.length >= 8, $('#password-length-error').val())) return;
	if(!password_condition(password === password_confirmation, $('#password-confirmation-error').val())) return;

	if(!change_password_lock) return;
	change_password_lock = false;

    button.addClass('dark-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'post',
        url: '/settings/password/update',
        data: {
            current_password: current_password,
			password: password,
			password_confirmation: password_confirmation
		},
        success: function() {
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            button.removeClass('dark-bs-disabled');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');

            change_password_lock = true;
        }
    })
});

/** deactivate account */

$('#deactivate-account-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#deactivate-account-confirm-value').val();
	let button = $('#deactivate-account');
    
    if(confirmation_input.val() == confirmation_value) {
        if($('#deactivate-password').val() == '') {
            print_top_message($('#password-required-error').val(), 'error');
            confirmation_input.val(confirmation_input.val() + ' - x')
            return;
        }
        button.removeClass('dark-bs-disabled');
        deactivate_account_confirmed = true;
    } else {
        button.addClass('dark-bs-disabled');
        deactivate_account_confirmed = false;
    }
});

$('#deactivate-password').on('input', function() {
    let confirmation_input = $('#deactivate-account-confirm-input');
    let confirmation_value = $('#deactivate-account-confirm-value').val();
    let button = $('#deactivate-account');

    if($(this).val() == '' && confirmation_input.val() == confirmation_value) {
        confirmation_input.val(confirmation_input.val() + ' - x');
        button.addClass('dark-bs-disabled');
        deactivate_account_confirmed = false;
    }
});

let deactivate_account_confirmed = false;
let deactivate_account_lock = true;
$('#deactivate-account').on('click', function() {
    if(!deactivate_account_confirmed) return;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon');
    let error_container = $('#account-deactivation-box .error-container');

    error_container.addClass('none');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('dark-bs-disabled');

    if(!deactivate_account_lock) return;
    deactivate_account_lock = false;

    $.ajax({
        type: 'post',
        url: '/settings/account/deactivate',
        data: {
            password: $('#deactivate-password').val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            
            error_container.find('.message-text').text(error);
            error_container.removeClass('none');
            $(window).scrollTop(0);

            $('#deactivate-account-confirm-input').trigger('input'); // Reverify input and confirmation to remove disabled style from button
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            deactivate_account_lock = true;
        }
    });
});

/** activate account */
$('#activate-account-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#activate-account-confirm-value').val();
	let button = $('#activate-account');
    
    if(confirmation_input.val() == confirmation_value) {
        if($('#activate-password').val() == '') {
            print_top_message($('#password-required-error').val(), 'error');
            confirmation_input.val(confirmation_value + ' - x')
            return;
        }
        button.removeClass('green-bs-disabled');
        activate_account_confirmed = true;
    } else {
        button.addClass('green-bs-disabled');
        activate_account_confirmed = false;
    }
});

$('#activate-password').on('input', function() {
    let confirmation_input = $('#activate-account-confirm-input');
    let confirmation_value = $('#activate-account-confirm-value').val();
    let button = $('#activate-account');

    if($(this).val() == '' && confirmation_input.val() == confirmation_value) {
        confirmation_input.val(confirmation_value + ' - x');
        button.addClass('green-bs-disabled');
        activate_account_confirmed = false;
    }
});

let activate_account_confirmed = false;
let activate_account_lock = true;
$('#activate-account').on('click', function() {
    if(!activate_account_confirmed) return;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon');
    let error_container = $('#activation-error-container');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    button.addClass('green-bs-disabled');

    if(!activate_account_lock) return;
    activate_account_lock = false;

    $.ajax({
        type: 'post',
        url: '/settings/account/activate',
        data: {
            password: $('#activate-password').val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            error_container.find('.message-text').text(error);
            error_container.removeClass('none');

            button.removeClass('green-bs-disabled');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            activate_account_lock = true;
        }
    })
});

function password_condition(condition, error) {
    if(!condition) {
        $('.error-container .message-text').text(error);
        $('.error-container').removeClass('none');
        $(window).scrollTop(0);
        return false;
    }

    return true;
}