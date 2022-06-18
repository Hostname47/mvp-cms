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
			// Set new filter name as selected (along with global filter value to use for fetching sign-ups)
			$('#dashboard-statistics-filter-selection-name').text(button.find('.filter-name').val());
			$('#dashboard-statistics-filter').val(button.find('.filter').val());
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
			// The following line force sign ups viewer to fetch users again because the filter is changed
			signups_viewer_opened = false;
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

let open_signups_viewer_lock = true;
let signups_viewer_opened = false;
$('#open-newsignups-viewer').on('click', function() {
	let viewer = $('#new-signups-viewer');
	if(!signups_viewer_opened) {
		if(!open_signups_viewer_lock) return;
		open_signups_viewer_lock = false;

		let content = $('#new-signups-box');
		let no_signups_found = $('#signups-not-found-box');
		let fetch = $('#signups-fetch-more-button');
		let loading = viewer.find('.loading-box');

		content.html('');
		fetch.addClass('none');
		no_signups_found.addClass('none');
		loading.removeClass('none');
        loading.find('.loading-spinner').addClass('inf-rotate');

        $.ajax({
            url: '/admin/sign-ups',
			data: {
				filter: $('#dashboard-statistics-filter').val(),
				skip: 0,
				take: 8
			},
            success: function(response) {
                signups_viewer_opened = true;

                content.html(response.users);

				if(response.hasmore)
					fetch.removeClass('none');
				else
					fetch.addClass('none');

				if(!response.count)
					no_signups_found.removeClass('none');

                loading.addClass('none');
            },
			error: function() {
				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');
			},
            complete: function() {
				open_signups_viewer_lock = true;
            }
        });
	}

	viewer.removeClass('none');
	disable_page_scroll();
});

let fetch_more_signups_lock = true;
$('#signups-fetch-more-button').on('click', function() {
	if(!fetch_more_signups_lock) return;
	fetch_more_signups_lock = false;

	let content = $('#new-signups-box');
	let button = $(this);
	let spinner = button.find('.spinner');

	spinner.removeClass('none');
	spinner.addClass('inf-rotate');

	$.ajax({
		url: '/admin/sign-ups',
		data: {
			filter: $('#dashboard-statistics-filter').val(),
			skip: content.find('.signup-user-component').length,
			take: 8
		},
		success: function(response) {
			content.append(response.users);

			if(response.hasmore)
				button.removeClass('none');
			else
				button.addClass('none');
		},
		error: function() {
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
		},
		complete: function() {
			fetch_more_signups_lock = true;
			spinner.addClass('none');
			spinner.removeClass('inf-rotate');
		}
	});
});