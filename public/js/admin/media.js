$('.open-media-upload-files-section').on('click', function () {
    let gmbox = global_media_box($(this)); // gmbox: global media box
    gmbox.find('.media-upload-files-section').removeClass('none');
    gmbox.find('.media-library-section').addClass('none');
});

let media_library_opened = false;
let media_library_opening_lock = true;
$('.open-media-library-section').on('click', function () {
    let gmbox = global_media_box($(this)); // gmbox: global media box
    gmbox.find('.media-upload-files-section').addClass('none');
    gmbox.find('.media-library-section').removeClass('none');

    /**
     * If the media library section is not opened yet then we need to take several actions
     * (demonstrated below)
     */
    if(!media_library_opened) {
        if(!media_library_opening_lock) return;
        media_library_opening_lock = false;
        /**
         * The media loading section is by default opened in case the user open the library
         * we just have to start rotating the spinner and fetch the medias
         */
        gmbox.find('.media-library-media-loading-container .spinner').addClass('inf-rotate');

        $.ajax({
            url: '/admin/media/fetch?skip=0&take=20&form=component',
            success: function (response) {
                media_library_opened = true;
                /**
                 * Once we get the media (or get nothing in case the library is empty), we need to
                 * remove the loading section because loading container is used only for bootstrap the
                 * first media chunk fetch
                 * In case of uploading more media after opening the library is done in other container
                 * called : media-library-bringing-uploaded-media-container
                 */
                gmbox.find('.media-library-media-loading-container').remove();

                /**
                 * If the library is empty we display no items found with an upload button
                 * in a container : called media-library-no-media-found-container
                 */
                if(response.count == 0)
                    gmbox.find('.media-library-no-media-found-container').removeClass('none');
                else {
                    /**
                     * If the library has media, then we do the following actions:
                     *  1. Remove none from media container inside library section to display the result
                     *  2. Then take the components payload from request and put it to media items container
                     *  3. Then we loop through madias and handle their events
                     */
                    let media_container = gmbox.find('.media-library-media-container');
                    let media_items_container = gmbox.find('.media-library-items-container');
                    media_container.removeClass('none');
                    media_items_container.html(response.payload);
                    // Handling events
                    media_container.find('.media-library-item-container').each(function () {
                        handle_library_media_event($(this));
                    });
                }
            },
            error: function (response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
            },
            complete: function () {
                media_library_opening_lock = true;
            }
        })
    }
});

let supported_media_format = ['image', 'video']
$('.upload-media-to-library').on('change', function () {
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
        show_upload_media_error(input, 'The maximum number of files upload is ' + maximum_number_of_uploads + ' files at a time.');
        return;
    }

    for (let i = 0; (i < files.length && i < maximum_number_of_uploads); i++) {
        // .2
        let filesize = files[i].size / (1024 * 1024);
        if(filesize > 5) {
            show_upload_media_error(input, '<strong>' + files[i].name + '</strong> file size exceeds the maximum size allowed per file (>5 MB max)');
            return;
        }
        /**
         * 3.
         *   3.1. validate image
         *   3.2. if it is not image then we validate video
         */
        if(!supported_media_format.includes(get_file_type(files[i]))) {
            show_upload_media_error(input, '<strong>' + files[i].name + '</strong> file format is not supported. only images & videos are supported at the moment');
            return;
        }

        validated_medias.push(files[i]);
    }
    input.val(''); // Empty the input after validation

    if(validated_medias.length > 0) {
        let spinner = input.parent().find('.spinner');
        spinner.addClass('inf-rotate');
        spinner.removeClass('none');

        let media = new FormData();
        for (let i = 0; i < validated_medias.length; i++) {
            media.append('files[]', validated_medias[i]);
        }

        $.ajax({
            type: 'post',
            url: '/admin/media-library/upload',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: media,
            success: function (response) {
                let gmbox = global_media_box(input); // global media box

                /**
                 * If the media library is not already opened, then the following click event
                 * trigger will take care of bringing media components and put them into the 
                 * media container
                 * If the media library was already opened, then we should take some extra steps (next if statement)
                 */
                gmbox.find('.open-media-library-section').trigger('click');
                // Hide no media found container if it is already there
                gmbox.find('.media-library-no-media-found-container').addClass('none');
                // Display media library container if it is hidden
                gmbox.find('.media-library-media-container').removeClass('none');
                gmbox.find('.media-library-items-container').removeClass('none');

                if(media_library_opened) {
                    /**
                     * Display uploaded media bringing container and rotate its spinner
                     */
                    let bring_media_loading_viewer = gmbox.find('.media-library-bringing-uploaded-media-container');
                    bring_media_loading_viewer.find('.spinner').addClass('inf-rotate');
                    bring_media_loading_viewer.removeClass('none');

                    /**
                     * Then we issue a request to get those uploaded media in form of components and then prepend
                     * them to the media container
                     */
                    $.ajax({
                        url: '/admin/media/set/components',
                        data: {
                            metadata_ids: response.metadata_ids,
                        },
                        success: function (response) {
                            gmbox.find('.media-library-items-container').prepend(response.payload);
                            // Handling events
                            gmbox.find('.media-library-item-container').slice(0, response.count).each(function () {
                                handle_library_media_event($(this));
                            });

                            bring_media_loading_viewer.find('.spinner').removeClass('inf-rotate');
                            bring_media_loading_viewer.addClass('none');
                        },
                        error: function (response) {
                            let errorObject = JSON.parse(response.responseText);
                            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                            if(errorObject.errors) {
                                let errors = errorObject.errors;
                                error = errors[Object.keys(errors)[0]][0];
                            }
                            print_top_message(error, 'error');
                        }
                    })
                }
            },
            complete: function (response) {
                input.attr('disabled', false);
                spinner.removeClass('inf-rotate');
                spinner.addClass('none');
            },
            error: function (response) {
                let errorObject = JSON.parse(response.responseText);
                let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
                if(errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                print_top_message(error, 'error');
            },
        })
    }
});

function media_selection_tick_effect(media) {
    media.find('.media-library-media-selectbox').on({
        mouseenter: function () {
            $(this).find('.selected-icon').addClass('none');
            $(this).find('.unselect-icon').removeClass('none');
        },
        mouseleave: function () {
            $(this).find('.selected-icon').removeClass('none');
            $(this).find('.unselect-icon').addClass('none');
        }
    });
}

/**
 * Array of metadata ids selected from media library
 */
