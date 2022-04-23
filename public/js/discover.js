
let posts_fetch_more = $('#posts-fetch-more');
let posts_fetch_more_lock = true;
if(posts_fetch_more.length) {
    $(window).on('DOMContentLoaded scroll', function() {
        if($(window).scrollTop() + $(window).innerHeight() + posts_fetch_more.height() >= $(document).height()) {
            if(!posts_fetch_more_lock || posts_fetch_more.hasClass('stop-fetch')) return;
            posts_fetch_more_lock=false;
            
            let present_posts = $('#posts-box .post-component').length;
            $.ajax({
				url: '/posts/fetch',
				data: {
                    skip: present_posts,
                    take: 10,
                    form: 'card-component',
                    sort: 'publish-date'
				},
                success: function(response) {
					let posts = response.posts;
					let hasmore = response.hasmore;
		
					if(posts.length) {
						$('#posts-box').append(response.posts);

                        // Here we need to handle featured image event (lazy load it)

						if(!hasmore)
                            posts_fetch_more.addClass('none stop-fetch');
					} else {
						// no results found
						posts_fetch_more.addClass('none stop-fetch');
					}
                },
                complete: function() {
                    posts_fetch_more_lock = true;
                }
            });
        }
    });
}

$('#discover-posts-count').on('change', function() {
    window.location.href = updateQueryStringParameter(window.location.href, 'count', $(this).val());
});

$('#discover-posts-sort').on('change', function() {
    window.location.href = updateQueryStringParameter(window.location.href, 'sort', $(this).val());
});
