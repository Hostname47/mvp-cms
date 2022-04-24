$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// $(window).on('unload', function() { $(window).scrollTop(0); });

$('.fade-box').each(function() {
    let box = $(this);
    window.setInterval(function(){
        let target_color;
        if(box.css('background-color') == "rgb(214, 218, 225)") {
            target_color = "rgb(233, 236, 240)";
        } else {
            target_color = "rgb(214, 218, 225)";
        }
        box.css({
            backgroundColor: target_color,
        });
    }, 800);
})

let discover_opening_timeout;
$('#header-discover-button').on({
    mouseenter: function() {
        clearTimeout(discover_opening_timeout);
        $('#header-discover-box').css('display', 'block');
    },
    mouseleave: function() {
        close_header_discover_section();
    }
});

$('#header-discover-box').on({
    mouseenter: function() {
        clearTimeout(discover_opening_timeout);
    },
    mouseleave: function() {
        close_header_discover_section();
    }
});

function close_header_discover_section() {
    discover_opening_timeout = setTimeout(function() {
        $('#header-discover-box').css('display', 'none');
    }, 60);
}

$('.toggle-box').each(function() { handle_toggling($(this)); });
function handle_toggling(box) {
    box.find('.toggle-button').first().on('click', function() {
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
function slugify(s) {
    return s.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "") //remove diacritics
            .toLowerCase()
            .replace(/\s+/g, '-') //spaces to dashes
            .replace(/&/g, '-and-') //ampersand to and
            .replace(/[^\w\-]+/g, '') //remove non-words
            .replace(/\-\-+/g, '-') //collapse multiple dashes
            .replace(/^-+/, '') //trim starting dash
            .replace(/-+$/, ''); //trim ending dash
}

$('.header-menu-button').on({
    mouseenter: function() {
        $(this).find('.header-menu-button-strip').width('100%');
    },
    mouseleave: function() {
        $(this).find('.header-menu-button-strip').width('0%');
    }
})

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
    let message_container;
    $('.top-message-container').addClass('none'); // First close all message containers types
    switch(type) {
        case 'green':
            message_container = $('#top-green-message-container');
            break;
        case 'warning':
            message_container = $('#top-warning-message-container');
            break;
        case 'error':
            message_container = $('#top-error-message-container');
            break;
    }    
    message_container.find('.message-text').text(message);
    message_container.removeClass('none')
    
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

$('.remove-top-message-container-button').on('click', function() {
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
        console.log(width);
        console.log(height);
        if(width > height)
            image.width('100%');
        else
            image.height('100%');
    })
}
$('.fill-and-center-image-on-parent').each(function() { handle_image_center_fill($(this)); })
function handle_image_center_fill(image) {
    image.on('load', function(){
        if(this.naturalWidth > this.naturalHeight)
            image.css('width', '100%');
        else
            image.css('height', '100%');

        /**
         * Here we have to check if the height after qsetting width to 100% is bigger than
         * the container or not; If so then ok; otherwise, we have to set height to 100% and width to auto
         * to make image fill all the parent area (parent should have flex centering styles).
         * I'll go back to it later to handle image loading and dimensions processing
         */
        console.log($(this).width())
    });
}
function load_image(src, callback) {
    let image = new Image();
    $(image).on('load', function() {
        callback(image);
    });
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

$('.open-image-on-image-viewer').each(function() {
    handle_image_open($(this).parent());
});
$('#image-viewer').on('click', function() {
    $(this).addClass('none');
});
$('#image-viewer .image').on('click', function(event) {
    event.stopPropagation();
});
function handle_image_open(component) {
    component.find('.open-image-on-image-viewer').each(function() {
        $(this).on('click', function() {
            let viewer = $('#image-viewer');
            let vimage = viewer.find('.image');

            vimage.attr('src', $(this).attr('src'));
            viewer.removeClass('none');
            handle_viewer_media_logic(vimage);
        });
    });
}
function handle_viewer_media_logic(image) {
    image.attr('style', '');
    let container_height = image.parent().height();
    let original_width = image.width();
    let original_height = image.height();

    if(original_width > original_height) {
        image.css('width', '100%');
        let new_width = image.width(); // get the new width after setting it to 100%
        let new_height = image.height(); // get newer height dimension because width is changed and affect the height

        if(new_height > container_height) {
            image.css('height', '100%');
            let ratio = container_height * original_width / original_height;
            image.css('width', ratio + 'px');
        } else {
            
        }
    } else {
        image.css('height', '100%');
    }
}

$('.login-required').each(function() { handle_login_required_actions($(this).parent()); });
function handle_login_required_actions(section) {
    section.find('.login-required').each(function() {
        $(this).on('click', function(event) {
            $('#login-viewer').removeClass('none');
            disable_page_scroll();
            
            event.preventDefault();
        });
    });
}

function stretch_image_to_parent_dimensions(image, has_fade) {
    let container = image.parent();
    let image_w = image[0].naturalWidth;
    let image_h = image[0].naturalHeight;
    let container_w = container.width();
    let container_h = container.height();

    image.on({
        load: function() {
            if(image_w > image_h) {
                image.height(container_h);
                if(container_w > image.width()) {
                    image.width(container_w);
                    image.css('height', 'auto');
                }
            }
            else {
                image.width(container_w);
                if(container_h > image.height()) {
                    image.height(container_h);
                    image.css('width', 'auto');
                }
            }
            // Remove fade if exists once the image finish loading
            if(has_fade)
                image.parent().find('.fade-box').remove();
        },
        error: function() {
            if(has_fade)
                image.parent().find('.fade-box').remove();
            
            console.log('error');
        },
        complete: function() {
            console.log('fisnish');
        }
    });
}

$(window).on('DOMContentLoaded load resize scroll', function() {
    handle_lazy_images();
});

function handle_lazy_images() {
    $('.lazy-image').each(function() {
        let image = $(this);
        if(is_visible_in_viewport(image[0])) {
            let src = image.attr('data-src');
            let stretch = image.attr('data-stretch');
            image.attr('src', src);
            image.removeAttr('data-src');
            image.removeAttr('stretch');
            image.removeClass('lazy-image');

            switch(stretch) {
                case 'fill-parent-dims':
                    stretch_image_to_parent_dimensions(image, image.hasClass('with-fade'));
                    break;
            }
        }
    });
}

function is_visible_in_viewport(element) {
    let rect = element.getBoundingClientRect();
    var top = rect.top;
    var bottom = rect.bottom;

    return top < window.innerHeight && bottom >= 0;
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * The follwing code will expend all the toggles of selected category's ancestors.
 * e.g. If we have the following hierarchy:
 *  Tech
 *  ---Back-end
 *  ------PHP
 * If the user select the php we need to expend tech and backend toggle containers
 */
$('#left-panel .category.bold').each(function() {
    let category = $(this);
    let has_children = category.parent().find('.category-toggle-button').length;
    let categories_box = category;
    while(!categories_box.hasClass('categories-box')) {
        if(categories_box.hasClass('toggle-box'))
            if(has_children)
                has_children = false;
            else
                categories_box.find('.toggle-button').first().trigger('click');
        categories_box = categories_box.parent();
    }
    // The following line open categories box
    categories_box.find('.toggle-button').first().trigger('click');
});

/**
 * Newsletter subscription
 */
let newsletter_subscription_lock = true;
$('#newsletter-subscribe-button').on('click', function() {
    let error = $('#newsletter-viewer .error');
    let email = $('#newsletter-subscribe-email-input').val().trim();
    
    error.addClass('none');
    if(email == "" || !validateEmail(email)) {
        error.removeClass('none');
        return;
    }

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('newsletter-subscribe-button-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    if(!newsletter_subscription_lock) return;
    newsletter_subscription_lock = false;
});

