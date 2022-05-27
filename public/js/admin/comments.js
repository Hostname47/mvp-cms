$('.comment-row').on({
    mouseenter: function() {
        if($(this).hasClass('action-in-progress')) return;
        $(this).find('.comment-actions-links').css('opacity', '1');
    },
    mouseleave: function() {
        if($(this).hasClass('action-in-progress')) return;
        $(this).find('.comment-actions-links').css('opacity', '0');
    }
});

let trash_comment_lock = true;
$('.trash-comment-button').on('click', function(event) {
    if(!trash_comment_lock) return;
    trash_comment_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let comment_id = button.find('.comment-id').val();

    let comment = $('#comment-row-' + comment_id);
    comment.addClass('action-in-progress');

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/comments/trash',
        data: { comments: [comment_id] },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            comment.removeClass('action-in-progress');
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            trash_comment_lock = true;
        }
    })
});

let untrash_comment_lock = true;
$('.untrash-comment-button').on('click', function(event) {
    if(!untrash_comment_lock) return;
    untrash_comment_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let comment_id = button.find('.comment-id').val();

    let comment = $('#comment-row-' + comment_id);
    comment.addClass('action-in-progress');

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/comments/untrash',
        data: { comments: [comment_id] },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            comment.removeClass('action-in-progress');
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            untrash_comment_lock = true;
        }
    })
});

let restore_comment_lock = true;
$('.restore-comment-button').on('click', function(event) {
    if(!restore_comment_lock) return;
    restore_comment_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let comment_id = button.find('.comment-id').val();

    let comment = $('#comment-row-' + comment_id);
    comment.addClass('action-in-progress');

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/comments/restore',
        data: { comments: [comment_id] },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            comment.removeClass('action-in-progress');
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            restore_comment_lock = true;
        }
    })
});

let destroy_comment_lock = true;
$('.destroy-comment-button').on('click', function(event) {
    if(!destroy_comment_lock) return;
    destroy_comment_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let comment_id = button.find('.comment-id').val();

    let comment = $('#comment-row-' + comment_id);
    comment.addClass('action-in-progress');

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/comments/destroy',
        data: { comments: [comment_id] },
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            comment.removeClass('action-in-progress');
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            destroy_comment_lock = true;
        }
    })
});

/** bulk actions */
let bulk_action_lock = true;
$('.bulk-action').on('click', function() {
    let action = $(this).find('.action').val();
    let comments = [];
    $('.comment-selection-input:checked').each(function() {
        comments.push($(this).val());
    });
    if(!check_bulk_selection(comments)) return;

    let button = $(this);
    let spinner = button.find('.spinner');
    
    spinner.addClass('inf-rotate');
    spinner.removeClass('none');
    
    if(!bulk_action_lock) return;
    bulk_action_lock = false;
    
    $.ajax({
        type: 'post',
        url: '/admin/comments/' + action,
        data: { comments: comments },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            bulk_action_lock = true;
        }
    });
});

function check_bulk_selection(comments) {
    if(!comments.length) {
        print_top_message('Please select at least one comment before performing any bulk action', 'error');
        return false;
    }
    return true;
}

$('.open-edit-container').on('click', function() {
    $('.comment-edit-box').removeClass('none');
    $('.comment-to-manage .content').addClass('none');
});

$('.cancel-comment-update').on('click', function() {
    $('.comment-edit-box').addClass('none');
    $('.comment-to-manage .content').removeClass('none');
    $('.comment-update-content').val($('#comment-content').val());
});

$('.update-comment').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let comment_id = button.find('.comment-id').val();
    
    let comment_component = $('.comment-to-manage');
    let content = comment_component.find('.comment-update-content').val().trim();
    let original_content = $('#comment-content').val().trim();
    // Before checking update content input we hide the error container
    let error_container = $('.comment-edit-box .error-container');
    error_container.addClass('none');

    // Then if the content input is empty we show the error
    if(content == '') {
        console.log(error_container);
        error_container.find('.error').text('comment content field is required');
        error_container.removeClass('none');
        return;
    }

    /**
     * If the user open the update section but the content is the same as the original
     * then we don't have to run patch request
     */
    if(content == original_content) {
        comment_component.find('.cancel-comment-update').trigger('click');
        return;
    }

    if(button.hasClass('in-progress')) return;
    button.addClass('in-progress');

    button.addClass('update-comment-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'patch',
        url: '/comments',
        data: {
            comment_id: comment_id,
            content: content
        },
        success: function() {
            $('#comment-content').val(content);
            $('.comment-to-manage .content').text(content);
            comment_component.find('.cancel-comment-update').trigger('click');
            left_bottom_notification('Comment updated successfully.');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');
        },
        complete: function() {
            button.removeClass('in-progress');

            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
            button.removeClass('update-comment-disabled');
        }
    })
});