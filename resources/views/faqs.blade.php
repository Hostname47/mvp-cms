@extends('layouts.app')

@section('title', 'Fibonashi - Contact')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/faqs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/faqs.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div id="contact-main" class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('faqs') }}" class="page-path">
                <span>{{__('Faqs')}}</span>
            </a>
        </div>
        <div class="align-center space-between">
            <div class="align-center">
                <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M316,71a74.93,74.93,0,0,0-60,30.05,74.93,74.93,0,0,0-60-30H0V381H21v60H491V381h21V71ZM51,411V381H196a45.07,45.07,0,0,1,42.42,30Zm190-45a74.59,74.59,0,0,0-45-15H30V101H196a45.05,45.05,0,0,1,45,45ZM359,101h50V203.73l-25-12.5-25,12.5ZM461,411H273.58A45.06,45.06,0,0,1,316,381H461Zm21-60H316a74.59,74.59,0,0,0-45,15V146a45.05,45.05,0,0,1,45-45h13V252.27l55-27.5,55,27.5V101h43ZM139,139a45.05,45.05,0,0,0-45,45h30a15,15,0,1,1,15,15H124v50h30V226.43A45,45,0,0,0,139,139ZM124,279h30v30H124Z"/></svg>
                <h1 class="title-style">{{ __('Faqs') }}</h1>
            </div>
            {{ $faqs->onEachSide(0)->links() }}
        </div>
        <p id="sub-title">{{ __('Top frequently asked questions') }}</p>

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

        @foreach($faqs as $faq)
        <div class="faq-component">
            <div class="question-container">
                <svg class="question-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119.08,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.88,199.88,0,0,1,256,456ZM363.24,200.8c0,67.05-72.42,68.08-72.42,92.86V300a12,12,0,0,1-12,12H233.18a12,12,0,0,1-12-12v-8.66c0-35.74,27.1-50,47.58-61.51,17.56-9.85,28.32-16.55,28.32-29.58,0-17.25-22-28.7-39.78-28.7-23.19,0-33.9,11-49,30a12,12,0,0,1-16.66,2.13l-27.83-21.1a12,12,0,0,1-2.64-16.37C184.85,131.49,214.94,112,261.79,112,310.86,112,363.24,150.3,363.24,200.8ZM298,368a42,42,0,1,1-42-42A42,42,0,0,1,298,368Z"/></svg>
                <p class="question bold">{{ __($faq->question) }}</p>
                <svg class="faq-toggle-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 350"><path d="M192,271.31l136-136a23.9,23.9,0,0,0,.1-33.8.94.94,0,0,1-.1-.1l-22.6-22.6a23.9,23.9,0,0,0-33.8-.1l-.1.1L175,175.11,78.6,78.7a23.91,23.91,0,0,0-33.8-.1l-.1.1L22,101.3a23.9,23.9,0,0,0-.1,33.8l.1.1,136,136a23.94,23.94,0,0,0,33.84.26l.16-.16Z"/></svg>
            </div>
            <div class="answer-container none">
                <svg class="answer-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <p class="answer">{!! __($faq->answer) !!}</p>
            </div>
        </div>
        @endforeach
    </div>
@endsection