let selected_media = [];
function handle_library_media_selection(media) {
    media.on('click', function () {
        let gmbox = global_media_box($(this)); // global media box
        let selection_type = gmbox.find('.selection-type').val();
        let selected = $(this).find('.selected').val();
        let targetbutton = gmbox.find('.media-viewer-target-action-button');

        if(selection_type == 'single') {
            /**
             * If selection type is single, we need to unselect previous medias if exists
             * and remove all selected medias from selected media array
             */
            gmbox.find('.media-library-item-container').each(function () {
                library_media_item_selection($(this), 'unselect');
            });
            selected_media = [];

            if(selected == 1)
                targetbutton.addClass('dark-bs-disabled prevent-action');            
            else {
                targetbutton.removeClass('dark-bs-disabled prevent-action');
                library_media_item_selection($(this), 'select');
                insert_to_selected_media($(this).find('.metadata-id').val());
            }
        } else {
            let selected_count = 0;
            gmbox.find('.media-library-item-container').each(function () {
                if($(this).find('.selected').val() == 1)
                    selected_count++;
            });

            if(selected == 1) { // If the media is already selected (means admin is going to unselect it)
                library_media_item_selection($(this), 'unselect');
                remove_from_selected_media($(this).find('.metadata-id').val())
                if(selected_count == 1) // If the unselected one is the only one selected
                    targetbutton.addClass('dark-bs-disabled prevent-action');
            } else {
                library_media_item_selection($(this), 'select');
                insert_to_selected_media($(this).find('.metadata-id').val());
                targetbutton.removeClass('dark-bs-disabled prevent-action');
            }
        }
    });
}
function insert_to_selected_media(metadata_id) {
    selected_media.indexOf(metadata_id) === -1 ? selected_media.push(metadata_id) : '';
}
function remove_from_selected_media(metadata_id) {
    for(let i = 0; i < selected_media.length; i++) {
        if(selected_media[i] == metadata_id) { 
            selected_media.splice(i, 1);
            break;
        }
    }
}
function library_media_item_selection(media, selection = 'select') {
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
function handle_library_media_event(media) {
    handle_library_media_selection(media); // Just UI selection
    media_selection_tick_effect(media); // Handle hover event on selection tick
    /**
     * Case media is an image
     */
    handle_image_center_fill(media.find('.media-library-item-image'));
    handle_open_media_image_settings(media);
}

/**
 * Handle library media - image
 */
function handle_open_media_image_settings(media) {
    media.on('click', function () {
        let gmbox = global_media_box($(this)); // global media box
        let status = media.find('.selected').val();
        let selection_type = gmbox.find('.selection-type').val();
        gmbox.find('.media-library-settings-container').addClass('none');
        /**
         * If admin select an image, we set its settings to image settings section
         * In the other hand if the admin unselect it, we need to check if there are other
         * medias already selected (in case of multiple selection) and set the first selected media
         */
        if(status == 1)
            set_media_image_details_into_settings_section(gmbox, media);
        else
            if(selection_type == 'multiple')
                gmbox.find('.media-library-item-container').each(function () {
                    if($(this).find('.selected').val() == 1) {
                        set_media_image_details_into_settings_section(gmbox, $(this));
                        return false;
                    }
                });
    });
}
function set_media_image_details_into_settings_section(viewer, media) {
    let setting_container = viewer.find('.media-library-image-settings-container');
    // Set image
    setting_container.find('.library-media-image').attr('src', media.find('.media-library-item-image').attr('src'));
    setting_container.find('.library-media-image').attr('style', '');
    handle_image_center_based_on_higher_dim(setting_container.find('.library-media-image'));
    // Set informations
    setting_container.find('.name').text(media.find('.name').val());
    setting_container.find('.upload-date').text(media.find('.upload-date').val());
    setting_container.find('.size').text(media.find('.size').val());
    setting_container.find('.width').text(media.find('.width').val());
    setting_container.find('.height').text(media.find('.height').val());

    setting_container.find('.metadata-id').val(media.find('.metadata-id').val());
    setting_container.find('.alt').val(media.find('.alt').val());
    setting_container.find('.title').val(media.find('.title').val());
    setting_container.find('.caption').val(media.find('.caption').val());
    setting_container.find('.description').val(media.find('.description').val());
    setting_container.find('.link').val(media.find('.link').val());

    // First close all other media types settings sections
    viewer.find('.media-library-settings-container').addClass('none');
    // Then we open image settings section
    viewer.find('.media-library-image-settings-container').removeClass('none');
}

$('.restore-media-image-settings').on('click', function () {
    let metadata_id = $(this).find('.metadata-id').val();
    let gmbox = global_media_box($(this)); // global media box

    let media;
    gmbox.find('.media-library-items-container .media-library-item-container').each(function () {
        if($(this).find('.metadata-id').val() == metadata_id) {
            media = $(this);
            return false;
        }
    });
    if(media) {
        set_media_image_details_into_settings_section(gmbox, media);
        left_bottom_notification('Image settings get restored with defaults');
    }
});

let save_media_metadata = true;
$('.save-media-metadata').on('click', function () {
    if(!save_media_metadata) return;
    save_media_metadata = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    let setting_box = $(this);
    while (!setting_box.hasClass('media-library-settings-container')) setting_box = setting_box.parent();

    let metadata_id = setting_box.find('.metadata-id').val();
    let keys = [];
    let values = [];
    setting_box.find('.metadata').each(function () {
        keys.push($(this).attr('name'));
        values.push($(this).val());
    });

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'patch',
        url: '/admin/media/metadata',
        data: {
            metadata_id: metadata_id,
            keys: keys,
            values, values
        },
        success: function (response) {
            print_top_message('File metadata has been updated successfully', 'green');
            sync_media_metadata_to_new_settings_change(metadata_id, setting_box); // Read function prototype
        },
        error: function (response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');
        },
        complete: function () {
            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            save_media_metadata = true;
        }
    })
});
/**
 * Here, we get the global viewer, aand then we start searching for the media container in media items box;
 * Once we get it, we need to make its metadata in sync with the saved settings metadata
 */
