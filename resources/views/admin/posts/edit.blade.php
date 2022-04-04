@extends('layouts.admin')

@section('title', 'Admin - create post')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts', 'subpage'=>'admin.posts.edit'])
@endsection

@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}" defer></script>
<script src="{{ asset('js/admin/post/manage.js') }}" defer></script>
<script src="{{ asset('js/admin/post/edit.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/edit.css') }}" rel="stylesheet">
@endpush

@section('content')
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
            <x-admin.post.post-form :post="$post"/>
        </div>
        <x-admin.post.post-management-panel />
    @endif
</main>
@endsection