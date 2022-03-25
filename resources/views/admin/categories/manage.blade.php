@extends('layouts.admin')

@section('title', 'Admin - manage categories')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.categories', 'subpage'=>'admin.categories.manage'])
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/simplemde.js') }}" defer></script>
<script src="{{ asset('js/admin/category/category.js') }}" defer></script>
<script src="{{ asset('js/admin/category/manage.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"></path></svg>
            <h1 class="fs20 dark no-margin">Manage Categories</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span class="fs13 bold">{{ __('Home') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage Categories') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        @if(Session::has('message'))
        <div class="flex">
            <div class="informative-message-container flex align-center relative my8">
                <div class="informative-message-container-left-stripe imcls-green"></div>
                <p class="no-margin fs13 bold">{!! Session::get('message') !!}</p>
                <div class="close-parent close-informative-message-style">✖</div>
            </div>
        </div>
        @endif

        @if(is_null($category))
            <style>
                .hierarchy-category-wrapper {
                    padding: 6px 4px;
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
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #1f2324;
                    fill: white;
                    border-radius: 4px;
                    margin-left: 8px;
                    padding: 1px;
                }

                .angle-before-subcategories-box {
                    height: 12px;
                    width: 12px;
                    position: absolute;
                    left: -24px;
                    top: 0px;
                }
            </style>
            <h1 class="dark fs19 no-margin mb4">Manage a category</h1>
            <p class="dark no-margin fs13 mb4">Click on a category from the following hierarchy to configure.</p>
            <div class="typical-section-style my4">
                <p class="dark no-margin fs13 mb4">The number before every category is the priority order of categories that is used to order categories in the client side. You can update it to change the order of categories or subcategories by clicking on arrage first and then update.</p>
            </div>
            <div class="flex align-center">
                <h2 class="dark fs14 no-margin mb4 mr8">Categories hierarchy :</h2>
                <div class="flex align-center">
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
            <!-- initialize viewer with one deep level and then admin click to expend subcategories -->
            <x-admin.category.hierarchy.click-selection.subcategories-level :categories="$categories" :route="route('category.manage')"/>
            @else
            <div class="typical-section-style flex align-center mt8">
                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="fs12 dark no-margin">This blog website has no categories for the moment. Please create a new one in create category page.</p>
            </div>
            @endif
        @else
        @endif
    </div>
</main>
@endsection