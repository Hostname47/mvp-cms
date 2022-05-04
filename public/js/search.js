let fetch_authors_lock = true;
$('#fetch-more-authors').on('click', function() {
    if(!fetch_authors_lock) return;
    fetch_authors_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon');
    let present_authors = $('.authors-container .author-component').length;

    let data = {
        skip: present_authors,
        take: 10,
    };
    if($('#init-search-input').val())
        data.k = $('#init-search-input').val();

    button.addClass('default-cursor');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
    

    $.ajax({
        url: '/search/authors/fetch',
        data: data,
        success: function(response) {
            if(!response.hasmore)
                button.remove();

            let authors = response.authors;
            if(response.count) {
                for(let i = 0; i < response.count; i++) {
                    let author = $('.author-component-skeleton').clone(true);
                    author.find('.author-avatar').attr('src', authors[i].avatar);
                    author.find('.fullname').text(authors[i].fullname);
                    author.find('.fullname').attr('href', authors[i].link);
                    author.find('.posts-count').text(authors[i].posts_count);
                    author.find('.username').text(authors[i].username);
                    author.removeClass('author-component-skeleton none');

                    $('.authors-container').append(author);
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
        complete: function(response) {
            fetch_authors_lock = true;
            button.removeClass('default-cursor');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        },
    })
});