function sync_media_metadata_to_new_settings_change(metadata_id, setting_box) {
    let gmbox = global_media_box(setting_box); // global media box

    let media;
    gmbox.find('.media-library-item-container').each(function () {
        if($(this).find('.metadata-id').val() == metadata_id) {
            media = $(this);
            return false;
        }
    });

    setting_box.find('.metadata').each(function () {
        media.find('.' + $(this).attr('name')).val($(this).val());
    });
}

$('.open-media-delete-viewer').on('click', function () {
    $('#delete-media-viewer').find('.metadata-id').val($(this).find('.metadata-id').val());
    $('#delete-media-viewer').removeClass('none');
    /**
     * Important:
     * Here after we open the delete viewer, we have to specified the source from where we
     * want to delete the media; We pass get the global vieer from the opening button and past it to
     * delete_media_from variable so that after deleting the media we go back to it and then delete
     * the component of media deleted from it. ;)
     */
    delete_media_from_viewer = global_media_box($(this));
});

let delete_media_from_viewer;
let delete_media_item_lock = true;
$('.delete-media-item').on('click', function () {
    if(!delete_media_item_lock) return;
    delete_media_item_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let metadata_id = button.find('.metadata-id').val();

    button.addClass('red-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    $.ajax({
        type: 'delete',
        url: '/admin/media',
        data: { metadata_id: metadata_id },
        success: function (response) {
            $('#delete-media-viewer').find('.close-global-viewer').trigger('click');
            delete_media_from_viewer.find('.media-library-settings-container').addClass('none');
            delete_media_from_viewer.find('.media-library-item-container').each(function () {
                if($(this).find('.metadata-id').val() == metadata_id) {
                    $(this).remove();
                    return false;
                }
            });
            /**
             * If the deleted media item is the only media there, then we need to display not media
             * found with upload button section and hide media items container
             */
            delete_media_from_viewer.find('.media-library-media-part').each(function () {
                if(!$(this).find('.media-library-items-container .media-library-item-container').length) {
                    $(this).find('.media-library-items-container').addClass('none');
                    $(this).find('.media-library-no-media-found-container').removeClass('none');
                }
            });

            print_top_message('Media has been deleted successfully.', 'green');
        },
        error: function (response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if(errorObject.errors) {
                let errors = errorObject.errors;
                error = errors[Object.keys(errors)[0]][0];
            }
            print_top_message(error, 'error');
        },
        complete: function (response) {
            delete_media_item_lock = true;

            button.removeClass('red-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');
        }
    });
});

function show_upload_media_error(input, message) {
    let container = upload_media_box(input).find('.media-upload-error-container');
    container.find('.message-text').html(message);
    container.removeClass('none');
    $('#upload-media').attr('disabled', false);
    $('#upload-media').val('');
}
function global_media_box(element) {
    let box = element;
    while(!box.hasClass('media-viewer')) box = box.parent();
    return box;
}
function upload_media_box(input) {
    let box = input;
    while(!box.hasClass('media-upload-files-container')) box = box.parent();
    console.log(box);
    return box;
}