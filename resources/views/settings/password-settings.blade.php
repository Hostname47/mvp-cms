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
            <a href="{{ route('password.settings') }}" class="page-path">
                <span>{{ __('password settings') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
            <h1 class="title-style">Password Settings</h1>
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

        <div class="informative-message-container align-center error-container relative none my8">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <div class="no-margin fs13 message-text"></div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>

        <div id="settings-box">
                <input type="hidden" id="password-required-error" value="{{ __('Password fields are required') }}" autocomplete="off">
                <input type="hidden" id="password-length-error" value="{{ __('The password must contain at least 8 characters') }}" autocomplete="off">
                <input type="hidden" id="password-confirmation-error" value="{{ __('The password confirmation should match password value') }}" autocomplete="off">

            @include('partials.settings.settings-links', ['page'=>$page])

            @if(is_null($user->password))
                <div class="typical-section-style mb8">
                    <p class="no-margin dark lh15">{{ __("You are currently logged in using :oauth_provider service, and your account has no associated password. You can attach a new password to your account using the form below", ['oauth_provider'=>$user->provider]) }}.</p>
                </div>
                <p class="no-margin dark mb8 lh15"><strong>{{ __('Your email') }} :</strong> {{ $user->email }}</p>
                <p class="no-margin dark mb8 lh15">{{ __("For now, the only way you can log in is to use your social login because you are not associating any password to this account. However, If you create a new password, you will be able to login using your email and password") }}.</p>

                <!-- set password box -->
                <div>
                    <h2 class="dark no-margin fs18">{{ __('Create a password for your account') }}</h2>
                    <p class="fs13 gray mt2 mb8">{{ __('Enter the password you want to attach to this account') }}.</p>
                    <div>
                        <label for="password" class="label">{{ __('Password') }}</label>
                        <input type="password" class="styled-input" id="password" autocomplete="new-password" placeholder="{{ __('Your password') }}">
                    </div>
                    <div style="margin-top: 14px;">
                        <label for="password_confirmation" class="label">{{ __('Confirm password') }}</label>
                        <input type="password" class="styled-input" id="password_confirmation" autocomplete="new-password" placeholder="{{ __('Confirm your password') }}">
                    </div>
                    <div class="typical-section-style my4">
                        <p class="fs13 gray no-margin lh15">{{ __("Please remember your password after setting it, because some actions require your current password like password update. We don't have email service available for now to reset passwords and if you forget the password, then the only way to login is to use your social login") }}.</p>
                    </div>
                    <div id="set-password" class="typical-button-style dark-bs align-center width-max-content" style="margin-bottom: 24px;">
                        <div class="relative size14 mr4">
                            <svg class="size12 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12" style="margin-top: 1px">{{ __('Set password') }}</span>
                    </div>
                </div>
            @else
                <p class="no-margin mb8 dark lh15">{{ __('If you forgot your password, unfortunately you will not be able to change the password, because we do not have password reset functionality available at this moment. However you still be able to login using your :oauth_provider account', ['oauth_provider'=>$user->provider]) }}.</p>

                <div class="typical-section-style flex mb8">
                    <svg class="size14 mr8 mt2" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size14 mr8"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
                    <p class="no-margin fs13 dark lh15">{{ __("The reason we cannot restore forgotten password is because we are not currently using any email service to send email verification to account owner. We'll add this feature as soon as we can to make password reset much easier and secured") }}.</p>
                </div>

                <p class="no-margin mb8 fs13 dark lh15"><strong>{{__('Your email')}} :</strong> {{ $user->email }}</p>
                <h2 class="dark no-margin fs18">{{ __('Change Password') }}</h2>
                <div class="my12">
                    <label for="current-password" class="label">{{ __('Current password') }}</label>
                    <input type="password" class="styled-input" id="current-password" autocomplete="new-password" placeholder="{{ __('Current password') }}">
                </div>
                <div class="my12">
                    <label for="new-password" class="label">{{ __('New password') }}</label>
                    <input type="password" class="styled-input" id="new-password" autocomplete="new-password" placeholder="{{ __('Enter your new password') }}">
                </div>
                <div class="my12">
                    <label for="new-password-confirmation" class="label">{{ __('Confirm new password') }}</label>
                    <input type="password" class="styled-input" id="new-password-confirmation" autocomplete="new-password" placeholder="{{ __('Confirm your new password') }}">
                </div>
                <div class="typical-section-style my12">
                    <p class="fs13 gray no-margin lh15">{{ __("Please remember your password after updating it, because some actions require your current password to be done. We don't have email service available for now to reset passwords and if you forget the password, then the only way to login is to use your social login") }}.</p>
                </div>
                <div id="change-password" class="typical-button-style dark-bs align-center width-max-content" style="margin-bottom: 24px;">
                    <div class="relative size14 mr4">
                        <svg class="size12 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12">{{ __('Change password') }}</span>
                </div>
            @endif
        </div>
    </div>
@endsection