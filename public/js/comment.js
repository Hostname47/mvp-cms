
handle_comment_keyup($('body'));
function handle_comment_keyup(comment_input_section) {
    comment_input_section.find('.comment-input').on('keyup', function() {
        if($(this).val().trim() == '')
            comment_input_section.find('.share-comment').addClass('share-comment-disabled');
        else
            comment_input_section.find('.share-comment').removeClass('share-comment-disabled');
    });
}

handle_display_comment_switch($('body'));
function handle_display_comment_switch(comment_input_section) {
    comment_input_section.find('.comment-display-switch').on('click', function() {
        if($(this).hasClass('root')) {
            let input = $('#root-comment-input .comment-input-box');
            let open = $('#root-comment-input .open');
            if(input.hasClass('none')) {
                input.removeClass('none');
                open.addClass('none');
            } else {
                input.addClass('none');
                open.removeClass('none');
            }
        } else {
            console.log('not root');
        }
    });
}

handle_share_comment($('body'));
function handle_share_comment(comment_input_section) {
    comment_input_section.find('.share-comment').on('click', function() {
        let button = $(this);
        let spinner = button.find('.spinner');
        let buttonicon = button.find('.icon-above-spinner');
        let error_container = comment_input_section.find('.error-container');
        error_container.addClass('none');
        
        if(button.hasClass('login-required')) return;

        let comment_input = comment_input_section.find('.comment-input');
        let content = comment_input.val().trim();
        let post_id = $('#post-id').val();

        if(content == '') {
            error_container.find('.error').text($('#comment-content-required').val());
            error_container.removeClass('none');
            return;
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
                post_id: post_id,
                form: 'component'
            },
            success: function(response) {
                comment_input.val('');
                if(button.hasClass('root')) {
                    $('#post-comments-box').prepend(response);
                    let comment = $('#post-comments-box .comment-component').first();
                    handle_comment_events(comment);
                    $('#post-comments-box .comment-component').removeClass('highlighted-comment');
                    comment.addClass('highlighted-comment');
                    left_bottom_notification($('#comment-shared-successfully').val());
                } else {

                }
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

$('body').on('click', function() {
    $('#post-comments-box .comment-component').removeClass('highlighted-comment');
});

let loading_comments = $('#post-comments-loading-box');
if(loading_comments.length) {
    $(window).on('DOMContentLoaded scroll', bootstrap_comments_when_loading_reached);
}

let loading_comments_lock = true;
function bootstrap_comments_when_loading_reached() {
    if(is_visible_in_viewport(loading_comments[0])) {
        if(!loading_comments_lock || loading_comments.hasClass('stop-fetch')) return;
        loading_comments_lock=false;
        let spinner = loading_comments.find('.spinner');
        let present_comments = $('#post-comments-box .comment-component').length;
        spinner.addClass('inf-rotate');
        
        $.ajax({
            url: '/comments/fetch',
            data: {
                skip: present_comments,
                take: 10,
                form: 'component',
                sort: 'newest'
            },
            success: function(response) {
                let comments = response.comments;
                let hasmore = response.hasmore;
    
                if(comments.length) {
                    $('#post-comments-box').append(response.comments);

                    let appended_comments = 
                        $('#post-comments-box .comment-component').slice(response.count*(-1));

                    appended_comments.each(function() {
                        handle_comment_events($(this));
                    });
                }
    
                if(hasmore)
                    $('#comments-fetch-more').removeClass('none');
                else
                    $('#comments-fetch-more').remove();
            },
            complete: function() {
                spinner.removeClass('inf-rotate');
                loading_comments.remove();
                $(window).off('DOMContentLoaded scroll', bootstrap_comments_when_loading_reached);
            },
            error: function() {
                loading_comments_lock = true;

                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
            }
        });
    }
}

let fetch_comments_lock = true;
$('#comments-fetch-more').on('click', function() {
    if(!fetch_comments_lock) return;
    fetch_comments_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let present_comments = $('#post-comments-box .comment-component').length;

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        url: '/comments/fetch',
        data: {
            skip: present_comments,
            take: 10,
            form: 'component',
            sort: 'newest'
        },
        success: function(response) {
            let comments = response.comments;
            let hasmore = response.hasmore;

            if(comments.length)
                $('#post-comments-box').append(response.comments);

            if(hasmore)
                $('#comments-fetch-more').removeClass('none');
            else
                $('#comments-fetch-more').remove();
        },
        complete: function() {
            fetch_comments_lock = true;
            
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            buttonicon.removeClass('none');
        },
        error: function(response) {
            
        }
    });
});

function handle_comment_events(comment) {
    comment.find('.tooltip-box').each(function() { handle_tooltip($(this)); });
    handle_suboptions_container(comment);
}