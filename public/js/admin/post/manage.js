let post_editor;
$(document).ready(function() {
    if($('#post-content').length) {
        CKEditor
            .create($('#post-content')[0], {
                toolbar: {
                    items: [
                        'heading',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        'bold', 'italic', '|',
                        'link', '|',
                        'outdent', 'indent', '|',
                        'bulletedList', 'numberedList',
                        'insertTable', '|',
                        'blockQuote', 'code', 'codeBlock', '|',
                        'undo', 'redo',
                    ],
                    shouldNotGroupWhenFull: true,
                    pasteFilter: null,
                    fullPage: true,
                },
                mediaEmbed: {
                    previewsInData: true
                }
            })
            .then(editor => {
                post_editor = editor;
                $('#post-content-editor-loading').remove();
            })
            .catch(error => {
                console.error(error);
            });
    }
});

$('#toggle-meta-and-slug').on('click', function () {
    let button = $(this);
    let targetbox = $('#meta-and-slug-section');
    if(targetbox.hasClass('none')) {
        button.find('.toggle-arrow').first().css({
            transform: 'rotate(90deg)',
            '-ms-transform': 'rotate(90deg)',
            '-moz-transform': 'rotate(90deg)',
            '-webkit-transform': 'rotate(90deg)',
            '-o-transform': 'rotate(90deg)'
        });
        targetbox.removeClass('none');
    } else {
        button.find('.toggle-arrow').first().css({
            transform: 'rotate(0deg)',
            '-ms-transform': 'rotate(0deg)',
            '-moz-transform': 'rotate(0deg)',
            '-webkit-transform': 'rotate(0deg)',
            '-o-transform': 'rotate(0deg)'
        });
        targetbox.addClass('none');
    }
})

$('#post-title').on('input', function () {
    let value = $(this).val().trim();
    let slug = slugify(value);

    $('#post-meta-title').val(value);
    $('#post-slug').val(slug);
});

function post_input_validate(condition, input, message) {
    let container = $('#post-error-container');
    if(!condition) {
        $(window).scrollTop(0);
        container.find('.message-text').text(message);
        container.removeClass('none');
        let input_wrapper = input;
        while (!input_wrapper.hasClass('input-wrapper')) input_wrapper = input_wrapper.parent();
        input_wrapper.find('.error-asterisk').css('display', 'inline');

        return false;
    }
    return true;
}

$('.post-visibility-button').on('click', function(event) {
    let visibility = $(this).find('.visibility').val();
    if(visibility == 'password-protected') {
        event.stopPropagation();
        $(this).parent().css('display', 'block');
        $('#post-password-container').removeClass('none');
    }
    else
        $('#post-password-container').addClass('none');
});

$('.open-thumbnail-image-selection-viewer').on('click', function () {
    $('#set-thumbnail-image-viewer').removeClass('none');
});

$('.set-thumbnail-image').on('click', function () {
    if($(this).hasClass('prevent-action')) return;
    
    let selected_thumbnail_image_metadata_id = selected_media[0];
    if(!selected_thumbnail_image_metadata_id) {
        print_top_message('Please select a thumbnail image first.', 'error');
        return;
    }
    
    let gmbox = $('#set-thumbnail-image-viewer');
    let selected_media_item;
    gmbox.find('.media-library-item-container').each(function () {
        if($(this).find('.selected').val() == 1) {
            selected_media_item = $(this);
            return false;
        }
    });

    $('#post-thumbnail-image-metadata-id').val(selected_thumbnail_image_metadata_id);
    $('.selected-thumbnail-image').attr('src', selected_media_item.find('.media-library-item-image').attr('src'));
    handle_image_center_fill($('.selected-thumbnail-image'));
    $('.thumbnail-image-upload-box').addClass("none");
    $('.uploaded-thumbnail-image-box').removeClass("none");
    gmbox.find('.close-global-viewer').trigger('click');
});

$('.remove-thumbnail-image').on('click', function () {
    $('#set-thumbnail-image-viewer').find('.media-library-item-container').each(function () {
        if($(this).find('.selected').val() == 1) {
            $(this).trigger('click');
        }
    });
    $('#post-thumbnail-image-metadata-id').val('');
    $('.selected-thumbnail-image').attr('src', '');
    $('.thumbnail-image-upload-box').removeClass("none");
    $('.uploaded-thumbnail-image-box').addClass("none");
});

$('.update-thumbnail-image').on('click', function () {
    $('#set-thumbnail-image-viewer').removeClass('none');
    $('#set-thumbnail-image-viewer').find('.open-medias-library-section').trigger('click');
});

$('.post-tags-wrapper').on('click', function () {
    $('.post-tags-input').focus();
});

$('.post-tags-input').on('keyup', function (event) {
    let input = $(this);
    let value = $(this).val().trim();

    if (event.key === 'Enter' || event.keyCode === 13) {
        if(value == '') return;
        let already_exists = false;
        $('.post-tags-wrapper .tag-text').each(function () {
            if ($(this).text().trim().toLowerCase() == value.toLowerCase()) {
                already_exists = true;
                return false;
            }
        });

        if (already_exists) {
            print_top_message('Tag already exists. Tags should have unique values', 'error')
            input.val('');
            return;
        }

        let tag = $('.post-tag-item-skeleton').clone(true);
        tag.find('.tag-text').text(value);
        tag.removeClass('post-tag-item-skeleton none');
        $(tag).insertBefore(input);
        input.val('');
    }

    // Left arrow button
    if (event.keyCode == 37) {
        $(input).insertBefore(input.prev());
        input.focus();
    }
    // Right arrow button
    if (event.keyCode == 39) {
        $(input).insertAfter(input.next());
        input.focus();
    }
});

let create_post_lock = true;
$('.create-post-button').on('click', function () {
    let title = $('#post-title');
    let meta_title = $('#post-meta-title');
    let slug = $('#post-slug');
    let content_element = $('#post-content');
    let visibility = $('#post-visibility');
    
    post_editor.data.processor = post_editor.data.htmlProcessor;
    let content = post_editor.getData();

    $('#post-error-container').addClass('none');
    $('.error-asterisk').css('display', 'none');

    // validate post title
    if (!post_input_validate(title.val() != '', title, 'Title field is required.')) return;
    // validate post meta title
    if (!post_input_validate(meta_title.val() != '', meta_title, 'Meta title field is required.')) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    // validate post slug
    if (!post_input_validate(slug.val() != '', slug, 'Slug field is required.')) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    // validate post content
    if (!post_input_validate(content != '', content_element, 'Content field is required.')) return;
    // validate post visibility in case of visibility is password protected
    if(visibility.val() == 'password-protected' && $('#post-password-input').val() == '') {
        print_top_message('password is required in case of password protected visibility posts', 'error');
        return;
    }

    let categories = [];
    $('.post-category-id').each(function() {
        if($(this).is(':checked'))
            categories.push($(this).val());
    });

    let tags = [];
    $('.post-tags-wrapper .tag-text').each(function() {
        tags.push($(this).text());
    });

    let data = {
        title: title.val(),
        title_meta: meta_title.val(),
        slug: slug.val(),
        content: content,
        status: $(this).find('.status').val(),
        visibility: visibility.val(),
        allow_comments: $('#allow-comments').is(':checked') ? 1 : 0,
        allow_reactions: $('#allow-reactions').is(':checked') ? 1 : 0,
        categories: categories,
        tags: tags,
    };

    if($('#post-thumbnail-image-metadata-id').val() != '')
        data.thumbnail_id = $('#post-thumbnail-image-metadata-id').val();
    
    if($('#post-summary').val() != '')
        data.summary = $('#post-summary').val();

    if($('#post-visibility').val() == 'password-protected') {
        if($('#post-password-input').val() == '') {
            print_top_message('password is required in case of password protected visibility posts', 'error');
            return;
        }
        else
            data.password = $('#post-password-input').val();
    }

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.hasClass('dark-bs') ? button.addClass('dark-bs-disabled') : button.addClass('white-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    
    if (!create_post_lock) return;
    create_post_lock = false;
    // right now we just refresh te page after creating the post
    $.ajax({
        type: 'post',
        url: '/admin/posts',
        data: data,
        success: function(response) {
            if(button.hasClass('save-as-draft'))
                window.location.href = response.editlink;
            else if(button.hasClass('preview-post')) {
                // Open post in preview page
                window.open(response.previewlink, '_blank').focus();
                // Then redirect to edit link to manage
                window.location.href = response.editlink;
            }
            else
                window.location.href = response.allpostslink;
        },
        error: function (response) {
            create_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.hasClass('dark-bs') ? button.removeClass('dark-bs-disabled') : button.removeClass('white-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            print_top_message(error, 'error');
        }
    })
});

let update_post_status = true;
$('.update-post-status').on('click', function() {
    if(!update_post_status) return;
    update_post_status = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let post_id = button.find('.post-id').val();
    let status = button.find('.status').val();

    button.hasClass('dark-bs') ? button.addClass('dark-bs-disabled') : button.addClass('white-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: '/admin/posts/status',
        data: {
            post_id: post_id,
            status: status
        },
        success: function() {
            location.reload();
        },
        error: function (response) {
            update_post_status = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.hasClass('dark-bs') ? button.removeClass('dark-bs-disabled') : button.removeClass('white-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            print_top_message(error, 'error');
        }
    })
});

/** Trashing & Untrashing & Permanent Deleting posts */
let trash_post_lock = true;
$('.trash-post-button').on('click', function(event) {
    if(!trash_post_lock) return;
    trash_post_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let post_id = button.find('.post-id').val();

    let post_row = button;
    while(!post_row.hasClass('post-row')) post_row = post_row.parent();
    post_row.addClass('prevent-hover-effect');

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/posts/trash',
        data: { post_id: post_id },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            post_row.removeClass('prevent-hover-effect');
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            trash_post_lock = true;
        }
    })
});

let untrash_post_lock = true;
$('.untrash-post-button').on('click', function() {
    if(!untrash_post_lock) return;
    untrash_post_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let post_id = button.find('.post-id').val();

    let row;
    if(button.hasClass('fix-row-hover-event')) {
        row = button;
        while(!row.hasClass('post-row')) row = row.parent();
        row.addClass('prevent-hover-effect');
    }

    spinner.addClass('inf-rotate');
    spinner.removeClass('none');

    $.ajax({
        type: 'post',
        url: '/admin/posts/untrash',
        data: { post_id: post_id },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            if(button.hasClass('fix-row-hover-event')) {
                row.removeClass('prevent-hover-effect');
            }
            spinner.removeClass('inf-rotate');
            spinner.addClass('none');

            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            untrash_post_lock = true;
        }
    })
});

$('.open-post-permanent-delete-viewer').on('click', function() {
    let post_id = $(this).find('.post-id').val();
    let row = $(this);
    while(!row.hasClass('post-row')) row = row.parent();
    let title = row.find('.post-title').text();
    let viewer = $('#permanent-delete-post-viewer');

    viewer.find('.post-id').val(post_id);
    viewer.find('.post-title').text(title);

    viewer.removeClass('none');
    disable_page_scroll();
});

let permanent_delete_post_lock = true;
$('.permanent-delete-post-button').on('click', function() {
    if(!permanent_delete_post_lock) return;
    permanent_delete_post_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let post_id = button.find('.post-id').val();

    button.addClass('red-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/posts',
        data: { post_id: post_id },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            permanent_delete_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('red-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            print_top_message(error, 'error');
        }
    })
});