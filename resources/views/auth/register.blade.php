@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/auth.js') }}" defer></script>
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div id="auth-section" class="full-center">
    <div id="typical-register-notice-viewer" class="global-viewer full-center none">
        <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
        <div class="viewer-box-style-1">
            <div class="full-center light-gray-border-bottom relative border-box" style="padding: 14px;">
                <div class="flex align-center mt2">
                    <svg class="size14 mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M113.53,3.53c-1.24-.19-2.69.41-3.77-.56a36.31,36.31,0,0,1-4.49-.34H92.81a17.18,17.18,0,0,1-3,.27c-.32,0-.63,0-1,0s-.61,0-.92,0h-.11c-4.53,1-9.1,1.81-13.51,3.17C34.79,18.27,11.43,44.89,4,85.59c-.1.55.09,1.25-.22,1.74a22.72,22.72,0,0,1-.21,2.32,24,24,0,0,1-.35,3c0,.61,0,1.23-.1,1.85V109c.25.9.47,1.83.65,2.79.93,2.27.88,4.78,1.39,7.13a96.65,96.65,0,0,0,99.7,76.58C152,193,190.75,156.11,195.5,109.25,200.76,57.4,165.14,11.5,113.53,3.53ZM99.16,171.46A72.36,72.36,0,1,1,172,99.28,72.42,72.42,0,0,1,99.16,171.46ZM111.68,81c0,5.89.06,11.78,0,17.67-.09,7.23-5.38,12.58-12.22,12.49-6.67-.09-11.83-5.42-11.87-12.47q-.09-17.67,0-35.35c0-7.24,5.34-12.56,12.21-12.47,6.68.09,11.79,5.4,11.88,12.45C111.74,69.21,111.68,75.11,111.68,81ZM99.79,147.33a12.05,12.05,0,1,1,11.88-12A12.16,12.16,0,0,1,99.79,147.33Z"/></svg>
                    <span class="flex align-center global-viewer-title">{{ __("Usual registration not supported") }}</span>
                </div>
                <div class="pointer fs20 close-global-viewer unselectable absolute" style="right: 16px">✖</div>
            </div>
            <div class="full-center relative">
                <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 120px; max-height: 358px">
                    <h3 class="fs14 dark no-margin">{{__('Reason for not allowing usual registration method')}}</h3>
                    <p class="my8 fs13 dark">{{ __("We are currently accept new users registration using their social accounts only to make sure we have verified emails to identify users") }}.</p>
                    <p class="my8 fs13 dark">{{ __("Typical registration actually works, but we don't have email verification service to verify emails. If we allow users to register using typical form, we'll end up with fake emails or impersonation issues.") }}</p>
                    <p class="my8 fs13 dark">{{ __("We will add this feature as soon as we can, by inform our users in announcements page") }}</p>
    
                    <div class="typical-section-style white-background flex">
                        <svg class="size14 mr4" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z"></path></svg>
                        <p class="no-margin fs13 dark">{{ __("Please, notice that when you use one of your social accounts to login, we don't have your password or access to your account. We only get informations like your name, email and avatar.") }} <a href="{{ 'privacy?move-to=data-we-collect' }}" target="_blank" class="link-style">{{ __('click here') }}</a> {{ __('to read more in privacy policy page') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="register-section" class="full-center">
        <div id="auth-viewer-box" class="viewer-box-style-1">
            <div class="full-center my8">
                <svg fill="black" style="width: 60%; stroke: black;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 90">
                    <path d="M63.41,34.07c-.88-3-2.16-6-3.52-7.52-1.68-1.76-2.72-2.08-6.56-2.08h-6c-2.72,0-3,.16-3,2.88V44.79h8.56c4.72,0,5.36-1.2,6.56-6.8h3V55.75h-3c-.88-5.44-2.08-6.8-6.48-6.8H44.29V61.43c0,7.36.48,7.92,7.68,8.4v3H26.37v-3c6.08-.56,6.8-1,6.8-8.4V32c0-7.12-.72-7.76-6.8-8.24v-3H53.49c6.88,0,10.88-.08,12.16-.16.08,1.36.48,8.24.88,13Zm8.88,38.72v-3c6.08-.56,6.8-1,6.8-7.76V31.59c0-6.72-.8-7.36-6.8-7.84v-3H97v3c-6,.56-6.8,1.12-6.8,7.84V62.07c0,6.64.72,7.12,6.8,7.76v3Zm62.48-28.64c8.4,1.52,14.32,5.52,14.32,13.12,0,5-3.12,9.6-7.68,12.16-4.08,2.24-9.28,3.36-15.2,3.36h-22.4v-3c6.16-.64,6.8-1,6.8-7.76V31.59c0-6.72-1-7.44-6.72-7.84v-3h24.32c6.08,0,9.92.8,13.12,2.8a10.28,10.28,0,0,1,4.88,8.88C146.21,39.11,140,43.11,134.77,44.15Zm-10.16-1c7.6,0,10.4-3.28,10.4-9.2,0-7-4.56-9.6-9-9.6a7.65,7.65,0,0,0-3.76.64c-.88.56-.8,1.28-.8,3v15.2Zm-3.12,18.8c0,5.76,2.64,7.52,7,7.44s8.72-3.92,8.72-11.36c0-7.76-3.92-11.44-12.88-11.44h-2.8Zm163.2-38.16c-4.88.64-6.4,1.68-6.64,5.28-.24,3.12-.49,5.84-.49,12.8V73.67h-4.47l-33.37-40V51.75a121.5,121.5,0,0,0,.4,12.4c.32,3.52,2,5.36,7.92,5.68v3H228.2v-3c4.56-.4,6.56-1.6,7-5.36a107.59,107.59,0,0,0,.48-12.72v-19c0-2.64-.16-4.4-1.68-6.48s-3.36-2.24-6.72-2.56v-3h15.6L273.4,56.23V41.83c0-7-.07-9.6-.31-12.56-.24-3.44-1.53-5.12-8.17-5.52v-3h19.77Zm29.51,49v-3c5-.72,5-1.6,3.92-5-.8-2.4-2.08-6-3.28-9.2h-15.6c-.88,2.48-2,5.52-2.8,8-1.68,5,.24,5.68,6.56,6.24v3H283.24v-3c5-.64,6.32-1.36,9-8.08l16.64-41.36,3.85-.72c5.12,13.92,10.55,28.16,15.75,41.52,3,7.44,3.69,8,8.88,8.64v3Zm-7-38.24c-2.32,5.76-4.56,11.12-6.56,17h12.72ZM371.48,34c-1.6-5.12-3.84-11-11.2-11a7.37,7.37,0,0,0-7.68,7.76c0,4.4,3,7,10,10.56,8.56,4.24,14,8.4,14,16.32,0,9.44-7.84,16.32-19.28,16.32-5.12,0-9.68-1.36-13.44-2.48-.48-1.84-1.84-10.16-2.4-13.92l3.12-.72c1.6,5,6.08,13.76,13.92,13.76,4.88,0,7.84-3,7.84-8.16,0-4.64-2.88-7.36-9.6-11C348.44,47,343,43,343,34.71s6.56-15,18.56-15A59.14,59.14,0,0,1,373,21.11c.32,3,.88,7.12,1.52,12.16Zm68.88-10.24c-6.24.64-6.8,1.12-6.8,7.76V62.15c0,6.64.64,7.12,6.8,7.68v3H415.64v-3c6.32-.8,6.8-1,6.8-7.68v-15h-21.6v15c0,6.64.72,7,6.72,7.68v3H382.92v-3c5.92-.64,6.8-1,6.8-7.68V31.51c0-6.64-.72-7.28-6.8-7.76v-3h24.64v3c-6.08.56-6.72,1.12-6.72,7.76V43h21.6V31.51c0-6.64-.8-7.12-6.8-7.76v-3h24.72Zm6.8,49v-3c6.08-.56,6.8-1,6.8-7.76V31.59c0-6.72-.8-7.36-6.8-7.84v-3h24.72v3c-6,.56-6.8,1.12-6.8,7.84V62.07c0,6.64.72,7.12,6.8,7.76v3Z"/>
                    <path d="M204.29,46.25a2.17,2.17,0,0,0-2.62,1.17,2.13,2.13,0,0,0,.58,3,28.32,28.32,0,0,0,5.38,3c1.85.75,2.89-.4,3.29-2.33-.22-.48-.32-1.22-.74-1.56A20,20,0,0,0,204.29,46.25Z" stroke-miterlimit="10" stroke-width="1.5px"/>
                    <path d="M181.08,20.32c-9.69,3.53-15.69,10.52-18.35,20.46-3.77-2.83-3.8-3.37-.3-5.44a2.42,2.42,0,0,0,1.31-2.86c-.36-1.48-1.47-1.87-2.88-1.76-5.36.43-7.91,5.35-5.15,10a17.25,17.25,0,0,0,4.63,5,4.38,4.38,0,0,1,2,3.61,28.07,28.07,0,0,0,21,25.12,28.32,28.32,0,1,0-2.22-54.15Zm32.61,28.36c-.29,10.83-10.23,20.89-21.45,21.6-12,.75-22.93-7.55-24.41-18.61.12-.13.25-.25.38-.38-.16-.2-.33-.33-.51-.23.18-.1.35,0,.51.23h0c3.18,1.53,6.34,3.1,9.55,4.56a2.66,2.66,0,0,1,1.63,2c1.23,4.24,4,6.4,7.76,6.42a8,8,0,0,0,7.66-5.37,8.21,8.21,0,0,0-3.07-9.14c-3.1-2.14-6.72-1.94-10,.86a2,2,0,0,1-2.7.34c-2.95-1.54-5.89-3.09-8.91-4.49-2.69-1.25-3.52-3-1.78-5.87,2.36,1.33,4.77,2.69,7.17,4.07,1.48.85,3.06,1.31,4.09-.42s0-3.08-1.67-4c-1.92-1-3.73-2.3-5.7-3.21-2.19-1-1.94-2.07-.67-3.71,5.77-7.39,13.36-10.66,22.52-9.2,8.89,1.4,15.1,6.55,18.17,15.19l-.63.51.67.29-.67-.29h0l-4.93-2.66c-1.38-.76-2.71-.66-3.55.7s-.37,2.8,1.11,3.67c2.61,1.52,5.21,3,7.86,4.49A2.59,2.59,0,0,1,213.69,48.68Zm-26.47,4.1c4.51,0,4.5,7,0,7S182.71,52.78,187.22,52.78Z" stroke-miterlimit="10"/>
                </svg>
            </div>
            <div class="align-center space-between">
                <h1 class="dark fs18">{{ __('SIGNUP') }}</h1>
                <div class="flex">
                    <div class="flex align-center register-type-switch  register-type-switch-selected mr4">
                        <svg class="size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                        <span class="fs10 bold ml4 unselectable">{{ __('usual') }}</span>
                        <input type="hidden" class="register-type" value="usual" autocomple="off">
                    </div>
                    <div class="flex align-center register-type-switch">
                        <svg class="size12 blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M201.05,3.07c8.23,2.72,16.28,5.55,23,11.56,18.11,16.18,19.44,44.44,2.63,63.18-15.58,17.37-43.73,18.58-61,2.32-3.22-3-5.24-3.16-8.9-.81-12.46,8-25.25,15.52-37.83,23.35-2.31,1.44-3.62,1.53-4.7-1.19a24.77,24.77,0,0,0-2.4-4.25c-3.53-5.4-3.54-5.38,2.16-8.86,12.22-7.48,24.42-15,36.69-22.41,2-1.22,3.23-2.23,2.32-4.93-8.35-24.77,7.61-50.71,30.61-56.36.94-.23,2.38-.15,2.75-1.6Zm22.63,173.39c-18.11-15.47-41.43-15-58.9,1.2-2.5,2.31-4.1,2.5-6.93.7C147,171.46,136,164.82,125,158.12c-2.89-1.76-5.92-4.75-8.81-4.66-2.47.08-2.92,5-5,7.28-.11.12-.15.3-.27.41-2.76,2.69-2.35,4.38,1.1,6.42,12.77,7.52,25.29,15.47,38,23,2.84,1.7,3.94,3.2,2.65,6.51-2.57,6.57-2.39,13.51-1.28,20.28,3.49,21.33,24.74,38.21,45.44,36.42,24.16-2.08,42.07-21.18,41.82-44.6C238.39,196.12,233.64,185,223.68,176.46Zm-161-92c-24-.28-44.23,19.81-44.27,44a44.34,44.34,0,0,0,43.71,44.11c24,.28,44.22-19.81,44.27-44A44.36,44.36,0,0,0,62.68,84.43Z"></path></svg>
                        <span class="fs10 bold ml4 unselectable">{{ __('social') }}</span>
                        <input type="hidden" class="register-type" value="social" autocomple="off">
                    </div>
                </div>
                <!-- back to login page -->
                <!-- <a href="{{ route('login') }}" class="link-style flex align-center">
                    <svg class="mr4 size10" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"/></svg>
                    <span class="bold blue fs12">{{ __('Login') }}</span>
                </a> -->
            </div>
                @if($errors->any())        
                <div class="informative-message-container media-upload-error-container flex align-center relative my8">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <p class="no-margin fs13 message-text">{{ $errors->first() }}</p>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
                @endif
            <div id="social-register-box" class="none">
                <div class="typical-section-style my8">
                    <p class="fs13 bold text-center dark lh15 no-margin">{{ __('In order to prevent abuse we require users to sign up using social login. To review the reason behind locking usual registration, click on usual button and open the reason viewer.') }}</p>
                </div>
                <div>
                    <div class="align-center">
                        <a href="{{ url('/login/google') }}" class="my8 google-auth-button sm-button full-width full-center mr4">
                            <svg class="size14 mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M113.47,309.41,95.65,375.94l-65.14,1.38a256.46,256.46,0,0,1-1.89-239h0l58,10.63L112,206.54a152.85,152.85,0,0,0,1.44,102.87Z" style="fill:#fbbb00"/><path d="M507.53,208.18a255.93,255.93,0,0,1-91.26,247.46l0,0-73-3.72-10.34-64.54a152.55,152.55,0,0,0,65.65-77.91H261.63V208.18h245.9Z" style="fill:#518ef8"/><path d="M416.25,455.62l0,0A256.09,256.09,0,0,1,30.51,377.32l83-67.91a152.25,152.25,0,0,0,219.4,77.95Z" style="fill:#28b446"/><path d="M419.4,58.94l-82.93,67.89A152.23,152.23,0,0,0,112,206.54l-83.4-68.27h0A256,256,0,0,1,419.4,58.94Z" style="fill:#f14336"/></svg>
                            <span class="fs13 lblack bold">Google</span>
                        </a>
                        <a href="{{ url('/login/facebook') }}" class="facebook-auth-button sm-button full-width full-center ml4">
                            <svg class="size14 mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.25,1H54.75A54.75,54.75,0,0,0,0,55.75v401.5A54.75,54.75,0,0,0,54.75,512H211.3V338.27H139.44V256.5H211.3V194.18c0-70.89,42.2-110,106.84-110,31,0,63.33,5.52,63.33,5.52v69.58H345.8c-35.14,0-46.1,21.81-46.1,44.17v53.1h78.45L365.6,338.27H299.7V512H456.25A54.75,54.75,0,0,0,511,457.25V55.75A54.75,54.75,0,0,0,456.25,1Z" style="fill:#fff"/></svg>
                            <span class="fs13 bold white">Facebook</span>
                        </a>
                    </div>
                    <a href="{{ url('/login/twitter') }}" class="twitter-auth-button sm-button full-width full-center">
                        <svg class="size16 auth-buton-left-icon mx8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 310 310"><path d="M303,57.39a117.23,117.23,0,0,1-15,5.46,66.26,66.26,0,0,0,13.5-23.73,5,5,0,0,0-7.32-5.82,118,118,0,0,1-34.88,13.78A66.58,66.58,0,0,0,146.15,94.64a68.24,68.24,0,0,0,.55,8.6,170.37,170.37,0,0,1-116.94-62,5,5,0,0,0-8.19.65,66.61,66.61,0,0,0,6.82,76.59,56.29,56.29,0,0,1-8.91-4,5,5,0,0,0-7.42,4.25c0,.3,0,.59,0,.89a66.76,66.76,0,0,0,32.58,57.23c-1.7-.17-3.39-.41-5.07-.73a5,5,0,0,0-5.7,6.43,66.54,66.54,0,0,0,48.75,44.61,117.71,117.71,0,0,1-62.93,18,120.15,120.15,0,0,1-14.09-.83,5,5,0,0,0-3.29,9.18A179.44,179.44,0,0,0,99.35,281.9c67.75,0,110.14-31.95,133.76-58.75,29.46-33.42,46.36-77.66,46.36-121.37,0-1.82,0-3.67-.09-5.51a129.26,129.26,0,0,0,29.78-31.53A5,5,0,0,0,303,57.39Z"></path></svg>
                        Twitter
                    </a>
                </div>
            </div>
            <div id="typical-register-box">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="flex">
                        <div class="half-width mr8">
                            <label for="firstname" class="fs12 lblack flex mb2">{{ __('Firstname') }} @error('firstname')<span class="error-asterisk">*</span> @enderror</label>
                            <input id="firstname" type="text" class="styled-input @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name" autofocus placeholder="Firstname">
                        </div>
                        <div class="half-width">
                            <label for="lastname" class="fs12 lblack flex mb2">{{ __('Lastname') }} @error('lastname') <span class="error-asterisk">*</span> @enderror</label>
                            <input id="lastname" type="text" class="styled-input" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name" autofocus placeholder="Lastname">
                        </div>
                    </div>
    
                    <div class="my8">
                        <label for="username" class="fs12 lblack flex mb2">{{ __('Username') }} @error('username') <span class="error-asterisk">*</span> @enderror</label>
                        <input id="username" type="text" class="styled-input full-width" name="username" value="{{ old('username') }}" required autocomplete="name" autofocus placeholder="Username">
                    </div>
    
                    <div class="my8">
                        <label for="email" class="fs12 lblack flex mb2">{{ __('Email address') }} @error('email') <span class="error-asterisk">*</span> @enderror</label>
                        <input type="email" id="email" name="email" class="styled-input full-width" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                    </div>
    
                    <div class="my8">
                        <label for="password" class="fs12 lblack flex mb2">{{ __('Password') }} @error('password') <span class="error-asterisk">*</span> @enderror</label>
                        <input type="password" id="password" name="password" class="styled-input full-width" required placeholder="{{ __('Password') }}" autocomplete="current-password">
                    </div>
    
                    <div class="my8">
                        <label for="password-confirm" class="fs12 lblack flex mb2">{{ __('Confirm your password') }} </label>
                        <input type="password" id="password-confirm" name="password_confirmation" class="styled-input full-width" required placeholder="{{ __('Re-enter password') }}">
                    </div>
                    
                    <!-- <button type="submit" class="typical-button-style disabled-typical-button-style full-width cursor-not-allowed"> -->
                    <div class="typical-section-style flex my8">
                        <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129,233.33h-108c-13.79,0-18.82-8.86-11.87-20.89q54-93.6,108.12-187.2c7.34-12.71,17.14-12.64,24.55.17,36,62.4,71.95,124.88,108.27,187.13,7.05,12.07-.9,21.28-12.37,21.06C201.43,232.88,165.21,233.33,129,233.33Zm91.36-24L129.4,51.8,38.5,209.3Zm-79-103.77c-.13-7.56-5.28-13-12-12.85s-11.77,5.58-11.82,13.1q-.13,20.58,0,41.18c.05,7.68,4.94,13,11.69,13.14,6.92.09,12-5.48,12.15-13.39.09-6.76,0-13.53,0-20.29C141.35,119.45,141.45,112.49,141.32,105.53Zm-.15,70.06a12.33,12.33,0,0,0-10.82-10.26,11.29,11.29,0,0,0-12,7.71,22.1,22.1,0,0,0,0,14A11.82,11.82,0,0,0,131.4,195c6.53-1.09,9.95-6.11,9.81-14.63A31.21,31.21,0,0,0,141.17,175.59Z"></path></svg>
                        <p class="no-margin lblack fs12">{{ __('We cannot register users using usual registration form.') }} <span class="bold blue pointer open-typical-register-notice-viewer">{{ __('click here') }}</span> {{ __('to read more') }}</p>
                    </div>
                    <button type="submit" class="typical-button-style dark-bs full-width full-center">
                        <span class="fs12 bold white" style="font-family: arial;">{{ __('Register') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
