$('.read-contact-message').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon');
    let spinner = button.find('.spinner');

    if(button.hasClass('in-action')) return;
    button.addClass('in-action');

    let read = button.find('.read').val();
    let messages = [button.find('.message-id').val()];

    button.attr('style', 'cursor: default;');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/contact-messages/read',
        data: {
            messages: messages,
            read: read
        },
        success: function() {
            if(read == 1) {
                button.addClass('none');
                button.parent().find('.unread-button').removeClass('none');
                left_bottom_notification('Contact message marked as read successfully.');
            } else {
                button.addClass('none');
                button.parent().find('.read-button').removeClass('none');
                left_bottom_notification('Contact message unread for further checks.');
            }
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
        complete: function() {
            button.removeClass('in-action');
            button.attr('style', '');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    })
});

$('.delete-contact-message').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');

    if(button.hasClass('in-action')) return;
    button.addClass('in-action');

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/contact-messages',
        data: {
            messages: [button.find('.message-id').val()],
        },
        success: function() {
            let component = button;
            while(!component.hasClass('contact-message-component')) component = component.parent();
            component.remove();
            if(!$('.contact-message-component').length)
                $('#no-contact-messages-row').removeClass('none');
            left_bottom_notification('Contact message deleted successfully.');
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');

            button.removeClass('in-action');
            button.attr('style', '');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
        },
    });
});

let contact_messages_bulk_lock = true;
$('.read-contact-messages-bulk').on('click', function() {
    if(!$('.contact-message-selection-input:checked').length) {
        print_top_message('You need to select at least one message to perform any bulk action', 'error');
        return;
    }

    if(!contact_messages_bulk_lock) return;
    contact_messages_bulk_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');

    let read = button.find('.read').val();
    let messages = [];
    let components = [];
    $('.contact-message-selection-input:checked').each(function() {
        messages.push($(this).val());

        let component = $(this);
        while(!component.hasClass('contact-message-component')) component = component.parent();
        components.push(component);
    });

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/contact-messages/read',
        data: {
            messages: messages,
            read: read
        },
        success: function() {
            if(read == 1) {
                $(components).each(function() {
                    $(this).find('.read-button').addClass('none');
                    $(this).find('.unread-button').removeClass('none');
                });
            } else {
                $(components).each(function() {
                    $(this).find('.read-button').removeClass('none');
                    $(this).find('.unread-button').addClass('none');
                });
            }

            $('body').trigger('click');
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
        complete: function() {
            contact_messages_bulk_lock = true;
            button.attr('style', '');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
        }
    });
});

$('.delete-contact-messages-bulk').on('click', function() {
    if(!$('.contact-message-selection-input:checked').length) {
        print_top_message('You need to select at least one message to perform any bulk action', 'error');
        return;
    }

    if(!contact_messages_bulk_lock) return;
    contact_messages_bulk_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');

    let messages = [];
    let components = []
    $('.contact-message-selection-input:checked').each(function() {
        messages.push($(this).val());

        let component = $(this);
        while(!component.hasClass('contact-message-component')) component = component.parent();
        components.push(component);
    });

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/contact-messages',
        data: {
            messages: messages,
        },
        success: function() {
            $(components).each(function() { $(this).remove(); });
            if(!$('.contact-message-component').length)
                $('#no-contact-messages-row').removeClass('none');
            left_bottom_notification('Selected messages deleted successfully.');
            $('body').trigger('click');
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
        complete: function() {
            contact_messages_bulk_lock = true;
            button.attr('style', '');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
        }
    });
});

$('#bulk-select-all-contact-messages').on('change', function() {
    if($(this).is(':checked'))
        $('.contact-message-selection-input').prop('checked', true);
    else
        $('.contact-message-selection-input').prop('checked', false);
});
