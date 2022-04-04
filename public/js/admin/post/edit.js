$('body').on('click', (event) => $('#posts-search-result-box').addClass('none'));
$('#posts-search-result-box, #posts-search-input').on('click', (event) => event.stopPropagation());

let last_post_search_query = '';
let post_search_lock = true;
$('#search-for-posts-button').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#posts-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#posts-search-input').val();

	if(query == '') return;
	if(query == last_post_search_query) {
		if(post_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	// Here if the flow reaches here and the lock is false meaning admin should wait until he get results from previous search
	if(!post_search_lock) return;
	post_search_lock = false;

	$('#posts-search-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		url: '/admin/posts/search?k='+query,
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let posts = response.posts;
			let hasmore = response.hasmore;

			if(posts.length) {
				for(let i = 0; i < posts.length; i++) {
					let postcomponent = create_post_search_entity(posts[i]);
					results.append(postcomponent);
				}

				// After handling all posts components we have to check if search has more results
                let loadmore = $('#posts-search-fetch-more-results');
				if(hasmore)
					loadmore.removeClass('none no-fetch')
				else
					// no-fetch prevent the scroll event from proceeding when no more results are there
					loadmore.addClass('none no-fetch');
			} else {
				// Results not founf
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');
			last_post_search_query = query;
			$('#k').val(query); // This is used in fetch more
		},
		error: function(response) {
			spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
		},
		complete: function() {
			post_search_lock = true;
		}
	})
});

$('#posts-search-input').on('keyup', function(event) {
	if(event.key === 'Enter' || event.keyCode === 13)
		$('#search-for-posts-button').trigger('click');
});

function create_post_search_entity(post) {
	let post_component = $('#posts-search-result-box .post-search-entity-factory').clone(true, true);
	post_component.attr('href', post.editlink);
	post_component.find('.post-id-text').text(post.id);
	post_component.find('.post-title-text').text(post.title);
	post_component.find('.post-author-name-text').text(post.author_name);
	post_component.find('.post-creation-date').text(post.creation_date);
    post_component.removeClass('none post-search-entity-factory');
	return post_component;
}