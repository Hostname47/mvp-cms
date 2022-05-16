$('#post-content-box').append($('.post-share-section').clone(true));

$('.move-to-comments').on('click', function() {
    let comments = $('#comments-section')[0].offsetTop;
    window.scrollTo({ top: comments, behavior: 'smooth'});
});

$('.clap-post').on('click', function() {
    let button = $(this);
    let clapable_id = button.find('.clapable-id').val();
    let clapable_type = button.find('.clapable-type').val();

    post_clap_button_change(button);

    $.ajax({
        type: 'post',
        url: '/claps',
        data: {
            clapable_id: clapable_id,
            clapable_type: clapable_type
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');
            post_clap_button_change(button)
        }
    })
});

function post_clap_button_change() {
    $('.clap-post').each(function() {
        let button = $(this);
        let claps_counter = button.find('.claps-count');
        let claps_count = parseInt(claps_counter.text(), 10);
        if(button.hasClass('post-claped')) {
            button.removeClass('post-claped');
            claps_count--;
            claps_counter.text(claps_count);
        } else {
            button.addClass('post-claped');
            claps_count++;
            claps_counter.text(claps_count);
        }
    });
}

function post_save_button_change() {
    $('.save-post').each(function() {
        let button = $(this);
        if(button.hasClass('post-saved'))
            button.removeClass('post-saved');
        else
            button.addClass('post-saved');
    });
}

$('.share-anchor').on('click', function() {
    window.open($(this).attr('href'), 'newwindow', 'width=300,height=250');
    return false;
});

$('.save-post').on('click', function() {
    let button = $(this);
    let post_id = button.find('.post-id').val();

    post_save_button_change();

    $.ajax({
        type: 'post',
        url: '/posts/save',
        data: {
            post_id: post_id,
        },
        success: function(response) {
            console.log(response);
        },
        error: function(response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');
            post_save_button_change(button)
        }
    })
});
