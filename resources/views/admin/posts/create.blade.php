@extends('layouts.admin')

@section('title', 'Admin - create post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts', 'subpage'=>'admin.posts.create'])
@endsection

@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/media.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/post/manage.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/post/create.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/post-management-right-panel.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/create.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/media.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- delete media viewer -->
    <x-media-library.delete-media-viewer />
    <!-- set thumbnail image viewer (media library) -->
    <x-media-library.library>
        <x-slot name="id">set-thumbnail-image-viewer</x-slot>
        <x-slot name="title">Thumbnail image</x-slot>
        <x-slot name="selection_type">single</x-slot>
        <x-slot name="target_button">
            <div class="typical-button-style dark-bs dark-bs-disabled align-center move-to-right media-viewer-target-action-button set-thumbnail-image prevent-action" style="padding: 6px 12px;">
                <div class="relative size14 mr4">
                    <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M58.55,251.39c-9.94,0-15.72-5.59-14.54-14.83,2.77-21.61,6-43.16,9.09-64.73.47-3.3,2.39-5.94,4.78-8.32q40.7-40.6,81.26-81.35c2.57-2.58,3.89-2.93,6.66-.13q33.54,33.93,67.46,67.48c2.68,2.66,2.69,4,0,6.66q-40.81,40.49-81.33,81.27c-3.74,3.76-8.24,4.81-13.18,5.5-18.75,2.6-37.48,5.38-56.22,8.08C61.12,251.22,59.69,251.29,58.55,251.39ZM246.34,89.65c-7.19-36.3-51.11-53.73-81.14-32.19-2,1.43-4.84,2.3-1.42,5.68q34.36,34,68.35,68.34c2.69,2.72,3.75,1.61,5.39-.68,6.47-9.06,9.79-19.13,10.1-32.08C247.74,96.86,247.05,93.25,246.34,89.65ZM142.6,34.57c8.12-.06,13.3-5.32,13.34-12.81s-5.25-13-13.16-13.07c-38.95-.12-77.9-.07-116.84-.06a12.77,12.77,0,0,0-12,7.09C9.22,24.6,15.6,34.48,26.37,34.58c19.37.18,38.74.05,58.11.05S123.23,34.74,142.6,34.57ZM102.41,87c8.81-.07,14.4-5.3,14.35-13.17-.06-7.69-5.36-12.76-14-12.79q-37.92-.16-75.83,0c-8.84,0-14.56,5.36-14.48,13.06s6,12.86,14.73,12.91c12.64.07,25.28,0,37.92,0C77.54,87,90,87.05,102.41,87ZM51.69,139.25c7.56-.53,12.85-5.92,13-12.81.18-7.06-5.31-13-13.09-13.33-8.73-.36-17.5-.36-26.23,0-7.64.32-12.8,5.78-12.94,12.77-.15,7.24,5.11,12.81,13,13.36,4.25.31,8.53.06,12.81.06C42.75,139.31,47.24,139.57,51.69,139.25Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs12 unselectable" style="margin-top: 1px;">Set thumbnail image</span>
            </div>
        </x-slot>
    </x-media-library.library>

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
        <div class="admin-page-content-box">
            @if(Session::has('message'))
            <div class="informative-message-container media-upload-error-container flex align-center relative my8">
                <div class="informative-message-container-left-stripe imcls-green"></div>
                <p class="no-margin fs13 message-text">{!! Session::get('message') !!}</p>
                <div class="close-parent close-informative-message-style">✖</div>
            </div>
            @endif
            <div class="informative-message-container align-center relative my8 none" id="post-error-container">
                <div class="informative-message-container-left-stripe imcls-red"></div>
                <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                <div class="close-parent close-informative-message-style">✖</div>
            </div>
            <x-admin.post.post-form />
        </div>
        <!-- 
            Here we invoked the post panel component wiothout giving it any post, because we are
            in the creation page. In edit, we can pass a post model to the component to fill in the
            data into the panel like post categories and tags for edit
        -->
        <x-admin.post.post-management-panel />
    </main>
@endsection