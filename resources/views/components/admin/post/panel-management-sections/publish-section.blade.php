<div class="post-management-panel-section">
    <div class="align-center post-management-panel-section-header">
        <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M144.66,177.79c0-10.43.06-20.86,0-31.29-.08-10-6.08-16.64-14.83-16.51-8.51.12-14.4,6.65-14.43,16.35-.08,20.86,0,41.71,0,62.57,0,9.74-3.26,14.08-12.7,16.82q-34.59,10-69.22,19.85c-6.32,1.8-12.15,1-16.52-4.33s-4.29-11.07-1.32-17Q65.94,123.56,116.26,22.87c2.87-5.74,7.07-9.29,13.71-9.31s10.89,3.5,13.75,9.23Q194,123.46,244.37,224.09c3,5.95,3.1,11.74-1.16,17s-10.16,6.28-16.47,4.49q-35.46-10-70.87-20.23c-7.42-2.15-11.12-7.25-11.18-15.16C144.6,199.41,144.67,188.6,144.66,177.79Z"/></svg>
        <h2 class="dark fs12 no-margin">Publish Section</h2>
    </div>
    <div class="post-management-panel-section-content">

        @if($post)
            @php
                $scolor = $post->status == 'published' ? 'green' : 'light-gray';
            @endphp
            <p class="no-margin mb8 fs12 light-gray">Post's current status : <span class="bold {{ $scolor }}">{{ $post->status }}</span></p>
        @else
        
        @endif
        <div class="flex">
            <div class="typical-button-style white-bs align-center save-post-as-draft" style="padding: 5px 11px;">
                <div class="relative size14 mr4">
                    <svg class="size13 icon-above-spinner" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M58.55,251.39c-9.94,0-15.72-5.59-14.54-14.83,2.77-21.61,6-43.16,9.09-64.73.47-3.3,2.39-5.94,4.78-8.32q40.7-40.6,81.26-81.35c2.57-2.58,3.89-2.93,6.66-.13q33.54,33.93,67.46,67.48c2.68,2.66,2.69,4,0,6.66q-40.81,40.49-81.33,81.27c-3.74,3.76-8.24,4.81-13.18,5.5-18.75,2.6-37.48,5.38-56.22,8.08C61.12,251.22,59.69,251.29,58.55,251.39ZM246.34,89.65c-7.19-36.3-51.11-53.73-81.14-32.19-2,1.43-4.84,2.3-1.42,5.68q34.36,34,68.35,68.34c2.69,2.72,3.75,1.61,5.39-.68,6.47-9.06,9.79-19.13,10.1-32.08C247.74,96.86,247.05,93.25,246.34,89.65ZM142.6,34.57c8.12-.06,13.3-5.32,13.34-12.81s-5.25-13-13.16-13.07c-38.95-.12-77.9-.07-116.84-.06a12.77,12.77,0,0,0-12,7.09C9.22,24.6,15.6,34.48,26.37,34.58c19.37.18,38.74.05,58.11.05S123.23,34.74,142.6,34.57ZM102.41,87c8.81-.07,14.4-5.3,14.35-13.17-.06-7.69-5.36-12.76-14-12.79q-37.92-.16-75.83,0c-8.84,0-14.56,5.36-14.48,13.06s6,12.86,14.73,12.91c12.64.07,25.28,0,37.92,0C77.54,87,90,87.05,102.41,87ZM51.69,139.25c7.56-.53,12.85-5.92,13-12.81.18-7.06-5.31-13-13.09-13.33-8.73-.36-17.5-.36-26.23,0-7.64.32-12.8,5.78-12.94,12.77-.15,7.24,5.11,12.81,13,13.36,4.25.31,8.53.06,12.81.06C42.75,139.31,47.24,139.57,51.69,139.25Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs11 unselectable">save as draft</span>
            </div>
            <div class="typical-button-style white-bs align-center ml8 preview-post" style="padding: 5px 11px;">
                <div class="relative size14 mr4">
                    <svg class="size13 icon-above-spinner" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M122.25,202.87C82.73,201.11,48,180,27.42,136.91a16.18,16.18,0,0,1-.09-14.48A110.74,110.74,0,0,1,139.06,56.8c43.49,4.07,74.38,26.22,93.2,65.52a16.15,16.15,0,0,1,.09,14.48C214.46,177.33,175,202.86,122.25,202.87Zm8.19-115.11c-22.64-.57-41.77,18-42.44,41.13-.66,22.64,17.73,41.74,41,42.57,22.72.82,42.24-18.08,42.71-41.36C172.16,107.39,153.61,88.35,130.44,87.76Zm-21.39,41.52a20.79,20.79,0,1,0,21-20.45A20.57,20.57,0,0,0,109.05,129.28Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs11 unselectable">preview</span>
            </div>
        </div>
        @if($post)
        <div class="typical-button-style dark-bs full-center update-post mt8" style="padding: 8px 11px;">
            <div class="relative size14 mr4">
                <svg class="flex size12 icon-above-spinner" style="margin-top: 1px;" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold fs12 unselectable">Save changes</span>
        </div>
        @else
        <div class="typical-button-style dark-bs full-center create-post-button mt8" style="padding: 8px 11px;">
            <div class="relative size14 mr4">
                <svg class="flex size12 icon-above-spinner" style="margin-top: 1px;" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M144.66,177.79c0-10.43.06-20.86,0-31.29-.08-10-6.08-16.64-14.83-16.51-8.51.12-14.4,6.65-14.43,16.35-.08,20.86,0,41.71,0,62.57,0,9.74-3.26,14.08-12.7,16.82q-34.59,10-69.22,19.85c-6.32,1.8-12.15,1-16.52-4.33s-4.29-11.07-1.32-17Q65.94,123.56,116.26,22.87c2.87-5.74,7.07-9.29,13.71-9.31s10.89,3.5,13.75,9.23Q194,123.46,244.37,224.09c3,5.95,3.1,11.74-1.16,17s-10.16,6.28-16.47,4.49q-35.46-10-70.87-20.23c-7.42-2.15-11.12-7.25-11.18-15.16C144.6,199.41,144.67,188.6,144.66,177.79Z"/></svg>
                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold fs12 unselectable">Create Post</span>
        </div>
        @endif
    </div>
</div>