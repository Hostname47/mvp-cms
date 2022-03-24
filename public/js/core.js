$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.toggle-box').each(function() { handle_toggling($(this)); });
function handle_toggling(component) {
    component.find('.toggle-button').each(function() {
        $(this).on('click', function() {
            let box = $(this);
            while(!box.hasClass('toggle-box')) box = box.parent();
            let container = box.find('.toggle-container').first();
            let arrow = box.find('.toggle-arrow').first();

            if(container.hasClass('none')) {
                container.removeClass('none');
                container.addClass('block');

                if(arrow.length) {
                    arrow.css({
                        transform:'rotate(90deg)',
                        '-ms-transform':'rotate(90deg)',
                        '-moz-transform':'rotate(90deg)',
                        '-webkit-transform':'rotate(90deg)',
                        '-o-transform':'rotate(90deg)'
                    });
                }
            } else {
                container.removeClass('block');
                container.addClass('none');

                if(arrow.length) {
                    arrow.css({
                        transform:'rotate(0deg)',
                        '-ms-transform':'rotate(0deg)',
                        '-moz-transform':'rotate(0deg)',
                        '-webkit-transform':'rotate(0deg)',
                        '-o-transform':'rotate(0deg)'
                    });
                }
            }
        });
    });
}

function disable_page_scroll() {
    $('body').attr('style', 'overflow-y: hidden;');
}
function enable_page_scroll() {
    $('body').attr('style', '');
}

$('.close-global-viewer').each(function() { handle_global_viewer_close_button($(this)); })
function handle_global_viewer_close_button(button) {
    button.on('click', function() {
        let globalviewer = $(this);
        while(!globalviewer.hasClass('global-viewer')) globalviewer = globalviewer.parent();
    
        if($('.global-viewer').not('.none').length == 1)
            enable_page_scroll();
        globalviewer.addClass('none');
    });
}

function scroll_to_element(id, top=-60, scrollable=null) {
    $('#'+id)[0].scrollIntoView(true);
    if(scrollable == null)
        $(window).scrollTop($(window).scrollTop() + top);
    else
        scrollable.scrollTop(scrollable.scrollTop() + top);
}

function convertToSlug(text) {
    return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
}

$('.remove-parent').on('click', function() {
    $(this).parent().remove();
});
$('.close-parent').on('click', function() {
    $(this).parent().addClass('none');
});
