
$('.open-featured-image-selection-viewer').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
});

$('.remove-featured-image').on('click', function () {

});

$('.update-featured-image').on('click', function () {
    $('#set-featured-image-viewer').removeClass('none');
    $('#set-featured-image-viewer').find('.open-medias-library-section').trigger('click');
});

$('.open-medias-upload-files-section').on('click', function () {
    $('.medias-upload-files-section').removeClass('none');
    $('.media-library-section').addClass('none');
});

let medias_library_opened = false;
let medias_library_opening_lock = true;
$('.open-medias-library-section').on('click', function () {
    $('.medias-upload-files-section').addClass('none');
    $('.media-library-section').removeClass('none');

    let global_media_viewer = $(this);
    while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

    if (!medias_library_opened) {
        if (!medias_library_opening_lock) return;
        medias_library_opening_lock = false;
        global_media_viewer.find('.media-library-media-loading-container .spinner').addClass('inf-rotate');

        $.ajax({
            url: '/admin/media/fetch?skip=0&take=20&form=component',
            success: function (response) {
                medias_library_opened = true;
                global_media_viewer.find('.media-library-media-loading-container').remove();
                if (response.count == 0) {
                    global_media_viewer.find('.media-library-no-media-found-container').removeClass('none');
                } else {
                    let media_container = global_media_viewer.find('.media-library-media-container');
                    let media_items_container = global_media_viewer.find('.media-library-items-container');
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
                if (errorObject.errors) {
                    let errors = errorObject.errors;
                    error = errors[Object.keys(errors)[0]][0];
                }
                show_upload_media_error(error);
            },
            complete: function () {
                medias_library_opening_lock = true;
            }
        })
    }
});

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
    if (files.length > maximum_number_of_uploads) {
        show_upload_media_error('The maximum number of files upload is ' + maximum_number_of_uploads + ' files at a time.');
        return;
    }

    for (let i = 0; (i < files.length && i < maximum_number_of_uploads); i++) {
        // .2
        let filesize = files[i].size / (1024 * 1024);
        if (filesize > 5) {
            show_upload_media_error('<strong>' + files[i].name + '</strong> file size exceeds the maximum size allowed per file (>5 MB max)');
            return;
        }
        /**
         * 3.
         *   3.1. validate image
         *   3.2. if it is not image then we validate video
         */
        if (get_file_type(files[i]) != 'image') {
            if (get_file_type(files[i]) != 'video') {
                show_upload_media_error('<strong>' + files[i].name + '</strong> file format is not supported. only images & videos are supported at the moment');
                return;
            }
        }

        validated_medias.push(files[i]);
    }
    input.val(''); // Empty the input after validation

    if (validated_medias.length > 0) {
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
                let global_media_viewer = input;
                while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

                global_media_viewer.find('.open-medias-library-section').trigger('click');
                global_media_viewer.find('.media-library-no-media-found-container').addClass('none');
                if (medias_library_opened) {
                    let bring_media_loading_viewer = global_media_viewer.find('.media-library-bringing-uploaded-media-container');
                    bring_media_loading_viewer.find('.spinner').addClass('inf-rotate');
                    bring_media_loading_viewer.removeClass('none');

                    $.ajax({
                        url: '/admin/media/set/components',
                        data: {
                            metadata_ids: response.metadata_ids,
                        },
                        success: function (response) {
                            global_media_viewer.find('.media-library-items-container').prepend(response.payload);
                            // Handling events
                            global_media_viewer.find('.media-library-item-container').slice(0, response.count).each(function () {
                                handle_library_media_event($(this));
                            });

                            bring_media_loading_viewer.find('.spinner').removeClass('inf-rotate');
                            bring_media_loading_viewer.addClass('none');
                        },
                        error: function (response) {

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
                if (errorObject.errors) {
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
function handle_library_media_selection(media) {
    media.on('click', function () {
        let global_media_viewer = $(this);
        while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();
        let selection_type = global_media_viewer.find('.selection-type').val();
        let selected = $(this).find('.selected').val();

        if (selection_type == 'single') {
            /**
             * If selection type is single, we need to unselect previous medias if exists 
             */
            global_media_viewer.find('.media-library-item-container').each(function () {
                library_media_item_selection($(this), 'unselect');
            });

            if (selected == 1) {
                global_media_viewer.find('.media-viewer-taget-action-button').addClass('dark-bs-disabled prevent-action');
            }
        }

        if (selected == 0) {
            library_media_item_selection($(this), 'select');
            global_media_viewer.find('.media-viewer-taget-action-button').removeClass('dark-bs-disabled prevent-action');
        } else {
            library_media_item_selection($(this), 'unselect');
        }
    });
}
function library_media_item_selection(media, selection = 'select') {
    if (selection == 'select') {
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
    handle_image_center_based_on_higher_dim(media.find('.media-library-item-image'));
    handle_open_media_image_settings(media);
}

/**
 * Handle library media - image management
 */
function handle_open_media_image_settings(media) {
    media.on('click', function () {
        let global_media_viewer = $(this);
        while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

        let status = media.find('.selected').val();
        let selection_type = global_media_viewer.find('.selection-type').val();
        global_media_viewer.find('.media-library-settings-container').addClass('none');
        if (status == 1) {
            set_media_image_details_into_settings_section(global_media_viewer, media);
        } else {
            if (selection_type == 'multiple') {
                global_media_viewer.find('.media-library-item-container').each(function () {
                    if ($(this).find('.selected').val() == 1) {
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

    viewer.find('.media-library-image-settings-container').removeClass('none');
}
$('.restore-media-image-settings').on('click', function () {
    let mid = $(this).find('.metadata-id').val();
    let global_media_viewer = $(this);
    while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

    let media;
    global_media_viewer.find('.media-library-items-container .media-library-item-container').each(function () {
        if ($(this).find('.metadata-id').val() == mid) {
            media = $(this);
            return false;
        }
    });
    if (media) {
        set_media_image_details_into_settings_section(global_media_viewer, media);
        left_bottom_notification('Image settings get restored');
    }
});

let save_media_metadata = true;
$('.save-media-metadata').on('click', function () {
    if (!save_media_metadata) return;
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
            sync_media_metadata_to_new_settings_change(metadata_id, setting_box, setting_box); // Read function prototype
        },
        error: function (response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
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
 * Element parameter here is used to get the global viewer container by going backward to parents; It must be 
 * included within the global media viewer.
 * 
 * After we fetch the global viewer, we start searching for the media container in media items box;
 * Once we get it, we need to make its metadata in sync with the saved settings metadata
 */
function sync_media_metadata_to_new_settings_change(metadata_id, element, setting_box) {
    let global_media_viewer = element;
    while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();

    let media;
    global_media_viewer.find('.media-library-item-container').each(function () {
        if ($(this).find('.metadata-id').val() == metadata_id) {
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
});
let delete_media_item_lock = true;
$('.delete-media-item').on('click', function () {
    if (!delete_media_item_lock) return;
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
            $('.media-library-settings-container').addClass('none');
            $('.media-library-item-container').each(function () {
                if ($(this).find('.metadata-id').val() == metadata_id) {
                    $(this).remove();
                    return false;
                }
            });
            $('.media-library-media-part').each(function () {
                if (!$(this).find('.media-library-items-container .media-library-item-container').length) {
                    $(this).find('.media-library-items-container').addClass('none');
                    $(this).find('.media-library-no-media-found-container').removeClass('none');
                }
            });

            print_top_message('media Has been deleted successfully.', 'green');
        },
        error: function (response) {
            let errorObject = JSON.parse(response.responseText);
            let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
            if (errorObject.errors) {
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
let set_featured_image_lock = true;
$('.set-featured-image').on('click', function () {
    if (!set_featured_image_lock || $(this).hasClass('prevent-action')) return;
    set_featured_image_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');
    let global_media_viewer = button;
    while (!global_media_viewer.hasClass('media-viewer')) global_media_viewer = global_media_viewer.parent();
    let selected_media;
    global_media_viewer.find('.media-library-item-container').each(function () {
        if ($(this).find('.selected').val() == 1) {
            selected_media = $(this);
        }
    });

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    // $.ajax({
    //     type:
    // });

    $('.selected-featured-image').attr('src', selected_media.find('.media-library-item-image').attr('src'));
    handle_image_center_by_filling_parent($('.selected-featured-image'));
    $('.featured-image-upload-box').addClass("none");
    $('.uploaded-featured-image-box').removeClass("none");
    global_media_viewer.find('.close-global-viewer').trigger('click');

    button.removeClass('dark-bs-disabled');
    buttonicon.removeClass('none');
    spinner.addClass('opacity0');
    spinner.removeClass('inf-rotate');
    set_featured_image_lock = true;
});

let publish_post_lock = true;
$('.publish-post').on('click', function () {
    if (!publish_post_lock) return;
    publish_post_lock = false;

    let title = $('#post-title').val();
    let meta_title = $('#post-meta-title').val();
    let slug = $('#post-slug').val();
    let content = $('#post-content').val();

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');
});


function show_upload_media_error(message) {
    let container = $('.media-upload-error-container');
    container.find('.message-text').html(message);
    container.removeClass('none');
    $('#upload-media').attr('disabled', false);
    $('#upload-media').val('');
}