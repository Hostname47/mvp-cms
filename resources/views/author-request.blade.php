@extends('layouts.app')

@section('title', 'Fibonashi - Author Request')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/discover.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    @include('partials.viewers.newsletter-viewer')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('author-request') }}" class="page-path">
                <span>{{__('Author request')}}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="size22 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
            <h1 class="title-style">{{ __('Author Request') }}</h1>
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
    </div>
@endsection