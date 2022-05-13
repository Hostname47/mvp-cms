@extends('layouts.app')

@section('title', 'Fibonashi - profile settings')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/settings.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('account.settings') }}" class="page-path">
                <span>{{ __('account settings') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
            <h1 class="title-style">Account Settings</h1>
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
        <div id="settings-box">
            <input type="hidden" id="password-required-error" value="{{ __('Password field is required') }}" autocomplete="off">
            <input type="hidden" id="password-length-error" value="{{ __('The password must contain at least 8 characters') }}" autocomplete="off">
            <input type="hidden" id="password-confirmation-error" value="{{ __('The password confirmation should match password value') }}" autocomplete="off">

            @include('partials.settings.settings-links', ['page'=>$page])

            <!-- Deactivating account -->
            <div id="account-deactivation-box" class="my12">
                <!-- accoun deactivation error container -->
                <div class="informative-message-container align-center error-container relative none my8">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <div class="no-margin fs13 message-text"></div>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>

                <div class="align-center" style="margin-top: 16px">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                    <h2 class="no-margin dark fs18">{{__('Account deactivation')}}</h2>
                </div>
                <p class="my8 lh15">{{ __("By deactivating your account, all your activities and everything belongs to you will be hidden from public, and you (and anyone else) will not be able to access your account until you activate it again") }}.</p>
                @if(is_null($user->password))
                <div class="typical-section-style flex my8">
                    <svg class="size14 mt2 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <p class="no-margin fs13 lh15">{{ __("Deactivating account require your account to have an associated password to confirm and make sure you are the one who take this action") }}. <a href="{{ route('password.settings') }}" class="blue bold fs12 no-underline">{{ __('Click here') }}</a> {{ __('to create a password for your account') }}</p>
                </div>
                @else
                <div id="deactivate-account-container">
                    <div class="my12">
                        <label for="deactivate-password" class="label">{{ __('Current password') }}</label>
                        <input type="password" class="styled-input" id="deactivate-password" autocomplete="new-password" placeholder="{{ __('Your current password') }}">
                    </div>
                    <!-- confirmation -->
                    <div class="my12">
                        <label for="deactivate-account-confirm-input" class="label">{{__('Confirmation')}}</label>
                        <p class="no-margin mb4 dark">{{__('Please type')}} <strong>{{ $user->username }}::{{ __('deactivate-account') }}</strong> {{__('to confirm')}}.</p>
                        <div>
                            <input type="text" autocomplete="off" class="styled-input" id="deactivate-account-confirm-input" style="padding: 8px 10px" placeholder="{{__('confirmation')}}">
                            <input type="hidden" id="deactivate-account-confirm-value" autocomplete="off" value="{{ $user->username }}::{{ __('deactivate-account') }}">
                        </div>
                    </div>
                    <div id="deactivate-account" class="typical-button-style dark-bs dark-bs-disabled align-center width-max-content mt8">
                        <div class="relative size14 mr4">
                            <svg class="size12 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12 unselectable">{{ __('Deactivate account') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection