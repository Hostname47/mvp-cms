
handle_comment_keyup($('body'));
function handle_comment_keyup(comment) {
    comment.find('.comment-input-container').each(function() {
        let comment_input_container = $(this);
        comment_input_container.find('.comment-input').each(function() {
            $(this).on('keyup', function() {
                if($(this).val().trim() == '')
                    comment_input_container.find('.share-comment').first().addClass('share-comment-disabled');
                else
                    comment_input_container.find('.share-comment').first().removeClass('share-comment-disabled');
            });
        });
    })
}

handle_display_comment_input_switch($('body'));
function handle_display_comment_input_switch(comment) {
    comment.find('.comment-display-switch').each(function() {
        $(this).on('click', function() {
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
                let comment_reply_input_container = $(this);
                while(!comment_reply_input_container.hasClass('comment-reply-input')) {
                    comment_reply_input_container = comment_reply_input_container.parent();
                }

                if(comment_reply_input_container.hasClass('none'))
                    comment_reply_input_container.removeClass('none');
                else
                    comment_reply_input_container.addClass('none');
            }
        });
    });
}

handle_share_comment($('body'));
function handle_share_comment(comment) {
    comment.find('.comment-input-container').each(function() {
        let comment_input_container = $(this);
        comment_input_container.find('.share-comment').on('click', function() {
            let button = $(this);
            if(button.hasClass('in-progress')) return;
            button.addClass('in-progress');

            let spinner = button.find('.spinner');
            let buttonicon = button.find('.icon-above-spinner');
            let error_container = comment_input_container.find('.error-container').first();
            error_container.addClass('none');
    
            let comment_input = comment_input_container.find('.comment-input');
            let content = comment_input.val().trim();
            let post_id = $('#post-id').val();
            let parent_comment = button.find('.parent-comment-id').val();
    
            if(content == '') {
                error_container.find('.error').text($('#comment-content-required').val());
                error_container.removeClass('none');
                return;
            }
    
            let data = {
                content: content,
                post_id: post_id,
                form: 'component'
            };
            if(parent_comment)
                data.parent_comment_id = parent_comment;
    
            button.addClass('share-comment-disabled');
            spinner.addClass('inf-rotate');
            spinner.removeClass('opacity0');
            buttonicon.addClass('none');
    
            $.ajax({
                type: 'post',
                url: '/comments',
                data: data,
                success: function(response) {
                    comment_input.val('');
                    let comment;
                    if(button.hasClass('root')) {
                        $('#post-comments-box').prepend(response);
                        comment = $('#post-comments-box .comment-component').first();
                    } else {
                        let replies_box = comment_input;
                        while(!replies_box.hasClass('comment-replies-box')) replies_box = replies_box.parent();
                        let replies_container = replies_box.find('.comment-replies-container').first();
                        replies_container.prepend(response);
                        replies_container.removeClass('none');
                        replies_box.removeClass('none')
                        comment = replies_box.find('.comment-component').first();
                        // Increment comment replies count (we need to reach the parent comment)
                        let parent_comment = button;
                        while(!parent_comment.hasClass('comment-component')) parent_comment = parent_comment.parent();
                        parent_comment.find('.replies-count').first().text(parseInt(parent_comment.find('.replies-count').first().text()) + 1);
                        parent_comment.find('.replies-count-part').first().removeClass('none');
                    }
                    handle_comment_events(comment);
                    left_bottom_notification($('#comment-shared-successfully').val());
    
                    $('.post-comments-count').text(parseInt($('.post-comments-count').text()) + 1);
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
    
                    button.removeClass('share-comment-disabled');
                },
                complete: function() {
                    button.removeClass('in-progress');
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');
                }
            });
        });
    });
}

function handle_comment_update_input_opener(comment) {
    comment.find('.open-comment-update-input').each(function() {
        $(this).on('click', function() {
            $(this).parent().css('display', 'none');
            let comment_section = $(this);
            while(!comment_section.hasClass('comment-section')) comment_section = comment_section.parent();
            comment_section.find('.comment-update-box').first().removeClass('none');
            comment_section.find('.comment-wrapper').first().addClass('none');
        })
    });
}
function handle_comment_update_canceler(comment) {
    comment.find('.cancel-comment-update').each(function() {
        $(this).on('click', function() {
            let comment_section = $(this);
            while(!comment_section.hasClass('comment-section')) comment_section = comment_section.parent();
            // Hide update section
            comment_section.find('.comment-update-box').first().addClass('none');
            // Reset the content in update input
            comment_section.find('.comment-update-content').first().val(comment_section.find('.original-content').first().val());
            // Show comment
            comment_section.find('.comment-wrapper').first().removeClass('none');
        })
    });
}
function handle_comment_update_button(comment) {
    comment.find('.update-comment').each(function() {
        $(this).on('click', function() {
            let button = $(this);
            let spinner = button.find('.spinner');
            let buttonicon = button.find('.icon-above-spinner');
            let comment_id = button.find('.comment-id').val();
            
            let comment_component = button;
            while(!comment_component.hasClass('comment-component')) comment_component = comment_component.parent();
            let content = comment_component.find('.comment-update-content').first().val();
            // Before checking update content input we hide the error container
            let error_container = comment_component.find('.comment-update-box .error-container').first();
            error_container.addClass('none');
            // Then if the content input is empty we show the error
            if(content == '') {
                error_container.find('.error').text($('#comment-content-required').val());
                error_container.removeClass('none');
                return;
            }
    
            button.addClass('update-comment-disabled');
            spinner.addClass('inf-rotate');
            spinner.removeClass('opacity0');
            buttonicon.addClass('none');

            if(button.hasClass('in-progress')) return;
            button.addClass('in-progress');

            $.ajax({
                type: 'patch',
                url: '/comments',
                data: {
                    comment_id: comment_id,
                    content: content
                },
                success: function() {
                    comment_component.find('.comment-content').first().text(content);
                    comment_component.find('.original-content').first().val(content);
                    comment_component.find('.comment-edited').first().removeClass('none');
                    comment_component.find('.cancel-comment-update').trigger('click');
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

                    button.removeClass('update-comment-disabled');
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');
                }
            })
        });
    });
}

function handle_comment_reply_button(comment) {
    comment.find('.comment-reply').each(function() {
        $(this).on('click', function() {
            let comment_section = $(this);
            while(!comment_section.hasClass('comment-section')) {
                comment_section = comment_section.parent();
            }
            let comment_reply_container = comment_section.find('.comment-reply-input').first();
            
            if(comment_reply_container.hasClass('none')) {
                comment_reply_container.removeClass('none');
            } else {
                comment_reply_container.addClass('none');
            }
        });
    });
}

function handle_comment_threadline(comment) {
    comment.find('.comment-threadline').each(function() {
        $(this).on({
            mouseenter: function() {
                $(this).find('.comment-threadline-inner').css('background-color', '#07b9ff');
            },
            mouseleave: function() {
                $(this).find('.comment-threadline-inner').css('background-color', '');
            }
        });
    })
}

function handle_comment_appearence_toggling(comment) {
    comment.find('.appearence-toggle').each(function() {
        $(this).on('click', function() {
            let comment_component = $(this);
            while(!comment_component.hasClass('comment-component')) comment_component = comment_component.parent();
            let comment_container = comment_component.find('.comment-container').first();
            let expand = comment_component.find('.appearence-toggle.expand').first();
            if($(this).hasClass('expand')) {
                comment_container.removeClass('none');
                expand.addClass('none');
                expand.css('margin-left', '-12px');
            } else {
                comment_container.addClass('none');
                expand.removeClass('none');
                expand.animate({
                    marginLeft: '0px'
                }, 20);

                /**
                 * If the hidden comment is not in the viewport (its top is not in the viewport)
                 * then we need to scroll to it right after hide it.
                 */
                let id = comment_component.find('.comment-id').first().val();
                let element = $('#comment-'+id);
                if(element[0].getBoundingClientRect().top < $('header').height())
                    scroll_to_element('comment-'+comment_component.find('.comment-id').first().val());
            }
        })
    });
}

function handle_load_more_replies(comment) {
    comment.find('.load-more-replies').each(function() {
        $(this).on('click', function() {
            if($(this).hasClass('loading')) return;
            $(this).addClass('loading');

            let button = $(this);
            let spinner = button.find('.spinner');
            let buttonicon = button.find('.icon-above-spinner');
            let comment_id = button.find('.comment-id').val();
            
            let component = button;
            while(!component.hasClass('comment-component')) component = component.parent();
            let replies_box = component.find('.comment-replies-container').first();
            
            spinner.addClass('inf-rotate');
            spinner.removeClass('opacity0');
            buttonicon.addClass('none');

            $.ajax({
                url: '/comments/replies',
                data: {
                    comment_id: comment_id,
                    skip: $('.reply-child-of-'+comment_id).length,
                    take: 8,
                    sort: 'newest',
                    form: 'component'
                },
                success: function(response) {
                    if(!response.hasmore)
                        button.remove();
                    // Append replies
                    replies_box.append(response.replies);
                    // Handle their events
                    $('.reply-child-of-'+comment_id).slice(response.count*(-1)).each(function() {
                        handle_comment_events($(this));
                    });

                    component.find('.comment-replies-container').removeClass('none');
                },
                error: function(response) {
                    let errorObject = JSON.parse(response.responseText);
                    let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                    if(errorObject.errors) {
                        let errors = errorObject.errors;
                        error = errors[Object.keys(errors)[0]][0];
                    }
                    print_top_message(error, 'error');
                    button.removeClass('loading')
                    spinner.addClass('opacity0');
                    spinner.removeClass('inf-rotate');
                    buttonicon.removeClass('none');
                }
            })
        });
    });
}

function handle_clap(comment) {
    comment.find('.clap').on('click', function() {
        let button = $(this);
        let clapable_id = button.find('.clapable-id').val();
        let clapable_type = button.find('.clapable-type').val();

        comment_clap_button_change(button);

        $.ajax({
            type: 'post',
            url: '/claps',
            data: {
                clapable_id: clapable_id,
                clapable_type: clapable_type
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
                comment_clap_button_change(button)
            }
        })
    });
}

function comment_clap_button_change(button) {
    let claps_counter = button.find('.claps-count');
    let claps_count = parseInt(claps_counter.text(), 10);
    let singular = $('#clap-singular').val();
    let plural = $('#clap-plural').val();

    if(button.hasClass('comment-claped')) {
        button.removeClass('comment-claped');
        claps_count--;
        claps_counter.text(claps_count);
        if(claps_count == 0)
            claps_counter.addClass('none');
        
        if(claps_count <= 1)
            button.find('.claps-text').text(singular);
        
    } else {
        button.addClass('comment-claped');
        claps_count++;
        claps_counter.text(claps_count);
        if(claps_count > 0)
            claps_counter.removeClass('none');
        
        if(claps_count > 1)
            button.find('.claps-text').text(plural);
    }
}

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
        spinner.addClass('inf-rotate');
        
        bootstrap_comments($('#post-id').val(), 0, 10, 'component', $('#post-comments-sort-key').val());
    }
}

function bootstrap_comments(post_id, skip, take, form, sort) {
    return $.ajax({
        url: '/comments/fetch',
        data: {
            post_id: post_id,
            skip: skip,
            take: take,
            form: form,
            sort: sort
        },
        success: function(response) {
            let comments = response.comments;
            let hasmore = response.hasmore;

            if(comments.length) {
                $('#post-comments-box').append(response.comments);

                let appended_comments = 
                    $('#post-comments-box .comment-component.root').slice(response.count*(-1));

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
            loading_comments.find('spinner').removeClass('inf-rotate');
            loading_comments.addClass('none');
            $(window).off('DOMContentLoaded scroll', bootstrap_comments_when_loading_reached);
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            loading_comments.addClass('none');
        }
    });
}

let fetch_comments_lock = true;
$('#comments-fetch-more').on('click', function() {
    if(!fetch_comments_lock) return;
    fetch_comments_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let present_comments = $('#post-comments-box .comment-component.root').length;

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        url: '/comments/fetch',
        data: {
            post_id: $('#post-id').val(),
            skip: present_comments,
            take: 10,
            form: 'component',
            sort: $('#post-comments-sort-key').val()
        },
        success: function(response) {
            let comments = response.comments;
            let hasmore = response.hasmore;

            if(comments.length) {
                $('#post-comments-box').append(response.comments);
                let appended_comments = 
                    $('#post-comments-box .comment-component.root').slice(response.count*(-1));

                appended_comments.each(function() { handle_comment_events($(this)); });
            }

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

$('.sort-comments').on('click', function() {
    // Hide sort buttons container
    $(this).parent().css('display', 'none');
    // Give selected sort key the selected class
    $('.sort-comments').removeClass('sort-comments-key-selected');
    $(this).addClass('sort-comments-key-selected');
    // Assig key and name
    $('#comments-sortby-key').text($(this).find('.sort-key-text').val());
    $('#post-comments-sort-key').val($(this).find('.sort-key').val());
    // Remove all previous comments
    $('#post-comments-box').html('');
    // Show loading section (and hide fetch more button if it is shown)
    let loading = $('#post-comments-loading-box');
    let fetch = $('#comments-fetch-more');
    loading.find('.spinner').addClass('inf-rotate');
    loading.removeClass('none');
    fetch.addClass('none');

    // Finally fetch comments based onthe sort key selected
    bootstrap_comments($('#post-id').val(), 0, 10, 'component', $(this).find('.sort-key').val());
});

function handle_comment_events(comment) {
    comment.find('.tooltip-box').each(function() { handle_tooltip($(this)); });
    handle_suboptions_container(comment);
    handle_login_required_actions(comment);
    handle_clap(comment);
    // Reply to comment events
    handle_display_comment_input_switch(comment);
    handle_comment_keyup(comment);
    handle_share_comment(comment);
    handle_comment_reply_button(comment);
    handle_comment_threadline(comment);
    handle_close_parent(comment);
    handle_load_more_replies(comment);
    handle_comment_appearence_toggling(comment);
    handle_comment_update_input_opener(comment);
    handle_comment_update_canceler(comment);
    handle_comment_update_button(comment);
}