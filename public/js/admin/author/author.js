
let last_author_request_to_review = null;
let open_author_request_review_viewer_lock = true;
$('.open-manage-author-request-viewer').on('click', function() {
    let request = $(this).find('.request-id').val();
    let viewer = $('#review-request-viewer');

    if(request != last_author_request_to_review) {
        if(!open_author_request_review_viewer_lock) return;
		open_author_request_review_viewer_lock = false;

        let content_block = viewer.find('.viewer-content');
        let loading_block = $('#author-request-review-loading-box');
		let spinner = loading_block.find('.loading-viewer-spinner');
		spinner.addClass('inf-rotate');
        
		content_block.html('');
        content_block.addClass('none');
        loading_block.removeClass('none');

		$.ajax({
			type: 'get',
			url: `/admin/author/requests/review-viewer?request=${request}`,
			success: function(response) {
				content_block.html(response);
                content_block.removeClass('none');
                loading_block.addClass('none');
                // Handle events
				content_block.find('.toggle-box').each(function() { handle_toggling($(this)); });
				handle_accept_request();
				handle_refuse_request();
				handle_delete_request();
				last_author_request_to_review = request;
			},
			error: function(response) {
				viewer.find('.close-global-viewer').trigger('click');
				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');
                last_author_request_to_review = null;
			},
			complete: function() {
				spinner.removeClass('inf-rotate');
				open_author_request_review_viewer_lock = true;
			}
		});
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let author_request_action_lock = true;
function handle_accept_request() {
	$('#accept-request').on('click', function() {
		if(!author_request_action_lock) return;
		author_request_action_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon');
		let spinner = button.find('.spinner');
		let request = button.find('.request-id').val();

		button.addClass('green-bs-disabled');
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');

		$.ajax({
			type: 'post',
			url: '/admin/author/requests/accept',
			data: {
				request: request
			},
			success: function() {
				location.reload();
			},
			error: function(response) {
				$('#review-request-viewer .close-global-viewer').trigger('click');
				last_author_request_to_review = null;
				
				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');

                author_request_action_lock = true;
				button.removeClass('green-bs-disabled');
				spinner.removeClass('inf-rotate');
				spinner.addClass('opacity0');
				buttonicon.removeClass('none');
			}
		})
	});
}

function handle_refuse_request() {
	$('#refuse-request').on('click', function() {
		if(!author_request_action_lock) return;
		author_request_action_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon');
		let spinner = button.find('.spinner');
		let request = button.find('.request-id').val();

		button.addClass('red-bs-disabled');
		spinner.addClass('inf-rotate');
		spinner.removeClass('opacity0');
		buttonicon.addClass('none');

		$.ajax({
			type: 'post',
			url: '/admin/author/requests/refuse',
			data: {
				request: request
			},
			success: function() {
				location.reload();
			},
			error: function(response) {
				$('#review-request-viewer .close-global-viewer').trigger('click');
				last_author_request_to_review = null;
				
				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');

                author_request_action_lock = true;
				button.removeClass('red-bs-disabled');
				spinner.removeClass('inf-rotate');
				spinner.addClass('opacity0');
				buttonicon.removeClass('none');
			}
		})
	});
}

function handle_delete_request() {
	$('#delete-request').on('click', function() {
		if(!author_request_action_lock) return;
		author_request_action_lock = false;

		let button = $(this);
		let spinner = button.find('.spinner');
		let request = button.find('.request-id').val();

		button.addClass('default-cursor');
		spinner.addClass('inf-rotate');
		spinner.removeClass('none');

		$.ajax({
			type: 'delete',
			url: '/admin/author/requests',
			data: {
				request: request
			},
			success: function() {
				location.reload();
			},
			error: function(response) {
				$('#review-request-viewer .close-global-viewer').trigger('click');
				last_author_request_to_review = null;
				
				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');

                author_request_action_lock = true;
				button.removeClass('default-cursor');
				spinner.removeClass('inf-rotate');
				spinner.addClass('none');
			}
		})
	});
}