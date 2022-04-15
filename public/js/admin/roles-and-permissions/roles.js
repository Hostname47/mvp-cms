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
    if(event.key === 'Enter' || event.keyCode === 13) {
		$('#role-search-for-member-to-grant').trigger('click');
	}
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
			$('#rum-k').val(query); // This is used in fetch more
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
			display_top_informer_message(error, 'error');
		},
		complete: function() {
			role_member_search_lock = true;
		}
	})
});

function create_role_member_search_component(user) {
	let usercomponent = $('#role-members-search-result-box .role-member-search-user-factory').clone(true);
	usercomponent.removeClass('none role-member-search-user-factory');

	let role = user.role;
	let already_has_role = user.already_has_this_role;

	usercomponent.find('.ru-uid').val(user.id);
	usercomponent.find('.ru-avatar').attr('src', user.avatar);
	usercomponent.find('.ru-fullname').text(user.fullname);
	usercomponent.find('.ru-username').text(user.username);
	usercomponent.find('.ru-user-manage-link').attr('href', user.user_manage_link);
	
	if(role == null) {
		usercomponent.find('.ru-role').text('normal user');
		usercomponent.find('.ru-role').removeClass('blue bold');
		usercomponent.find('.ru-role').addClass('gray italic');
	} else
		usercomponent.find('.ru-role').text(role);

	if(already_has_role) {
		usercomponent.find('.role-select-member').remove();
		usercomponent.find('.already-has-role').removeClass('none');
	} else {
		usercomponent.find('.already-has-role').remove();
		usercomponent.find('.role-select-member').removeClass('none');
	}

	return usercomponent;
}