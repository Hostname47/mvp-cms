$('.post-tags-wrapper').on('click', function () {
    $('.post-tags-input').focus();
});

$('.post-tags-input').on('keyup', function (event) {
    let input = $(this);
    let value = $(this).val().trim();

    if (event.key === 'Enter' || event.keyCode === 13) {
        let already_exists = false;
        $('.post-tags-wrapper .tag-text').each(function () {
            if ($(this).text().trim() == value) {
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

    $('.post-top-error-container').addClass('none');
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
        allow_reactions: $('#allow-reactions').is(':checked') ? 1 : 0,
        allow_comments: $('#allow-reactions').is(':checked') ? 1 : 0,
        categories: categories,
        tags: tags,
    };

    if($('#post-featured-image-metadata-id').val() != '')
        data.featured_image = $('#post-featured-image-metadata-id').val();
    
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