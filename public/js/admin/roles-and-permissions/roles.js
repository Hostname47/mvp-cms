$('.open-create-role-dialog').on('click', function() {
    let viewer = $('#create-role-viewer');
	let viewerbox = viewer.find('.viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);
    
	viewer.removeClass('none');
    disable_page_scroll();
});

$('#create-role-confirm-input').on('input', function() {
    if(!create_role_lock) return;

    let confirmation_input = $(this);
    let confirmation_value = $('#create-role-confirm-value').val();
	let button = $('#create-role-button');
    
	create_role_confirmed = false;
    if(confirmation_input.val().trim() == confirmation_value) {
		create_role_confirmed = true;
		button.removeClass('green-bs-disabled');
    } else
        button.addClass('green-bs-disabled');
});

let create_role_confirmed = false;
let create_role_lock = true;
$('#create-role-button').on('click', function() {
    if(!create_role_confirmed) return;

    let title = $('#create-role-title-input');
    let slug = $('#create-role-slug-input');
    let description = $('#create-role-description-input');
    let error_container = $('#create-role-error-container');

    $('#create-role-viewer .error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_role_input(title.val() != '', title, error_container, 'Title field is required')) return;
    if(!validate_role_input(slug.val() != '', slug, error_container, 'Slug field is required')) return;
    if(!validate_role_input(description.val() != '', description, error_container, 'Description field is required')) return;

    if(!create_role_lock) return;
    create_role_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('green-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/roles',
        data: {
            title: title.val(),
            slug: slug.val(),
            description: description.val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function (response) {
            create_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('green-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            validate_role_input(false, false, error_container, error);
        }
    })
});

let update_role_lock = true;
$('#update-role-button').on('click', function() {
    let title = $('#update-role-title-input');
    let slug = $('#update-role-slug-input');
    let description = $('#update-role-description-input');
    let error_container = $('#update-role-error-container');

    $('#update-role-section .error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_role_input(title.val() != '', title, error_container, 'Title field is required')) return;
    if(!validate_role_input(slug.val() != '', slug, error_container, 'Slug field is required')) return;
    if(!validate_role_input(description.val() != '', description, error_container, 'Description field is required')) return;

    if(!update_role_lock) return;
    update_role_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: '/admin/roles',
        data: {
            role_id: $('#role-id').val(),
            title: title.val(),
            slug: slug.val(),
            description: description.val()
        },
        success: function(response) {
            window.location.href = response;
        },
        error: function (response) {
            update_role_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            validate_role_input(false, false, error_container, error);
        }
    })
});

function validate_role_input(condition, input, error_container, error_message) {
    if(!condition) {
        error_container.find('.message-text').text(error_message);
        error_container.removeClass('none');
        if(input)
            input.parent().find('.error-asterisk').css('display', 'inline');

        return false;
    }
    return true;
}

/** grant role to users */

$('.open-grant-role-dialog').on('click', function() {
	$('#grant-role-to-users-viewer').removeClass('none');
    disable_page_scroll();
});

$('body').on('click', (event) => $('#role-members-search-result-box').addClass('none'));
$('#role-members-search-result-box,#role-member-search-input').on('click', (event) => event.stopPropagation());
$('#role-member-search-input').on('keyup', function(event) {
    if(event.key === 'Enter' || event.keyCode === 13)
		$('#role-search-for-member-to-grant').trigger('click');
});

$('.open-role-grant-dialog').on('click', function() {
	$('#grant-role-to-users-viewer').removeClass('none');
    disable_page_scroll();
});

let role_last_member_search_query = '';
let role_member_search_lock = true;
$('#role-search-for-member-to-grant').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#role-members-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#role-member-search-input').val();
	let role = $('#role-id').val();

	if(query == '') return;
	if(query == role_last_member_search_query) {
		if(role_member_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	// Here if the flow reaches here and the lock is false meaning admin should wait until he get results from previous search
	if(!role_member_search_lock) return;
	role_member_search_lock = false;

	$('#role-users-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		type: 'get',
		url: `/admin/roles/users/search?role=${role}&k=${query}`,
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let users = response.users;
			let hasmore = response.hasmore;

			if(users.length) {
				for(let i = 0; i < users.length; i++) {
					let usercomponent = create_role_member_search_component(users[i]);
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
			role_last_member_search_query = query;
			$('#role-user-k').val(query); // This is used in fetch more
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
			role_member_search_lock = true;
		}
	})
});

let role_user_search_fetch_more = $('#role-users-fetch-more-results');
let role_user_search_results_box = $('#role-members-search-result-box');
let role_user_search_fetch_more_lock = true;
if(role_user_search_results_box.length) {
    role_user_search_results_box.on('DOMContentLoaded scroll', function() {
        if(role_user_search_results_box.scrollTop() + role_user_search_results_box.innerHeight() + 50 >= role_user_search_results_box[0].scrollHeight) {
			// no-fetch class is attached to fetch_more loader when no more results are there to prevent fetch
            if(!role_user_search_fetch_more_lock || role_user_search_fetch_more.hasClass('no-fetch')) return;
            role_user_search_fetch_more_lock=false;
            
			let role_id = $('#role-id').val();
			let results = $('#role-members-search-result-box .results-container');
			let spinner = role_user_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_role_users = role_user_search_results_box.find('.results-container .role-member-search-user').length;

			spinner.addClass('inf-rotate');
            $.ajax({
				url: '/admin/roles/users/search/fetchmore',
				data: {
					role: role_id,
					skip: present_role_users,
					k: $('#role-user-k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;
		
					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_role_member_search_component(users[i]);
							results.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore) {
							let loadmore = $('#role-users-fetch-more-results');
							loadmore.removeClass('none no-fetch');
						} else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							$('#role-users-fetch-more-results').addClass('none no-fetch');
					} else {
						// Results not found
						results.addClass('none');
						no_results_box.removeClass('none');
					}
                },
                complete: function() {
                    role_user_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}

$('.role-select-member').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('role-member-search-user'))
		selected_user_component = selected_user_component.parent();

	let selected_members_box = $('#role-members-selected-box');
	let empty_selected_members_box = $('#empty-role-members-selected-box');

	let user_component = $('.selected-role-member-to-get-role-factory').clone(true, true);
	let uid = selected_user_component.find('.role-user-id').val();
	user_component.find('.selected-user-id').val(uid);
	user_component.find('.selected-user-avatar').attr('src', selected_user_component.find('.role-user-avatar').attr('src'));
	user_component.find('.selected-user-fullname').text(selected_user_component.find('.role-user-fullname').text());
	user_component.find('.selected-user-profilelink').attr('href', selected_user_component.find('.role-user-profilelink').attr('href'));
	user_component.find('.selected-user-username').text(selected_user_component.find('.role-user-username').text());
	user_component.find('.selected-user-role').text(selected_user_component.find('.role-user-role').text());

	user_component.removeClass('none selected-role-member-to-get-role-factory');

	if(!role_user_already_selected(uid))
		selected_members_box.append(user_component);

	if(selected_members_box.hasClass('none')) {
		selected_members_box.removeClass('none');
		empty_selected_members_box.addClass('none');
	}
});

function role_user_already_selected(uid) {
	let already_selected = false;
	$('.selected-role-member-to-get-role').each(function() {
		if($(this).find('.selected-user-id').val() == uid) {
			already_selected = true;
			return false;
		}
	});

	return already_selected;
}

$('.remove-selected-user-from-selection').on('click', function() {
	let selected_user_component = $(this);
	while(!selected_user_component.hasClass('selected-role-member-to-get-role')) {
		selected_user_component = selected_user_component.parent();
	}

	selected_user_component.remove();

	if(!$('#role-members-selected-box .selected-role-member-to-get-role').length) {
		$('#role-members-selected-box').addClass('none');
		$('#empty-role-members-selected-box').removeClass('none');
		disable_grant_role_button();
	}
});

function create_role_member_search_component(user) {
	let usercomponent = $('#role-members-search-result-box .role-member-search-user-factory').clone(true, true);
	usercomponent.removeClass('none role-member-search-user-factory');

	let role = user.role;
	let already_has_role = user.already_has_this_role;

	usercomponent.find('.role-user-id').val(user.id);
	usercomponent.find('.role-user-avatar').attr('src', user.avatar);
	usercomponent.find('.role-user-fullname').text(user.fullname);
	usercomponent.find('.role-user-username').text(user.username);
	usercomponent.find('.role-user-user-manage-link').attr('href', user.user_manage_link);
	
	if(role == null) {
		usercomponent.find('.role-user-role').text('normal user');
		usercomponent.find('.role-user-role').removeClass('blue bold');
		usercomponent.find('.role-user-role').addClass('gray italic');
	} else
		usercomponent.find('.role-user-role').text(role);

	if(already_has_role) {
		usercomponent.find('.role-select-member').remove();
		usercomponent.find('.already-has-role').removeClass('none');
	} else {
		usercomponent.find('.already-has-role').remove();
		usercomponent.find('.role-select-member').removeClass('none');
	}

	return usercomponent;
}

function disable_grant_role_button() {
	let confirmation_input = $('#grant-role-confirm-input');
	let confirmation_value = $('#grant-role-confirm-value').val();
	if(confirmation_input.val() == confirmation_value)
		confirmation_input.val(confirmation_input.val() + ' - x');

	$('#grant-role-button').addClass('green-bs-disabled');
	grant_role_confirmed = false;
}

$('#grant-role-confirm-input').on('input', function() {
    let input_value = $(this).val();
    let confirm_value = $('#grant-role-confirm-value').val();
	let grantbutton = $('#grant-role-button');
    
    grant_role_confirmed = false;
    if(input_value == confirm_value) {
		// Check if at least one member selected
		if(!$('#role-members-selected-box .selected-role-member-to-get-role').length) {
			// Only append error to confirmation when the values match
			let confirmation_input = $('#grant-role-confirm-input');
			let confirmation_value = $('#grant-role-confirm-value').val();
			if(confirmation_input.val() == confirmation_value)
				confirmation_input.val(confirmation_input.val() + ' - x');

            print_top_message('You need to select at least one member to attach role into', 'error');
			grantbutton.addClass('green-bs-disabled');
			grant_role_confirmed = false;

			return;
		} else {
			grantbutton.removeClass('green-bs-disabled');
			grant_role_confirmed = true;
		}
    } else {
        // Only append error to confirmation when the values match
		let confirmation_input = $('#grant-role-confirm-input');
		let confirmation_value = $('#grant-role-confirm-value').val();
		if(confirmation_input.val() == confirmation_value)
			confirmation_input.val(confirmation_input.val() + ' - x');

		$('#grant-role-button').addClass('green-bs-disabled');
		grant_role_confirmed = false;
    }
});

let grant_role_confirmed = false;
let grant_role_lock = true;
$('#grant-role-button').on('click', function() {
    if(!grant_role_lock || !grant_role_confirmed) return;
	grant_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	let selected_members = [];
	$('#role-members-selected-box .selected-role-member-to-get-role').each(function() {
		selected_members.push($(this).find('.selected-user-id').val());
	});

	let data = {
		role: $('#role-id').val(),
		users: selected_members,
	};

	button.addClass('green-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/grant-to-users',
		data: data,
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

			grant_role_lock = true;
		}
	});
});

/** revoke role from user */
let last_user_to_revoke_role = null;
let last_role_to_revoke = null;
let open_revoke_dialog_lock = true;
$('.open-revoke-role-dialog').on('click', function() {
	let viewer = $('#revoke-role-from-users-viewer');
	let button = $(this);
	let user_id = button.find('.user-id').val();
	let role_id = button.find('.role-id').val();

	if(user_id != last_user_to_revoke_role || role_id != last_role_to_revoke) {
		if(!open_revoke_dialog_lock) return;
		open_revoke_dialog_lock = false;

		let spinner = viewer.find('.loading-viewer-spinner');
		spinner.removeClass('opacity0');
		spinner.addClass('inf-rotate');
		viewer.find('.global-viewer-content-box').html('');

		$.ajax({
			type: 'get',
			url: `/admin/roles/viewers/revoke-viewer?role=${role_id}&user=${user_id}`,
			success: function(response) {
				viewer.find('.global-viewer-content-box').html(response);
				handle_role_revoke_confirmation_input();
				handle_role_revoke_button();
				last_user_to_revoke_role = user_id;
				last_role_to_revoke = role_id;
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
			},
			complete: function() {
				spinner.addClass('opacity0');
				spinner.removeClass('inf-rotate');
				open_revoke_dialog_lock = true;
			}
		});
	}

	disable_page_scroll();
	viewer.removeClass('none');
});

let revoke_role_confirmed = false;
function handle_role_revoke_confirmation_input() {
	$('#revoke-role-confirm-input').on('input', function() {
		let input_value = $(this).val();
		let confirm_value = $('#revoke-role-confirm-value').val();
		let revokebutton = $('#revoke-role-button');
		
		revoke_role_confirmed = false;
		if(input_value == confirm_value) {
			revokebutton.removeClass('red-bs-disabled');
			revoke_role_confirmed = true;
		} else
			revokebutton.addClass('red-bs-disabled');
	});
}

let revoke_role_lock = true;
function handle_role_revoke_button() {
	$('#revoke-role-button').on('click', function() {
		if(!revoke_role_lock || !revoke_role_confirmed) return;
		revoke_role_lock = false;
	
		let button = $(this);
		let buttonicon = button.find('.icon-above-spinner');
		let spinner = button.find('.spinner');

		button.addClass('red-bs-disabled');
		spinner.addClass('inf-rotate');
		buttonicon.addClass('none');
		spinner.removeClass('opacity0');
		
		$.ajax({
			type: 'post',
			url: '/admin/roles/revoke-from-users',
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
				button.removeClass('red-bs-disabled');

				let errorObject = JSON.parse(response.responseText);
				let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
				if(errorObject.errors) {
					let errors = errorObject.errors;
					error = errors[Object.keys(errors)[0]][0];
				}
				print_top_message(error, 'error');

				revoke_role_lock = true;
			},
		});
	});
}

/** Attach permissions to role */
$('.open-attach-permissions-to-role-dialog').on('click', function() {
	$('#attach-permissions-to-role-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-permission-to-attach-to-role').on('click', function() {
	let button = $(this);
	let pid = button.find('.pid').val();

	let already_selected = false;
	$('#role-permissions-selected-box .selected-permission-to-attach-to-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			already_selected = true;
			return false;
		}
	})
	if(already_selected) return;

	button.find('.x-ico').addClass('none');
	button.find('.v-ico').removeClass('none');

	let permission_component = $('.selected-permission-to-attach-to-role-factory').clone(true, true);
	permission_component.find('.permission-title').text(button.find('.permission-title').text());
	permission_component.find('.pid').val(pid);
	permission_component.removeClass('none selected-permission-to-attach-to-role-factory');

	$('#empty-role-permissions-selected-box').addClass('none');
	$('#role-permissions-selected-box').removeClass('none');
	$('#role-permissions-selected-box').append(permission_component);
});

$('.remove-selected-permission-to-attach-to-role').on('click', function() {
	let component = $(this);
	while(!component.hasClass('selected-permission-to-attach-to-role')) {
		component = component.parent();
	}
	let pid = component.find('.pid').val();
	$('.select-permission-to-attach-to-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			$(this).find('.x-ico').removeClass('none');
			$(this).find('.v-ico').addClass('none');
			return false;
		}
	})
	component.remove();

	if(!$('#role-permissions-selected-box .selected-permission-to-attach-to-role').length) {
		$('#empty-role-permissions-selected-box').removeClass('none');
		$('#role-permissions-selected-box').addClass('none');
		disable_attach_permission_to_role_button();
	}
});

