@extends('layouts.admin')

@section('title', 'Admin - Tags')

@push('scripts')
<script src="{{ asset('js/admin/tags.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tags.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'tags.management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
            <h1 class="fs20 dark no-margin">Tags Management</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Tags management') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        <!-- update tag viewer -->
        <div id="update-tag-viewer" class="global-viewer full-center none" style="z-index:11112">
            <div class="viewer-box-style-1">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                    <div class="flex align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
                        <span class="fs20 bold dark">Update tag informations</span>
                    </div>
                    <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div style="padding: 14px;" class="dark fs13">
                    <div class="content-container none">
                        <h3 class="dark fs16 no-margin">Update Tag</h3>
                        <!-- tag form component that include tag inputs to update the selected tag -->
                        <x-admin.tag.tag-form operation="update">
                            <x-slot name="bottomline">
                                <div class="flex">
                                    <div id="update-tag-button" class="typical-button-style dark-bs full-center mt8" style="padding: 8px 11px;">
                                        <div class="relative size14 mr4">
                                            <svg class="flex size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="bold fs12 unselectable">Update Tag</span>
                                        <input type="hidden" class="tag-id" autocomplete="off"> <!-- set dynamically -->
                                    </div>
                                </div>
                            </x-slot>
                        </x-admin.tag.tag-form>
                    </div>
                    <div class="loading-container full-center" style="height: 160px;">
                        <div class="full-center flex-column">
                            <svg class="spinner size18" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                            <p class="dark bold fs12 my8">Fetching tag informations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete tag viewer -->
        <div id="delete-tag-viewer" class="global-viewer full-center none" style="z-index:11112">
            <div class="viewer-box-style-1">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                    <div class="flex align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                        <span class="fs20 bold dark">Delete tag</span>
                    </div>
                    <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div style="padding: 14px;" class="dark fs13">
                    <div class="content-container">
                        <h3 class="dark fs16 no-margin">Delete Tag :</h3>
                        <div class="ml8">
                            <div class="full-center">
                                <a href="" class="text-center fs24 bold my8 dark blue-when-hover">#<span class="slug-text">websockets</span></a>
                            </div>
                            <p class="my8 blue"><strong>Title</strong> : <span class="dark title-text">Websockets</span></p>
                            <p class="my8 blue"><strong>Meta title</strong> : <span class="dark meta-title-text">Websockets</span></p>
                            <p class="my8 blue"><strong>Slug</strong> : <span class="dark slug-text">web-sockets</span></p>
                            <p class="my8 blue"><strong>Description</strong> : <span class="dark description-text">This is cool description about websockets</span></p>
                        </div>
                        <div class="typical-section-style my8" style="margin-top: 14px;">
                            <p class="no-margin dark">You are about to <strong>permanently delete this tag</strong> from your site. Once it gets deleted, all posts with that tag will not be classified under it anymore. This action cannot be undone.</p>
                        </div>
                        <div class="flex">
                            <div id="delete-tag-button" class="typical-button-style red-bs align-center" style="padding: 8px 11px;">
                                <div class="relative size14 mr4">
                                    <svg class="flex size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs12 unselectable">Delete Tag</span>
                                <input type="hidden" class="tag-id" autocomplete="off"> <!-- set dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Session::has('message'))
        <div class="informative-message-container flex align-center relative my8">
            <div class="informative-message-container-left-stripe imcls-green"></div>
            <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @endif
        <div class="flex">
            <h2 class="blue no-margin">Tags</h2>
            <!-- search section -->
            <div class="move-to-right">
                <form action="" class="align-center relative">
                    <svg class="search-icon-style-1" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                    <input type="text" required name="k" class="search-input-style-1" style="width: 300px" placeholder="search for tags" @if($k) value="{{ $k }}" @endif>
                    <button class="search-button-style-1">
                        <span>Search Tags</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="flex mt8">
            <div id="create-tag-section">
                <div class="align-center">
                    <svg class="size12 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"></path></svg>
                    <h3 class="dark fs16 no-margin">Create Tag</h3>
                </div>
                <p class="no-margin my4 fs13 dark">Create a new tag, and start classify your posts more precisely.</p>
                <!-- tag form component that include tag inputs to create a new tag -->
                <x-admin.tag.tag-form operation="create">
                    <x-slot name="bottomline">
                        <div class="flex">
                            <div id="create-tag-button" class="typical-button-style dark-bs full-center mt8" style="padding: 8px 11px;">
                                <div class="relative size12 mr4">
                                    <svg class="flex size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"></path></svg>
                                    <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs12 unselectable">Create Tag</span>
                            </div>
                        </div>
                    </x-slot>
                </x-admin.tag.tag-form>
            </div>
            <div id="tags-section">
                <div class="flex my8">
                    <div class="move-to-right">
                        {{ $tags->appends(request()->query())->links() }}
                    </div>
                </div>
                <table id="tags-table" class="full-width">
                    <thead>
                        <tr class="flex">
                            <th class="tags-table-selection-column">
                                <input type="checkbox" class="no-margin size16">
                            </th>
                            <th class="tags-table-title-column">
                                <span class="blue">Tag title</span>
                            </th>
                            <th class="tags-table-slug-column">
                                <span class="dark fs13">Tag slug</span>
                            </th>
                            <th class="tags-table-description-column">
                                <span class="dark fs13">Description</span>
                            </th>
                            <th class="tags-table-count-column">
                                <span class="dark fs13">Posts</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr class="flex tag-row">
                            <!-- tags selection -->
                            <td class="tags-table-selection-column">
                                <input type="checkbox" class="no-margin size16" autocomplete="off">
                            </td>
                            <!-- tags title -->
                            <td class="tags-table-title-column">
                                <div>
                                    <a href="" class="dark-blue bold no-underline title-text">{{ $tag->title }}</a>
                                    <p class="fs12 light-gray my2">meta title: <span class="meta-title-text">{{ $tag->title_meta }}</span></p>
                                </div>
                                <div class="align-center mt4 tag-actions-links-container">
                                    <div class="fs12 dark-blue pointer open-tag-update-viewer">
                                        <span>Edit</span>
                                        <input type="hidden" class="tag-id" value="{{ $tag->id }}" autocomplete="off">
                                    </div>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <span class="fs12 red pointer align-center open-tag-delete-viewer">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Delete</span>
                                        <input type="hidden" class="tag-id" value="{{ $tag->id }}" autocomplete="off">
                                    </span>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <a href="{{ route('tag.view', ['tag'=>$tag->slug]) }}" target="_blank" class="fs12 dark-blue no-underline tag-link">
                                        <span>View</span>
                                    </a>
                                </div>
                            </td>
                            <!-- tags slug -->
                            <td class="tags-table-slug-column">
                                <p class="dark no-margin fs13 slug-text">{{ $tag->slug }}</p>
                            </td>
                            <!-- tags description -->
                            <td class="tags-table-description-column">
                                <p class="dark no-margin fs13 description-text">{{ $tag->description }}</p>
                            </td>
                            <!-- tags posts count -->
                            <td class="tags-table-count-column">
                                <a href="" class="dark-blue bold no-underline tag-link tag-count">{{ $tag->posts()->withoutGlobalScopes()->count() }}</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="empty-tags-row @if($tags->count()) none @endif">
                            <td colspan="5" class="full-center">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="bold dark fs13 my4">No tags found. Consider the left section to create a new tag</p>
                            </td>
                        </tr>
                        <tr class="flex tag-row tag-row-skeleton none">
                            <!-- tags selection -->
                            <td class="tags-table-selection-column">
                                <input type="checkbox" class="no-margin tag-selection-id size16" autocomplete="off">
                            </td>
                            <!-- tags title -->
                            <td class="tags-table-title-column">
                                <div>
                                    <a href="" class="dark-blue bold no-underline title-text"></a>
                                    <p class="fs12 light-gray my2">meta title: <span class="meta-title-text"></span></p>
                                </div>
                                <div class="align-center mt4 tag-actions-links-container">
                                    <div class="fs12 dark-blue pointer open-tag-update-viewer">
                                        <span>Edit</span>
                                        <input type="hidden" class="tag-id" value="" autocomplete="off">
                                    </div>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <span class="fs12 red pointer align-center open-tag-delete-viewer">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Delete</span>
                                        <input type="hidden" class="tag-id" value="" autocomplete="off">
                                    </span>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <a href="" target="_blank" class="fs12 dark-blue no-underline tag-link">
                                        <span>View</span>
                                    </a>
                                </div>
                            </td>
                            <!-- tags slug -->
                            <td class="tags-table-slug-column">
                                <p class="dark no-margin fs13 slug-text"></p>
                            </td>
                            <!-- tags description -->
                            <td class="tags-table-description-column">
                                <p class="dark no-margin fs13 description-text"></p>
                            </td>
                            <!-- tags posts count -->
                            <td class="tags-table-count-column">
                                <a href="" class="dark-blue bold no-underline tag-link tag-count"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex my8">
                    <div class="move-to-right">
                        {{ $tags->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection