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
                    fullPage: true
                }
            })
            .then(editor => {
                post_editor = editor;
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
    let slug = convertToSlug(value);

    $('#post-meta-title').val(value);
    $('#post-slug').val(slug);
});

function post_input_validate(condition, input, message) {
    let container = $('.error-container');
    if(!condition) {
        $(window).scrollTop(0);
        container.find('.message-text').text(message);
        container.removeClass('none');
        let input_wrapper = input;
        while (!input_wrapper.hasClass('input-wrapper')) input_wrapper = input_wrapper.parent();
        input_wrapper.find('.error-asterisk').css('display', 'inline');
        lock = true; // Release rade condition lock

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

$('.open-featured-image-selection-viewer').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
});

let set_featured_image_lock = true;
$('.set-featured-image').on('click', function () {
    if($(this).hasClass('prevent-action')) return;
    
    let selected_featured_image_metadata_id = selected_media[0];
    if(!selected_featured_image_metadata_id) {
        print_top_message('Please select a featured image first.', 'error');
        return;
    }
    
    let gmbox = $('#set-featured-image-viewer');
    let selected_media_item;
    gmbox.find('.media-library-item-container').each(function () {
        if($(this).find('.selected').val() == 1) {
            selected_media_item = $(this);
            return false;
        }
    });

    $('#post-featured-image-metadata-id').val(selected_featured_image_metadata_id);
    $('.selected-featured-image').attr('src', selected_media_item.find('.media-library-item-image').attr('src'));
    handle_image_center_fill($('.selected-featured-image'));
    $('.featured-image-upload-box').addClass("none");
    $('.uploaded-featured-image-box').removeClass("none");
    gmbox.find('.close-global-viewer').trigger('click');
});

$('.remove-featured-image').on('click', function () {
    $('#set-featured-image-viewer').find('.media-library-item-container').each(function () {
        if($(this).find('.selected').val() == 1) {
            $(this).trigger('click');
        }
    });
    $('#post-featured-image-metadata-id').val('');
    $('.selected-featured-image').attr('src', '');
    $('.featured-image-upload-box').removeClass("none");
    $('.uploaded-featured-image-box').addClass("none");
});

$('.update-featured-image').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
    $('#set-featured-image-viewer').find('.open-medias-library-section').trigger('click');
});