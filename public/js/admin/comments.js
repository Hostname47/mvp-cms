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
        data: { comment_id: comment_id },
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