
$('.review-report').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon');
    let spinner = button.find('.spinner');

    if(button.hasClass('in-action')) return;
    button.addClass('in-action');

    let state = button.find('.status').val();
    let reports = [];
    if(button.hasClass('bulk')) {

    } else {
        reports.push(button.find('.report-id').val());
    }

    button.attr('style', 'cursor: default;');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/reports/review',
        data: {
            reports: reports,
            state: state
        },
        success: function() {
            if(button.hasClass('bulk')) {
                
            } else {
                if(state == 1) {
                    button.addClass('none');
                    button.parent().find('.unreview-button').removeClass('none');
                    left_bottom_notification('Report marked as reviewed successfully.');
                } else {
                    button.addClass('none');
                    button.parent().find('.review-button').removeClass('none');
                    left_bottom_notification('Report unreviewed for further checks.');
                }
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