let create_tag_lock = true;
$('#create-tag-button').on('click', function() {
    let title = $('#create-tag-title');
    let title_meta = $('#create-tag-meta-title');
    let slug = $('#create-tag-slug');
    let description = $('#create-tag-description');
    
    $('#tag-create-error-container').addClass('none');
    $('#create-tag-section .error-asterisk').css('display', 'none');

    // validate post title
    if (!tag_input_validate(title.val() != '', title, 'Title field is required.')) return;
    // validate post meta title
    if (!tag_input_validate(title_meta.val() != '', title_meta, 'Meta title field is required.')) return;
    // validate post slug
    if (!tag_input_validate(slug.val() != '', slug, 'Slug field is required.')) return;

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
        success: function(response) {
            let container = $('#tag-create-green-message-container');
            container.find('.message-text').text('Tag has been created successfully.');
            container.removeClass('none');
            scroll_to_element('tag-create-green-message-container', -8);

            // Clone tag row and append it to tags table
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            tag_input_validate(false, false, error);
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
            success: function(response) {
                last_tag_update_opened = tag_id;

                content_container.find('.title').val(response.title);
                content_container.find('.meta-title').val(response.title_meta);
                content_container.find('.slug').val(response.slug);
                content_container.find('.description').val(response.description);

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

});

function tag_input_validate(condition, input, message) {
    let container = $('#tag-create-error-container');
    if(!condition) {
        container.find('.message-text').text(message);
        container.removeClass('none');
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

$('#create-tag-title').on('input', function() {
    let value = $(this).val().trim();
    let slug = slugify(value);

    $('#create-tag-meta-title').val(value);
    $('#create-tag-slug').val(slug);
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