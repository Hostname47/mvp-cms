let change_dashboard_statistics_filter_lock = true;
$('.dashboard-statistics-filter').on('click', function(event) {
	if($(this).hasClass('dsf-selected') || !change_dashboard_statistics_filter_lock) return;
	change_dashboard_statistics_filter_lock = false;

	event.stopPropagation();
	let button = $(this);
	let filter = button.find('.filter').val();
	let loadingsection = $('#dashboard-statistics-loading-strip');
	
	loadingsection.find('.spinner').addClass('inf-rotate');
	loadingsection.removeClass('none');
	
	button.parent().css('display', 'none');
	button.attr('style', 'cursor: default');

	$.ajax({
		url: '/admin/dashboard/statistics?filter=' + filter,
		success: function(response) {
			// Set new filter name as selected
			$('#dashboard-statistics-filter-selection-name').text(button.find('.filter-name').val());
			// Remove selected style from previous filter and gize it to the selected filter
            $('.dashboard-statistics-filter').removeClass('dsf-selected');
			button.addClass('dsf-selected');
			// Get statistics from response
			let statistics = response;
			// Set statistics to counters
			$('.dashboard-online-users-count').text(statistics['online-users']);
			$('.dashboard-visitors-count').text(statistics['visitors']);
			$('.dashboard-signups-count').text(statistics['sign-ups']);

			$('.dashboard-posts-count').text(statistics['posts']);
			$('.dashboard-comments-count').text(statistics['comments']);
			$('.dashboard-claps-count').text(statistics['claps']);
			
			$('.dashboard-contact-messages-count').text(statistics['contact-messages']);
			$('.dashboard-author-requests-count').text(statistics['author-requests']);
			$('.dashboard-posts-awaiting-review-count').text(statistics['posts-awaiting-review']);
			$('.dashboard-faqs-count').text(statistics['faqs']);

			$('.dashboard-reports-count').text(statistics['reports']);
			$('.dashboard-unauthorized-actions-count').text(statistics['unauthorized-actions']);
			$('.dashboard-newsletter-count').text(statistics['newsletter-subscribers']);
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
			change_dashboard_statistics_filter_lock = true;
			loadingsection.find('.spinner').removeClass('inf-rotate');
			loadingsection.addClass('none');
			button.attr('style', '');
		}
	})
});