
$('.open-medias-upload-files-section').on('click', function() {
    $('.medias-upload-files-section').removeClass('none');
    $('.media-library-section').addClass('none');
});

$('.open-medias-library-section').on('click', function() {
    $('.medias-upload-files-section').addClass('none');
    $('.media-library-section').removeClass('none');
});

$('.upload-media-to-library').on('change', function() {
    /**
     * First we hide the error container if it was already opened
     */
    $('.media-upload-error-container').addClass('none');
    let input = $(this);
    let files = input[0].files;
    let maximum_number_of_uploads = 16;
    let validated_medias = [];

    /** disable the input during processing */
    input.attr('disabled', 'disabled');

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
    input.val(''); // Empty the input after validation

    if(validated_medias.length > 0) {
        let spinner = input.parent().find('.spinner');
        spinner.addClass('inf-rotate');
        spinner.removeClass('none');

        let media = new FormData();
        for(let i = 0; i < validated_medias.length; i++) {
            media.append('files[]', validated_medias[i]);
        }

        $.ajax({
            type: 'post',
            url: '/admin/media-library/upload',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: media,
            success: function(response) {

            },
            complete: function(response) {
                input.attr('disabled', false);
                spinner.removeClass('inf-rotate');
                spinner.addClass('none');
            },
            error: function(response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                show_upload_media_error(error);
            },
        })
    }
});

$('.media-library-media-selectbox').on({
    mouseenter: function() {
        $(this).find('.selected-icon').addClass('none');
        $(this).find('.unselect-icon').removeClass('none');
    },
    mouseleave: function() {
        $(this).find('.selected-icon').removeClass('none');
        $(this).find('.unselect-icon').addClass('none');
    }
})

$('.media-library-item-container').each(function() { handle_library_media_selection($(this)); });
function handle_library_media_selection(media_container) {
    media_container.on('click', function() {
        let selection_type = $(this).parent().find('.selection-type').val();
        let selected = $(this).find('.selected').val();
        let medias_box = $(this);
        while(!medias_box.hasClass('media-library-items-container')) medias_box = medias_box.parent();

        if(selection_type == 'single') {
            /**
             * If selection type is single, we need to unselect previous medias if exists 
             */
            medias_box.find('.media-library-item-container').each(function() {
                library_media_item_selection($(this), 'unselect');
            });
        }

        if(selected == 0) {
            library_media_item_selection($(this), 'select');
        } else {
            library_media_item_selection($(this), 'unselect');
        }
    });
}

function library_media_item_selection(item, selection='select') {
    if(selection == 'select') {
        item.find('.selected').val('1');
        item.find('.media-library-media-selectbox').removeClass('none');
        item.addClass('media-library-item-selected');
    } else {
        item.find('.selected').val('0');
        item.find('.media-library-media-selectbox').addClass('none');
        item.removeClass('media-library-item-selected');
    }
}

function show_upload_media_error(message) {
    let container = $('.media-upload-error-container');
    container.find('.message-text').html(message);
    container.removeClass('none');
    $('#upload-media').attr('disabled', false);
    $('#upload-media').val('');
}