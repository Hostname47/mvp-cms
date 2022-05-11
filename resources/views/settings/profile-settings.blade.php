@extends('layouts.app')

@section('title', 'Fibonashi - profile settings')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('user.settings') }}" class="page-path">
                <span>{{ __('settings') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M126.22,254.33C56.67,251.16,2.8,193.84,5.67,126.07,8.61,56.79,66.47,2.52,134.05,5.67c69.5,3.25,123.55,61,120.24,128.52C250.9,203.54,193.48,257.4,126.22,254.33Zm103.14-124c.12-55-43.67-99.72-98.69-99.57-41.23.12-72.2,19.27-90,56.19C22.91,123.69,27.83,159.3,52.23,192.09c2.1,2.83,3.41,3.47,6.66.88,43-34.33,99.26-34.38,142.05-.14,3.43,2.74,4.75,2,7.06-1C222,173.66,229.26,153.28,229.36,130.35Zm-49.58-24.73c.48-27-21.92-49.93-49.13-50.21a50,50,0,0,0-50.46,49.48c-.23,27.17,22.06,49.65,49.44,49.84A49.71,49.71,0,0,0,179.78,105.62Z"/></svg>
            <h1 class="title-style">Profile Settings</h1>
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
            <div class="avatar-and-meta-container">
                <div id="avatar-area">
                    <div class="user-avatar-settings-button-container">
                        <svg class="user-avatar-settings-button button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,384H160V368a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,400v32a16,16,0,0,0,16,16H96v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V448H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-160H416V208a16,16,0,0,0-16-16H368a16,16,0,0,0-16,16v16H16A16,16,0,0,0,0,240v32a16,16,0,0,0,16,16H352v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V288h80a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Zm0-160H288V48a16,16,0,0,0-16-16H240a16,16,0,0,0-16,16V64H16A16,16,0,0,0,0,80v32a16,16,0,0,0,16,16H224v16a16,16,0,0,0,16,16h32a16,16,0,0,0,16-16V128H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Z"></path></svg>
                        <div class="suboptions-container typical-suboptions-container width-max-content">
                            <div class="suboption-style-2 align-center relative overflow-hidden">
                                <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M217.14,121.14c-4.55-.89-8.39-1.9-12.29-2.32-2.95-.31-3.65-1.43-3.63-4.33.14-20.13.08-40.27.07-60.4,0-6.76-.51-7.26-7.38-7.26H34.5c-6.95,0-7.47.49-7.47,7.19V174.33c0,6.73.47,7.17,7.48,7.17,33,0,66,.06,99-.08,3.43,0,5.29.62,5.16,4.35a15,15,0,0,0,.44,3.44c.53,2.56,2.44,6.36,1.44,7.38-1.89,1.95-5.52.72-8.41.73q-53,.08-105.94,0c-10.8,0-15-4.18-15-14.88V45.82C11.19,35.13,15.4,31,26.25,31H202c11.11,0,15.14,4.06,15.15,15.23ZM155.66,88.56c-6.79-8.14-14.77-8.12-21.56,0-11.48,13.81-23,27.63-34.3,41.55-1.93,2.37-2.84,2.83-4.92.1-5.29-6.94-10.92-13.63-16.45-20.38-6.54-8-14.5-8.14-21.34-.38S43.75,125,37,132.61a7.87,7.87,0,0,0-2,5.78c.09,10.22.2,20.45,0,30.67-.09,3.56.65,4.65,4.48,4.63q47-.28,94,0c3.63,0,4.94-.88,5.5-4.6,3.1-20.5,14.21-35.38,32.59-44.82,3.17-1.63,6.59-2.76,10.24-4.27C172.84,109.33,164.29,98.91,155.66,88.56ZM248.81,178a51.48,51.48,0,1,0-51.59,51C225.4,229.13,248.7,206.1,248.81,178Zm-63.3,2.7c.13-2.6-.68-3.59-3.27-3.25a20,20,0,0,1-4,0c-4.31-.29-6-3.15-3.6-6.64,6.15-8.93,12.47-17.76,18.88-26.52,2.47-3.38,5.09-3.35,7.59.07q9.48,12.93,18.62,26.1c2.61,3.77,1,6.68-3.53,7a9.28,9.28,0,0,1-2.47,0c-4.14-.81-4.74,1.27-4.64,4.85.24,8.23,0,16.47.13,24.7.1,4.42-1.61,6.38-6.1,6.16-4.11-.19-8.23-.1-12.35,0-3.7.08-5.47-1.54-5.39-5.32.1-4.61,0-9.22,0-13.83C185.45,189.61,185.3,185.16,185.51,180.73ZM115,76.81A16.14,16.14,0,0,0,99,60.74a15.84,15.84,0,0,0,.07,31.67A16,16,0,0,0,115,76.81Z"/></svg>
                                <span class="fs12 bold dark unselectable">{{ __('Upload new avatar') }}</span>
                                <input type="file" id="avatar-input" class="avatar-upload-button" autocomplete="off">
                            </div>
                            @if($user->has_avatar)
                            <div class="suboption-style-2 align-centermt2 open-remove-avatar-dialog">
                                <svg class="size16 mr4" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <span class="fs12 bold dark unselectable">{{ __('Remove used avatar') }}</span>
                            </div>
                            @endif
                            <div class="suboption-style-2 align-centermt2 restore-original-avatar none">
                                <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <span class="fs12 bold dark unselectable">{{ __('Restore original avatar') }}</span>
                            </div>
                            <div class="suboption-style-2 align-centermt2 discard-uploaded-avatar none">
                                <svg class="size15 mr4" style="min-width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                                <span class="fs12 bold dark unselectable">{{ __('Discard uploaded avatar') }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="avatar-container">
                        <img src="{{ $user->avatar(100) }}" id="avatar" alt="{{ $user->fullname . ' - ' . $user->username . ' avatar' }}">
                    </div>
                    <input type="hidden" id="default-avatar" value="{{ $user->defaultavatar(100) }}" autocomplete="off">
                    <input type="hidden" id="original-avatar" value="{{ $user->avatar(100) }}" autocomplete="off">
                </div>
                <div class="meta-container">
                    <h2 class="fullname-text">{{ $user->fullname }}</h2>
                    <span class="username-text">{{ $user->username }}</span>
                    <!-- firstname & lastname -->
                    <div class="first-and-last-names-container">
                        <div class="full-width">
                            <label for="firstname" class="label">{{ __('Firstname') }}</label>
                            <input type="text" id="firstname" class="full-width styled-input" value="@if(@old('firstname')){{@old('firstname')}}@else{{$user->firstname}}@endif" required autocomplete="off" placeholder="{{__('Firstname')}}">
                        </div>
                        <div class="full-width">
                            <label for="lastname" class="label">{{ __('Lastname') }}</label>
                            <input type="text" id="lastname" class="full-width styled-input" value="@if(@old('lastname')){{@old('lastname')}}@else{{$user->lastname}}@endif" required autocomplete="off" placeholder="{{__('Lastname')}}">
                        </div>
                    </div>
                </div>
            </div>
            <!-- username -->
            <div class="my12">
                <label for="username" class="label">{{ __('Change username') }} </label>
                <input type="text" id="username" class="styled-input" value="@if(@old('username')){{@old('username')}}@else{{$user->username}}@endif" required autocomplete="off" placeholder="{{__('Username')}}">
            </div>
            <!-- about -->
            <div class="my12">
                <label for="about" class="label">{{ __('About me') }}</label>
                <textarea id="about" class="styled-input" maxlength="1400" spellcheck="false" autocomplete="off" placeholder="{{ __('Something about you') }}">{{ $user->about }}</textarea>
            </div>
            <!-- save user informations button -->
            <div id="save-user-profile-settings" class="typical-button-style dark-bs align-center width-max-content mt8">
                <div class="relative size14 mr4">
                    <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.26,58.1V233.76c-2,2.05-2.07,5-3.36,7.35-4.44,8.28-11.79,12.56-20.32,15.35H26.32c-.6-1.55-2.21-1.23-3.33-1.66C11,250.24,3.67,240.05,3.66,227.25Q3.57,130.14,3.66,33c0-16.47,12.58-29.12,29-29.15q81.1-.15,162.2,0c10,0,19.47,2.82,26.63,9.82C235,26.9,251.24,38.17,256.26,58.1ZM129.61,214.25a47.35,47.35,0,1,0,.67-94.69c-25.81-.36-47.55,21.09-47.7,47.07A47.3,47.3,0,0,0,129.61,214.25ZM108.72,35.4c-17.93,0-35.85,0-53.77,0-6.23,0-9,2.8-9.12,9-.09,7.9-.07,15.79,0,23.68.06,6.73,2.81,9.47,9.72,9.48q53.27.06,106.55,0c7.08,0,9.94-2.85,10-9.84.08-7.39.06-14.79,0-22.19S169.35,35.42,162,35.41Q135.35,35.38,108.72,35.4Z"/><path d="M232.58,256.46c8.53-2.79,15.88-7.07,20.32-15.35,1.29-2.4,1.38-5.3,3.36-7.35,0,6.74-.11,13.49.07,20.23.05,2.13-.41,2.58-2.53,2.53C246.73,256.35,239.65,256.46,232.58,256.46Z"/></svg>
                    <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                </div>
                <span class="bold fs12" style="margin-top: 1px">{{ __('Save Profile Informations') }}</span>
            </div>
        </div>
    </div>
@endsection