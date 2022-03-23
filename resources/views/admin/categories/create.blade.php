@extends('layouts.admin')

@section('title', 'Admin - create post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts.create'])
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/simplemde.js') }}" defer></script>
<script type="module" src="{{ asset('js/admin/category/create.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
@endpush

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"/></svg>
            <h1 class="fs20 dark no-margin">Create new category</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span class="fs13 bold">{{ __('Home') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Create new category') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        <div>
            <label class="input-label dark fs14" for="title">Category Title</label>
            <p class="fs12 my2 light-gray">Category meta title and slug will be cloned to match the exact title by default. (you can edit them)</p>
            <input type="text" id="title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter post title here") }}'>
        </div>
        <div class="typical-section-style mt4">
            <p class="fs12 mb2 light-gray no-margin">Meta title and slug are useful to <strong>improve SEO</strong> of blog post and ranking</p>
            <div>
                <label class="input-label dark fs13 my2" for="meta-title">Meta title</label>
                <input type="text" id="meta-title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter meta title here (displayed by search engines and browser tab title)") }}'>
            </div>
            <div class="mt8">
                <label class="input-label dark fs13 my2" for="slug">Slug</label>
                <input type="text" id="slug" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter slug here (e.g. xyz-category-and-more)") }}'>
            </div>
        </div>
        <div class="flex flex-column" style="margin-top: 10px">
            <label class="input-label dark fs14" for="description">Description</label>
            <p class="fs12 my2 light-gray">Category description should include all related topics and keyswords</p>
            <textarea id="description" class="styled-input no-textarea-resize" style="height: 126px;" autocomplete="off" placeholder='Category description'></textarea>
        </div>
        <div class="flex flex-column" style="margin-top: 10px">
            <label class="input-label dark fs14" for="content">Is sub-category ?</label>
            <p class="fs12 my2 light-gray">If this category is a subcategory, then check the following toggle button and choose its parent</p>
            <div class="align-center">
                <!-- is sub category toggle button -->
                <div id="sub-category-toggle-button" class="pointer">
                    <input type="hidden" class="is-sub-category" value="no" autocomplete="off">
                    <svg class="off-icon size40 flex" fill="#575757" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M2,46.07c0-.14,0-.28,0-.41,0-.37.1-.74.12-1.13v-.14a12.33,12.33,0,0,0,.32-1.49c.08-.29.15-.58.21-.88h0c6.25-15.42,18.23-21.32,34.9-20.33,10.24.61,20.54,0,30.8.14C85.69,22.09,98.13,34,98.1,50S85.63,77.85,68.24,78.19c-10.26.2-20.56-.41-30.8.15C20.35,79.26,8.25,72.9,2.17,56.65c0-.32-.1-.64-.16-.95a13.65,13.65,0,0,0-.11-1.57V46.84C1.93,46.59,2,46.33,2,46.07ZM30.15,66a16,16,0,0,0-.41-32.09A16,16,0,0,0,30.15,66Z"/></svg>
                    <svg class="on-icon size40 flex none" fill="#26ebff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M98,46.07c0-.14,0-.28,0-.41,0-.37-.1-.74-.12-1.13v-.14a12.33,12.33,0,0,1-.32-1.49c-.08-.29-.15-.58-.21-.88h0c-6.25-15.42-18.23-21.32-34.9-20.33-10.24.61-20.54,0-30.8.14C14.31,22.09,1.87,34,1.9,50S14.37,77.85,31.76,78.19c10.26.2,20.56-.41,30.8.15,17.09.92,29.19-5.44,35.27-21.69,0-.32.1-.64.16-.95a13.65,13.65,0,0,1,.11-1.57V46.84C98.07,46.59,98,46.33,98,46.07ZM69.85,66a16,16,0,0,1,.41-32.09A16,16,0,0,1,69.85,66Z"/></svg>
                </div>
                <span class="fs8 bold light-gray unselectable mx8">●</span>
                <div class="typical-button-style white-bs align-center cursor-not-allowed open-categories-to-chose-parent">
                    <div class="relative size14 mr4">
                        <svg class="size13 icon-above-spinner" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs11 unselectable">Chose parent category</span>
                </div>
            </div>
        </div>
        <div style="margin-top: 12px">
            <p class="fs12 mb4 light-gray">The category will be created with under review status until an admin fill some content and review its informations.</p>
            <div class="typical-button-style dark-bs width-max-content align-center create-category">
                <div class="relative size14 mr4">
                    <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.64,117.68a33.42,33.42,0,0,1-.55-3.63c-1.72-6-2.06-12.41-3.89-18.48-11.73-38.92-36.07-67-73.74-81.8C132.08-3.66,89.66,2.4,52.48,32.3,15.83,61.78.35,101.19,7.37,147.93c6.71,44.7,32.1,76.16,72.82,95.35,10.6,5,21.91,7.82,33.51,9.51.79.11,1.79-.17,2.44.42.77.14,1.54.3,2.28.49s1.31.12,2,.2h19.09a25.1,25.1,0,0,1,2.74-.23c.43-.08.87-.14,1.3-.2,6.7-1.84,13.67-2.28,20.37-4.27,34.55-10.22,60.17-31.29,77.1-63a121.4,121.4,0,0,0,12.82-40.47c.1-.7-.11-1.57.25-2.21a24.86,24.86,0,0,1,.5-3.46,25.46,25.46,0,0,1,.36-4V119.31C254.8,118.77,254.71,118.23,254.64,117.68Zm-124.93,112c-55.47-.46-100.05-45.34-99.9-100.59C30,73.54,75.14,28.55,130.52,28.81c55.57.25,100.51,45.5,100.15,100.83C230.3,185.25,185,230.13,129.71,229.66ZM96.14,141.21c-6.33,0-12.66-.09-19,0-2.46.05-3.45-.57-3.36-3.23.19-5.67.23-11.36,0-17-.13-3,.79-3.85,3.79-3.81,12,.16,24-.12,36,.17,4,.1,4.8-1.26,4.74-4.94-.22-11.84,0-23.69-.15-35.53,0-3.11.66-4.29,4-4.11,5.51.29,11,.22,16.55,0,2.77-.1,3.59.76,3.55,3.53-.14,12,.14,24-.16,36-.11,4.21,1.26,5.08,5.18,5,11.84-.26,23.7,0,35.54-.16,2.9,0,4,.62,3.86,3.74-.27,5.5-.25,11,0,16.54.14,3-.79,3.85-3.78,3.81-12-.16-24,.12-36-.17-4-.1-4.8,1.26-4.74,4.94.22,11.84,0,23.69.15,35.54.05,3.1-.66,4.28-4,4.1-5.5-.29-11-.22-16.55,0-2.77.1-3.59-.75-3.55-3.53.14-12-.14-24,.16-36,.11-4.21-1.25-5.22-5.19-5C107.51,141.46,101.82,141.21,96.14,141.21Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs11 unselectable">create category</span>
            </div>
        </div>
    </div>
</main>
@endsection