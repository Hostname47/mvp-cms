$('#sort-faqs-components-by-priority').on('click', function() {
	// First check if admin enter an invalide priority value by mistake (character or empty string)
	let invalid_priority = false;
	$('#live-faqs-container .faq-component .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		display_top_informer_message('A priority value of one of live faqs is invalid. (priority should be a number)');
		return;
	}

	// Reorder options after votes based on number of votes (using bubble sort)
	let faqs = $('#live-faqs-container .faq-component');
	let count = faqs.length;
	let i, j;
	for (i = 0; i < count-1; i++) {
		faqs = $('#live-faqs-container .faq-component');
		// (count-i-1) because last i elements will be in the right place
		for (j = 0; j < count-i-1; j++) {
			let faqa = $(faqs[j]);
			let faqb = $(faqs[j+1]);
			let va = parseInt(faqa.find('.faq-priority').val());
			let vb = parseInt(faqb.find('.faq-priority').val());

			if(va > vb) {
				faqa.insertAfter(faqb);
				faqs = $('#live-faqs-container .faq-component');
			}
		}
	}
});

let update_faqs_priorities_lock = true;
$('#update-faqs-priorities').on('click', function() {
	let invalid_priority = false;
	$('#live-faqs-container .faq-component .faq-priority').each(function() {
		if(!parseInt($(this).val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		print_top_message('A priority value of one of live faqs is invalid. (priority should be a number)', 'error');
		return;
	}

    if(!$('#live-faqs-container .faq-component .faq-priority').length) {
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
	$('#live-faqs-container .faq-component').each(function() {
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
