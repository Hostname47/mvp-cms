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
                <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.51,206.37a4,4,0,0,1,4.71.52c.53.49,1.06,1,1.58,1.51l31.93,31.92a12.14,12.14,0,0,0,16.88.27q5.79-5.42,11.39-11a12.9,12.9,0,0,0,0-18.26q-15.63-15.52-31.31-31c-.29-.28-1.11-1-1.43-1.28a4,4,0,0,1-1-5.25,110.15,110.15,0,0,0,14.58-38.92C229.44,85,195.67,32.54,146.6,20c-6.25-1.59-12.65-2.62-19-3.89L110,16.32c-9.55,2.24-19.51,3.5-28.44,7.22C43,39.57,20.4,68.72,16.72,110.23c-3.59,40.5,12.55,73.32,46.85,95.2,35.87,22.89,73.09,22.32,109.92.95Zm-55-24.64c-35.1-.71-62.94-29.43-62.06-64,.86-34.23,29.56-62,63.37-61.24,34.61.74,62.59,29.41,61.78,63.29C180.72,154.6,152.4,182.42,118.46,181.73Z"></path></svg>
                <h1 class="title-style">{{__('Authors Search')}}</h1>
            </div>
            
            <!-- search component -->

            @if($k)
                <p class="search-result-query-text">{{__('Authors search results for')}} "<span class="blue unselectable">{{ $k }}</span>"</p>
            @endif
            
            <div class="simple-line-separator my12"></div>

            <div id="authors-section">
                <div class="align-center">
                    <svg class="size16 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
                    <h3 class="search-resource-title">{{ __('Authors') }} <span class="count">({{ $authors->total() }})</span></h3>
                </div>
                @foreach($authors as $author)
                <div class="author-component">
                    <a href="" class="flex mr6">
                        <img src="{{ $author->avatar(100) }}" class="author-avatar" alt="">
                    </a>
                    <div>
                        <span class="name"><a href="" class="blue no-underline">{{ $author->fullname }}</a> - <span class="posts-count">({{ $author->posts()->count() . ' ' . __('posts') }})</span></span>
                        <span class="username">{{ '@' . $author->username }}</span>
                    </div>
                </div>
                @endforeach
                @if(!$authors->count())
                    <p class="italic light-gray fs13 no-margin ml4" style="margin-top: 1px;">{{ __('No authors found') }}</p>
                @endif
                @if($hasmore)
                <a href="" id="authors-see-more">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.52,227.47q-33.72,0-67.45,0c-18.09,0-29.55-11.5-29.55-29.56V63c0-19.39,11.1-30.48,30.49-30.48q67,0,134,0c19.41,0,30.48,11.08,30.49,30.49q0,67.7,0,135.38c0,17.41-11.61,29-29.08,29.07C175.43,227.51,152.48,227.47,129.52,227.47Zm82.76-65.05c.08-1.79.19-3.17.19-4.55q0-47.79,0-95.58c0-10.11-4.74-14.77-15-14.77q-67.47,0-134.94,0c-10.4,0-15,4.68-15,15.22q0,47.33,0,94.65c0,1.64.14,3.28.21,5ZM47.52,177.68c0,6.68,0,12.9,0,19.11C47.53,208,52,212.47,63,212.47H169.86c9.84,0,19.68.07,29.52,0,6.41-.07,11.82-3.43,12.38-9.25.82-8.4.21-16.94.21-25.52Zm68.64-92.07c-4-3.89-8.34-4.1-11.54-.74-3,3.12-2.68,7.52.94,11.22q9,9.19,18.21,18.22c4.37,4.3,8.11,4.29,12.55-.06q9-8.85,17.89-17.89c3.84-3.9,4.2-8.4,1.09-11.57-3.35-3.41-7.61-3-11.87,1.23s-8.52,8.69-13.36,13.64C125.13,94.66,120.7,90.07,116.16,85.61Z" style="stroke-miterlimit:10;stroke-width:6px"></path></svg>
                    {{ __('See more authors') }}
                </a>
                @endif
            </div>
        </div>
    </div>
@endsection