let attach_permissions_to_role_confirmed = false;
$('#attach-permissions-to-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#attach-permissions-to-role-confirm-value').val();
	let button = $('#attach-permissions-to-role-button');
    
    attach_permissions_to_role_confirmed = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		if(!$('#role-permissions-selected-box .selected-permission-to-attach-to-role').length) {
			disable_attach_permission_to_role_button();
			print_top_message('You need to select at least one permission to attach to role.', 'warning');
			return;
		}

		button.removeClass('green-bs-disabled');
		attach_permissions_to_role_confirmed = true;
    } else
		disable_attach_permission_to_role_button();
});

function disable_attach_permission_to_role_button() {
	let button = $('#attach-permissions-to-role-button');
	let confirmation_input = $('#attach-permissions-to-role-confirm-input');
	let confirmation_value = $('#attach-permissions-to-role-confirm-value').val();
	if(confirmation_input.val() == confirmation_value) {
		confirmation_input.val(confirmation_value + ' - x');
	}
	button.addClass('green-bs-disabled');
	attach_permissions_to_role_confirmed = false;
}

let attach_permissions_to_role_lock = true;
$('#attach-permissions-to-role-button').on('click', function() {
	if(!attach_permissions_to_role_lock || !attach_permissions_to_role_confirmed) return;
	attach_permissions_to_role_lock = false;
	
	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('#role-permissions-selected-box .selected-permission-to-attach-to-role').each(function() {
		permissions.push($(this).find('.pid').val());
	});

	button.addClass('green-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/attach-permissions',
		data: {
			role: $('#role-id').val(),
			permissions: permissions
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

			attach_permissions_to_role_lock = true;
		},
	});
});

