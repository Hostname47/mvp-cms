<div class="post-management-panel-section toggle-box">
    @php
        $has_thumbnail = $post && $post->has_thumbnail();
    @endphp
    <input type="hidden" id="post-thumbnail-image-metadata-id" autocomplete="off" @if($has_thumbnail) value="{{ $post->thumbnail->id }}" @endif>
    <div class="align-center post-management-panel-section-header pointer toggle-button">
        <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,53.73V205.58c-.3.36-.74.67-.87,1.07C247.5,230.37,232,241.8,207.16,241.8H126.38c-25.62,0-51.24.19-76.86-.07C25.24,241.49,5.21,222,5.07,198.05q-.39-68,0-136.1C5.24,38.67,25,18.77,48.29,18.64c55.16-.32,110.32-.16,165.48,0,9.39,0,17.8,3.42,25.32,9.08C247.9,34.3,252.73,43.43,255.79,53.73ZM130.48,217.38h78.86c13.59,0,20.89-7.18,20.9-20.72q0-65.88,0-131.77c0-12.57-8.28-20.82-20.87-20.83q-79.11,0-158.21,0c-12.65,0-20.78,8.16-20.79,20.81q0,65.88,0,131.76c0,12.75,8,20.73,20.76,20.74Q90.81,217.4,130.48,217.38ZM186.8,196c12,.49,18.25-10.89,13.66-21.05-8.78-19.41-16.89-39.13-25.19-58.75-2.18-5.16-5.34-9-11.24-9.59-6.35-.68-10.86,2.12-14.3,7.4q-7.17,11.09-14.86,21.83c-5.45,7.62-14.89,7.95-20.86.94-1.59-1.86-3-3.84-4.57-5.74-7.45-9.27-17-8.85-23.5,1.18C77,146.08,68.33,160,59.44,173.89c-3.15,4.91-4.09,10-1.36,15.25,2.83,5.41,7.86,6.76,13.64,6.72,19.27-.1,38.53,0,57.79,0C148.61,195.82,167.73,195.26,186.8,196ZM208.66,81c0-10-9.18-19.16-19.11-19.12a19,19,0,0,0-.08,38C199.6,100,208.63,91.07,208.66,81Z"/></svg>
        <h2 class="dark fs12 no-margin">Thumbnail image</h2>
        <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
            <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
        </svg>
    </div>
    <div class="post-management-panel-section-content toggle-container none">
        <div class="thumbnail-image-box">
            <div class="thumbnail-image-upload-box open-thumbnail-image-selection-viewer @if($has_thumbnail) none @endif">
                <span class="bold dark">Set thumbnail image</span>
            </div>
            <div class="uploaded-thumbnail-image-box @if(!$has_thumbnail) none @endif">
                <div class="selected-thumbnail-image-container full-center overflow-hidden">
                    <img src="@if($has_thumbnail){{ $post->thumbnail_image }}@endif" class="selected-thumbnail-image open-image-on-image-viewer fill-and-center-image-on-parent pointer" alt="">
                </div>
                <div class="mt8 flex flex-column">
                    <div class="typical-button-style white-bs align-center update-thumbnail-image" style="padding: 7px 11px; width: max-content;">
                        <span class="bold fs11 unselectable">Update thumbnail image</span>
                    </div>
                    <span class="red mt8 fs12 bold pointer remove-thumbnail-image" style="padding: 0 11px;">Remove thumbnail image</span>
                </div>
            </div>
        </div>
    </div>
</div>