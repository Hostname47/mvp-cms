/** Create permission */
$('.open-create-permission-dialog').on('click', function() {
	let viewer = $('#create-permission-viewer');
	let viewerbox = viewer.find('.global-viewer-content-box');
	viewerbox.css('margin-top', '30px');
	viewerbox.animate({
		'margin-top': '0'
	}, 200);

	if($(this).find('.scope').length) { // if admin click on + new button on specific scope we set scope in viewer explicitely
        // First we check the existing scope switch
        $('.permission-scope-switch[value="existing"]').trigger('click');
        // Then we set the option according to the clicked scope
		let scope_value = $(this).find('.scope').val();
		let scope_dropdown = viewer.find('.existing-scope');
        // here we have to unselect all scopes
        scope_dropdown.find('option').attr('selected',false);
        // Then select the clickable one
		scope_dropdown.find('option[value="' + scope_value + '"]').attr('selected','selected');
        // Then we outline the dropdown input to show that the scope will be using is the clickable one
		scope_dropdown.css({
			outline: '4px solid rgba(33, 192, 255, 0.19)',
			border: '1px solid rgb(111, 205, 242)'
		});
        // We scroll down a little to show the highlighted scope 
        $('#create-permission-viewer-scrollable').animate({
            scrollTop: 56
        }, 100);
	}
	viewer.removeClass('none');
    disable_page_scroll();
});

$('.permission-scope-switch').on('change', function() {
    let viewer = $('#create-permission-viewer');
    let type = $(this).val();
    if(type == 'existing') {
        // disable new scope input and enable existing scopes dropdown
		viewer.find('.existing-scope').prop('disabled', false);
		viewer.find('.fresh-scope').prop('disabled', true);
    } else {
        viewer.find('.existing-scope').prop('disabled', true);
		viewer.find('.fresh-scope').prop('disabled', false);
    }
});

function validate_permission_input_inputs() {
    let viewer = $('#create-permission-viewer');
    let vscrollable = $('#create-permission-viewer-scrollable');
    let error_container = $('#create-permission-error-container');

    let title = viewer.find('.title');
    let slug = viewer.find('.slug');
    let description = viewer.find('.description');
    let existing_scope = viewer.find('.exisitng-scope');
    let fresh_scope = viewer.find('.fresh-scope');

    viewer.find('.error-asterisk').css('display', 'none');
    error_container.addClass('none');

    if(!validate_permission_input(title.val() != '', title, error_container, 'Title field is required.', vscrollable)) return false;
    if(!validate_permission_input(slug.val() != '', slug, error_container, 'Slug field is required.', vscrollable)) return false;
    if(!validate_permission_input(description.val() != '', description, error_container, 'Description field is required.', vscrollable)) return false;

    // Validate scope
    if($('.permission-scope-switch:checked').val() == 'fresh')
        if(!validate_permission_input(fresh_scope.val() != '', fresh_scope, error_container, 'Permission scope field is required', vscrollable)) return false;
    else
        if(!validate_permission_input(!existing_scope.val(), null, error_container, 'Permission scope field is required', vscrollable)) return false;

    return true;
}

function validate_permission_input(condition, input, error_container, error_message, scrollable=null) {
    if(!condition) {
        error_container.find('.message-text').text(error_message);
        error_container.removeClass('none');

        if(input) {
            let input_wrapper = input;
            while(!input_wrapper.hasClass('input-wrapper')) input_wrapper = input_wrapper.parent();
            input_wrapper.find('.error-asterisk').css('display', 'inline');
        }

        if(scrollable)
            scrollable.animate({
                scrollTop: 0
            }, 100);

        return false;
    }
    return true;
}

let create_permission_lock = true;
$('#create-permission-button').on('click', function() {
    if(!validate_permission_input_inputs()) return;
    let viewer = $('#create-permission-viewer');
	let data = {
        title: viewer.find('.title').val(),
        slug: viewer.find('.slug').val(),
        description: viewer.find('.description').val(),
	};

    if($('.permission-scope-switch:checked').val() == 'fresh')
        data.scope = viewer.find('.fresh-scope').val();
    else
        data.scope = viewer.find('.existing-scope').val();

    
    if(!create_permission_lock) return;
    create_permission_lock = false;

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');

    button.addClass('green-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

	$.ajax({
		type: 'post',
		url: '/admin/permissions',
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

            let error_container = $('#create-permission-error-container');
            let vscrollable = $('#create-permission-viewer-scrollable');
            validate_permission_input(false, null, error_container, error, vscrollable)

			create_permission_lock = true;
		}
	});
});

