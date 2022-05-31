$('body').on('click', (event) => $('#user-search-result-box').addClass('none'));
$('#user-search-result-box, #user-search-input').on('click', (event) => event.stopPropagation());

let last_user_search_query = '';
let user_search_lock = true;
$('#search-for-user-button').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#user-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');
    let fetch_more = $('#user-search-fetch-more-results');

	let query = $('#user-search-input').val().trim();

	if(query == '') return;
	if(query == last_user_search_query) {
		if(user_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	if(!user_search_lock) return;
	user_search_lock = false;

	fetch_more.addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		url: '/admin/users/search?k='+query,
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let users = response.users;
			let hasmore = response.hasmore;

			if(users.length) {
				for(let i = 0; i < users.length; i++) {
					let usercomponent = create_user_to_manage_search_component(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
				if(hasmore) {
					fetch_more.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					fetch_more.addClass('none no-fetch');
				}
			} else {
				// Results not found
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');

			last_user_search_query = query;
			$('#user-to-manage-k').val(query); // This is used in fetch more
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
			user_search_lock = true;
		}
	})
});
$('#user-search-input').on('keyup', function(event) {
	if(event.key === 'Enter' || event.keyCode === 13)
		$('#search-for-user-button').trigger('click');
});

let user_search_fetch_more = $('#user-search-fetch-more-results');
let user_search_results_box = $('#user-search-result-box');
let user_search_fetch_more_lock = true;
if(user_search_results_box.length) {
    user_search_results_box.on('DOMContentLoaded scroll', function() {
        if(user_search_results_box.scrollTop() + user_search_results_box.innerHeight() + 50 >= user_search_results_box[0].scrollHeight) {
            if(!user_search_fetch_more_lock || user_search_fetch_more.hasClass('no-fetch')) return;
            user_search_fetch_more_lock=false;
            
			let results_container = $('#user-search-result-box .results-container');
			let spinner = user_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_search_members = results_container.find('.search-entity').length;
			spinner.addClass('inf-rotate');
            $.ajax({
				url: '/admin/users/search',
				data: {
					skip: present_search_members,
					take: 10,
					k: $('#user-to-manage-k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;

					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_user_to_manage_search_component(users[i]);
							results_container.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore)
							user_search_fetch_more.removeClass('none no-fetch');
						else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							user_search_fetch_more.addClass('none no-fetch');
					} else {
						// If scrolling does not find any data for some reason then we hide spinner
						user_search_fetch_more.addClass('none no-fetch');
					}
                },
                complete: function() {
                    user_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

function create_user_to_manage_search_component(user) {
    let usercomponent = $('#user-search-result-box .search-entity-factory').clone(true);
	usercomponent.removeClass('none search-entity-factory');

    usercomponent.attr('href', user.user_management_link);
	usercomponent.find('.avatar').attr('src', user.avatar);
	usercomponent.find('.fullname').text(user.fullname);
	usercomponent.find('.username').text(user.username);

	return usercomponent;
}

$('.um-ban-type').on('change', function() {
    let type = $(this).val();
    if(type == 'temporary') {
        $('#ban-box').find('.temporary-ban-box').removeClass('none');
        $('#ban-box').find('.permanent-ban-box').addClass('none');
    } else {
        $('#ban-box').find('.permanent-ban-box').removeClass('none');
        $('#ban-box').find('.temporary-ban-box').addClass('none');
    }
});
