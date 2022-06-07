$('#sort-faqs-components-by-priority').on('click', function() {
	// First check if admin enter an invalide priority value by mistake (character or empty string)
	let invalid_priority = false;
	$('.faq-component .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		display_top_informer_message('A priority value of one of faqs is invalid. (priority should be a number)');
		return;
	}

	// Reorder options after votes based on number of votes (using bubble sort)
	let faqs = $('.faq-component');
	let count = faqs.length;
	let i, j;
	for (i = 0; i < count-1; i++) {
		faqs = $('.faq-component');
		// (count-i-1) because last i elements will be in the right place
		for (j = 0; j < count-i-1; j++) {
			let faqa = $(faqs[j]);
			let faqb = $(faqs[j+1]);
			let va = parseInt(faqa.find('.faq-priority').val());
			let vb = parseInt(faqb.find('.faq-priority').val());

			if(va > vb) {
				faqa.insertAfter(faqb);
				faqs = $('.faq-component');
			}
		}
	}
});

let update_faqs_priorities_lock = true;
$('#update-faqs-priorities').on('click', function() {
	let invalid_priority = false;
	$('.faq-component .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		print_top_message('A priority value of one of faqs is invalid. (priority should be a number)', 'error');
		return;
	}

    if(!$('.faq-component .faq-priority').length) {
        print_top_message('You need at least one faq to update its priority.', 'error');
		return;
    }

	if(!update_faqs_priorities_lock) return;
	update_faqs_priorities_lock = false;

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	let faqs=[];
	let priorities=[];
	$('.faq-component').each(function() {
		faqs.push($(this).find('.faq-id').val());
		priorities.push($(this).find('.faq-priority').val());
	});

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

	$.ajax({
		type: 'post',
		url: '/admin/faqs/priorities',
		data: {
			faqs: faqs,
			priorities: priorities
		},
		success: function() {
			location.reload();
		},
		error: function(response) {
			update_faqs_priorities_lock = true;

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');

			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			button.removeClass('dark-bs-disabled');
		}
	})
});

$('.open-faq-edit-container').on('click', function() {
	let component = $(this);
	while(!component.hasClass('faq-component')) component = component.parent();

	component.find('.faq-content-container').addClass('none');
	component.find('.faq-edit-container').removeClass('none');
});

$('.discard-faq-update').on('click', function() {
	let component = $(this);
	while(!component.hasClass('faq-component')) component = component.parent();

	let content_container = component.find('.faq-content-container');
	let edit_container = component.find('.faq-edit-container');

	content_container.removeClass('none');
	edit_container.addClass('none');
	edit_container.find('.error-container').addClass('none');

	edit_container.find('.faq-question').val(edit_container.find('.original-faq-question').val());
	edit_container.find('.faq-answer').val(edit_container.find('.original-faq-answer').val());
});

let update_faq_lock = true;
$('.update-faq').on('click', function() {
	let faq_box = $(this);
	while(!faq_box.hasClass('faq-component')) faq_box = faq_box.parent();
	let faq_edit_box = faq_box.find('.faq-edit-container');
	
	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
	let faq_id = button.find('.faq-id').val();
	let errorbox = faq_edit_box.find('.error-container');

	let question = faq_edit_box.find('.faq-question').val();
	let answer = faq_edit_box.find('.faq-answer').val();

	if(question.trim() == '') {
		errorbox.find('.error').text('Question field is required');
		errorbox.removeClass('none');
		return;
	}

	if(answer.trim() == '') {
		errorbox.find('.error').text('Answer field is required');
		errorbox.removeClass('none');
		return;
	}

	errorbox.addClass('none');

	if(!update_faq_lock) return;
	update_faq_lock = false;

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

	$.ajax({
		type: 'patch',
		url: '/admin/faqs',
		data: {
			faq_id: faq_id,
			question: question,
			answer: answer,
		},
		success: function(response) {
			faq_box.find('.faq-content-container').removeClass('none');
			faq_box.find('.faq-edit-container').addClass('none');

			faq_box.find('.original-faq-question').val(question);
			faq_box.find('.original-faq-answer').val(answer);
			faq_box.find('.question-text').text(question);
			faq_box.find('.answer-text').text(answer);

			left_bottom_notification('faq content has been updated');
		},
		error: function(response) {
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
		},
		complete: function(response) {
			update_faq_lock = true;

			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			button.removeClass('dark-bs-disabled');
		}
	})
});

$('.open-faq-delete-container').on('click', function(event) {
	let component = $(this);
	while(!component.hasClass('faq-component')) component = component.parent();

	$(this).parent().css('display', 'none');

	let viewer = $('#faq-delete-viewer');
	viewer.find('.faq-id').val(component.find('.faq-id').val());
	viewer.find('.question-text').text(component.find('.question-text').text());
	viewer.find('.answer-text').text(component.find('.answer-text').text());

	viewer.removeClass('none');
	disable_page_scroll();
});

let delete_faq_lock = true;
$('#delete-faq-button').on('click', function() {
	if(!delete_faq_lock) return;
	delete_faq_lock = false;

	let viewer = $('#faq-delete-viewer');
	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
	let faq_id = button.find('.faq-id').val();

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('red-bs-disabled');

	$.ajax({
		type: 'delete',
		url: '/admin/faqs',
		data: {
			faq_id: faq_id,
		},
		success: function() {
			viewer.find('.close-global-viewer').trigger('click');
			$('#faq-' + faq_id + '-box').remove();
			$('.faqs-count').text(parseInt($('.faqs-count').first().text()) - 1);
			
			if(!$('.faq-component').length) {
				$('.no-faqs-available').removeClass('none');
			}
			left_bottom_notification('faq has been deleted successfully');
		},
		error: function(response) {
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
		},
		complete: function() {
			delete_faq_lock = true;
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
			button.removeClass('red-bs-disabled');
		}
	});
});

let update_faq_state_lock = true;
$('.change-faq-state').on('click', function() {
	if(!update_faq_state_lock) return;
	update_faq_state_lock = false;

	let component = $(this);
	while(!component.hasClass('faq-component')) component = component.parent();

	let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');
	let faq_id = component.find('.faq-id').val();

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');

	$.ajax({
		type: 'patch',
		url: '/admin/faqs',
		data: {
			faq_id: faq_id,
			live: button.find('.state').val()
		},
		success: function(response) {
			left_bottom_notification('faq status has been changed');
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

			update_faq_state_lock = true;
			spinner.removeClass('inf-rotate');
			spinner.addClass('opacity0');
			buttonicon.removeClass('none');
		},
	})
});