/** Detach permissions from role */
$('.open-detach-permissions-from-role-dialog').on('click', function() {
	$('#detach-permissions-from-role-viewer').removeClass('none');
    disable_page_scroll();
});

$('.select-permission-to-detach-from-role').on('click', function() {
	let button = $(this);
	let pid = button.find('.pid').val();

	let already_selected = false;
	$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			already_selected = true;
			return false; // Just break the loop
		}
	})
	if(already_selected) return;

	button.find('.x-ico').addClass('none');
	button.find('.v-ico').removeClass('none');

	let permission_component = $('.selected-permission-to-detach-from-role-factory').clone(true, true);
	permission_component.find('.permission-title').text(button.find('.permission-title').text());
	permission_component.find('.pid').val(pid);
	permission_component.removeClass('none selected-permission-to-detach-from-role-factory');

	$('#empty-role-permissions-to-detach-selected-box').addClass('none');
	$('#role-permissions-to-detach-selected-box').removeClass('none');
	$('#role-permissions-to-detach-selected-box').append(permission_component);
});

$('.remove-selected-permission-to-detach-from-role').on('click', function() {
	let component = $(this);
	while(!component.hasClass('selected-permission-to-detach-from-role')) {
		component = component.parent();
	}
	let pid = component.find('.pid').val();
	$('.select-permission-to-detach-from-role').each(function() {
		if($(this).find('.pid').val() == pid) {
			$(this).find('.x-ico').removeClass('none');
			$(this).find('.v-ico').addClass('none');
			return false;
		}
	})
	component.remove();

	if(!$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').length) {
		$('#empty-role-permissions-to-detach-selected-box').removeClass('none');
		$('#role-permissions-to-detach-selected-box').addClass('none');
		disable_detach_permissions_from_role_button();
	}
});

