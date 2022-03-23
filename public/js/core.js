$('.toggle-box').each(function() { handle_toggling($(this)); });
function handle_toggling(component) {
    component.find('.toggle-button').each(function() {
        $(this).on('click', function() {
            let box = $(this);
            while(!box.hasClass('toggle-box')) box = box.parent();
            let container = box.find('.toggle-container');

            if(container.css('display') == 'none') {
                container.removeClass('none');
                container.addClass('block');

                if(box.find('.toggle-arrow').length) {
                    box.find('.toggle-arrow').css({
                        transform:'rotate(90deg)',
                        '-ms-transform':'rotate(90deg)',
                        '-moz-transform':'rotate(90deg)',
                        '-webkit-transform':'rotate(90deg)',
                        '-o-transform':'rotate(90deg)'
                    });
                }
            } else {
                container.removeClass('block');
                container.addClass('none');

                if(box.find('.toggle-arrow').length) {
                    box.find('.toggle-arrow').css({
                        transform:'rotate(0deg)',
                        '-ms-transform':'rotate(0deg)',
                        '-moz-transform':'rotate(0deg)',
                        '-webkit-transform':'rotate(0deg)',
                        '-o-transform':'rotate(0deg)'
                    });
                }
            }
        });
    });
}