/** Update permission */
$('.select-scope').on('click', function() {
    $('#update-permission-scope-input').val($(this).find('.scope').text());
    $('body').trigger('click');
});

let update_permission_lock = true;
$('#update-permission-button').on('click', function() {
    let title = $('#update-permission-title-input');
    let slug = $('#update-permission-slug-input');
    let description = $('#update-permission-description-input');
    let scope = $('#update-permission-scope-input');
    let error_container = $('#update-permission-error-container');

    if(!validate_permission_input(title.val()!='', title, error_container, 'Title field is required.')) return;
    if(!validate_permission_input(slug.val()!='', slug, error_container, 'Slug field is required.')) return;
    if(!validate_permission_input(description.val()!='', description, error_container, 'Description field is required.')) return;
    if(!validate_permission_input(scope.val()!='', scope, error_container, 'Scope field is required.')) return;

    $('#update-permission-section .error-asterisk').css('display', 'none');
    error_container.addClass('none');

    let button = $(this);
    let buttonicon = button.find('.icon-above-spinner');
    let spinner = button.find('.spinner');
    
    button.addClass('dark-bs-disabled');
	spinner.addClass('inf-rotate');
	buttonicon.addClass('none');
	spinner.removeClass('opacity0');

    if(!update_permission_lock) return;
    update_permission_lock = false;

    $.ajax({
        type: 'patch',
        url: '/admin/permissions',
        data: {
            permission_id: $('#permission-id').val(),
            title: title.val(),
            slug: slug.val(),
            description: description.val(),
            scope: scope.val(),
        },
        success: function() {
            location.reload();
        },
        error: function(response) {
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('dark-bs-disabled');

			let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}

            let error_container = $('#update-permission-error-container');
            validate_permission_input(false, null, error_container, error)

			update_permission_lock = true;
        }
    })
});

/** attach permission to users */
$('.open-attach-permission-dialog').on('click', function() {
	$('#attach-permission-to-users-viewer').removeClass('none');
    disable_page_scroll();
});

$('body').on('click', (event) => $('#permission-members-search-result-box').addClass('none'));
$('#permission-members-search-result-box,#permission-member-search-input').on('click', (event) => event.stopPropagation());
$('#permission-member-search-input').on('keyup', function(event) {
    if(event.key === 'Enter' || event.keyCode === 13)
		$('#permission-search-for-member-to-attach').trigger('click');
});

let permission_last_member_search_query = '';
let permission_member_search_lock = true;
$('#permission-search-for-member-to-attach').on('click', function(event) {
	event.stopPropagation();

	let resultbox = $('#permission-members-search-result-box');
	let results = resultbox.find('.results-container');
	let loading_block = resultbox.find('.search-loading');
	let no_results_box = resultbox.find('.no-results-found-box')
	let spinner = loading_block.find('.spinner');

	let query = $('#permission-member-search-input').val();
	let permission = $('#permission-id').val();

	if(query == '') return;
	if(query == permission_last_member_search_query) {
		if(permission_member_search_lock)
			loading_block.addClass('none');

		resultbox.removeClass('none');
		results.removeClass('none');
		return;
	}

	// Here if the flow reaches here and the lock is false meaning admin should wait until he get results from previous search
	if(!permission_member_search_lock) return;
	permission_member_search_lock = false;

	$('#permission-users-fetch-more-results').addClass('none no-fetch');

	results.html('');
	no_results_box.addClass('none'); // Hide no results box if it is displayed before
	spinner.addClass('inf-rotate');
	loading_block.removeClass('none');
	loading_block.removeClass('none'); // Display loading annimation

	resultbox.removeClass('none'); // Display parent

	$.ajax({
		type: 'get',
		url: `/admin/permissions/users/search?permission=${permission}&k=${query}`,
		success: function(response) {
			// Emptying old results
			results.html('');
			resultbox.removeClass('none');

			let users = response.users;
			let hasmore = response.hasmore;

			if(users.length) {
				for(let i = 0; i < users.length; i++) {
					let usercomponent = create_permission_member_search_component(users[i]);
					results.append(usercomponent);
				}

				// After handling all users components we have to check if search has more results
				if(hasmore) {
					let loadmore = $('#permission-users-fetch-more-results');
					loadmore.removeClass('none no-fetch')
				} else {
					// no-fetch prevent the scroll event from proceeding when no more results are there
					$('#permission-users-fetch-more-results').addClass('none no-fetch');
				}
			} else {
				// Results not found
				results.addClass('none');
				no_results_box.removeClass('none');
			}
			loading_block.addClass('none');

			results.removeClass('none');
			resultbox.removeClass('none');
			permission_last_member_search_query = query;
			$('#permission-user-k').val(query); // This is used in fetch more
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
			permission_member_search_lock = true;
		}
	})
});

