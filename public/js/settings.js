$('.avatar-upload-button').on('change', function(event) {
    // validate uploaded cover
    let avatar_img = $('#avatar');
    let error_container = $('.error-container');
    let uploaded_avatar = event.target.files[0];
    if(!validate_avatar_image_type(uploaded_avatar)) {
        error_container.find('.error').text($('#avatar-file-not-supported').val());
        error_container.removeClass('none');
        $('body').trigger('click');
        return;
    }
    error_container.addClass('none');

    // validating image size and dimensions is done in server side
    avatar_img.attr('src', URL.createObjectURL(event.target.files[0]));
    avatar_img.removeClass('none');
    // Handle uploaded avatar dimensions
    avatar_img.attr('style', '');
    setTimeout(function() {
        fill_image_on_square_container(avatar_img);
    }, 400);

    $('.discard-uploaded-avatar').removeClass('none');
    $('.open-remove-avatar-dialog').addClass('none');

    $('body').trigger('click'); // Hide button parent suboptions-container
    event.stopPropagation();
});

$('.discard-uploaded-avatar').on('click', function(event) {
    $('#avatar-input').val(''); // Discard upload
    let avatar_img = $('#avatar');

    // Discard uploaded avatar from avatar image tag
    if($('#original-avatar').val() != '') {
        avatar_img.attr('src', $('#original-avatar').val());
        avatar_img.removeClass('none');
        $('.open-remove-avatar-dialog').removeClass('none');
    } else
        avatar_img.attr('src', $('#default-avatar').val());
    
    $(this).parent().css('display', 'none');
    event.stopPropagation();

    $('.discard-uploaded-avatar').addClass('none');
    $('.restore-original-avatar').addClass('none');
});

function validate_avatar_image_type(file){
    let extensions = ["jpg", "jpeg", "png", "gif", "bmp"];
    let name = file.name;
    var extension = name.substr(name.lastIndexOf(".") + 1, name.length).toLowerCase();
    if(extensions.includes(extension))
        return file;

    return false;
}