let detach_permissions_from_role_confirmed = false;
$('#detach-permissions-from-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#detach-permissions-from-role-confirm-value').val();
	let button = $('#detach-permissions-from-role-button');
    
    detach_permissions_from_role_confirmed = false;
    if(confirmation_input.val() == confirmation_value) {
		// Check if at least one member selected
		if(!$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').length) {
			disable_detach_permissions_from_role_button();
			print_top_message('You need to select at least one permission to detach from role', 'warning');
			return;
		}

		button.removeClass('red-bs-disabled');
		detach_permissions_from_role_confirmed = true;
    } else {
		disable_detach_permissions_from_role_button();
    }
});

function disable_detach_permissions_from_role_button() {
	let button = $('#detach-permissions-from-role-button');
	let input = $('#detach-permissions-from-role-confirm-input');
	let conf = $('#detach-permissions-from-role-confirm-value').val();
	if(input.val() == conf) {
		input.val(conf + ' - x');
	}
	button.addClass('red-bs-disabled');
	detach_permissions_from_role_confirmed = false;
}

let detach_permissions_from_role_lock = true;
$('#detach-permissions-from-role-button').on('click', function() {
	if(!detach_permissions_from_role_lock || !detach_permissions_from_role_confirmed) return;
	detach_permissions_from_role_lock = false;
	
	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');
	
	let permissions = [];
	$('#role-permissions-to-detach-selected-box .selected-permission-to-detach-from-role').each(function() {
		permissions.push($(this).find('.pid').val());
	});
	
	let data = {
		role: $('#role-id').val(),
		permissions: permissions
	};

	button.addClass('red-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/roles/detach-permissions',
		data: data,
		success: function(response) {
			location.reload();
		},
		error: function(response) {
			spinner.addClass('opacity0');
			spinner.removeClass('inf-rotate');
			buttonicon.removeClass('none');
			button.removeClass('red-bs-disabled');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');

			detach_permissions_from_role_lock = true;
		},
	});
});

