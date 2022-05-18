@extends('layouts.app')

@section('title', 'Fibonashi - Activate your account')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/settings.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel page="user-section" subpage="settings" />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('contact') }}" class="page-path">
                <span>{{__('account activation')}}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
            <h1 class="title-style">{{ __('Activate your account') }}</h1>
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

            <div id="activation-error-container" class="informative-message-container align-center error-container relative none my8">
                <div class="informative-message-container-left-stripe imcls-red"></div>
                <div class="no-margin fs13 message-text"></div>
                <div class="close-parent close-informative-message-style">✖</div>
            </div>

            <p class="my8 lh15">{{ __("Your account is currently deactivated and all your resources and activities are hidden from public until you activate it again. You cannot access any page until your account get activated again.") }}</p>
            <p class="my8 lh15">{{ __("Please, enter your current password and confirm your activation") }}.</p>

            <div class="my12">
                <label for="activate-password" class="label">{{ __('Current password') }}</label>
                <input type="password" class="styled-input" id="activate-password" autocomplete="new-password" placeholder="{{ __('Your current password') }}">
            </div>
            <div class="my12">
                <label for="activate-account-confirm-input" class="label">{{__('Confirmation')}}</label>
                <p class="no-margin mb4 dark">{{__('Please type')}} <strong>{{ $user->username }}::{{ __('activate-account') }}</strong> {{__('to confirm')}}.</p>
                <div>
                    <input type="text" autocomplete="off" class="styled-input" id="activate-account-confirm-input" style="padding: 8px 10px" placeholder="{{__('confirmation')}}">
                    <input type="hidden" id="activate-account-confirm-value" autocomplete="off" value="{{ $user->username }}::{{ __('activate-account') }}">
                </div>
            </div>

            <div id="activate-account" class="typical-button-style green-bs green-bs-disabled align-center width-max-content my12">
                <div class="relative size14 mr4">
                    <svg class="size14 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M143.07,255.58H115.63c-1.47-1.93-3.77-1.5-5.71-1.8A115.72,115.72,0,0,1,68.3,239c-34.6-20.48-56-50.43-61.72-90.34-6.69-47,8.7-86.63,45.66-116.2C89.37,2.76,131.66-3.41,176.08,13.73c38.41,14.82,63.1,43.15,75,82.64,2,6.63,2,13.66,4.7,20.07v28.42c-1.92.89-1.35,2.86-1.55,4.26A110.34,110.34,0,0,1,247,175.93q-23.64,57.1-82.86,74.95C157.2,253,149.88,253.09,143.07,255.58ZM130.61,32.19c-53.67-.25-97.8,43.5-98.28,97.44-.48,53.76,43.66,98.25,97.72,98.5,53.67.26,97.8-43.49,98.28-97.44C228.81,76.94,184.67,32.45,130.61,32.19Z"/><path d="M157.75,130.06a27.42,27.42,0,1,1-27.52-27.31A27.63,27.63,0,0,1,157.75,130.06Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs12" style="margin-top: 1px">{{ __('Activate account') }}</span>
            </div>
        </div>
    </div>
@endsection