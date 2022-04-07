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