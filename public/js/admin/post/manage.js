let post_editor;
// $(document).ready(function() {
//     if($('#post-content').length) {
//         CKEditor
//             .create($('#post-content')[0], {
//                 toolbar: {
//                     items: [
//                         'heading',
//                         'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
//                         'bold', 'italic', '|',
//                         'link', '|',
//                         'outdent', 'indent', '|',
//                         'bulletedList', 'numberedList',
//                         'insertTable', '|',
//                         'blockQuote', 'code', 'codeBlock', '|',
//                         'undo', 'redo',
//                     ],
//                     shouldNotGroupWhenFull: true,
//                     pasteFilter: null,
//                     fullPage: true
//                 }
//             })
//             .then(editor => {
//                 post_editor = editor;
//             })
//             .catch(error => {
//                 console.error(error);
//             });
//     }
// });

$('#toggle-meta-and-slug').on('click', function () {
    let button = $(this);
    let targetbox = $('#meta-and-slug-section');
    if (targetbox.hasClass('none')) {
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
    if (!condition) {
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

$('.open-featured-image-selection-viewer').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
});

let set_featured_image_lock = true;
$('.set-featured-image').on('click', function () {
    if (!set_featured_image_lock || $(this).hasClass('prevent-action')) return;
    set_featured_image_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let global_media_viewer = button;
    while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();
    let selected_media;
    global_media_viewer.find('.media-library-item-container').each(function () {
        if ($(this).find('.selected').val() == 1) {
            selected_media = $(this);
        }
    });

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    // $.ajax({
    //     type:
    // });

    $('.selected-featured-image').attr('src', selected_media.find('.media-library-item-image').attr('src'));
    handle_image_center_by_filling_parent($('.selected-featured-image'));
    $('.featured-image-upload-box').addClass("none");
    $('.uploaded-featured-image-box').removeClass("none");
    global_media_viewer.find('.close-global-viewer').trigger('click');

    button.removeClass('dark-bs-disabled');
    buttonicon.removeClass('none');
    spinner.addClass('opacity0');
    spinner.removeClass('inf-rotate');
    set_featured_image_lock = true;
});

$('.remove-featured-image').on('click', function () {

});

$('.update-featured-image').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
    $('#set-featured-image-viewer').find('.open-medias-library-section').trigger('click');
});