/** delete role - DANGER ZONE */
$('.open-delete-role-dialog').on('click', function() {
	$('#delete-role-viewer').removeClass('none');
    disable_page_scroll();
});

let delete_role_confirmed = false;
$('#delete-role-confirm-input').on('input', function() {
    let confirmation_input = $(this);
    let confirmation_value = $('#delete-role-confirm-value').val();
	let button = $('#delete-role-button');
    
	delete_role_confirmed = false;
    if(confirmation_input.val() == confirmation_value) {
		delete_role_confirmed = true;
		button.removeClass('red-bs-disabled');
    } else
		button.addClass('red-bs-disabled');
});

let delete_role_lock = true;
$('#delete-role-button').on('click', function() {
	if(!delete_role_confirmed || !delete_role_lock) return;
	delete_role_lock = false;

	let button = $(this);
	let buttonicon = button.find('.icon-above-spinner');
	let spinner = button.find('.spinner');

	button.addClass('red-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'delete',
		url: '/admin/roles',
		data: {
			role_id: $('#role-id').val()
		},
		success: function(response) {
			window.location.href = response;
		},
		error: function(response) {
			spinner.addClass('opacity0');
			spinner.removeClass('inf-rotate');
			buttonicon.removeClass('none');
			button.removeClass('red-bs-disabled');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');

			delete_role_lock = true;
		},
	});
});

