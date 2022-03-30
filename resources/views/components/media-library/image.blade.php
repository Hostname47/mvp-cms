<div class="media-library-item-container media-library-open-image-settings">
    <div class="full-center full-dimensions overflow-hidden">
        <img src="{{ asset($metadata->filepath) }}" class="media-library-item-image" alt="">
    </div>
    <div class="media-library-media-selectbox full-center none">
        <svg class="selected-icon size14" fill="#232a35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
        <svg class="unselect-icon size14 none" fill="#232a35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M245.66,99.54H123.13c.18,9.79-.28,26.54-.28,28.46,0,2.18-.4,24.28-.41,32.47h124.2c6.92,0,9-2.1,9-9.12q0-20.85,0-41.7C255.63,101.31,253.89,99.54,245.66,99.54Z"/><path d="M14.82,99.53H137.35c-.17,9.79.28,26.54.28,28.46,0,2.18.41,24.28.42,32.47H13.84c-6.92,0-9-2.1-9-9.12q0-20.85,0-41.7C4.86,101.29,6.6,99.53,14.82,99.53Z"/></svg>
    </div>
    <!-- file details -->
    <input type="hidden" class="selected" value="0" autocomplete="off">
    <input type="hidden" class="metadata-id" value="{{ $metadata->id }}" autocomplete="off">
    <input type="hidden" class="name" value="{{ $metadata->data['file'] }}" autocomplete="off">
    <input type="hidden" class="size" value="{{ $metadata->human_size }}" autocomplete="off">
    <input type="hidden" class="width" value="{{ $metadata->data['width'] }}" autocomplete="off">
    <input type="hidden" class="height" value="{{ $metadata->data['height'] }}" autocomplete="off">
    <input type="hidden" class="upload-date" value="{{ $metadata->human_upload_date }}" autocomplete="off">

    <input type="hidden" class="alt" value="{{ isset($metadata->data['alt']) ? $metadata->data['alt'] : '' }}" autocomplete="off">
    <input type="hidden" class="title" value="{{ isset($metadata->data['title']) ? $metadata->data['title'] : '' }}" autocomplete="off">
    <input type="hidden" class="caption" value="{{ isset($metadata->data['caption']) ? $metadata->data['caption'] : '' }}" autocomplete="off">
    <input type="hidden" class="description" value="{{ isset($metadata->data['description']) ? $metadata->data['description'] : '' }}" autocomplete="off">
    <input type="hidden" class="link" value="{{  asset($metadata->filepath) }}" autocomplete="off">

</div>