function create_permission_member_search_component(user) {
	let usercomponent = $('#permission-members-search-result-box .permission-member-search-user-factory').clone(true, true);
	usercomponent.removeClass('none permission-member-search-user-factory');

	let role = user.role;
	let already_has_permission = user.already_has_this_permission;

	usercomponent.find('.permission-user-id').val(user.id);
	usercomponent.find('.permission-user-avatar').attr('src', user.avatar);
	usercomponent.find('.permission-user-fullname').text(user.fullname);
	usercomponent.find('.permission-user-username').text(user.username);
	usercomponent.find('.permission-user-user-manage-link').attr('href', user.user_manage_link);
	
	if(role == null) {
		usercomponent.find('.permission-user-role').text('normal user');
		usercomponent.find('.permission-user-role').removeClass('blue bold');
		usercomponent.find('.permission-user-role').addClass('gray italic');
	} else
		usercomponent.find('.permission-user-role').text(role);

	if(already_has_permission) {
		usercomponent.find('.permission-select-member').remove();
		usercomponent.find('.already-has-permission').removeClass('none');
	} else {
		usercomponent.find('.already-has-permission').remove();
		usercomponent.find('.permission-select-member').removeClass('none');
	}

	return usercomponent;
}

let permission_user_search_fetch_more = $('#permission-users-fetch-more-results');
let permission_user_search_results_box = $('#permission-members-search-result-box');
let permission_user_search_fetch_more_lock = true;
if(permission_user_search_results_box.length) {
    permission_user_search_results_box.on('DOMContentLoaded scroll', function() {
        if(permission_user_search_results_box.scrollTop() + permission_user_search_results_box.innerHeight() + 50 >= permission_user_search_results_box[0].scrollHeight) {
			// no-fetch class is attached to fetch_more loader when no more results are there to prevent fetch
            if(!permission_user_search_fetch_more_lock || permission_user_search_fetch_more.hasClass('no-fetch')) return;
            permission_user_search_fetch_more_lock=false;
            
			let results = $('#permission-members-search-result-box .results-container');
			let spinner = permission_user_search_fetch_more.find('.spinner');
			// Notice we don't count directly role members from scrollable because it will count factory components as well
            let present_permission_users = permission_user_search_results_box.find('.results-container .permission-member-search-user').length;

			spinner.addClass('inf-rotate');
            $.ajax({
				url: '/admin/permissions/users/search/fetchmore',
				data: {
					permission: $('#permission-id').val(),
					skip: present_permission_users,
					k: $('#permission-user-k').val()
				},
                success: function(response) {
					let users = response.users;
					let hasmore = response.hasmore;
		
					if(users.length) {
						for(let i = 0; i < users.length; i++) {
							let usercomponent = create_permission_member_search_component(users[i]);
							results.append(usercomponent);
						}
		
						// After handling all users components we have to check if search has more results
						if(hasmore) {
							let loadmore = $('#permission-users-fetch-more-results');
							loadmore.removeClass('none no-fetch');
						} else
							// no-fetch prevent the scroll event from proceeding when no more results are there
							$('#permission-users-fetch-more-results').addClass('none no-fetch');
					} else {
						// Results not found
						results.addClass('none');
						no_results_box.removeClass('none');
					}
                },
                complete: function() {
                    permission_user_search_fetch_more_lock = true;
					spinner.removeClass('inf-rotate');
                }
            });
        }
    });
}