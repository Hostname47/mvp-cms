@extends('layouts.app')

@section('title', 'Fibonashi - Discover')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
    @include('partials.viewers.newsletter-viewer')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('user.profile', ['user'=>$user->username] ) }}" class="page-path">
                <span>{{ $user->username . ' - ' . __('profile') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M126.22,254.33C56.67,251.16,2.8,193.84,5.67,126.07,8.61,56.79,66.47,2.52,134.05,5.67c69.5,3.25,123.55,61,120.24,128.52C250.9,203.54,193.48,257.4,126.22,254.33Zm103.14-124c.12-55-43.67-99.72-98.69-99.57-41.23.12-72.2,19.27-90,56.19C22.91,123.69,27.83,159.3,52.23,192.09c2.1,2.83,3.41,3.47,6.66.88,43-34.33,99.26-34.38,142.05-.14,3.43,2.74,4.75,2,7.06-1C222,173.66,229.26,153.28,229.36,130.35Zm-49.58-24.73c.48-27-21.92-49.93-49.13-50.21a50,50,0,0,0-50.46,49.48c-.23,27.17,22.06,49.65,49.44,49.84A49.71,49.71,0,0,0,179.78,105.62Z"/></svg>
            <h1 class="title-style">User Profile</h1>
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

        <div id="profile-main">
            <div class="relative">
                <img src="{{ $user->avatar(400) }}" class="user-avatar" alt="">
                @if($user->same)
                <a href="" class="profile-edit-avatar">
                    <svg class="icon" viewBox="0 0 16 16" version="1.1"><path d="M11.013 1.427a1.75 1.75 0 012.474 0l1.086 1.086a1.75 1.75 0 010 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251.93a.75.75 0 01-.927-.928l.929-3.25a1.75 1.75 0 01.445-.758l8.61-8.61zm1.414 1.06a.25.25 0 00-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 000-.354l-1.086-1.086zM11.189 6.25L9.75 4.81l-6.286 6.287a.25.25 0 00-.064.108l-.558 1.953 1.953-.558a.249.249 0 00.108-.064l6.286-6.286z"></path></svg>
                    <span>{{ __('edit') }}</span>
                </a>
                @endif
            </div>
            <div class="user-meta">
                @if($user->same)
                <div class="links-container">
                    <a href="" class="button-style-2">{{ __('profile') }}</a>
                    <a href="" class="button-style-2">{{ __('activities') }}</a>
                    <a href="" class="button-style-2">{{ __('settings') }}</a>
                </div>
                @endif
                <h2 class="user-fullname">{{ $user->fullname }}</h2>
                <span class="user-username">{{ '@' . $user->username }}</span>
                <div class="dot-separator">•</div>
                @if($role)
                <p><strong>{{ __('Role') }}</strong> : {{ $role->title }}</p>
                @endif
                <p><strong>{{ __('Joined') }}</strong> : {{ $user->join_date }}</p>
                <div class="dot-separator">•</div>
                <div class="about-section">
                    <span class="title">{{ __('About') }}</span>
                    <p class="content">: ❝ {{ $user->about ? $user->about : 'the quieter you become' }} ❞</p>
                </div>
            </div>
        </div>
    </div>
@endsection