
$('.review-report').on('click', function() {
    let button = $(this);
    let buttonicon = button.find('.icon');
    let spinner = button.find('.spinner');

    if(button.hasClass('in-action')) return;
    button.addClass('in-action');

    let state = button.find('.status').val();
    let reports = [button.find('.report-id').val()];

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
            if(state == 1) {
                button.addClass('none');
                button.parent().find('.unreview-button').removeClass('none');
                left_bottom_notification('Report marked as reviewed successfully.');
            } else {
                button.addClass('none');
                button.parent().find('.review-button').removeClass('none');
                left_bottom_notification('Report unreviewed for further checks.');
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

$('.delete-report').on('click', function() {
    let button = $(this);
    let spinner = button.find('.spinner');

    if(button.hasClass('in-action')) return;
    button.addClass('in-action');

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/reports',
        data: {
            reports: [button.find('.report-id').val()],
        },
        success: function() {
            let component = button;
            while(!component.hasClass('report-component')) component = component.parent();

            component.remove();
            left_bottom_notification('Report has been deleted successfully.');
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
    })
});

let review_reports_bulk_lock = true;
$('.review-reports-bulk').on('click', function() {
    if(!$('.report-selection-input:checked').length) {
        print_top_message('You need to select at least one report to perform any bulk action', 'error');
        return;
    }

    if(!review_reports_bulk_lock) return;
    review_reports_bulk_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');

    let state = button.find('.state').val();
    let reports = [];
    let components = []
    $('.report-selection-input:checked').each(function() {
        reports.push($(this).val());

        let component = $(this);
        while(!component.hasClass('report-component')) component = component.parent();
        components.push(component);
    });

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'post',
        url: '/admin/reports/review',
        data: {
            reports: reports,
            state: state
        },
        success: function() {
            if(state == 1) {
                $(components).each(function() {
                    $(this).find('.review-button').addClass('none');
                    $(this).find('.unreview-button').removeClass('none');
                });
            } else {
                $(components).each(function() {
                    $(this).find('.review-button').removeClass('none');
                    $(this).find('.unreview-button').addClass('none');
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
            review_reports_bulk_lock = true;
            button.attr('style', '');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
        }
    });
});

let delete_reports_bulk_lock = true;
$('.delete-reports-bulk').on('click', function() {
    if(!$('.report-selection-input:checked').length) {
        print_top_message('You need to select at least one report to perform any bulk action', 'error');
        return;
    }

    if(!delete_reports_bulk_lock) return;
    delete_reports_bulk_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');

    let reports = [];
    let components = []
    $('.report-selection-input:checked').each(function() {
        reports.push($(this).val());

        let component = $(this);
        while(!component.hasClass('report-component')) component = component.parent();
        components.push(component);
    });

    button.attr('style', 'cursor: default;');
    spinner.removeClass('none');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/reports',
        data: {
            reports: reports,
        },
        success: function() {
            $(components).each(function() { $(this).remove(); });
            if(!$('.report-component').length) $('#no-reports-row').removeClass('none');
            left_bottom_notification('Selected reports deleted successfully.');
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
            delete_reports_bulk_lock = true;
            button.attr('style', '');
            spinner.addClass('none');
            spinner.removeClass('inf-rotate');
        }
    });
});

$('#bulk-select-all-reports').on('change', function() {
    if($(this).is(':checked'))
        $('.report-selection-input').prop('checked', true);
    else
        $('.report-selection-input').prop('checked', false);
});
