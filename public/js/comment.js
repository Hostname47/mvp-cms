
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

let loading_comments = $('#post-comments-loading-box');
let loading_comments_lock = true;
if(loading_comments.length) {
    $(window).on('DOMContentLoaded scroll', function() {
        if(is_visible_in_viewport(loading_comments[0])) {
            console.log('reached');
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
						if(!hasmore)
                            loading_comments.addClass('none stop-fetch');
					} else {
						// no results found
						loading_comments.addClass('none stop-fetch');
					}
                },
                complete: function() {
                    loading_comments_lock = true;
                    spinner.removeClass('inf-rotate');
                },
                error: function() {
                    loading_comments.addClass('opacity0 stop-fetch');
                }
            });
        }
    });
}