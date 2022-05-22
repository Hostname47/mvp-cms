@extends('layouts.admin')

@section('title', 'Admin - Edit post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts', 'subpage'=>'admin.posts.edit'])
@endsection

@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/media.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/post/manage.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/post/edit.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/edit.css') }}" rel="stylesheet">
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
    @if($post && $post->has_thumbnail())
    <x-slot name="selected_media">{{ $post->thumbnail_image }}</x-slot>
    @endif
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
            <svg class="size18 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"></path></svg>
            <h1 class="fs20 dark no-margin">Edit a post</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span class="fs13 bold">{{ __('Home') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Edit a post') }}</span>
            </div>
        </div>
    </div>
    @if(!$post) <!-- search for a post -->
    <div class="full-center flex-column" style='margin: 30px 0 300px 0;'>
        <h2 class="fs20 dark no-margin">Edit a post</h2>
        <p class="dark no-margin mt4">Search for a post by typing its id, title or slug to edit</p>
        <div style="margin-top: 12px; width: 48%;">
            <div class="relative">
                <svg class="absolute size14" fill="#5b5b5b" style="top: 13px; left: 13px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                <input type="text" class="search-input-style full-width border-box" id="posts-search-input" autocomplete="off" placeholder="search for posts">
                <div class="search-button-style" id="search-for-posts-button">
                    <svg class="size14 mr4" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                    <span class="bold dark fs12">search</span>
                </div>
            </div>
            <div class="relative">
                <div id="posts-search-result-box" class="full-width scrolly none">
                    <input type="hidden" id="k" autocomplete="off">
                    <div class="results-container none">
                        
                    </div>
                    <a href="" class="post-search-entity post-search-entity-factory none">
                        <input type="hidden" class="post-id" autocomplete="off">
                        <p class="no-margin no-wrap">Id: <span class="bold dark-blue post-id-text">548</span></p>
                        <span class="fs11 mx4" style="color: rgb(187, 187, 187)">〡</span>
                        <div class="flex">
                            <span class="mr4">Title:</span>
                            <div>
                                <span class="bold dark-blue post-title-text">How are you today, mouad ?How are you today, mouad ?How are you today, mouad ?</span>
                                <div class="fs11 light-gray mt2">
                                    <span>author: <strong class="dark post-author-name-text">hostname47</strong></span>
                                    <span class="fs11 mx4" style="color: rgb(187, 187, 187)">〡</span>
                                    <span>creation date: <strong class="dark post-creation-date">3/12/2022 84:54 AM</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div id="posts-search-fetch-more-results" class="full-center none" style='height: 32px;'>
                        <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <!-- loading -->
                    <div class="search-loading full-center flex-column none" style="height: 86px">
                        <svg class="spinner size24 black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="fs12 dark fs11 bold" style="margin-top: 5px;">searching</span>
                    </div>
                    <!-- no results found -->
                    <div class="no-results-found-box full-center none" style="height: 58px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs13 gray no-margin bold">Posts not found with your search query</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        @push('styles')
        <link href="{{ asset('css/admin/post/post-management-right-panel.css') }}" rel="stylesheet">
        @endpush
        <input type="hidden" id="post-id" value="{{ $post->id }}" autocomplete="off">
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
            <x-admin.post.post-form :post="$post"/>
        </div>
        <x-admin.post.post-management-panel :post="$post"/>
    @endif
</main>
@endsection