/** roles priorities */
$('#sort-roles-components-by-priority').on('click', function() {
    $('.role-to-manage').each(function() {
        if(!validate_roles_priorities()) return;
        let roles = $('#roles-to-manage-wrapper .role-to-manage');
    
        // Reorder roles based on priority value in ascending order (using bubble sort)
        let count = roles.length;
        let i, j;
        for (i = 0; i < count-1; i++) {
            roles = $('#roles-to-manage-wrapper .role-to-manage');
            // (count-i-1) because last i elements will be in the right place
            for (j = 0; j < count-i-1; j++) {
                let rolea = $(roles[j]);
                let roleb = $(roles[j+1]);
                let ra = parseInt(rolea.find('.role-priority').first().val());
                let rb = parseInt(roleb.find('.role-priority').first().val());
    
                if(ra > rb) {
                    rolea.insertAfter(roleb);
                    roles = $('#roles-to-manage-wrapper .role-to-manage');
                }
            }
        }
    });
});

let update_roles_priorities_lock = true;
$('#update-roles-priorities').on('click', function() {
    if(!validate_roles_priorities()) return;
    let roles = $('#roles-to-manage-wrapper .role-to-manage');

    if(!update_roles_priorities_lock) return;
    update_roles_priorities_lock = false;

    let button = $(this);
	let spinner = button.find('.spinner');
	let buttonicon = button.find('.icon-above-spinner');

	let roles_ids=[];
	let roles_priorities=[];
	roles.each(function() {
		roles_ids.push($(this).find('.role-id').first().val());
		roles_priorities.push($(this).find('.role-priority').first().val());
	});

	spinner.addClass('inf-rotate');
	spinner.removeClass('opacity0');
	buttonicon.addClass('none');
	button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'patch',
        url: '/admin/roles/priorities',
        data: {
            roles: roles_ids,
            priorities: roles_priorities
        },
        success: function() {
            location.reload();
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            update_roles_priorities_lock = true;
        }
    })
});

function validate_roles_priorities() {
	let invalid_priority = false;
	let roles = $('#roles-to-manage-wrapper .role-to-manage');
	roles.each(function() {
		if(!parseInt($(this).find('.role-priority').first().val())) {
			invalid_priority = true;
			return false;
		}
	});

	if(invalid_priority) {
		print_top_message('A priority value of one of roles is invalid. (priority should be a number)', 'error');
		return false;
	}

	return true;
}
