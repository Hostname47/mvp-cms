
$('.open-medias-upload-files-section').on('click', function() {
    $('.medias-upload-files-section').removeClass('none');
    $('.media-library-section').addClass('none');
});

$('.open-medias-library-section').on('click', function() {
    $('.medias-upload-files-section').addClass('none');
    $('.media-library-section').removeClass('none');
});

$('#upload-media').on('change', function() {
    /**
     * First we hide the error container if it was already opened
     */
     $('.media-upload-error-container').addClass('none');
    let input = $(this)[0];
    let files = input.files;
    let maximum_number_of_uploads = 5;
    let validated_medias = [];
    
    if(files.length > maximum_number_of_uploads) {
        show_upload_media_error('The maximum number of files upload is ' + maximum_number_of_uploads + ' files at a time.');
        return;
    }

    for(let i = 0; (i < files.length && i < maximum_number_of_uploads ); i++) {
        /**
         * For each file upload, we have to check :
         *  1. Size should be less than 5 MB
         *  2. should be either image or video
         */

        // .1
        let filesize = files[i].size / (1024*1024);
        if(filesize > 5) {
            show_upload_media_error('File : <strong>' + files[i].name + '</strong> size exceeds the maximum size allowed per file (>5 MB max)');
            return;
        }
        
        /**
         * 2.
         *   2.1. validate image
         *   2.2. if it is not image then we validate video
         */
        if(get_file_type(files[i]) != 'image') {
            if(get_file_type(files[i]) != 'video') {
                show_upload_media_error('File : <strong>' + files[i].name + '</strong> format is not supported. only images & videos are supported at the moment');
                return;
            }
        }

        validated_medias.push(files[i]);
    }
    input.value = ''; // Empty the input after validation

    if(validated_medias.length > 0) {
        input = $(input);
        input.attr('disabled', 'disabled');
        let spinner = input.parent().find('.spinner');
        spinner.addClass('inf-rotate');
        spinner.removeClass('none');
    }
});

function show_upload_media_error(message) {
    let container = $('.media-upload-error-container');
    container.find('.message-text').html(message);
    container.removeClass('none');
}