
$('.open-medias-upload-files-section').on('click', function() {
    $('.medias-upload-files-section').removeClass('none');
    $('.media-library-section').addClass('none');
});

let medias_library_opened = false;
let medias_library_opening_lock = true;
$('.open-medias-library-section').on('click', function() {
    $('.medias-upload-files-section').addClass('none');
    $('.media-library-section').removeClass('none');

    let global_media_viewer = $(this);
    while(!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

    if(!medias_library_opened) {
        if(!medias_library_opening_lock) return;
        medias_library_opening_lock = false;
        global_media_viewer.find('.media-library-media-loading-container .spinner').addClass('inf-rotate');

        $.ajax({
            url: '/admin/media/fetch?skip=0&take=20&form=component',
            success: function(response) {
                medias_library_opened = true;
                global_media_viewer.find('.media-library-media-loading-container').remove();
                if(response.count == 0) {
                    global_media_viewer.find('.media-library-no-media-found-container').removeClass('none');
                } else {
                    let media_container = global_media_viewer.find('.media-library-media-container');
                    let media_items_container = global_media_viewer.find('.media-library-items-container');
                    media_container.removeClass('none');
                    media_items_container.html(response.payload);

                    // Handling events
                    media_container.find('.media-library-item-container').each(function() {
                        handle_library_media_selection($(this)); // Just UI selection
                        media_selection_tick_effect($(this)); // Handle hover event on selection tick

                        /**
                         * Case media is an image
                         */
                        handle_image_center_based_on_higher_dim($(this).find('.media-library-item-image'));
                        handle_open_media_image_settings($(this));
                    });
                }

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
            complete: function() {
                medias_library_opening_lock = true;
            }
        })
    }
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


function media_selection_tick_effect(media) {
    media.find('.media-library-media-selectbox').on({
        mouseenter: function() {
            $(this).find('.selected-icon').addClass('none');
            $(this).find('.unselect-icon').removeClass('none');
        },
        mouseleave: function() {
            $(this).find('.selected-icon').removeClass('none');
            $(this).find('.unselect-icon').addClass('none');
        }
    });
}
function handle_library_media_selection(media) {
    media.on('click', function() {
        let global_media_viewer = $(this);
        while(!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();
        let selection_type = global_media_viewer.find('.selection-type').val();
        let selected = $(this).find('.selected').val();

        if(selection_type == 'single') {
            /**
             * If selection type is single, we need to unselect previous medias if exists 
             */
             global_media_viewer.find('.media-library-item-container').each(function() {
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
function library_media_item_selection(media, selection='select') {
    if(selection == 'select') {
        media.find('.selected').val('1');
        media.find('.media-library-media-selectbox').removeClass('none');
        media.addClass('media-library-item-selected');
    } else {
        media.find('.selected').val('0');
        media.find('.media-library-media-selectbox').addClass('none');
        media.removeClass('media-library-item-selected');
    }
}

/**
 * Handle opening image media settings
 */
function handle_open_media_image_settings(media) {
    media.on('click', function() {
        let global_media_viewer = $(this);
        while(!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

        let status = media.find('.selected').val();
        let selection_type = global_media_viewer.find('.selection-type').val();
        global_media_viewer.find('.media-library-settings-container').addClass('none');
        if(status == 1) {
            set_media_image_details_into_settings_section(global_media_viewer, media);
        } else {
            if(selection_type == 'multiple') {
                global_media_viewer.find('.media-library-item-container').each(function() {
                    if($(this).find('.selected').val() == 1) {
                        set_media_image_details_into_settings_section(global_media_viewer, $(this));
                        return false;
                    }
                });
            }
        }
    });
}

function set_media_image_details_into_settings_section(viewer, media) {
    let setting_container = viewer.find('.media-library-image-settings-container');
    
    // Set image
    setting_container.find('.library-media-image').attr('src', media.find('.media-library-item-image').attr('src'));
    setting_container.find('.library-media-image').attr('style', '');
    handle_image_center_based_on_higher_dim(setting_container.find('.library-media-image'));
    // Set informations
    setting_container.find('.image-name').text(media.find('.image-name').val()); // Image name text
    setting_container.find('.image-upload-date').text(media.find('.image-upload-date').val());
    setting_container.find('.image-size').text(media.find('.image-size').val());
    setting_container.find('.image-width').text(media.find('.image-width').val());
    setting_container.find('.image-height').text(media.find('.image-height').val());
    
    setting_container.find('.metadata-id').val(media.find('.metadata-id').val());
    setting_container.find('.image-alt').val(media.find('.image-alt').val());
    setting_container.find('.image-title').val(media.find('.image-name').val());
    setting_container.find('.image-caption').val(media.find('.image-caption').val());
    setting_container.find('.image-description').val(media.find('.image-description').val());
    setting_container.find('.image-link').val(media.find('.image-link').val());
    
    viewer.find('.media-library-image-settings-container').removeClass('none');
}

function show_upload_media_error(message) {
    let container = $('.media-upload-error-container');
    container.find('.message-text').html(message);
    container.removeClass('none');
    $('#upload-media').attr('disabled', false);
    $('#upload-media').val('');
}