
let post_editor;
$(document).ready(function() {
    CKEditor
        .create($('#post-content')[0], {
            toolbar: {
                items: [
                    'heading',
                    'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                    'bold', 'italic', '|',
                    'link', '|',
                    'outdent', 'indent', '|',
                    'mediaEmbed',
                    'bulletedList', 'numberedList',
                    'insertTable', '|',
                    'blockQuote', 'code', 'codeBlock', '|',
                    'undo', 'redo',
                ],
                shouldNotGroupWhenFull: true,
                pasteFilter: null,
            }
        })
        .then(editor => {
            post_editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
});

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

$('#toggle-content-summary').on('click', function () {
    let button = $(this);
    let targetbox = $('#content-summary-section');
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

let publish_post_lock = true;
$('.publish-post').on('click', function () {
    // if (!publish_post_lock) return;
    // publish_post_lock = false;

    let title = $('#post-title');
    let meta_title = $('#post-meta-title');
    let slug = $('#post-slug');
    let content_element = $('#post-content');
    let content = post_editor.getData("html");

    $('.error-container').addClass('none');
    $('.error-asterisk').css('display', 'none');

    // Validating neccessary inputs
    if (!post_input_validate(title.val() != '', title, 'Title field is required.', publish_post_lock)) return;
    if (!post_input_validate(meta_title.val() != '', meta_title, 'Meta title field is required.', publish_post_lock)) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    if (!post_input_validate(slug.val() != '', slug, 'Slug field is required.', publish_post_lock)) {
        if ($('#meta-and-slug-section').hasClass('none'))
            $('#toggle-meta-and-slug').trigger('click');
        return;
    };
    if (!post_input_validate(content != '', content_element, 'Content field is required.', publish_post_lock)) return;

    // let tags = [];
    // $('.post-tags-wrapper .post-tag-item').each(function () {
    //     tags.push($(this).find('.tag-text').text());
    // });
    // let categories = [];
    // $('.category-input').each(function () {
    //     categories.push($(this).val());
    // });


    let data = {
        title: title.val(),
        title_meta: meta_title.val(),
        slug: slug.val(),
        content: content,
        status: $('#post-status').val(),
        allow_reactions: $('#allow-reactions').is(':checked') ? 1 : 0,
        allow_comments: $('#allow-reactions').is(':checked') ? 1 : 0,
        summary: $('#post-summary').val(),
    };

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/posts',
        data: data,
        success: function(response) {
            
        },
        error: function (response) {
            publish_post_lock = true;
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }

            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            print_top_message(error, 'error');
        },
    })
});

function post_input_validate(condition, input, message, lock = false) {
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
