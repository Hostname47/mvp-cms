
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
    let maximum_number_of_uploads = 16;
    let validated_medias = [];
    
    /**
     * For each file upload, we have to check :
     *  1. Check number of uploaded files at the time
     *  2. Size should be less than 5 MB
     *  3. Uploaded files should be either image or video files
     */
    if(files.length > maximum_number_of_uploads) {
        show_upload_media_error('The maximum number of files upload is ' + maximum_number_of_uploads + ' files at a time.');
        return;
    }

    for(let i = 0; (i < files.length && i < maximum_number_of_uploads ); i++) {

        // .2
        let filesize = files[i].size / (1024*1024);
        if(filesize > 5) {
            show_upload_media_error('<strong>'+files[i].name+'</strong> file size exceeds the maximum size allowed per file (>5 MB max)');
            return;
        }
        
        /**
         * 3.
         *   3.1. validate image
         *   3.2. if it is not image then we validate video
         */
        if(get_file_type(files[i]) != 'image') {
            if(get_file_type(files[i]) != 'video') {
                show_upload_media_error('<strong>'+files[i].name + '</strong> file format is not supported. only images & videos are supported at the moment');
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
    $('#upload-media').val('');
}