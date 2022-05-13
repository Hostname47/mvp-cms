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
$('#set-password-button').on('click', function() {
    if(!set_password_lock) return;
    set_password_lock = false;

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

            save_user_profile_settings_lock = true;
        }
    });
});

function password_condition(condition, error) {
    if(!condition) {
        $('.error-container .message-text').text(error);
        $('.error-container').removeClass('none');
        $(window).scrollTop(0);
        set_password_lock = true;
        return false;
    }

    return true;
}