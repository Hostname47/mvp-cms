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

	let query = $('#posts-search-input').val().trim();

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
				// Results not found
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
let posts_search_fetch_more = $('#posts-search-fetch-more-results');
let posts_search_results_box = $('#posts-search-result-box');
let posts_search_fetch_more_lock = true;
if(posts_search_results_box.length) {
    posts_search_results_box.on('DOMContentLoaded scroll', function() {
        if(posts_search_results_box.scrollTop() + posts_search_results_box.innerHeight() + 50 >= posts_search_results_box[0].scrollHeight) {
            if(!posts_search_fetch_more_lock || posts_search_fetch_more.hasClass('no-fetch')) return;
            posts_search_fetch_more_lock=false;
            
			let results_container = $('#posts-search-result-box .results-container');
			let spinner = posts_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_search_members = results_container.find('.post-search-entity').length;
			spinner.addClass('inf-rotate');
            $.ajax({
				url: '/admin/posts/search',
				data: {
					skip: present_search_members,
					take: 10,
					k: $('#k').val()
				},
                success: function(response) {
					let posts = response.posts;
					let hasmore = response.hasmore;

					if(posts.length) {
						for(let i = 0; i < posts.length; i++) {
							let postcomponent = create_post_search_entity(posts[i]);
							results_container.append(postcomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore)
							posts_search_fetch_more.removeClass('none no-fetch');
						else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							posts_search_fetch_more.addClass('none no-fetch');
					} else {
						// If scrolling does not find any data for some reason then we hide spinner
						posts_search_fetch_more.addClass('none no-fetch');
					}
                },
                complete: function() {
                    posts_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

let update_post_lock = true;
$('.update-post').on('click', function() {
    let title = $('#post-title');
    let meta_title = $('#post-meta-title');
    let slug = $('#post-slug');
    let content_element = $('#post-content');
    post_editor.data.processor = post_editor.data.htmlProcessor;
    let content = post_editor.getData();

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    $('.error-container').addClass('none');
    $('.error-asterisk').css('display', 'none');

    // Validating neccessary inputs
    if (!post_input_validate(title.val() != '', title, 'Title field is required.')) return;
    if (!post_input_validate(meta_title.val() != '', meta_title, 'Meta title field is required.')) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    if (!post_input_validate(slug.val() != '', slug, 'Slug field is required.')) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    if (!post_input_validate(content != '', content_element, 'Content field is required.')) return;
	
	let categories = [];
    $('.post-category-id').each(function() {
        if($(this).is(':checked'))
            categories.push($(this).val());
    });

    let tags = [];
    $('.post-tags-wrapper .tag-text').each(function() {
        tags.push($(this).text());
    });

    let data = {
		post_id: button.find('.post-id').val(),
        title: title.val(),
        title_meta: meta_title.val(),
        slug: slug.val(),
        content: content,
		visibility: $('#post-visibility').val(),
        allow_comments: $('#allow-comments').is(':checked') ? 1 : 0,
        allow_reactions: $('#allow-reactions').is(':checked') ? 1 : 0,
		categories: categories,
		tags: tags,
		thumbnail_id: $('#post-thumbnail-image-metadata-id').val(),
		summary: $('#post-summary').val()
    };

    if($('#post-visibility').val() == 'password-protected') {
        if($('#post-password-input').val() == '') {
            print_top_message('password is required in case the post visibility is password protected', 'error');
            return;
        }
        else
            data.password = $('#post-password-input').val();
    }

	if (!update_post_lock) return;
    update_post_lock = false;
	
    button.addClass('white-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

	$.ajax({
		type: 'patch',
		url: '/admin/posts',
		data: data,
		success: function() {
			location.reload();
		},
		error: function(response) {
			update_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('white-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            print_top_message(error, 'error');
		}
	})
});

let restore_post_content_lock = true;
$('.restore-post-content').on('click', function() {
	let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
	let post_id = button.find('.post-id').val();
	
    button.addClass('white-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

	if (!restore_post_content_lock) return;
    restore_post_content_lock = false;

	$.ajax({
		type: 'get',
		url: '/admin/posts/data?post_id='+post_id,
		success: function(post) {
			$('#post-title').val(post.title);
			$('#post-meta-title').val(post.title_meta);
			$('#post-slug').val(post.slug);
			post_editor.setData(post.content);

			// Discussion section
			$('#allow-comments').prop('checked', post.allow_comments==1);
			$('#allow-reactions').prop('checked', post.allow_reactions==1);
			// Summary section
			$('#post-summary').val(post.summary);
			// thumbnail image section
			if(post.thumbnail.exists) {
				$('.thumbnail-image-upload-box').addClass('none');
				$('.uploaded-thumbnail-image-box').removeClass('none');
				$('#post-thumbnail-image-metadata-id').val(post.thumbnail.metadata_id);
				$('.uploaded-thumbnail-image-box .selected-thumbnail-image').attr('src', post.thumbnail.path);
				handle_image_center_fill($('.selected-thumbnail-image'));
			} else {
				$('.thumbnail-image-upload-box').removeClass('none');
				$('.uploaded-thumbnail-image-box').addClass('none');
				$('#post-thumbnail-image-metadata-id').val('');
				$('.uploaded-thumbnail-image-box .selected-thumbnail-image').attr('src', '');
			}
			// Tags
			$('.post-tags-wrapper .post-tag-item').remove();
			for(let i = 0; i < post.tags.length; i++) {
				let tag = $('.post-tag-item-skeleton').clone(true);
				tag.find('.tag-text').text(post.tags[i]);
				tag.removeClass('post-tag-item-skeleton none');
				$(tag).insertBefore('#post-tags-input');
			}
			// Categories
			$('.post-category-id').prop('checked', false);
			$('.post-category-id').each(function() {
				$(this).prop('checked', post.categories.indexOf(parseInt($(this).val())) !== -1);
			});
			// Visibiliy section
			$('.post-visibility-button').removeClass('custom-dropdown-item-selected custom-dropdown-item-selected-style');
			$('.post-visibility-button').each(function() {
				if($(this).find('.visibility').val() == post.visibility) {
					$(this).trigger('click');
					$('body').trigger('click'); // Hide visibility suboptions container
					return false;
				}
			})
			$('.post-visibility').val(post.visibility);
			$('#post-password-input').val(post.password);

			left_bottom_notification('post data restored successfully.');
		},
		error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            print_top_message(error, 'error');
		},
		complete: function() {
			button.removeClass('white-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

			restore_post_content_lock = true;
		}
	})
});