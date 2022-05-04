@extends('layouts.app')

@section('title', 'Fibonashi - Search')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/search.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding flex">
        <div id="search-main">
            <!-- path -->
            <div class="page-path-wrapper align-center">
                <a href="{{ route('root.slash') }}" class="align-center page-path">
                    <span>{{__('Home')}}</span>
                </a>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
                <a href="{{ route('search') }}" class="page-path">
                    <span>{{__('Search')}}</span>
                </a>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
                <a href="{{ route('search.authors') }}" class="page-path">
                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.94,20.56c29.51,0,59,.13,88.54-.06,11.44-.08,20.42,3.77,25.2,14.52s1.34,20-6.35,28.39q-37.17,40.53-73.93,81.44a14.13,14.13,0,0,0-3.25,8.42c-.34,13.59-.26,27.19-.1,40.78a12.25,12.25,0,0,1-4.91,10.65c-13.35,10.5-26.59,21.15-39.84,31.79-3.11,2.49-6.31,4.06-10.32,2.18-4.18-2-5.13-5.49-5.12-9.74.06-25,0-50.08.11-75.12a12.83,12.83,0,0,0-3.65-9.52q-37.87-41.35-75.47-83C7.63,46.63,14.86,24.7,33.92,21a39.63,39.63,0,0,1,7.48-.41Q85.67,20.54,129.94,20.56Z"></path></svg>
                    <span>{{__('Advanced search')}}</span>
                </a>
            </div>
            <!-- session message/errors containers -->
            @if(Session::has('message'))
                <div class="informative-message-container align-center relative my8">
                    <div class="informative-message-container-left-stripe imcls-green"></div>
                    <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
            @endif
            @if(Session::has('errors'))
                <div class="informative-message-container align-center relative my8">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <div class="no-margin fs13 message-text">{!! Session::get('errors')->first() !!}</div>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="informative-message-container align-center relative my8">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <div class="no-margin fs13 message-text">{!! Session::get('error') !!}</div>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
            @endif
            <div class="align-center mb8">
                <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.94,20.56c29.51,0,59,.13,88.54-.06,11.44-.08,20.42,3.77,25.2,14.52s1.34,20-6.35,28.39q-37.17,40.53-73.93,81.44a14.13,14.13,0,0,0-3.25,8.42c-.34,13.59-.26,27.19-.1,40.78a12.25,12.25,0,0,1-4.91,10.65c-13.35,10.5-26.59,21.15-39.84,31.79-3.11,2.49-6.31,4.06-10.32,2.18-4.18-2-5.13-5.49-5.12-9.74.06-25,0-50.08.11-75.12a12.83,12.83,0,0,0-3.65-9.52q-37.87-41.35-75.47-83C7.63,46.63,14.86,24.7,33.92,21a39.63,39.63,0,0,1,7.48-.41Q85.67,20.54,129.94,20.56Z"></path></svg>
                <h1 class="title-style">{{__('Advanced Search')}}</h1>
            </div>
            <p class="mt4">{{ __('Search for posts using the following filters to get accurate results') }}.</p>

            <div class="filter-box categories-filter">
                <div class="align-center">
                    <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M83.38,179.88V144.5a2.58,2.58,0,0,0-2.58-2.57H16.35a2.57,2.57,0,0,1-2.57-2.57V121.1a2.57,2.57,0,0,1,2.57-2.57h64.1A2.57,2.57,0,0,0,83,116V80.52a2.57,2.57,0,0,1,4.39-1.82l49.81,50a2.56,2.56,0,0,1,0,3.62L87.76,181.7A2.57,2.57,0,0,1,83.38,179.88ZM246,94.71V72.29H142V94.71Zm-104,70.6v22.4H246.22v-22.4Zm34.89-24h69.13V118.57H176.93Z"></path></svg>
                    <span class="filter-title">{{ __('Select category(s) that you want to search in') }} :</span>
                </div>

                <div class="toggle-box selected-categories-for-search">
                    <div class="align-center toggle-button pointer">
                        <svg class="size14 mr6" style="margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
                        <h3 class="no-margin unselectable fs14 dark">Categories</h3>
                        <svg class="size7 ml8 mt2 toggle-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/></svg>
                    </div>
                    <div class="categories-wrapper toggle-container all none">
                        <div class="category-container">
                            <div class="align-center">
                                <input type="checkbox" id="category-input-all" class="category" value="0" autocomplete="off">
                                <label for="category-input-all" class="unselectable">{{ __('all categories') }}</label>
                            </div>
                        </div>
                        <div class="simple-line-separator my4" style="background-color: #d4dbe1;"></div>
                        <div class="categories">
                            @foreach($categories as $category)
                                <x-search.advanced.category :category="$category" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection