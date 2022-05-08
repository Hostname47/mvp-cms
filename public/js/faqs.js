$('.question-container').on('click', function() {
    let component = $(this);
    while(!component.hasClass('faq-component')) component = component.parent();

    let answer = component.find('.answer-container');
    if(answer.hasClass('none')) {
        answer.removeClass('none');
        rotate(component.find('.faq-toggle-arrow'), 180);
    } else {
        answer.addClass('none');
        rotate(component.find('.faq-toggle-arrow'), 0);
    }
});