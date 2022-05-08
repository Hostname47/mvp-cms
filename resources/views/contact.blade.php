@extends('layouts.app')

@section('title', 'Fibonashi - Contact')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/contact.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div id="contact-main" class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('contact') }}" class="page-path">
                <span>{{__('Contact')}}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path d="M39.24,33.2c-6.6.76-13.23.18-19.85.34-3.07.07-6.15,0-9.22,0C9,33.52,7.63,34,7,32.6s.68-2.12,1.46-2.93c2.56-2.63,5-5.36,7.78-7.78,1.81-1.6,1.42-2.48-.13-3.89-2.85-2.6-5.51-5.42-8.26-8.15C7.19,9.21,6.55,8.58,7,7.55c.31-.81,1-.88,1.72-.88q14.58,0,29.16,0a8.6,8.6,0,0,1,1.41.22ZM11.66,30.3H34.34c-2.55-2.44-4.6-4.3-6.52-6.29-1.18-1.22-2.14-2.41-3.64-.39a1.28,1.28,0,0,1-2.08.23c-1.89-2.52-3-.67-4.32.6C16,26.23,14.08,28,11.66,30.3ZM33.55,9.92H12.24c3.44,3.45,6.59,6.58,9.7,9.73.62.64,1.09,1,1.88.18C27,16.58,30.14,13.38,33.55,9.92ZM36,27.84V11.51c-2.61,2.76-4.67,5-6.82,7.19C28.4,19.5,27.94,20,29,21,31.37,23.2,33.61,25.49,36,27.84ZM4.55,21.58a12.17,12.17,0,0,0,1.48,0c.8-.1,1.59-.31,1.68-1.32.07-.77-.21-1.47-1-1.5-1.81-.07-3.74-.81-5.34.62A1.06,1.06,0,0,0,1.49,21a2.81,2.81,0,0,0,1.3.59,10.33,10.33,0,0,0,1.76,0Zm5-7.27c0-2.05-2-1.26-3.31-1.4a8.74,8.74,0,0,0-1.77,0A1.42,1.42,0,0,0,3,14.49a1.38,1.38,0,0,0,1.32,1.35c.59.06,1.19,0,2.13,0C7.4,15.63,9.58,16.65,9.52,14.31ZM6.25,27.2a13,13,0,0,0,2.07,0,1.34,1.34,0,0,0,1.25-1.67C9.27,24,8,24.16,7,24.26c-1.37.13-3.13-.76-3.9,1.14-.36.88.27,1.55,1.12,1.75a9.42,9.42,0,0,0,2.06,0Z"></path></svg>
            <h1 class="title-style">{{ __('Contact Us') }}</h1>
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

        @if($limit_reached)
        <div id="limit-message-container">
            <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M404.57,112.64V101.82c0-43.62-40.52-76.69-83-65.55-25.63-49.5-94.09-47.45-118,.75-41.28-10.56-82.41,20.92-82.41,65V228.13A65.45,65.45,0,0,0,59.06,237a67.45,67.45,0,0,0-14.55,93.15l120,168.42A32,32,0,0,0,190.54,512h222.9a32,32,0,0,0,31.18-24.81l30.18-131a203.49,203.49,0,0,0,5.2-45.67V179C480,138.38,444.48,107,404.57,112.64ZM432,310.56a155.71,155.71,0,0,1-4,34.89L400.71,464H198.79L83.59,302.3c-14.44-20.27,15-42.77,29.4-22.6l27.12,38.08c9,12.62,29,6.28,29-9.29V102c0-25.65,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16h6.86a16,16,0,0,0,16-16V67c0-25.66,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16H304a16,16,0,0,0,16-16V101.13c0-25.68,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16h6.85a16,16,0,0,0,16-16V179.69c0-26.24,36.57-25.64,36.57-.69V310.56Z"/></svg>
            <p class="text no-margin">{{ $limit_message }}</p>
        </div>
        <p class="text">{{ __("We have received all your messages, and we will get back to you as soon as possible") }}</p>
        @else
        <p class="text">{{ __("If you have any questions or queries, a member of staff will always be happy to help. Feel free to contact us using the form below and we will be sure to get back to you as soon as possible") }}.</p>
        <p class="text">{{ __("Be clear, thoughtful, and respectful. Make sure the message or feedback you offer is accurate, specific, and is limited only to the behavior in question, suggestion or advice") }}.</p>
        <div class="simple-line-separator my8"></div>
        <div id="contact-form-wrapper">
            <div id="validation-messages"> <!-- collection of validation messages -->
                <input type="hidden" id="firstname-required" value="{{ __('firstname is required') }}" autocomplete="off">
                <input type="hidden" id="lastname-required" value="{{ __('lastname is required') }}" autocomplete="off">
                <input type="hidden" id="email-required" value="{{ __('email is required') }}" autocomplete="off">
                <input type="hidden" id="email-invalide" value="{{ __('Invalide email address') }}" autocomplete="off">
                <input type="hidden" id="message-required" value="{{ __('Message required') }}" autocomplete="off">
                <input type="hidden" id="message-length-error" value="{{ __('Message should contain at least 10 characters') }}" autocomplete="off">
            </div>
            
            <div class="informative-message-container align-center none relative my8" id="contact-error-container">
                <div class="informative-message-container-left-stripe imcls-red"></div>
                <div class="no-margin fs13 error message-text"></div>
                <div class="close-parent close-informative-message-style">✖</div>
            </div>

            <div class="full-width align-center">
                <div class="mr8 half-width">
                    <label for="firstname" class="label">{{ __('Firstname') }}<span class="ml4 err red none fs12">*</span></label>
                    <input type="text" id="firstname" class="styled-input" autocomplete="off" maxlength="60" placeholder='{{ __("Your firstname") }}' value="@auth {{ auth()->user()->firstname }} @endauth" @auth disabled @endauth>
                </div>
                <div class="half-width">
                    <label for="lastname" class="label">{{ __('Lastname') }}<span class="ml4 err red none fs12">*</span></label>
                    <input type="text" id="lastname" class="styled-input" autocomplete="off" maxlength="60" placeholder='{{ __("Your lastname") }}' value="@auth {{ auth()->user()->lastname }} @endauth" @auth disabled @endauth>
                </div>
            </div>
            <div style="margin: 12px 0">
                <label for="contact-email" class="label">{{ __('Email') }}<span class="ml4 err red none fs12">*</span></label>
                <input type="text" id="contact-email" class="styled-input" autocomplete="off" maxlength="400" placeholder='{{ __("Your email") }}' value="@auth {{ auth()->user()->email }} @endauth" @auth disabled @endauth>
            </div>
            <div>
                <label for="message" class="label">{{ __('Message') }} <span class="ml4 err red none fs12">*</span></label>
                <p class="fs12 no-margin mb4 gray">{{ __('Be specific and clear. Make sure the feedback or message you offer is accurate') }}</p>
                <textarea id="message" class="no-textarea-x-resize styled-input" autocomplete="off" maxlength="4000" spellcheck="false" autocomplete="off" placeholder="{{ __('Your message content here') }}"></textarea>
            </div>

            <div class="flex">
                <div class="typical-button-style dark-bs align-center" id="contact-send-message">
                    <div class="relative size13 mr6">
                        <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"></path></svg>
                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12 unselectable">{{ __('Submit message') }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection