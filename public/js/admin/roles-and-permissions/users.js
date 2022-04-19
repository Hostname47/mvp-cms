$('body').on('click', (event) => $('#users-search-result-box').addClass('none'));
$('#users-search-result-box, #users-search-input').on('click', (event) => event.stopPropagation());

let last_user_search_query = '';
let user_search_lock = true;
$('#search-for-users-button').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#users-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#users-search-input').val().trim();

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

	$('#users-search-fetch-more-results').addClass('none no-fetch');

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
					let usercomponent = create_user_search_entity(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
                let loadmore = $('#users-search-fetch-more-results');
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
			last_user_search_query = query;
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
			user_search_lock = true;
		}
	})
});

$('#users-search-input').on('keyup', function(event) {
	if(event.key === 'Enter' || event.keyCode === 13)
		$('#search-for-users-button').trigger('click');
});

function create_user_search_entity(user) {
	let usercomponent = $('#users-search-result-box .search-user-factory').clone(true, true);
	usercomponent.removeClass('none search-user-factory');

	let role = user.role;

	usercomponent.attr('href', user.rp_management_link);
	usercomponent.find('.avatar').attr('src', user.avatar);
	usercomponent.find('.fullname').text(user.fullname);
	usercomponent.find('.username').text(user.username);
	
	if(role == null) {
		usercomponent.find('.role').text('normal user');
		usercomponent.find('.role').removeClass('blue bold');
		usercomponent.find('.role').addClass('gray italic');
	} else
		usercomponent.find('.role').text(role);

	return usercomponent;
}

let users_search_fetch_more = $('#users-search-fetch-more-results');
let users_search_results_box = $('#users-search-result-box');
let users_search_fetch_more_lock = true;
if(users_search_results_box.length) {
    users_search_results_box.on('DOMContentLoaded scroll', function() {
        if(users_search_results_box.scrollTop() + users_search_results_box.innerHeight() + 50 >= users_search_results_box[0].scrollHeight) {
            if(!users_search_fetch_more_lock || users_search_fetch_more.hasClass('no-fetch')) return;
            users_search_fetch_more_lock=false;
            
			let results = users_search_results_box.find('.results-container');
			let spinner = users_search_fetch_more.find('.spinner');
            let present_search_members = results.find('.search-user').length;

			spinner.addClass('inf-rotate');
            $.ajax({
				url: '/admin/users/search',
				data: {
					skip: present_search_members,
					k: $('#k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;

					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_user_search_entity(users[i]);
							results.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore)
							users_search_fetch_more.removeClass('none no-fetch');
						else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							users_search_fetch_more.addClass('none no-fetch');
					} else {
						// Results not founf
						results.addClass('none');
						results.find('.no-results-found-box').removeClass('none');
					}
                },
                complete: function() {
                    users_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

/** grant role to user */
$('.open-grant-role-to-user-dialog').on('click', function() {
	$('#grant-role-to-user-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-role-to-grant-button').on('click', function() {
	if($(this).hasClass('role-already-granted')) return;
	let button = $(this);
	let viewer = button;
	while(!viewer.hasClass('global-viewer')) {
		viewer = viewer.parent();
	}
	let role = button.find('.role-id').val();
	let user = button.find('.user-id').val();

	let loadingbox = viewer.find('.loading-box');
	let selectionbox = viewer.find('.role-selection-box');
	let contentbox = viewer.find('.global-viewer-content-box');

	contentbox.html('');
	selectionbox.addClass('none');

	let spinner = loadingbox.find('.spinner');
	loadingbox.find('.role-name').text(button.find('.role-name').val());
	loadingbox.removeClass('none');
	spinner.addClass('inf-rotate');
	
	$.ajax({
		url: '/admin/roles/viewers/grant-viewer',
		data: {
			role: role,
			user: user
		},
		success: function(response) {
			contentbox.html(response);
			loadingbox.addClass('none');
			selectionbox.addClass('none');
			contentbox.removeClass('none');

			handle_back_to_role_grant_to_user_button(viewer);
			handle_grant_role_to_user_confirmation();
			handle_grant_role_to_user_button();
		},
		error: function(response) {
			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');

			loadingbox.addClass('none');
			selectionbox.removeClass('none');
		},
		complete: function() {
			spinner.removeClass('inf-rotate');
		}
	})
});

function handle_back_to_role_grant_to_user_button(viewer) {
	$('.back-to-role-grant-to-user-selection').on('click', function() {
		viewer.find('.loading-box').addClass('none');
		viewer.find('.role-selection-box').removeClass('none');
		viewer.find('.global-viewer-content-box').addClass('none');
	});
}

function handle_grant_role_to_user_confirmation() {
	$('#grant-role-to-user-confirm-input').on('input', function() {
		let confirmation_input = $(this);
		let confirmation_value = $('#grant-role-to-user-confirm-value').val();
		let button = $('#grant-role-to-user-button');
		
		if(confirmation_input.val() == confirmation_value) {
			grant_role_to_user_confirmed = true;
			button.removeClass('green-bs-disabled');
		} else {
			grant_role_to_user_confirmed = false;
			button.addClass('green-bs-disabled');
		}
	});
}

let grant_role_to_user_confirmed = false;
let grant_role_to_user_lock = true;
function handle_grant_role_to_user_button() {
	$('#grant-role-to-user-button').on('click', function() {
		if(!grant_role_to_user_confirmed || !grant_role_to_user_lock) return;
		grant_role_to_user_lock = false;

		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');

		button.addClass('green-bs-disabled');
		spinner.addClass('inf-rotate');
		buttonicon.addClass('none');
		spinner.removeClass('opacity0');

		$.ajax({
			type: 'post',
			url: '/admin/roles/grant-to-users',
			data: {
				role: button.find('.role-id').val(),
				users: [button.find('.user-id').val()],
			},
			success: function(response) {
				location.reload();
			},
			error: function(response) {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				buttonicon.removeClass('none');
				button.removeClass('green-bs-disabled');

				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');

				grant_role_to_user_lock = true;
			},
		});
	});
}

/** Direct-Attach permissions to user */
$('.open-attach-permissions-to-user-dialog').on('click', function() {
	$('#attach-permissions-to-user-viewer').removeClass('none');
    disable_page_scroll();
});

$('#attach-permissions-to-user-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#attach-permissions-to-user-confirm-value').val();
	let button = $('#attach-permissions-to-user-button');
    
	attach_permissions_to_user_confirmed = false;
    if(confirmation_input.val() == confirmation_value) {
		if(!$('.permission-id-to-attach-select-input:checked').length) {
			print_top_message('You need to select at least one permission to attach to user', 'warning');
			disable_attach_permissions_to_user_button();
			return;
		}

		attach_permissions_to_user_confirmed = true;
		button.removeClass('green-bs-disabled');
    } else
		disable_attach_permissions_to_user_button();
});

function disable_attach_permissions_to_user_button() {
	let button = $('#attach-permissions-to-user-button');
	let confirmation_input = $('#attach-permissions-to-user-confirm-input');
    let confirmation_value = $('#attach-permissions-to-user-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_value + ' - x');

	button.addClass('green-bs-disabled');
	attach_permissions_to_user_confirmed = false;
}

let attach_permissions_to_user_confirmed = false;
let attach_permissions_to_user_lock = true;
$('#attach-permissions-to-user-button').on('click', function() {
	if(!attach_permissions_to_user_confirmed || !attach_permissions_to_user_lock) return;
	attach_permissions_to_user_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('.permission-id-to-attach-select-input:checked').each(function() {
		permissions.push($(this).val());	
	});
	
	let data = {
		users: [$('#user-id').val()],
		permissions: permissions
	};

	button.addClass('green-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/users/attach-permissions',
		data: data,
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			button.removeClass('green-bs-disabled');
			spinner.removeClass('inf-rotate');
			buttonicon.removeClass('none');
			spinner.addClass('opacity0');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');

			attach_permissions_to_user_lock = true;
		},
	});
});