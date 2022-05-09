$('#move-down-button').on('click', function() {
    let scrollDiv = document.getElementById("features-section").offsetTop;
    window.scrollTo({ top: scrollDiv, behavior: 'smooth'});
});

$('#discover-button').on({
    mouseenter: function() {
        let compass = $(this).find('.compass');
        compass.css('transform', 'rotate(180deg)');
    },
    mouseleave: function() {
        let compass = $(this).find('.compass');
        compass.css('transform', 'rotate(0deg)');
    }
})

let post_nav_lock = true;
$('.post-nav').on('click', function() {
    if(!post_nav_lock) return;
    post_nav_lock = false;

    let scrollable = $('#featured-posts-section');
    let width = $('.featured-post-component').width() + 2 + parseInt(scrollable.css('gap'), 10); // + 2 of borders (left and right)
    let scroll = $(this).hasClass('left') ? width * -1 : width;
    scrollable.animate({
        scrollLeft: scrollable.scrollLeft() + scroll
    }, 140, function() {
        post_nav_lock = true;
    });
});