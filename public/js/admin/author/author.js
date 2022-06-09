
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
			url: `/admin/authors/requests/review-viewer?request=${request}`,
			success: function(response) {
				content_block.html(response);
                content_block.removeClass('none');
                loading_block.addClass('none');
                // Handle events
				content_block.find('.toggle-box').each(function() { handle_toggling($(this)); });

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