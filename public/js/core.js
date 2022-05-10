$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// $(window).on('unload', function() { $(window).scrollTop(0); });

function set_cookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/;secure";
}
function get_cookie(name) {
    return document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || '';
}

$('.header-discover-display').on('change', function() {
    let value = $(this).val();
    set_cookie('header-explore-expand', value, 365);
    if(value == 'hover')
        handle_discover_section_hover_effect();
    else
        handle_discover_section_click_effect();
});

$('.header-menu-mobile-button').on('click', function() {
    let open = $(this).find('.open');
    let close = $(this).find('.close');

    if(open.hasClass('none')) {
        open.removeClass('none');
        close.addClass('none');
        $('.header-menu').css('display', 'none');
    } else {
        open.addClass('none');
        close.removeClass('none');
        $('.header-menu').css('display', 'block');
    }
});

let header_post_nav_lock = true;
$('.header-featured-post-nav').on('click', function() {
    if(!header_post_nav_lock) return;
    header_post_nav_lock = false;

    let scroll = $(this).hasClass('top') ? -200 : 200;
    let scrollable = $('#header-featured-posts-section');
    scrollable.animate({
        scrollTop: scrollable.scrollTop() + scroll
    }, 140, function() {
        header_post_nav_lock = true;
    });
});

$('#left-panel-toggle-button').on('click', function() {
    let button = $(this);
    let panel = $('#left-panel');

    if(parseInt(panel.css('left')) == 0) {
        panel.css('left', '-260px');
        rotate(button.find('.arrow'), 0);
    } else {
        panel.css('left', '0px');
        rotate(button.find('.arrow'), 180);
    }
});

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

$('.sticky-when-bottom-reached').each(function() {
    let section = $(this);
    let top = $(this).find('.compass')[0].offsetTop - window.innerHeight;
    section.css('top','-'+top+'px');
});

let discover_opening_timeout;
function handle_discover_section_hover_effect() {
    let discover_expand_button = $('#header-discover-expand-button');
    discover_expand_button.addClass('none');
    /**
     * Even though we hide the expand button, but we need to rotate it based on discover section
     * appearence so that when user select click again thebutton should be rotated
     */
    $('#header-discover-button').on({
        mouseenter: function() {
            clearTimeout(discover_opening_timeout);
            $('#header-discover-box').css('display', 'block');
            rotate(discover_expand_button, 90);
        },
        mouseleave: function() {
            close_header_discover_section();
        }
    });
    $('#header-discover-box').on({
        mouseenter: function() {
            clearTimeout(discover_opening_timeout);
            rotate(discover_expand_button, 90);
        },
        mouseleave: function() {
            close_header_discover_section();
        }
    });
}

function handle_discover_section_click_effect() {
    let discover_button = $('#header-discover-button');
    let expand = $('#header-discover-expand-button');
    let box = $('#header-discover-box');
    
    discover_button.off('mouseenter mouseleave');
    box.off('mouseenter mouseleave');

    expand.off('click');
    expand.on('click', function(event) {
        if(box.css('display') == 'none') {
            box.css('display', 'block');
            /**
             * The following click trigger is used to close any other options subcontainer that could
             * be opened already like header search
             */
            box.trigger('click');
            rotate(expand, 90);
        } else {
            box.css('display', 'none');
            rotate(expand, 0);
        }
        event.stopPropagation();
    });
    expand.removeClass('none');
}

function close_header_discover_section() {
    discover_opening_timeout = setTimeout(function() {
        $('#header-discover-box').css('display', 'none');
    }, 60);
    rotate($('#header-discover-expand-button'), 0);
}

$('.close-discover-panel').on('click', function() {
    close_header_discover_section();
});

if(get_cookie('header-explore-expand') == 'click')
    $('#discover-display-click').trigger('click');
else
    $('#discover-display-hover').trigger('click');

function rotate(element, deg) {
    element.css({
        transform:'rotate(' + deg + 'deg)',
        '-ms-transform':'rotate(' + deg + 'deg)',
        '-moz-transform':'rotate(' + deg + 'deg)',
        '-webkit-transform':'rotate(' + deg + 'deg)',
        '-o-transform':'rotate(' + deg + 'deg)'
    });
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
        $(this).find('.header-menu-button-strip').css('right', 'auto')
        $(this).find('.header-menu-button-strip').width('100%');
    },
    mouseleave: function() {
        $(this).find('.header-menu-button-strip').css('right', '0')
        $(this).find('.header-menu-button-strip').width('0%');
    }
})

$('.remove-parent').on('click', function() {
    $(this).parent().remove();
});
$('.close-parent').on('click', function() {
    $(this).parent().addClass('none');
});
function handle_close_parent(section) {
    section.find('.close-parent').on('click', function() {
        $(this).parent().addClass('none');
    });
}

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

handle_suboptions_container($('body'));
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
            } else
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
    var top = rect.top - ($('header').length ? $('header').height() : 0);
    var bottom = rect.bottom;

    return top < window.innerHeight;
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

$('.tooltip-box').each(function() {
    handle_tooltip($(this));
})

function handle_tooltip(tooltip_box) {
    tooltip_box.find('.tooltip-pointer').first().on({
        'mouseenter': function() {
            tooltip_box.find('.tooltip').first().css('display', 'block');
        },
        'mouseleave': function() {
            tooltip_box.find('.tooltip').first().css('display', 'none');
        }
    });
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

let newsletter_viewer_opening_lock = true;
let newsletter_viewer_opened = false;
$('#newsletter-subscribe-opener-button').on('click', function() {
    let viewer = $('#newsletter-viewer');
    if(newsletter_viewer_opening_lock && !newsletter_viewer_opened) {
        newsletter_viewer_opening_lock = false;

        let loading = $('#newsletter-loading-section');
        loading.find('.spinner').addClass('inf-rotate');

        $.ajax({
            type: 'get',
            url: '/newsletter/subscribe/viewer',
            success: function(response) {
                newsletter_viewer_opened = true;
                $('#newsletter-loading-section').remove();
                $('#newsletter-viewer-container').append(response);
                handle_newsletter_subscribe_button();
                handle_close_parent(viewer);
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
            },
            complete: function(response) {
                newsletter_viewer_opening_lock = true;
            }
        });
    }
    viewer.removeClass('none');
    // disable_page_scroll();
});

/**
 * Newsletter subscription
 */
let newsletter_subscription_lock = true;
function handle_newsletter_subscribe_button() {
    $('#newsletter-subscribe-button').on('click', function() {
        let viewer = $('#newsletter-viewer');
        let error_container = viewer.find('.error-container');
        let error = error_container.find('.error');
        let name = $('#newsletter-subscribe-name-input');
        let email = $('#newsletter-subscribe-email-input');
        
        error_container.addClass('none');
        // Verify name
        if(name.val().trim() == '') {
            error.text(viewer.find('.name-error').val());
            error_container.removeClass('none');
            return;
        }
        // Verify email
        if(email.val().trim() == "" || !validateEmail(email.val().trim())) {
            error.text(viewer.find('.email-error').val());
            error_container.removeClass('none');
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
    
        $.ajax({
            type: 'post',
            url: '/newsletter/subscribe',
            data: {
                name: name.val().trim(),
                email: email.val().trim(),
            },
            success: function() {
                $('#newsletter-submission-section').addClass('none');
                $('#newsletter-thankyou-section').removeClass('none');
            },
            error: function(response) {
                newsletter_subscription_lock = true;
                button.removeClass('newsletter-subscribe-button-disabled');
    
                buttonicon.removeClass('none');
                spinner.addClass('opacity0');
                spinner.removeClass('inf-rotate');
    
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
            },
            complete: function() {
    
            }
        })
    });
}

/**
 * Reporting
 */
function handle_report_choice(report_box) {
    report_box.find('.report-choice-input').each(function() {
        $(this).on('change', function() {
            let option = $(this);
            let report_box = option;
            while(!report_box.hasClass('report-section')) report_box = report_box.parent();
            let report_body_container = report_box.find('.report-body-input-container');
        
            if(option.val() == 'moderator-intervention') {
                report_body_container.animate({
                    height: '100%'
                }, 200);
        
                handle_report_body_input(report_body_container.find('.report-body-input'));
            } else {
                report_body_container.animate({ height: '0px' }, 200);
                enable_report_submit(report_box);
            }
        });
    });
}
function handle_report_body(report_box) {
    report_box.find('.report-body-input').on('input', function() {
        handle_report_body_input($(this));
    });
}
function handle_report_body_input(textarea) {
    let report_container = textarea;
    while(!report_container.hasClass('report-resource-container')) report_container = report_container.parent();
    let report_body_container = report_container.find('.report-body-input-container');
    let counter_container = textarea.parent().find('.report-body-counter');
    let counter = counter_container.find('.report-body-count');
    let phrase = counter_container.find('.report-body-count-phrase');
    let maxlength = 500;
    let currentLength = textarea.val().trim().length;

    disable_report_submit(report_container);

    counter_container.addClass('gray');
    if(currentLength == 0) {
        counter_container.attr('style', '');
        counter.text('');
        phrase.text(report_body_container.find('.enter-at-least-10-chars-text').val());
    } else if(currentLength > maxlength) {
        let more_than_max = currentLength - maxlength;
        let chars_text = more_than_max > 1 ? report_body_container.find('.characters-text').val() : report_body_container.find('.characters-text').val().slice(0, -1);
        let counter_phrase = report_body_container.find('.too-long-text').val() + ' ' + more_than_max + ' ' + chars_text;
        counter.text('');
        phrase.text(counter_phrase);

        counter_container.removeClass('gray');
        counter_container.css('color', '#e83131');
    } else {
        counter_container.attr('style', '');
        if(currentLength < 10) {
            let left_to_10 = 10 - currentLength;
            let counter_phrase = report_body_container.find('.more-to-go-text').val();
            counter_container.find('.report-body-count').text(left_to_10);
            phrase.text(counter_phrase);
        } else {
            let chars_left = maxlength - currentLength;
            let counter_phrase = report_body_container.find('.chars-left-text').val();
            counter_container.find('.report-body-count').text(chars_left);
            phrase.text(counter_phrase);
            
            enable_report_submit(report_container);
        }
    }
}
function enable_report_submit(report_box) {
    report_box.find('.submit-report').removeClass('dark-bs-disabled');
    submit_report_confirmed = true;
}
function disable_report_submit(report_box) {
    report_box.find('.submit-report').addClass('dark-bs-disabled');
    submit_report_confirmed = false;
}

let submit_report_confirmed = false;
let submit_report_lock = true;
function handle_report_submit_button(report_box) {
    report_box.find('.submit-report').on('click', function() {
        if(!submit_report_lock || !submit_report_confirmed) return;
        submit_report_lock = false;
        
        let button = $(this);
        let spinner = button.find('.spinner');
        
        let reportable_type = report_box.find('.reportable-type').val();
        let reportable_id = report_box.find('.reportable-id').val();
        let report_type = report_box.find('input[name="report-option"]:checked').val();
        let report_content = report_box.find('.report-body-input').val();
        
        let data = {
            reportable_id: reportable_id,
            reportable_type: reportable_type,
            type: report_type
        };
        if(report_type == "moderator-intervention")
            data.body = report_content;
        
        spinner.removeClass('none');
        spinner.addClass('inf-rotate');
        button.addClass('dark-bs-disabled');

        $.ajax({
            type: 'post',
            url: `/reports`,
            data: data,
            success: function(response) {
                report_box.find('.close-report-container').trigger('click');
                // Wait for closing annimation
                setTimeout(function() {
                    report_box.addClass('none');
                    left_bottom_notification($('#reported-successfully-message').val());
                    disable_report_submit(report_box);
                }, 200);
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
                report_box.find('input[name="report-option"]:checked').trigger('change');
                spinner.addClass('none');
                spinner.removeClass('inf-rotate');
            },
            complete: function() {
                submit_report_lock = true;
            }
        });
    });
}
function handle_close_report_box(report_box) {
    report_box.find('.close-report-container').each(function() {
        $(this).on('click', function() {
            report_box.animate({
                opacity: 0
            }, 100, function() {
                report_box.addClass('none');
            })
        })
    });
}