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

            @if(is_null($k))
            <div class="full-center">
                <div id="init-search-container">
                    <div class="align-center mb8">
                        <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.51,206.37a4,4,0,0,1,4.71.52c.53.49,1.06,1,1.58,1.51l31.93,31.92a12.14,12.14,0,0,0,16.88.27q5.79-5.42,11.39-11a12.9,12.9,0,0,0,0-18.26q-15.63-15.52-31.31-31c-.29-.28-1.11-1-1.43-1.28a4,4,0,0,1-1-5.25,110.15,110.15,0,0,0,14.58-38.92C229.44,85,195.67,32.54,146.6,20c-6.25-1.59-12.65-2.62-19-3.89L110,16.32c-9.55,2.24-19.51,3.5-28.44,7.22C43,39.57,20.4,68.72,16.72,110.23c-3.59,40.5,12.55,73.32,46.85,95.2,35.87,22.89,73.09,22.32,109.92.95Zm-55-24.64c-35.1-.71-62.94-29.43-62.06-64,.86-34.23,29.56-62,63.37-61.24,34.61.74,62.59,29.41,61.78,63.29C180.72,154.6,152.4,182.42,118.46,181.73Z"></path></svg>
                        <h1 class="title-style">{{__('Search')}}</h1>
                    </div>
                    <span>{{ __('Search for posts, authors, tags.. etc') }}</span>
                    <form action="{{ route('search') }}" id="init-search-inputs-container" class="relative">
                        <svg class="absolute size14" fill="#5b5b5b" style="top: 13px; left: 13px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                        <input type="text" name="k" required id="init-search-input" autocomplete="off" placeholder="{{ __('search for posts') }}">
                        <button id="init-search-button">
                            <svg id="init-search-button-icon" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                            <span>search</span>
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="align-center mb8">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.51,206.37a4,4,0,0,1,4.71.52c.53.49,1.06,1,1.58,1.51l31.93,31.92a12.14,12.14,0,0,0,16.88.27q5.79-5.42,11.39-11a12.9,12.9,0,0,0,0-18.26q-15.63-15.52-31.31-31c-.29-.28-1.11-1-1.43-1.28a4,4,0,0,1-1-5.25,110.15,110.15,0,0,0,14.58-38.92C229.44,85,195.67,32.54,146.6,20c-6.25-1.59-12.65-2.62-19-3.89L110,16.32c-9.55,2.24-19.51,3.5-28.44,7.22C43,39.57,20.4,68.72,16.72,110.23c-3.59,40.5,12.55,73.32,46.85,95.2,35.87,22.89,73.09,22.32,109.92.95Zm-55-24.64c-35.1-.71-62.94-29.43-62.06-64,.86-34.23,29.56-62,63.37-61.24,34.61.74,62.59,29.41,61.78,63.29C180.72,154.6,152.4,182.42,118.46,181.73Z"></path></svg>
                <h1 class="title-style">{{__('Search')}}</h1>
            </div>
            <p class="dark fs16 bold my8">{{__('Search results for')}} "<span class="blue unselectable">{{ $k }}</span>"</p>
            @endif
        </div>
    </div>
@endsection