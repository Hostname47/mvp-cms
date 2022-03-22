
let content = new SimpleMDE({
    element: $('#content')[0],
    hideIcons: ["guide", "image"],
    spellChecker: false,
    mode: 'markdown',
    showMarkdownLineBreaks: true,
});

$('#toggle-meta-and-slug').on('click', function() {
    let button = $(this);
    let targetbox = $('#meta-and-slug-section');
    if(targetbox.hasClass('none')) {
        button.find('.toggle-arrow').first().css({
            transform:'rotate(90deg)',
            '-ms-transform':'rotate(90deg)',
            '-moz-transform':'rotate(90deg)',
            '-webkit-transform':'rotate(90deg)',
            '-o-transform':'rotate(90deg)'
        });
        targetbox.removeClass('none');
    } else {
        button.find('.toggle-arrow').first().css({
            transform:'rotate(0deg)',
            '-ms-transform':'rotate(0deg)',
            '-moz-transform':'rotate(0deg)',
            '-webkit-transform':'rotate(0deg)',
            '-o-transform':'rotate(0deg)'
        });
        targetbox.addClass('none');
    }
})

$('#toggle-content-summary').on('click', function() {
    let button = $(this);
    let targetbox = $('#content-summary-section');
    if(targetbox.hasClass('none')) {
        button.find('.toggle-arrow').first().css({
            transform:'rotate(90deg)',
            '-ms-transform':'rotate(90deg)',
            '-moz-transform':'rotate(90deg)',
            '-webkit-transform':'rotate(90deg)',
            '-o-transform':'rotate(90deg)'
        });
        targetbox.removeClass('none');
    } else {
        button.find('.toggle-arrow').first().css({
            transform:'rotate(0deg)',
            '-ms-transform':'rotate(0deg)',
            '-moz-transform':'rotate(0deg)',
            '-webkit-transform':'rotate(0deg)',
            '-o-transform':'rotate(0deg)'
        });
        targetbox.addClass('none');
    }
})