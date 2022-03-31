CKEditor
    .create(document.querySelector('#post-content'))
    .catch(error => {
        console.error(error);
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