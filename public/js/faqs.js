$('.question-container').on('click', function() {
    let component = $(this);
    while(!component.hasClass('faq-component')) component = component.parent();

    let answer = component.find('.answer-container');
    if(answer.hasClass('none')) {
        answer.removeClass('none');
        rotate(component.find('.faq-toggle-arrow'), 180);
    } else {
        answer.addClass('none');
        rotate(component.find('.faq-toggle-arrow'), 0);
    }
});

$('.faq-send-button').on('click', function() {
    let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
    let question = $("#question");
	let description = $("#description");

	if(!condition(question.val().trim()!='', $('#question-required').val())) return;
	if(!condition(question.val().trim().length >= 10, $('#question-length-error').val())) return;

    $('#faqs-error-container').addClass('none');

	if(button.hasClass('in-progress')) return;
	button.addClass('in-progress')

	// disable inputs
	question.attr('disabled', true);
	description.attr('disabled', true);

	button.addClass('in-progress dark-bs-disabled');
	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

	$.ajax({
		url: '/faqs',
		type: 'post',
		data: {
            question: question.val().trim(),
            description: description.val().trim(),
        },
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			button.removeClass('in-progress dark-bs-disabled');
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');

			question.attr('disabled', false);
			description.attr('disabled', false);

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
            condition(false, error);
		}
	});
});

function condition(condition, error) {
    if(!condition) {
        let error_container = $('#faqs-error-container');
        error_container.find('.error').text(error);
        error_container.removeClass('none');
        return false;
    }

    return true;
}
