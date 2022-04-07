@extends('layouts.admin')

@section('title', 'Admin - create post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts', 'subpage'=>'admin.posts.create'])
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/ckeditor.js') }}" defer></script>
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
    @include('partials.admin.media-library.delete-media-viewer')
    <x-media-library.library />

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
            <div class="informative-message-container post-top-error-container align-center relative my8 none">
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