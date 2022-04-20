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