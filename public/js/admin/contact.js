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