
handle_comment_keyup($('body'));
function handle_comment_keyup(comment_input_section) {
    comment_input_section.find('.comment-input').on('keyup', function() {
        if($(this).val().trim() == '')
            comment_input_section.find('.share-comment').addClass('share-comment-disabled');
        else
            comment_input_section.find('.share-comment').removeClass('share-comment-disabled');
    });
}

handle_share_comment($('body'));

let share_comment_lock = true;
function handle_share_comment(comment_input_section) {
    comment_input_section.find('.share-comment').on('click', function() {
        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let error_container = comment_input_section.find('.error-container');
        error_container.addClass('none');
        
        if(button.hasClass('share-comment-disabled') || button.hasClass('login-required')) return;

        let comment_input = comment_input_section.find('.comment-input');
        let content = comment_input.val().trim();
        let post_id = $('#post-id').val();

        if(content == '') {
            error_container.find('.error').text($('#comment-content-required').val());
            error_container.removeClass('none');
        }

        button.addClass('share-comment-disabled');
        spinner.addClass('inf-rotate');
        spinner.removeClass('opacity0');
        buttonicon.addClass('none');

        $.ajax({
            type: 'post',
            url: '/comments',
            data: {
                content: content,
                post_id: post_id
            },
            success: function(response) {
                comment_input.val('');
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                error_container.find('.error').text(error);
                error_container.removeClass('none');
            },
            complete: function(response) {
                button.removeClass('share-comment-disabled');
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
                buttonicon.removeClass('none');
            }
        })
    });
}