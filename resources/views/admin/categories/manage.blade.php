@extends('layouts.admin')

@section('title', 'Admin - manage categories')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'categories.management'])
@endsection

@push('scripts')
<script src="{{ asset('js/admin/category/create.js') }}" defer></script>
<script src="{{ asset('js/admin/category/category.js') }}" defer></script>
<script src="{{ asset('js/admin/category/manage.js') }}" defer></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/category.css') }}">
@endpush

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size18 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
            <h1 class="fs20 dark no-margin">Manage Categories</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span class="fs13 bold">Home</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">Manage Categories</span>
            </div>
        </div>
    </div>
    <!-- select category parent viewer -->
    <div id="select-one-category-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1" style="width: 680px;">
            <div class="flex align-center space-between light-gray-border-bottom" style="padding: 10px 14px;">
                <div class="flex align-center">
                    <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                    <span class="fs20 bold dark">Set parent category</span>
                </div>
                <div class="pointer fs20 close-global-viewer unselectable">✖</div>
            </div>
            <div class="full-center relative">
                <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                    <h2 class="fs16 dark no-margin mb4">Categories hierarchy</h2>
                    <p class="no-margin fs13 dark">The following hierarchy represents the categories and their subcategories. Select a category to set it as the parent of the current category</p>
                    <style>
                        .hierarchy-category-wrapper {
                            padding: 6px;
                        }

                        .categories-hierarchy-level {
                            padding: 6px;
                            background-color: #f4f5f782;
                            border: 1px solid #dde0e6;
                            border-radius: 3px;
                        }

                        .expand-subcategories-button {
                            height: 16px;
                            width: 16px;
                            min-width: 16px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background-color: #1f2324;
                            fill: white;
                            border-radius: 50%;
                            margin-left: 4px;
                            padding: 1px;
                        }

                        .angle-before-subcategories-box {
                            height: 12px;
                            width: 12px;
                            position: absolute;
                            left: -16px;
                            top: -5px;
                        }
                    </style>
                    @if($categories->count())
                        <div class="categories-hierarchy-level mt4">
                            @foreach($categories as $c)
                            <x-admin.category.hierarchy.selection.select-one-category :category="$c" inputname="create-category-parent-category" inputclass="create-category-parent-category" />
                            @endforeach
                        </div>
                    @else
                    <div class="typical-section-style flex align-center mt8">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="fs12 dark no-margin">This blog has no categories for the moment. Please create a new one in create category page.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        @if(Session::has('message'))
        <div class="informative-message-container flex align-center relative my8">
            <div class="informative-message-container-left-stripe imcls-green"></div>
            <p class="no-margin fs13 message-text">{!! Session::get('message') !!}</p>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @endif

        @if(is_null($category))
        <div class="flex">
            <!-- create category section -->
            <div id="create-category-section" class="category-form mr8">
                <div class="align-center mb8">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"/></svg>
                    <h2 class="dark no-margin">Create a category</h2>
                </div>
                <div class="simple-line-separator my8"></div>
                <x-admin.category.form-inputs :category="$category" action="create" />
                <!-- parent category selector -->
                <div class="input-container flex flex-column" style="margin-top: 10px">
                    <label class="input-label dark fs14">Is subcategory ?<span class="error-asterisk ml4">*</span></label>
                    <p class="fs12 my2 light-gray">If this category is a subcategory, then check the following toggle button and choose its parent</p>
                    <div class="align-center">
                        <!-- is sub-category toggle button -->
                        <div class="pointer is-sub-category-toggle-button">
                            <input type="hidden" class="is-sub-category" value="no" autocomplete="off">
                            <svg class="off-icon size40 flex" fill="#575757" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M2,46.07c0-.14,0-.28,0-.41,0-.37.1-.74.12-1.13v-.14a12.33,12.33,0,0,0,.32-1.49c.08-.29.15-.58.21-.88h0c6.25-15.42,18.23-21.32,34.9-20.33,10.24.61,20.54,0,30.8.14C85.69,22.09,98.13,34,98.1,50S85.63,77.85,68.24,78.19c-10.26.2-20.56-.41-30.8.15C20.35,79.26,8.25,72.9,2.17,56.65c0-.32-.1-.64-.16-.95a13.65,13.65,0,0,0-.11-1.57V46.84C1.93,46.59,2,46.33,2,46.07ZM30.15,66a16,16,0,0,0-.41-32.09A16,16,0,0,0,30.15,66Z"/></svg>
                            <svg class="on-icon size40 flex none" fill="#4ac4ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M98,46.07c0-.14,0-.28,0-.41,0-.37-.1-.74-.12-1.13v-.14a12.33,12.33,0,0,1-.32-1.49c-.08-.29-.15-.58-.21-.88h0c-6.25-15.42-18.23-21.32-34.9-20.33-10.24.61-20.54,0-30.8.14C14.31,22.09,1.87,34,1.9,50S14.37,77.85,31.76,78.19c10.26.2,20.56-.41,30.8.15,17.09.92,29.19-5.44,35.27-21.69,0-.32.1-.64.16-.95a13.65,13.65,0,0,1,.11-1.57V46.84C98.07,46.59,98,46.33,98,46.07ZM69.85,66a16,16,0,0,1,.41-32.09A16,16,0,0,1,69.85,66Z"/></svg>
                        </div>
                        <span class="fs8 bold light-gray unselectable mx8">●</span>
                        <div class="typical-button-style white-bs white-bs-disabled action-denied align-center open-select-one-category-viewer">
                            <input type="hidden" class="parent-category" autocomplete="off">
                            <svg class="size13 mr4" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
                            <span class="bold fs11 unselectable" style="margin-top: 1px;">Chose parent category</span>
                        </div>
                    </div>
                </div>
                <div class="typical-section-style mt8 mb4">
                    <p class="fs13 no-margin light-gray">The category will be <strong>under review</strong> after creation until an admin add some blog posts and review its informations, then he can publish it.</p>
                </div>
                <div style="margin-top: 12px">
                    <div id="create-category" class="typical-button-style dark-bs width-max-content align-center">
                        <div class="relative size13 mr4">
                            <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.64,117.68a33.42,33.42,0,0,1-.55-3.63c-1.72-6-2.06-12.41-3.89-18.48-11.73-38.92-36.07-67-73.74-81.8C132.08-3.66,89.66,2.4,52.48,32.3,15.83,61.78.35,101.19,7.37,147.93c6.71,44.7,32.1,76.16,72.82,95.35,10.6,5,21.91,7.82,33.51,9.51.79.11,1.79-.17,2.44.42.77.14,1.54.3,2.28.49s1.31.12,2,.2h19.09a25.1,25.1,0,0,1,2.74-.23c.43-.08.87-.14,1.3-.2,6.7-1.84,13.67-2.28,20.37-4.27,34.55-10.22,60.17-31.29,77.1-63a121.4,121.4,0,0,0,12.82-40.47c.1-.7-.11-1.57.25-2.21a24.86,24.86,0,0,1,.5-3.46,25.46,25.46,0,0,1,.36-4V119.31C254.8,118.77,254.71,118.23,254.64,117.68Zm-124.93,112c-55.47-.46-100.05-45.34-99.9-100.59C30,73.54,75.14,28.55,130.52,28.81c55.57.25,100.51,45.5,100.15,100.83C230.3,185.25,185,230.13,129.71,229.66ZM96.14,141.21c-6.33,0-12.66-.09-19,0-2.46.05-3.45-.57-3.36-3.23.19-5.67.23-11.36,0-17-.13-3,.79-3.85,3.79-3.81,12,.16,24-.12,36,.17,4,.1,4.8-1.26,4.74-4.94-.22-11.84,0-23.69-.15-35.53,0-3.11.66-4.29,4-4.11,5.51.29,11,.22,16.55,0,2.77-.1,3.59.76,3.55,3.53-.14,12,.14,24-.16,36-.11,4.21,1.26,5.08,5.18,5,11.84-.26,23.7,0,35.54-.16,2.9,0,4,.62,3.86,3.74-.27,5.5-.25,11,0,16.54.14,3-.79,3.85-3.78,3.81-12-.16-24,.12-36-.17-4-.1-4.8,1.26-4.74,4.94.22,11.84,0,23.69.15,35.54.05,3.1-.66,4.28-4,4.1-5.5-.29-11-.22-16.55,0-2.77.1-3.59-.75-3.55-3.53.14-12-.14-24,.16-36,.11-4.21-1.25-5.22-5.19-5C107.51,141.46,101.82,141.21,96.14,141.21Z"/></svg>
                            <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs11 unselectable">create category</span>
                    </div>
                </div>
            </div>
            <!-- categories to manage section -->
            <div id="categories-to-manage-section" class="ml8">
                <div class="align-center">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                    <h2 class="dark no-margin mb4">Manage categories</h2>
                </div>
                <p class="dark no-margin fs13 mb4">Click on a category from the following hierarchy to configure.</p>
                <div class="typical-section-style my8">
                    <p class="dark no-margin fs13 mb4">The number before every category is the <strong>priority order of categories</strong> that is used to order categories in the client side. You can update it to change the order of categories or subcategories by clicking on update order to verify the order first and then update.</p>
                </div>
                <div class="flex align-center mb8">
                    <h2 class="dark fs14 no-margin mb4 mr8">Categories hierarchy :</h2>
                    <div class="flex align-center move-to-right">
                        <div id="sort-categories-components-by-priority" class="typical-button-style white-bs flex align-center" style="padding: 4px 8px;">
                            <svg class="size12 mr4" style="min-width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M158.72,140.8c4.15-4.28,8.25-8.63,12.48-12.85,5.68-5.67,12.6-6.18,17.5-1.41s4.6,11.89-1,17.52q-16.15,16.31-32.48,32.46c-5.85,5.79-12.26,5.71-18.15-.13q-16.45-16.33-32.78-32.8c-5.26-5.31-5.52-12-.84-16.81s11.83-4.65,17.18.61c4.38,4.3,8.63,8.74,13.16,13.34,1.25-1.69.76-3.35.77-4.84,0-19.06,0-38.12,0-57.18,0-8,4.33-12.94,11.1-13.18,6.95-.23,12,4.74,12,12.21.07,19.36,0,38.72,0,58.08v4.41ZM114.88,42.33c10.51,0,21,.12,31.53-.07a11.33,11.33,0,0,0,11.32-11.12c.19-6-4-10.81-10.21-11.72a31.93,31.93,0,0,0-4.49-.23q-60.36,0-120.74,0a27.88,27.88,0,0,0-4.92.34A11.32,11.32,0,0,0,8.16,33.59c1.22,5.37,5.95,8.72,12.56,8.73q31.08,0,62.17,0Q98.88,42.33,114.88,42.33ZM98.71,88.4c7.69,0,12.88-4.66,12.93-11.39s-5.13-11.5-12.79-11.52q-39.19-.1-78.38,0c-7.79,0-12.67,4.68-12.59,11.61s5.06,11.27,12.9,11.3c13.06,0,26.13,0,39.19,0C72.88,88.41,85.8,88.45,98.71,88.4ZM20.34,111.64c-7.45.07-12.36,4.56-12.46,11.24s4.65,11.58,12,11.64q22.48.19,45,0c7.38-.07,12.13-4.89,12-11.68-.12-6.54-4.93-11.1-12-11.2-7.49-.09-15,0-22.47,0C35,111.62,27.68,111.57,20.34,111.64Z"/></svg>
                            <span class="fs12 bold dark unselectable">{{ __('order by priority') }}</span>
                        </div>
                        <div id="update-categories-priorities" class="typical-button-style dark-bs flex align-center ml8" style="padding: 4px 8px;">
                            <div class="relative size12 mr4">
                                <svg class="size12 icon-above-spinner" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <div class="fs12 bold white unselectable">{{ __('update priorities') }}</div>
                        </div>
                    </div>
                </div>
                @if($categories->count())
                <div id="categories-to-manager-box" class="categories-hierarchy-level">
                    @foreach($categories as $category)
                    <x-admin.category.hierarchy.selection.select-by-click-category :category="$category"/>
                    @endforeach
                </div>
                @else
                <div class="typical-section-style flex align-center mt8">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="fs12 dark no-margin">This blog website has no categories for the moment. Please create a new one in create category page.</p>
                </div>
                @endif
            </div>
        </div>
        @else
            <input type="hidden" id="category-id" value="{{ $category->id }}" autocomplete="off">
            <!-- update category parent viewer -->
            <div id="update-category-parent-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 680px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 10px 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M172,60.41c-14,6.48-27.8,12.84-41.56,19.26a3.38,3.38,0,0,1-3.18-.24c-13.52-6.27-27-12.5-41-18.93,1.11-1.59,2-3,3-4.32Q107.64,31.61,126,7a21.11,21.11,0,0,0,1.79-2.07l.45-.5.32-.27.72,0h.05l.81.72c.49,1,1.56,1.66,2.18,2.49C145.38,25,158.55,42.53,172,60.41Zm78.65,118c-8.19-10.93-16.48-21.77-24.48-32.83-2.05-2.84-3.5-3.14-6.62-1.55-28.73,14.67-57.6,29.08-86.34,43.75-3.12,1.59-5.41,1.47-8.47-.09C96,173.07,67.1,158.63,38.35,144c-2.82-1.43-4.31-1.31-6.27,1.39Q20.08,162,7.55,178.16c-2.07,2.68-2.16,3.76,1,5.56q58.73,33.57,117.28,67.47c2.47,1.43,4.19,1.3,6.52-.1,8.5-5.07,17.13-9.91,25.71-14.85Q203.4,210.13,248.74,184c1.37-.79,3-1.25,3.87-2.82C251.94,180.27,251.28,179.35,250.6,178.45ZM75.43,81.2c-9.88,13.11-19.59,26.33-29.6,39.34-2.16,2.81-2.07,3.83,1.15,5.44q39.6,19.77,79.05,39.84a5.76,5.76,0,0,0,5.84.08q39.67-20.15,79.48-40.05c3.28-1.63,2.74-2.76.91-5.17-9.95-13.06-19.82-26.17-29.47-39.44-2-2.75-3.43-2.69-6.23-1.36-14.49,6.89-29.14,13.44-43.64,20.31a8,8,0,0,1-7.69.07C110.74,93.38,96.13,86.74,81.56,80c-1-.47-2-1-3.23-1.52C76.61,78.43,76.22,80.14,75.43,81.2Z"></path></svg>
                            <span class="fs20 bold dark">Confirm parent category change</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="full-center relative">
                        <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">
                            <h2 class="fs16 dark no-margin">Change parent category</h2>
                            <p class="fs13 no-margin mt4 dark">The following section concerns setting and changing the parent category of the current category.</p>
                            <p class="fs14 dark mt8 mb4 bold">• Category : <span class="blue">{{ $category->title }}</span></p>
                            @if(is_null($category->parent_category_id))
                            <div class="typical-section-style align-center mt8 mb4">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs14 dark no-margin"><em>This category is a <strong>root category</strong> with no ancestors categories</em>.</p>
                            </div>
                            @endif
                            @if(!is_null($category->parent_category_id))
                            <p class="fs14 dark mt8 mb4 bold">• Current parent category : <span class="blue">{{ $category->ancestor->title }}</span></p>
                            @endif
                            <div class="simple-line-separator mx8 my8"></div>
                            <p class="fs13 dark mt8 mb4">Not the right parent category ? Click on selection viewer to change the selected parent category.</p>
                            <div class="flex">
                                <svg class="size10 ml4 mr8 mt8" fill="#848484" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                <p class="fs14 dark mt8 mb4 bold">New parent category : <span class="blue new-selected-category-parent"></span></p>
                            </div>

                            <div class="flex" style="margin-top: 24px">
                                <div id="update-category-parent" class="typical-button-style dark-bs align-center move-to-right" style="padding: 5px 8px;">
                                    <div class="relative size12 mr4">
                                        <svg class="size12 flex icon-above-spinner" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                        <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <div class="fs12 bold white unselectable">{{ __('update parent category') }}</div>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                                    <input type="hidden" class="new-parent-category-id" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete category viewer -->
            <div id="delete-category-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 680px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 10px 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                            <span class="fs20 bold dark">Delete category</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="global-viewer-content-box" style="padding: 14px; min-height: 200px; max-height: 450px">
                        <h2 class="fs16 dark no-margin">Delete "<span class="bold blue">{{ $category->title }}</span>" category</h2>
                        <p class="fs13 no-margin mt4 dark">Before deleting this category, specify the type of deletion below and how subcategories will be handled after. By default, sub-categories will be root categories (If the deleted category has subcategories).</p>
                        <div class="typical-section-style my8">
                            <p class="fs13 dark no-margin">Before deleting the category, all the posts that have only the deleted category <strong>will be attached to 'uncategorized' category</strong>, because a post should have at least one category.</p>
                        </div>
                        <!-- chose the type of deletion -->
                        <div>
                            <p class="dark my8 bold">After deleting the category:</p>
                            <label class="category-delete-item mb4">
                                <input type="radio" name="category-delete-type" checked value="delete-category-only" autocomplete="off" class="no-margin mt2 height-max-content category-delete-type">
                                <div class="ml8">
                                    <p class="bold dark no-margin">Delete category only</p>
                                    <p class="light-gray no-margin mt4 fs13">After deleting this category, all its subcategories (if it has sub-categories) will become roots categories and will not get deleted.</p>
                                </div>
                            </label>
                            <label class="category-delete-item">
                                <input type="radio" name="category-delete-type" value="delete-category-and-subcategories" autocomplete="off" class="no-margin mt2 height-max-content category-delete-type">
                                <div class="ml8">
                                    <p class="bold dark no-margin">Delete category and all its subcategories</p>
                                    <p class="light-gray no-margin mt4 fs13">After the category get deleted, all its subcategories (if it has sub-categories) will be deleted in cascading.</p>
                                </div>
                            </label>
                        </div>
                        <!-- confirmation -->
                        <label class="block" for="delete-category-confirm-input" style="margin-top: 12px">
                            <span class="mb2 bold dark">Confirmation</span>
                            <p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::delete-category::{{ $category->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width styled-input" id="delete-category-confirm-input" style="padding: 8px 10px" placeholder="Delete category confirmation">
                                <input type="hidden" id="delete-category-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::delete-category::{{ $category->slug }}">
                            </div>
                        </label>

                        <div class="flex" style="margin-top: 12px;">
                            <div id="delete-category-button" class="typical-button-style red-bs red-bs-disabled align-center" style="padding: 7px 11px;">
                                <div class="relative size14 mr4">
                                    <svg class="flex size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs12 unselectable">Delete Category</span>
                                <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off"> <!-- set dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="align-center">
                <h1 class="dark fs19 no-margin mb4">• Manage <span class="blue">"{{ $category->title }}"</span> category</h1>
                <span class="fs10 unselectable gray mx8">•</span>
                <a href="{{ route('category.manage') }}" class="blue bold no-underline fs12">Manage other category</a>
            </div>
            <p class="no-margin fs13 dark">Here, you can edit category informations, change its status and manage other stuff.</p>

            <div class="flex" style="margin-top: 12px;">
                <div id="update-category-informations-section" class="height-max-content category-form">
                    <h2 class="dark no-margin mb8">Update Category Informations</h2>
                    <div class="simple-line-separator my8"></div>
                    <x-admin.category.form-inputs :category="$category" action="update" />
                    <!-- update informations button -->
                    <div style="margin-top: 12px">
                        <div id="update-category-informations" class="typical-button-style dark-bs width-max-content align-center">
                            <div class="relative size13 mr4">
                                <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs11 unselectable">Update category informations</span>
                        </div>
                    </div>
                </div>
                <div id="update-category-settings-section" class="height-max-content">
                    <h2 class="no-margin dark">Category Settings</h2>
                    <div class="simple-line-separator my8"></div>
                    <!-- category status -->
                    @php
                        $statuscolor = 'green';
                        if($category->status != 'live') $statuscolor = 'gray';
                    @endphp
                    <div class="align-center mt8 mb4">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M149.78,24c-1.59-11.62,9.08-21.73,20.46-18.55,15.86,4.42,30,12.39,42.71,22.8A127,127,0,0,1,253.15,86c.53,1.53,1,3.09,1.41,4.66a9.31,9.31,0,0,1,.21,1.79c.11,8.12-5.09,15-12.24,17-7.65,2.05-16.12-1.28-19.6-8.13-2.5-4.92-4.19-10.23-6.67-15.15-11.35-22.5-28.86-38.21-52.52-46.94C156.42,36.46,150.94,32.45,149.78,24ZM248,148.15c-5.4-4.34-11.48-4.85-17.87-1.91-5.92,2.72-8,8.16-10.21,13.63-15,36.7-42.39,57.53-81.85,60.65-40.68,3.21-78.94-22.13-93.12-60A93.32,93.32,0,0,1,75.22,53.15c9-7,19.25-11.31,29.53-15.84a16.9,16.9,0,0,0,9.17-22c-3.4-8.5-12.58-12.77-21.8-9.4C47,22.42,18.44,53.84,7.24,100.79c-.75,3.13-.76,6.43-1.63,9.53A25.14,25.14,0,0,1,5.15,114,25.78,25.78,0,0,1,4.76,118a25.93,25.93,0,0,1-.34,4.68v15.2c.06.39.13.77.18,1.16a32.61,32.61,0,0,1,.67,4.11C7.12,149,7.35,155.3,9.1,161.28q15.65,53.25,64.46,79.36a117.93,117.93,0,0,0,37.87,12.64c.36,0,.71,0,1.07,0a28.75,28.75,0,0,1,7.33.94,29,29,0,0,1,5.65.56h.15c.78,0,1.55,0,2.31.1s1.33-.1,2-.1a29.69,29.69,0,0,1,4.76.39h3.77a27,27,0,0,1,5.53-.58l.6,0a1.88,1.88,0,0,1,1.14-.38c30-3,55.54-15.52,76.82-36.63,14.91-14.79,25.81-32.2,31.52-52.55C256,158.17,253.28,152.42,248,148.15Z"/></svg>
                        <p class="no-margin fs14 dark"><span class="bold">Status</span> : <span class="{{ $statuscolor }} bold">{{ $category->status }}</span></p>
                        <span class="fs12 gray mx8">•</span>
                        <div class="relative">
                            <div class="button-with-suboptions typical-button-style white-bs width-max-content align-center">
                                <svg class="size13 icon-above-spinner mr4" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                <span class="bold fs11 unselectable">Change status</span>
                            </div>
                            <div class="suboptions-container typical-suboptions-container category-change-box">
                                <h4 class="fs14 bold dark no-margin">Update category status</h4>
                                <p class="fs13 dark no-margin mt2">The <span class="blue">"{{ $category->title }}"</span> category is currently {{ $category->status }}.</p>
                                <p class="fs13 dark no-margin mt2">Once the status is updated, <strong>all its sub-categories will be updated</strong> as well.</p>
                                @if($category->status == 'awaiting review')
                                <div class="my4 typical-section-style">
                                    <p class="fs13 dark no-margin">Please review its informations and fill it with some content before publish it.</p>
                                </div>
                                @endif
                                <div calss=""></div>
                                <div class="update-category-status category-status-button @if($category->status == 'live') category-status-button-selected @endif mt8">
                                    <input type="hidden" class="status" value="live" autocomplete="off">
                                    <div class="align-center">
                                        <p class="no-margin bold dark">Live</p>
                                        <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>    
                                    <p class="fs12 dark no-margin mt2">The category is accessible to the public If It is live.</p>
                                </div>
                                <div class="update-category-status category-status-button @if($category->status == 'hidden') category-status-button-selected @endif mt4">
                                    <input type="hidden" class="status" value="hidden" autocomplete="off">
                                    <div class="align-center">
                                        <p class="no-margin bold dark">Hidden</p>
                                        <svg class="spinner size12 opacity0 ml4" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <p class="fs12 dark no-margin mt2">If category is hidden, all the content within it as well as all its sub-categories will not be accessible to public.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator mt8 mb4"></div>
                    <!-- render category hierarchy diagram -->
                    <div class="align-center mt8 mb4">
                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"/></svg>
                        <h3 class="fs14 dark no-margin">Category Hierarchy Settings</h3>
                    </div>
                    <div style="margin-left: 12px;">
                        <!-- render hierarchy -->
                        <p class="no-margin fs13 dark my4">The following diagram show the ategory ancestors as well as its direct subcategories.</p>                      
                        @foreach($category_hierarchy as $ch)
                            <div class="flex hierarchy-item" style="margin-left: calc({{ $loop->index }}*12px)">
                                @if(!$loop->first)
                                <svg class="angle-before-hierarchy-item" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                @endif
                                <p class="bold fs12 my4 @if($loop->last) blue @else dark @endif">• {{ $ch->mintitle }}</p>
                            </div>
                            @if($loop->last)
                            <div class="flex hierarchy-item" style="margin-left: calc({{ $loop->index + 1 }}*12px)">
                                <svg class="angle-before-hierarchy-item" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                <div class="mt2">
                                    <span class="default-weight fs11 gray">(direct sub-categories) :@if(!$category->subcategories->count()) 0 sub-categories @endif</span>
                                    <div>
                                        @foreach($category->subcategories as $subcategory)
                                        <p class="bold fs12 my4 dark">• {{ $subcategory->mintitle }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        <div class="simple-line-separator my8"></div>
                        <!-- set/change parent category -->
                        <div class="mt8">
                            @if(is_null($category->parent_category_id))
                            <div>
                                <h3 class="fs14 dark no-margin">Set this category as subcategory</h3>
                                <div class="flex hierarchy-item">
                                    <p class="bold fs12 my4 blue">• {{ $category->mintitle }}</p>
                                </div>
                                <p class="fs13 dark no-margin my4">Right now, this category <strong>is a root category</strong> (does not have a parent). You could make it as sub-category to other category.</p>
                                <div class="align-center space-between mt8">
                                    <div class="align-center open-select-one-category-viewer">
                                        <svg class="size13 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M95.74,74.64c-28,0-56-.07-84,.08-4,0-5.75-.65-5.43-5.15a167.92,167.92,0,0,0,0-18.09c-.11-3.15.52-4.43,4.14-4.42q85.62.18,171.24,0c3.48,0,4.42,1.11,4.28,4.43a131.8,131.8,0,0,0,0,17.44c.48,5.32-1.89,5.82-6.31,5.79-26.92-.18-53.85-.09-80.77-.09Zm84.68,138.23c4.61,0,5.92-1.26,5.61-5.74a163.63,163.63,0,0,1,0-17.44c.13-3.3-.82-4.49-4.3-4.49q-85.62.13-171.24,0c-3.68,0-4.21,1.39-4.1,4.49a133.7,133.7,0,0,1-.05,16.14c-.46,5.35.73,7.22,6.75,7.13,27.56-.41,55.14-.18,82.71-.18C124,212.76,152.2,212.65,180.42,212.87Zm57.83-16.74c4.43-4.4,8.66-9,13.34-13.16,3.08-2.71,2.58-4.26-.12-6.92-14-13.75-27.55-27.91-41.68-41.5-4.06-3.91-3.48-5.78.21-9.36,14.07-13.66,27.72-27.75,41.66-41.53,2.44-2.41,3.1-3.88.2-6.46A169,169,0,0,1,238.59,64c-2.6-2.89-4.07-2.3-6.54.19q-31.17,31.46-62.61,62.64c-2.18,2.17-2.94,3.45-.29,6.07,21.3,21.06,42.42,42.29,63.61,63.47.74.74,1.53,1.43,2.62,2.44C236.43,197.81,237.37,197,238.25,196.13ZM139.15,144c4.13,0,5.78-.92,5.51-5.34-.38-6-.23-12.07,0-18.1.1-3.17-.63-4.6-4.24-4.59q-65,.15-130,0c-3.09,0-4.14.89-4,4,.21,6.25.36,12.53,0,18.75C6,143.14,7.64,144,11.73,144c21.13-.19,42.26-.09,63.39-.09C96.46,143.89,117.8,143.79,139.15,144Z"/></svg>
                                        <span class="blue bold pointer fs13">Selection viewer</span>
                                    </div>
                                    <div id="open-category-parent-confirmation-dialog" class="typical-button-style dark-bs width-max-content flex align-center" style="padding: 5px 8px;">
                                        <input type="hidden" class="current-category-title" value="{{ $category->title }}" autocomplete="off">
                                        <svg class="size12 flex mr4" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                        <div class="fs12 bold white unselectable">{{ __('Confirm parent') }}</div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div>
                                <h3 class="fs14 dark no-margin">Change parent category</h3>
                                <div>
                                    <div class="flex hierarchy-item" style="margin-left: 4px">
                                        <p class="bold fs12 my4 dark">• {{ $category->ancestor->mintitle }}</p>
                                    </div>
                                    <div class="flex hierarchy-item" style="margin-left: 16px">
                                        <svg class="angle-before-hierarchy-item" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                        <p class="bold fs12 my4 blue">• {{ $category->mintitle }}</p>
                                    </div>
                                </div>
                                <p class="fs13 dark no-margin mt4 mb8">You can change the parent category "<strong>{{ $category->ancestor->title }}</strong>" to other category in the selection viewer.</p>
                                <p class="fs13 dark no-margin mt4 mb8">Current parent category : "<span class="bold">{{ $category->ancestor->title }}</span>"</p>
                                <div class="align-center space-between">
                                    <div class="align-center open-select-one-category-viewer">
                                        <svg class="size13 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M95.74,74.64c-28,0-56-.07-84,.08-4,0-5.75-.65-5.43-5.15a167.92,167.92,0,0,0,0-18.09c-.11-3.15.52-4.43,4.14-4.42q85.62.18,171.24,0c3.48,0,4.42,1.11,4.28,4.43a131.8,131.8,0,0,0,0,17.44c.48,5.32-1.89,5.82-6.31,5.79-26.92-.18-53.85-.09-80.77-.09Zm84.68,138.23c4.61,0,5.92-1.26,5.61-5.74a163.63,163.63,0,0,1,0-17.44c.13-3.3-.82-4.49-4.3-4.49q-85.62.13-171.24,0c-3.68,0-4.21,1.39-4.1,4.49a133.7,133.7,0,0,1-.05,16.14c-.46,5.35.73,7.22,6.75,7.13,27.56-.41,55.14-.18,82.71-.18C124,212.76,152.2,212.65,180.42,212.87Zm57.83-16.74c4.43-4.4,8.66-9,13.34-13.16,3.08-2.71,2.58-4.26-.12-6.92-14-13.75-27.55-27.91-41.68-41.5-4.06-3.91-3.48-5.78.21-9.36,14.07-13.66,27.72-27.75,41.66-41.53,2.44-2.41,3.1-3.88.2-6.46A169,169,0,0,1,238.59,64c-2.6-2.89-4.07-2.3-6.54.19q-31.17,31.46-62.61,62.64c-2.18,2.17-2.94,3.45-.29,6.07,21.3,21.06,42.42,42.29,63.61,63.47.74.74,1.53,1.43,2.62,2.44C236.43,197.81,237.37,197,238.25,196.13ZM139.15,144c4.13,0,5.78-.92,5.51-5.34-.38-6-.23-12.07,0-18.1.1-3.17-.63-4.6-4.24-4.59q-65,.15-130,0c-3.09,0-4.14.89-4,4,.21,6.25.36,12.53,0,18.75C6,143.14,7.64,144,11.73,144c21.13-.19,42.26-.09,63.39-.09C96.46,143.89,117.8,143.79,139.15,144Z"/></svg>
                                        <span class="blue bold pointer fs13">Selection viewer</span>
                                    </div>
                                    <div id="open-category-parent-confirmation-dialog" class="typical-button-style dark-bs width-max-content flex align-center" style="padding: 5px 8px;">
                                        <input type="hidden" class="current-category-title" value="{{ $category->title }}" autocomplete="off">
                                        <svg class="size12 flex mr4" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                                        <div class="fs12 bold white unselectable">{{ __('Confirm update') }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- make sub-category as root category -->
                        @if(!is_null($category->parent_category_id))
                        <div class="simple-line-separator my8"></div>
                        <div>
                            <h3 class="fs14 dark no-margin">Set category as root category</h3>
                            <p class="no-margin fs13 dark my4">Right now, "<span class="bold">{{ $category->title }} category</span>" is a sub-category of "<span class="bold">{{ $category->ancestor->title }} category</span>". You can make it a root category</p>
                            <div>
                                <div class="flex hierarchy-item" style="margin-left: 4px">
                                    <p class="bold fs12 my4 dark">• {{ $category->ancestor->mintitle }}</p>
                                </div>
                                <div class="flex hierarchy-item" style="margin-left: 16px">
                                    <svg class="angle-before-hierarchy-item" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                                    <p class="bold fs12 my4 blue">• {{ $category->mintitle }}</p>
                                </div>
                            </div>
                            <div id="set-category-as-root" class="typical-button-style dark-bs width-max-content align-center mt8">
                                <div class="relative size13 mr4">
                                    <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"></path></svg>
                                    <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs11 unselectable">Set category as root category</span>
                                <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="simple-line-separator my8"></div>
                    <!-- delete a category -->
                    <div class="mt8">
                        <div class="align-center">
                            <svg fill='#d23a3a' class="size13 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z"></path></svg>
                            <h3 class="fs15 red no-margin">Delete category</h3>
                        </div>
                        <div class="mt4">
                            <div class="typical-section-style my4">
                                <p class="no-margin fs13 dark">By default, only the current category will be deleted. You can control whether you want to delete only this category and set its subcategories as roots, or delete all its descendants. Click on the delete button below to configure the deletion process.</p>
                            </div>
                            <div id="open-delete-category-viewer" class="typical-button-style red-bs width-max-content align-center mt8" style="padding: 8px 10px;">
                                <svg class="size13 mr4 flex" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"/></svg>
                                <span class="bold fs11 unselectable">Open deletion section</span>
                                <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection