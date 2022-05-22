@extends('layouts.app')

@section('title', 'Fibonashi - Contact')

@push('scripts')
<script src="{{ asset('js/ckeditor.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/admin/post/manage.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/author/right-panel.css') }}">
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <!-- page path -->
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('author.dashboard' ) }}" class="page-path">
                <span>{{ __('Author area') }}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('author.create.post' ) }}" class="page-path">
                <span>{{ __('Create a post') }}</span>
            </a>
        </div>
        <!-- title -->
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
            <h1 class="title-style">{{ __('Create a post') }}</h1>
        </div>

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

        <x-admin.post.post-form />
        <div id="post-management-panel">
            
        </div>
    </div>
@endsection