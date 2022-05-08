$('#contact-send-message').on('click', function() {
    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let email = $('#contact-email');
    let message = $('#message');
    
    if(!condition(firstname.val().trim() != '', $('#firstname-required').val())) return;
    if(!condition(lastname.val().trim() != '', $('#lastname-required').val())) return;
    if(!condition(email.val().trim() != '', $('#email-required').val())) return;
    if(!condition(validateEmail(email.val().trim()), $('#email-invalide').val())) return;
    if(!condition(message.val().trim() != '', $('#message-required').val())) return;
    if(!condition(message.val().trim().length >= 10, $('#message-length-error').val())) return;
    
    $('#contact-error-container').addClass('none');

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	button.addClass('dark-bs-disabled');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

    if(button.hasClass('in-progress')) return;
    button.addClass('in-progress')

    $.ajax({
        url: '/contact',
        type: 'post',
        data: {
            firstname: firstname.val(),
            lastname: lastname.val(),
            email: email.val(),
            message: message.val()
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

            condition(false, error);
            button.removeClass('dark-bs-disabled in-progress');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
        }
    })
});

function condition(condition, error) {
    if(!condition) {
        let error_container = $('#contact-error-container');
        error_container.find('.error').text(error);
        error_container.removeClass('none');
        return false;
    }

    return true;
}
