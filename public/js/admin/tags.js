let create_tag_lock = true;
$('#create-tag-button').on('click', function() {
    let form = $(this);
    while(!form.hasClass('tag-form')) form = form.parent();
    let title = form.find('.title');
    let title_meta = form.find('.meta-title');
    let slug = form.find('.slug');
    let description = form.find('.description');
    
    let error_container = $('#tag-create-error-container');
    let green_message_container = $('#tag-create-green-message-container');

    error_container.addClass('none');
    form.find('.error-asterisk').css('display', 'none');

    // validate post title
    if (!tag_input_validate(title.val() != '', title, form, 'Title field is required.')) return;
    // validate post meta title
    if (!tag_input_validate(title_meta.val() != '', title_meta, form, 'Meta title field is required.')) return;
    // validate post slug
    if (!tag_input_validate(slug.val() != '', slug, form, 'Slug field is required.')) return;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    
    if(!create_tag_lock) return;
    create_tag_lock = false;
    
    button.addClass('dark-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');
    
    $.ajax({
        type: 'post',
        url: '/admin/tags',
        data: {
            title: title.val(),
            title_meta: title_meta.val(),
            slug: slug.val(),
            description: description.val()
        },
        success: function(tag) {
            error_container.addClass('none');
            green_message_container.find('.message-text').text('Tag has been created successfully.');
            green_message_container.removeClass('none');
            print_top_message('Tag has been created successfully.', 'green')

            // Clone tag row and append it to tags table
            let row = $('.tag-row-skeleton').clone(true);
            row.find('.tag-id').val(tag.id);
            row.find('.tag-selection-id').val(tag.id);
            row.find('.title-text').text(tag.title);
            row.find('.meta-title-text').text(tag.title_meta);
            row.find('.slug-text').text(tag.slug);
            row.find('.description-text').text(tag.description);
            row.find('.tag-count').text('0');
            row.find('.tag-link').attr('href', tag.link);
            row.removeClass('tag-row-skeleton none');

            $('#tags-table tbody').prepend(row);

            // Clean inputs after addition
            title.val('');
            title_meta.val('');
            slug.val('');
            description.val('');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            green_message_container.addClass('none');
            error_container.find('.message-text').text(error);
            error_container.removeClass('none');
            scroll_to_element('tag-create-error-container');
        },
        complete: function(response) {
            create_tag_lock = true;

            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    });
});

let open_tag_update_lock = true;
let last_tag_update_opened = null;
$('.open-tag-update-viewer').on('click', function() {
    // First we open the tag update 
    let viewer = $('#update-tag-viewer');
    let tag_id = $(this).parent().find('.tag-id').val();

    a:
    if(last_tag_update_opened != tag_id) {
        if(!open_tag_update_lock) break a;
        open_tag_update_lock = false;

        let content_container = viewer.find('.content-container');
        let loading_container = viewer.find('.loading-container');
        
        content_container.addClass('none');
        loading_container.removeClass('none');
        loading_container.find('.spinner').addClass('inf-rotate');

        $.ajax({
            url: '/admin/tags/data?tag='+tag_id,
            success: function(tag) {
                last_tag_update_opened = tag_id;

                content_container.find('.title').val(tag.title);
                content_container.find('.meta-title').val(tag.title_meta);
                content_container.find('.slug').val(tag.slug);
                content_container.find('.description').val(tag.description);
                content_container.find('.tag-id').val(tag.id);

                content_container.removeClass('none');
                loading_container.addClass('none');
                loading_container.find('.spinner').removeClass('inf-rotate');
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if (errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
    
                print_top_message(error, 'error');
                open_tag_update_lock = true;
            },
            complete: function() {
                open_tag_update_lock = true;
            }
        })
    }

    viewer.removeClass('none');
    disable_page_scroll();
});

let update_tag_lock = true;
$('#update-tag-button').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    
    let form = button;
    while(!form.hasClass('tag-form')) form = form.parent();
    let title = form.find('.title');
    let title_meta = form.find('.meta-title');
    let slug = form.find('.slug');
    let description = form.find('.description');
    let tag_id = button.find('.tag-id').val();
    
    let error_container = $('#tag-create-error-container');
    let green_message_container = $('#tag-create-green-message-container');

    error_container.addClass('none');
    form.find('.error-asterisk').css('display', 'none');

    // validate post title
    if (!tag_input_validate(title.val() != '', title, form, 'Title field is required.')) return;
    // validate post meta title
    if (!tag_input_validate(title_meta.val() != '', title_meta, form, 'Meta title field is required.')) return;
    // validate post slug
    if (!tag_input_validate(slug.val() != '', slug, form, 'Slug field is required.')) return;

    let data = {
        tag_id: tag_id,
        title: title.val(),
        title_meta: title_meta.val(),
        slug: slug.val(),
    };
    if(description.val() != '')
        data.description = description.val();

    button.addClass('dark-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    if(!update_tag_lock) return;
    update_tag_lock = false;

    $.ajax({
        type: 'patch',
        url: '/admin/tags',
        data: data,
        success: function() {
            let tag_row;
            $('.tag-row').each(function() {
                if($(this).find('.tag-id').val() == tag_id) {
                    tag_row = $(this);
                    return false;
                }
            });
            tag_row.find('.title-text').text(title.val());
            tag_row.find('.meta-title-text').text(title_meta.val());
            tag_row.find('.slug-text').text(slug.val());
            tag_row.find('.description-text').text(description.val());

            let viewer = button;
            while(!viewer.hasClass('global-viewer')) viewer = viewer.parent();

            viewer.find('.close-global-viewer').trigger('click');
            print_top_message('tag has been updated successfully.', 'green');
            last_tag_update_opened = -1;
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            print_top_message(error, 'error');
        },
        complete: function() {
            update_tag_lock = true;

            button.removeClass('dark-bs-disabled');
            spinner.removeClass('inf-rotate');
            spinner.addClass('opacity0');
            buttonicon.removeClass('none');
        }
    })
});

$('.open-tag-delete-viewer').on('click', function() {
    // First we open the tag update 
    let viewer = $('#delete-tag-viewer');
    let tag_row = $(this);
    while(!tag_row.hasClass('tag-row')) tag_row = tag_row.parent();

    viewer.find('.tag-id').val(tag_row.find('.tag-id').val());
    viewer.find('.slug-text').text(tag_row.find('.slug-text').text());
    viewer.find('.title-text').text(tag_row.find('.title-text').text());
    viewer.find('.meta-title-text').text(tag_row.find('.meta-title-text').text());
    viewer.find('.description-text').text(tag_row.find('.description-text').text());

    viewer.removeClass('none');
    disable_page_scroll();
});

let delete_tag_lock = true;
$('#delete-tag-button').on('click', function() {
    if(!delete_tag_lock) return;
    delete_tag_lock = false;
    
    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let tag_id = button.find('.tag-id').val();

    button.addClass('red-bs-disabled');
    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    buttonicon.addClass('none');

    $.ajax({
        type: 'delete',
        url: '/admin/tags',
        data: { tag_id: tag_id },
        success: function() {
            $('.tag-row').each(function() {
                if($(this).find('.tag-id').val() == tag_id) {
                    $(this).remove();
                    if($('.tag-row').length == 0)
                        $('.empty-tags-row').removeClass('none');
                    return false;
                }
            });

            let viewer = button;
            while(!viewer.hasClass('global-viewer')) viewer = viewer.parent();
            viewer.find('.close-global-viewer').trigger('click');

            print_top_message('Tag has been deleted successfully.', 'green');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            print_top_message(error, 'error');
        },
        complete: function() {
            delete_tag_lock = true;

            button.removeClass('red-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    })
})

function tag_input_validate(condition, input, form, message) {
    if(!condition) {
        let error_container = form.find('.error-container');
        form.find('.green-message-container').addClass('none')
        error_container.find('.message-text').text(message);
        error_container.removeClass('none');
        if(input) {
            let input_wrapper = input;
            while (!input_wrapper.hasClass('input-wrapper')) input_wrapper = input_wrapper.parent();
            input_wrapper.find('.error-asterisk').css('display', 'inline');
        }
        
        scroll_to_element('tag-create-error-container', -8);
        return false;
    }
    return true;
}

$('.tag-form .title').on('input', function() {
    let value = $(this).val().trim();
    let slug = slugify(value);

    let form = $(this);
    while(!form.hasClass('tag-form')) form = form.parent();

    form.find('.meta-title').val(value);
    form.find('.slug').val(slug);
});

$('.tag-row').on({
    mouseenter: function() {
        if(!$(this).hasClass('prevent-hover-effect'))
            $(this).find('.tag-actions-links-container').css('opacity', '1');
    },
    mouseleave: function() {
        if(!$(this).hasClass('prevent-hover-effect'))
            $(this).find('.tag-actions-links-container').css('opacity', '0');
    }
})