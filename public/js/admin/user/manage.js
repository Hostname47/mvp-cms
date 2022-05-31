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

	$('#user-search-fetch-more-results').addClass('none no-fetch');

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
					let loadmore = $('#role-users-fetch-more-results');
					loadmore.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					$('#role-users-fetch-more-results').addClass('none no-fetch');
				}
			} else {
				// Results not founf
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

function create_user_to_manage_search_component(user) {
    let usercomponent = $('#user-search-result-box .search-entity-factory').clone(true);
	usercomponent.removeClass('none search-entity-factory');

    usercomponent.attr('href', user.user_management_link);
	usercomponent.find('.avatar').attr('src', user.avatar);
	usercomponent.find('.fullname').text(user.fullname);
	usercomponent.find('.username').text(user.username);

	return usercomponent;
}
