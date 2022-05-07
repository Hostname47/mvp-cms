$('#submit-request').on('click', function() {
    let form = $('#request-form');
    if(!condition(form.find('.category:checked').length, $('#select-at-least-one-category').val())) return;
    if(!condition($('#request-message').val().trim(), $('#request-message-is-required').val())) return;

    let error_container = $('.error-container');
    let button = $(this);
    let spinner = button.find('.spinner');
    let icon = button.find('.icon');

    if(button.hasClass('in-progress')) return;
    button.addClass('in-progress');

    spinner.addClass('inf-rotate');
    spinner.removeClass('opacity0');
    icon.addClass('none');
    button.addClass('dark-bs-disabled');

    $.ajax({
        type: 'post',
        url: '/author-request',
        data: {
            categories: form.find('.category:checked').map(function(){ return $(this).val(); }).get(),
            message: $('#request-message').val()
        },
        success: function(response) {
            location.reload();
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            condition(false, error);

            button.removeClass('dark-bs-disabled in-progress');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
            icon.removeClass('none');
        }
    });
});

function condition(condition, error) {
    if(!condition) {
        let error_container = $('.error-container');
        error_container.find('.error').text(error);
        error_container.removeClass('none');
        $(window).scrollTop(0);
        return false;
    }

    return true;
}