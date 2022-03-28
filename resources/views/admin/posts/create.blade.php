@extends('layouts.admin')

@section('title', 'Admin - create post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.create.new.post'])
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/simplemde.js') }}" defer></script>
<script type="module" src="{{ asset('js/admin/post/create.js') }}" defer></script>
<script type="module" src="{{ asset('js/admin/post/manage.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/create.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- media feature -->
<div id="set-featured-image-viewer" class="global-viewer full-center">
    <div class="featured-image-viewer-box">
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 15px 20px;">
            <div class="flex align-center">
                <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,53.73V205.58c-.3.36-.74.67-.87,1.07C247.5,230.37,232,241.8,207.16,241.8H126.38c-25.62,0-51.24.19-76.86-.07C25.24,241.49,5.21,222,5.07,198.05q-.39-68,0-136.1C5.24,38.67,25,18.77,48.29,18.64c55.16-.32,110.32-.16,165.48,0,9.39,0,17.8,3.42,25.32,9.08C247.9,34.3,252.73,43.43,255.79,53.73ZM130.48,217.38h78.86c13.59,0,20.89-7.18,20.9-20.72q0-65.88,0-131.77c0-12.57-8.28-20.82-20.87-20.83q-79.11,0-158.21,0c-12.65,0-20.78,8.16-20.79,20.81q0,65.88,0,131.76c0,12.75,8,20.73,20.76,20.74Q90.81,217.4,130.48,217.38ZM186.8,196c12,.49,18.25-10.89,13.66-21.05-8.78-19.41-16.89-39.13-25.19-58.75-2.18-5.16-5.34-9-11.24-9.59-6.35-.68-10.86,2.12-14.3,7.4q-7.17,11.09-14.86,21.83c-5.45,7.62-14.89,7.95-20.86.94-1.59-1.86-3-3.84-4.57-5.74-7.45-9.27-17-8.85-23.5,1.18C77,146.08,68.33,160,59.44,173.89c-3.15,4.91-4.09,10-1.36,15.25,2.83,5.41,7.86,6.76,13.64,6.72,19.27-.1,38.53,0,57.79,0C148.61,195.82,167.73,195.26,186.8,196ZM208.66,81c0-10-9.18-19.16-19.11-19.12a19,19,0,0,0-.08,38C199.6,100,208.63,91.07,208.66,81Z"/></svg>
                <span class="fs20 bold dark">Featured image</span>
            </div>
            <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div id="featured-image-viewer-content-box" class="flex flex-column">
            <!-- top meny to choose upload or galery medias selection -->
            <div class="menu-buttons-style-1-wrapper px8 mt8">
                <div class="menu-toggle-button menu-button-style-1 menu-button-style-1-selected open-medias-upload-files-section">
                    <span>Upload medias</span>
                    <div class="selection-strip menu-button-style-1-selected-strip"></div>
                </div>
                <div class="menu-toggle-button menu-button-style-1 open-medias-library-section">
                    <span>Medias library</span>
                    <div class="selection-strip menu-button-style-1-selected-strip none"></div>
                </div>
            </div>
            <div class="full-dimensions flex flex-column">
                <!-- upload files -->
                <div class="full-height full-center flex-column medias-upload-files-section">
                    <label for="upload-media" class="fs18 dark flex">Upload files</label>
                    <div class="relative button-style-1 overflow-hidden align-center" style="margin: 12px 0;">
                        <input type="file" title="" multiple="multiple" id="upload-media" class="upload-media hide-file-input-style">
                        <svg class="spinner size15 mr8 none" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="fs14 dark">Select Files</span>
                    </div>
                    <p class="fs13 no-margin light-gray">Maximum upload file size is : 5 MB</p>
                    <div class="flex">
                        <div class="informative-message-container media-upload-error-container flex align-center relative my8 none">
                            <div class="informative-message-container-left-stripe imcls-red"></div>
                            <p class="no-margin fs13 message-text">The format of the uploaded file is not supported.</p>
                            <div class="close-parent close-informative-message-style">✖</div>
                        </div>
                    </div>
                </div>
                <!-- medias library section -->
                <div class="media-library-section none">
                    <h3>Media library</h3>
                </div>

                <!-- bottom strip -->
                <div class="media-viewer-bottom-section">
                    <div class="typical-button-style dark-bs dark-bs-disabled align-center move-to-right set-featured-image" style="padding: 6px 12px;">
                        <div class="relative size14 mr4">
                            <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M58.55,251.39c-9.94,0-15.72-5.59-14.54-14.83,2.77-21.61,6-43.16,9.09-64.73.47-3.3,2.39-5.94,4.78-8.32q40.7-40.6,81.26-81.35c2.57-2.58,3.89-2.93,6.66-.13q33.54,33.93,67.46,67.48c2.68,2.66,2.69,4,0,6.66q-40.81,40.49-81.33,81.27c-3.74,3.76-8.24,4.81-13.18,5.5-18.75,2.6-37.48,5.38-56.22,8.08C61.12,251.22,59.69,251.29,58.55,251.39ZM246.34,89.65c-7.19-36.3-51.11-53.73-81.14-32.19-2,1.43-4.84,2.3-1.42,5.68q34.36,34,68.35,68.34c2.69,2.72,3.75,1.61,5.39-.68,6.47-9.06,9.79-19.13,10.1-32.08C247.74,96.86,247.05,93.25,246.34,89.65ZM142.6,34.57c8.12-.06,13.3-5.32,13.34-12.81s-5.25-13-13.16-13.07c-38.95-.12-77.9-.07-116.84-.06a12.77,12.77,0,0,0-12,7.09C9.22,24.6,15.6,34.48,26.37,34.58c19.37.18,38.74.05,58.11.05S123.23,34.74,142.6,34.57ZM102.41,87c8.81-.07,14.4-5.3,14.35-13.17-.06-7.69-5.36-12.76-14-12.79q-37.92-.16-75.83,0c-8.84,0-14.56,5.36-14.48,13.06s6,12.86,14.73,12.91c12.64.07,25.28,0,37.92,0C77.54,87,90,87.05,102.41,87ZM51.69,139.25c7.56-.53,12.85-5.92,13-12.81.18-7.06-5.31-13-13.09-13.33-8.73-.36-17.5-.36-26.23,0-7.64.32-12.8,5.78-12.94,12.77-.15,7.24,5.11,12.81,13,13.36,4.25.31,8.53.06,12.81.06C42.75,139.31,47.24,139.57,51.69,139.25Z"/></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12 unselectable">Set featured image</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"/></svg>
            <h1 class="fs20 dark no-margin">Create new post</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span class="fs13 bold">{{ __('Home') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Create new post') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box full-height">
        <div>
            <div>
                <div class="align-center">
                    <label class="input-label dark fs14" for="post-title">Post Title</label>
                    <span class="fs8 bold light-gray unselectable mx8">●</span>
                    <div id="toggle-meta-and-slug" class="align-center pointer">
                        <span class="blue fs12 bold unselectable">meta & slug</span>
                        <svg class="toggle-arrow size6 ml4" fill="#2cb2ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                            <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                        </svg>
                    </div>
                </div>
                <p class="fs12 my2 light-gray no-margin">Meta title and slug will be cloned to match the exact title. (you can edit them)</p>
            </div>
            <input type="text" id="post-title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter post title here") }}'>
        </div>
        <div id="meta-and-slug-section" class="typical-section-style mt4 none">
            <p class="fs12 mb2 light-gray no-margin">Meta title and slug are useful to <strong>improve SEO</strong> of blog post and ranking. By default, meta title and slug match the title, but you can edit them.</p>
            <div class="mb8">
                <label class="input-label dark fs13 my2" for="post-meta-title">Meta title</label>
                <input type="text" id="post-meta-title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter meta title here (displayed by search engines and browser tab title)") }}'>
            </div>
            <div>
                <label class="input-label dark fs13 my2" for="post-slug">Slug</label>
                <input type="text" id="post-slug" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter slug here (e.g. 3-reasons-why-mouad-is-so-special)") }}'>
            </div>
        </div>
        <div id="content-input-box" class="flex flex-column" style="margin-top: 10px">
            <div>
                <div class="align-center">
                    <label class="input-label dark fs14" for="content">Content</label>
                    <span class="fs8 bold light-gray unselectable mx8">●</span>
                    <div id="toggle-content-summary" class="align-center pointer">
                        <span class="blue fs12 bold unselectable">Summary</span>
                        <svg class="toggle-arrow size6 ml4" fill="#2cb2ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                            <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                        </svg>
                    </div>
                </div>
                <div id="content-summary-section" class="typical-section-style my4 none">
                    <label class="input-label dark fs13 mb4" for="post-content-summary">Summary</label>
                    <textarea id="post-content-summary" class="styled-input no-textarea-resize" autocomplete="off" placeholder='short summary that displayed in blog posts cards (with read more button)'></textarea>
                </div>
                <p class="fs12 my2 light-gray no-margin">Summary will be taken from the first 55 words of the first paragraph by default. (you can update it in the right sidebar) </p>
            </div>
            <textarea id="post-content" class="styled-input" autocomplete="off" placeholder='Post content'></textarea>
        </div>
    </div>
    <div id="post-management-panel">
        <div class="post-management-panel-section">
            <div class="align-center post-management-panel-section-header">
                <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M144.66,177.79c0-10.43.06-20.86,0-31.29-.08-10-6.08-16.64-14.83-16.51-8.51.12-14.4,6.65-14.43,16.35-.08,20.86,0,41.71,0,62.57,0,9.74-3.26,14.08-12.7,16.82q-34.59,10-69.22,19.85c-6.32,1.8-12.15,1-16.52-4.33s-4.29-11.07-1.32-17Q65.94,123.56,116.26,22.87c2.87-5.74,7.07-9.29,13.71-9.31s10.89,3.5,13.75,9.23Q194,123.46,244.37,224.09c3,5.95,3.1,11.74-1.16,17s-10.16,6.28-16.47,4.49q-35.46-10-70.87-20.23c-7.42-2.15-11.12-7.25-11.18-15.16C144.6,199.41,144.67,188.6,144.66,177.79Z"/></svg>
                <h2 class="dark fs12 no-margin">Publish Section</h2>
            </div>
            <div class="post-management-panel-section-content">
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
                <div>
                    <div>
                        <!-- post status -->
                        <div class="align-center mt8 mb4">
                            <p class="fs12 no-margin dark mr4">Status :</p>
                            <div class="custom-dropdown-box" style="margin-left: 9px">
                                <input type="hidden" class="selected-value" id="post-status" value="draft" autocomplete="off">
                                <div class="custom-dropdown-button custom-dropdown-button-style">
                                    <span class="fs11 bold dark custom-dropdown-button-text">Draft</span>
                                    <svg class="arrow size6 ml4 dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                                    </svg>
                                </div>
                                <div class="custom-dropdown-items-container custom-dropdown-items-container-style" style="max-width: 176px;">
                                    <div class="custom-dropdown-item custom-dropdown-item-style">
                                        <span class="custom-dropdown-item-text fs14 dark bold block">Live</span>
                                        <span class="fs12 block">post will be accessible to public after publish.</span>
                                        <input type="hidden" class="custom-dropdown-item-value" value="live" autocomplete="off">
                                    </div>
                                    <div class="custom-dropdown-item custom-dropdown-item-style custom-dropdown-item-selected custom-dropdown-item-selected-style mt2">
                                        <span class="custom-dropdown-item-text fs14 dark bold block">Draft</span>
                                        <span class="fs12 block">post will be saved as draft to be updated and published later.</span>
                                        <input type="hidden" class="custom-dropdown-item-value" value="live" autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- post visibility -->
                        <div class="align-center my4">
                            <p class="fs12 no-margin dark mr4">Visibility :</p>
                            <div class="custom-dropdown-box">
                                <input type="hidden" class="selected-value" id="post-visibility" value="draft" autocomplete="off">
                                <div class="custom-dropdown-button custom-dropdown-button-style">
                                    <span class="fs11 bold dark custom-dropdown-button-text">Public</span>
                                    <svg class="arrow size6 ml4 dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                                    </svg>
                                </div>
                                <div class="custom-dropdown-items-container custom-dropdown-items-container-style" style="max-width: 180px;">
                                    <div class="custom-dropdown-item custom-dropdown-item-style custom-dropdown-item-selected custom-dropdown-item-selected-style">
                                        <span class="custom-dropdown-item-text fs14 dark bold block">Public</span>
                                        <span class="fs11 block">Post will be public.</span>
                                        <input type="hidden" class="custom-dropdown-item-value" value="public" autocomplete="off">
                                    </div>
                                    <div class="custom-dropdown-item custom-dropdown-item-style mt2">
                                        <span class="custom-dropdown-item-text fs14 dark bold block">Private</span>
                                        <span class="fs11 block">post will be hidden and private.</span>
                                        <input type="hidden" class="custom-dropdown-item-value" value="private" autocomplete="off">
                                    </div>
                                    <div class="custom-dropdown-item custom-dropdown-item-style mt2">
                                        <span class="custom-dropdown-item-text fs14 dark bold block">Password protected</span>
                                        <span class="fs11 block">Protected with a password you choose. Only those with the password can view this post.</span>
                                        <input type="hidden" class="custom-dropdown-item-value" value="private" autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="flex full-width">
                            <div class="typical-button-style dark-bs align-center publish-post move-to-right" style="padding: 5px 11px;">
                                <div class="relative size14 mr4">
                                    <svg class="flex size12 icon-above-spinner" style="margin-top: 1px;" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M144.66,177.79c0-10.43.06-20.86,0-31.29-.08-10-6.08-16.64-14.83-16.51-8.51.12-14.4,6.65-14.43,16.35-.08,20.86,0,41.71,0,62.57,0,9.74-3.26,14.08-12.7,16.82q-34.59,10-69.22,19.85c-6.32,1.8-12.15,1-16.52-4.33s-4.29-11.07-1.32-17Q65.94,123.56,116.26,22.87c2.87-5.74,7.07-9.29,13.71-9.31s10.89,3.5,13.75,9.23Q194,123.46,244.37,224.09c3,5.95,3.1,11.74-1.16,17s-10.16,6.28-16.47,4.49q-35.46-10-70.87-20.23c-7.42-2.15-11.12-7.25-11.18-15.16C144.6,199.41,144.67,188.6,144.66,177.79Z"/></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs11 unselectable">publish</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="post-management-panel-section toggle-box">
            <div class="align-center post-management-panel-section-header pointer toggle-button">
                <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"></path></svg>
                <h2 class="dark fs12 no-margin unselectable">Categories</h2>
                <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </div>
            <div class="post-management-panel-section-content post-management-cateories-box toggle-container none">
                @foreach($root_categories as $root_category)
                    <div class="flex">
                        <input type="checkbox" class="size14 mr4" id="category-{{ $root_category->id }}" value="{{ $root_category->id }}" autocomplete="off">
                        <label for="category-{{ $root_category->id }}" class="fs12 bold dark mt2">{{ $root_category->title }}</label>
                    </div>
                    @foreach($root_category->descendants()->orderBy('path')->get() as $descendant)
                        <div class="flex" style="margin-left: {{ $descendant->depth * 10 }}px">
                            <input type="checkbox" class="category-id size14 mr4" id="category-{{ $descendant->id }}" value="{{ $descendant->id }}" autocomplete="off">
                            <label for="category-{{ $descendant->id }}" class="fs12 bold dark mt2">{{ $descendant->title }}</label>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="post-management-panel-section toggle-box">
            <div class="align-center post-management-panel-section-header pointer toggle-button">
                <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
                <h2 class="dark fs12 no-margin">Tags</h2>
                <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </div>
            <div class="post-management-panel-section-content toggle-container none">
                <label class="fs13 dark bold" for="post-tags-input">Enter post tags</label>
                <p class="no-margin fs12 light-gray mt2">(separate tags by pressing enter)</p>
                <div class="post-tags-wrapper mt4">
                    <input type="text" id="post-tags-input" class="post-tags-input" autocomplete="off">
                </div>
                <div class="post-tag-item-skeleton post-tag-item align-center none">
                    <span class="fs13 tag-text">post tag</span>
                    <span class="unselectable post-tag-remove remove-parent">✖</span>
                </div>
            </div>
        </div>
        <div class="post-management-panel-section">
            <div class="align-center post-management-panel-section-header pointer">
                <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.79,53.73V205.58c-.3.36-.74.67-.87,1.07C247.5,230.37,232,241.8,207.16,241.8H126.38c-25.62,0-51.24.19-76.86-.07C25.24,241.49,5.21,222,5.07,198.05q-.39-68,0-136.1C5.24,38.67,25,18.77,48.29,18.64c55.16-.32,110.32-.16,165.48,0,9.39,0,17.8,3.42,25.32,9.08C247.9,34.3,252.73,43.43,255.79,53.73ZM130.48,217.38h78.86c13.59,0,20.89-7.18,20.9-20.72q0-65.88,0-131.77c0-12.57-8.28-20.82-20.87-20.83q-79.11,0-158.21,0c-12.65,0-20.78,8.16-20.79,20.81q0,65.88,0,131.76c0,12.75,8,20.73,20.76,20.74Q90.81,217.4,130.48,217.38ZM186.8,196c12,.49,18.25-10.89,13.66-21.05-8.78-19.41-16.89-39.13-25.19-58.75-2.18-5.16-5.34-9-11.24-9.59-6.35-.68-10.86,2.12-14.3,7.4q-7.17,11.09-14.86,21.83c-5.45,7.62-14.89,7.95-20.86.94-1.59-1.86-3-3.84-4.57-5.74-7.45-9.27-17-8.85-23.5,1.18C77,146.08,68.33,160,59.44,173.89c-3.15,4.91-4.09,10-1.36,15.25,2.83,5.41,7.86,6.76,13.64,6.72,19.27-.1,38.53,0,57.79,0C148.61,195.82,167.73,195.26,186.8,196ZM208.66,81c0-10-9.18-19.16-19.11-19.12a19,19,0,0,0-.08,38C199.6,100,208.63,91.07,208.66,81Z"/></svg>
                <h2 class="dark fs12 no-margin">Featured image</h2>
                <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </div>
            <div class="post-management-panel-section-content">
                <div class="featured-image-upload-box open-feature-image-viewer">
                    <span class="bold dark">Upload featured image</span>
                </div>
                <div class="uploaded-featured-image-box">

                </div>
            </div>
        </div>

    </div>
</main>
@endsection