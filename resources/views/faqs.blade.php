@extends('layouts.app')

@section('title', 'Fibonashi - FAQs')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/faqs.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/faqs.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel page="faqs" />
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
        <div class="simple-line-separator" style="margin: 26px 0;"></div>
        <!-- error container -->
        <div class="informative-message-container align-center none relative my8" id="faqs-error-container">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <div class="no-margin fs13 error message-text"></div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>

        <!-- send a question -->
        <h2 id="send-faq-title">{{ __("Your question does not exist ? Ask your question below") }}</h2>
        <p class="sub-title">{{ __("If your question does not exist within the faqs above, feel free to ask your quezstion in the form below and we'll responde to your question as soon as possible") }}.</p>
        <div id="send-faq-form">
            <input type="hidden" id="question-required" value="{{ __('Question field is required') }}">
            <input type="hidden" id="question-length-error" value="{{ __('Question must contain at least 10 characters') }}">

            <div class="my8 error-container faqs-error-container none">
                <div class="flex">
                    <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(68, 5, 5)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <span class="dark-red fs13 bold no-margin faqs-error"></span>
                </div>
            </div>
            <div class="my12">
                <label for="question" class="label">{{ __('Question') }}</label>
                <input type="text" id="question" class="styled-input" maxlength="500" autocomplete="off" placeholder='{{ __("Your question") }}'>
            </div>
            <div>
                <label for="description" class="label">{{ __('Description of your question') }} <span class="fs11 dark default-weight ml4">({{__('optional')}})</span></label>
                <textarea id="description" class="styled-input" maxlength="1000" autocomplete="off" placeholder="{{ __('More informations about your question') }}"></textarea>
            </div>
            <div class="flex my12" style="margin-bottom: 28px">
                <div class="typical-button-style dark-bs align-center @auth faq-send-button @else dark-bs-disabled login-required @endauth">
                    <div class="relative size14 mr4">
                        <svg class="size14 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"></path></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12 unselectable" style="margin-top: 1px">{{ __('Submit Question') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection