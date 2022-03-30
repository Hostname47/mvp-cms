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
        case 'green':
            $('.top-message-container').addClass('none'); // First close all message containers types
            let top_green_message_container = $('#top-green-message-container');
            top_green_message_container.find('.message-text').text(message);
            top_green_message_container.removeClass('none')
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

/**
 * When user click on any place on document we have to close all suboptions containers;
 * There's a special case where user click on suboptions container which is explained in handle_suboptions_container()
 */
document.addEventListener("click", function(event) {
    $(".suboptions-container").css("display", "none");
}, false);
$(".button-with-suboptions").each(function() {
    handle_suboptions_container($(this).parent());
});

function handle_suboptions_container(section) {
    section.find('.button-with-suboptions').each(function() {
        $(this).on('click', function(event) {
            let container = $(this).parent().find(".suboptions-container").first();
            /**
             * Prevent propagating event to reach the body which close all subotpions 
             * containers in case the user click on suboptions container area
             */
            container.on('click', function(e) { e.stopPropagation(); })

            /**
             * First we close all previously opened containers, then we open the target one.
             */
            if(container.css("display") == "none") {
                $(".suboptions-container").css("display", "none");
                container.css("display", "block");
            }
            else
                container.css("display", "none");
            
            event.stopPropagation();
        });
    })
}

document.addEventListener("click", function(event) { 
    $(".custom-dropdown-box .arrow").css({transform:'rotate(0deg)','-ms-transform':'rotate(0deg)','-moz-transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','-o-transform':'rotate(0deg)'});
    $(".custom-dropdown-items-container").css("display", "none");
}, false);
$('.custom-dropdown-button').on('click', function(event) {
    let button = $(this);
    let container = $(this).parent().find(".custom-dropdown-items-container").first();
    container.on('click', function(e) { e.stopPropagation(); })
    if(container.css("display") == "none") {
        $(".custom-dropdown-items-container").css("display", "none");
        $(".custom-dropdown-box .arrow").css({transform:'rotate(0deg)','-ms-transform':'rotate(0deg)','-moz-transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','-o-transform':'rotate(0deg)'});
        container.css("display", "block");
        button.find('.arrow').css({transform:'rotate(90deg)','-ms-transform':'rotate(90deg)','-moz-transform':'rotate(90deg)','-webkit-transform':'rotate(90deg)','-o-transform':'rotate(90deg)'});
    }
    else {
        container.css("display", "none");
        button.find('.arrow').css({transform:'rotate(0deg)','-ms-transform':'rotate(0deg)','-moz-transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','-o-transform':'rotate(0deg)'});
    }

    event.stopPropagation();
});
$('.custom-dropdown-item').on('click', function() {
    let button = $(this);
    let box = button;
    while(!box.hasClass('custom-dropdown-box')) box = box.parent();

    box.find('.custom-dropdown-button-text').text(button.find('.custom-dropdown-item-text').text());
    box.find('.selected-value').val(button.find('.custom-dropdown-item-value').val());
    button.addClass('custom-dropdown-item-selected');
    // Set selected to button
    box.find('.custom-dropdown-item').removeClass('custom-dropdown-item-selected custom-dropdown-item-selected-style')
    button.addClass('custom-dropdown-item-selected custom-dropdown-item-selected-style');

    box.find('.custom-dropdown-items-container').css('display', 'none');
    $('.custom-dropdown-button .arrow').css({transform:'rotate(0deg)','-ms-transform':'rotate(0deg)','-moz-transform':'rotate(0deg)','-webkit-transform':'rotate(0deg)','-o-transform':'rotate(0deg)'});
});

$('.menu-toggle-button').on('click', function() {
    let button = $(this);
    let menu = button.parent();

    menu.find('.menu-toggle-button').removeClass('menu-button-style-1-selected');
    menu.find('.menu-button-style-1-selected-strip').addClass('none');
    button.addClass('menu-button-style-1-selected');
    button.find('.menu-button-style-1-selected-strip').removeClass('none');
});

function validate_image(file, callback) {
    var url = window.URL || window.webkitURL;
    var image = new Image();
    
    image.onload = function() { callback(true); };
    image.onerror = function() { callback(false); };

    image.src = url.createObjectURL(file);
}

function get_file_type(file) {
    if(file.type.match('image.*')) return 'image';
    if(file.type.match('video.*')) return 'video';
    
    return 'other';
}

$('.center-image-based-on-higher-dimension').each(function() { handle_image_center_based_on_higher_dim($(this)); })
function handle_image_center_based_on_higher_dim(image) {
    load_image(image.attr('src'), function() {
        let width = image.width();
        let height = image.height();

        if(width > height)
            image.width('100%');
        else
            image.height('100%');
    })
}
function load_image(src, callback) {
    let image = new Image();
    image.onload = callback;
    image.src = src;
}

$('.copy-text').each(function() { handle_copy($(this)); })
function handle_copy(button) {
    button.on('click', function() {
        let copybox = $(this);
        while(!copybox.hasClass('copy-box'))  copybox = copybox.parent();
        
        let textelement = copybox.find('.text-to-copy');
        if(textelement.is('input')) {
            textelement.trigger('select');
            navigator.clipboard.writeText(textelement.val());
        }
        else if(textelement.is('p'))
            navigator.clipboard.writeText(textelement.text());
        
        copybox.find('.copy-icon').addClass('none');
        copybox.find('.copied-icon').removeClass('none');
        copybox.find('.copy-label').addClass('none');
        copybox.find('.copied-label').removeClass('none');

        setTimeout(function() {
            copybox.find('.copy-icon').removeClass('none');
            copybox.find('.copied-icon').addClass('none');
            copybox.find('.copy-label').removeClass('none');
            copybox.find('.copied-label').addClass('none');
        }, 1600);
    });
}

let left_bottom_notification_timeout;
function left_bottom_notification(message, icon='green-tick') {
    clearInterval(left_bottom_notification_timeout);
    let container = $('#basic-bottom-left-notification-container');
    container.find('.icon').addClass('none');
    container.find('.'+icon).removeClass('none');
    container.find('.content').html(message);
    container.removeClass('none');

    left_bottom_notification_timeout = setTimeout(function() {
        $('#basic-bottom-left-notification-container').addClass('none');
        $('#basic-bottom-left-notification-container').find('.content').html('');
   }, 5000);
}

$('#basic-bottom-left-notification-container').on({
    mouseenter: function() {
        // Stop animation to keep the notification displayed
        clearTimeout(left_bottom_notification_timeout);
    },
    mouseleave: function() {
        // Start animation to hide the notification after 5 seconds
        left_bottom_notification_timeout = setTimeout(function() {
            $('#basic-bottom-left-notification-container').addClass('none');
            $('#basic-bottom-left-notification-container').find('.content').html('');
       }, 3000);
    }
});