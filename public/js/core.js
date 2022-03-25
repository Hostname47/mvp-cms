$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(window).on('unload', function() { $(window).scrollTop(0); });

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

let top_message_timeout;
function print_top_message(message, type) {
    clearTimeout(top_message_timeout);

    let top_message_box = $('#top-message-box');
    top_message_box.removeClass('none');

    switch(type) {
        case 'normal':
            break;
        case 'warning':
            break;
        case 'error':
            $('.top-message-container').addClass('none'); // First close all message containers types
            let top_error_message_container = $('#top-error-message-container');
            top_error_message_container.find('.message-text').text(message);
            top_error_message_container.removeClass('none')
            break;
    }
    
    // This timeout will wait for 6 sec before close the message
    top_message_timeout = setTimeout(function() {
        top_message_box.addClass('none');
        top_message_box.find('.message-text').text('');
    }, 6000);
}
$('#top-message-box').on({
    mouseenter: function() {
        clearTimeout(top_message_timeout);
    },
    mouseleave: function() {
        let top_message_box = $(this);
        top_message_timeout = setTimeout(function() {
            top_message_box.addClass('none');
            top_message_box.find('.message-text').text('');
        }, 6000);
    }
});

$('#remove-top-message-container-button').on('click', function() {
    clearTimeout(top_message_timeout);
    $('#top-message-box').addClass('none');
});