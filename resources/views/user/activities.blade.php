@extends('layouts.app')

@section('title', 'Fibonashi - My activities')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/activities.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/activities.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('user.profile', ['user'=>$user->username] ) }}" class="page-path">
                <span>{{ __('my activities') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"/></svg>
            <h1 class="title-style">{{ __('My activities') }}</h1>
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

        <div id="activities-box">
            <div id="first-section">
                <img src="{{ $user->avatar(400) }}" class="avatar pointer open-image-on-image-viewer" alt="">
                <div class="meta-section">
                    <h2 class="fullname">{{ $user->fullname }}</h2>
                    <span class="username">{{ '@' . $user->username }}</span>
                    <div class="metas-wrapper">
                        <div class="align-center">
                            <svg aria-hidden="true" fill="#282b2f" class="meta-icon" viewBox="0 0 18 18"><path d="M9 4.5a1.5 1.5 0 0 0 1.28-2.27L9 0 7.72 2.23c-.14.22-.22.48-.22.77 0 .83.68 1.5 1.5 1.5Zm3.45 7.5-.8-.81-.81.8c-.98.98-2.69.98-3.67 0l-.8-.8-.82.8c-.49.49-1.14.76-1.83.76-.55 0-1.3-.17-1.72-.46V15c0 1.1.9 2 2 2h10a2 2 0 0 0 2-2v-2.7c-.42.28-1.17.45-1.72.45-.69 0-1.34-.27-1.83-.76Zm1.3-5H10V5H8v2H4.25C3 7 2 8 2 9.25v.9c0 .81.91 1.47 1.72 1.47.39 0 .77-.14 1.03-.42l1.61-1.6 1.6 1.6a1.5 1.5 0 0 0 2.08 0l1.6-1.6 1.6 1.6c.28.28.64.43 1.03.43.81 0 1.73-.67 1.73-1.48v-.9C16 8.01 15 7 13.75 7Z"></path></svg>
                            <span class="meta-text">{{ __('Member for') }} <span class="ml4" title="{{ $user->join_date }}">{{ $user->join_date_humans }}</span></span>
                        </div>
                        <div class="align-center">
                            <svg aria-hidden="true" fill="#282b2f" class="meta-icon" viewBox="0 0 18 18"><path d="M9 17c-4.36 0-8-3.64-8-8 0-4.36 3.64-8 8-8 4.36 0 8 3.64 8 8 0 4.36-3.64 8-8 8Zm0-2c3.27 0 6-2.73 6-6s-2.73-6-6-6-6 2.73-6 6 2.73 6 6 6ZM8 5h1.01L9 9.36l3.22 2.1-.6.93L8 10V5Z"></path></svg>
                            <span class="meta-text">{{ __('Last seen') }} <span class="ml4" title="{{ $user->join_date }}">{{ $user->join_date_humans }}</span></span>
                        </div>
                    </div>
                    <div class="about"><strong class="no-wrap mr4">{{ __('About') . ' :' }}</strong> {{ $user->about() }}</div>
                </div>
                <div class="links">
                    <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="typical-button-style white-bs align-center">
                        <svg class="size14 mr6" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,254C61.82,254.05,5.93,198.12,6,129.89S62.07,5.77,130.23,6A124.29,124.29,0,0,1,254,129.79C254.18,198,198.32,254,130,254Zm99-123.86c.06-54.55-43.36-98.92-98-99C89.94,31.1,59,50.08,41.12,86.79,23.34,123.28,28,158.8,52.29,191.58c2.25,3,3.58,3.77,7,1,43-34.12,98.77-34.07,141.52.13,3.24,2.59,4.48,1.9,6.63-.87C221.6,173.69,229,153.2,229,130.14ZM74.91,212c32.78,23.76,81.48,21.67,110.05-.06C155.36,185.48,105.73,185.4,74.91,212Zm54.77-57.31c-27.29-.17-49.5-22.52-49.31-49.63a49.79,49.79,0,0,1,50.24-49.34c27.12.25,49.43,23,49,50A49.53,49.53,0,0,1,129.68,154.65Zm25-49.32A24.65,24.65,0,1,0,130,130,24.71,24.71,0,0,0,154.65,105.33Z"/></svg>
                        <span class="fs13">{{ __('Profile') }}</span>
                    </a>
                    <a href="{{ route('user.settings') }}" class="typical-button-style white-bs flex">
                        <span class="fs13">{{ __('Settings') }}</span>
                    </a>
                </div>
            </div>
            <div id="activities-section">
                <div class="links">
                    <a href="?section=claped-posts" class="button-style-2 link @if($section=='claped-posts') section-selected @endif">{{ __('Claped posts') }}</a>
                    <a href="?section=saved-posts" class="button-style-2 link @if($section=='saved-posts') section-selected @endif">{{ __('Saved posts') }}</a>
                    <a href="?section=comments" class="button-style-2 link @if($section=='comments') section-selected @endif">{{ __('Comments') }}</a>
                    <a href="?section=corrections" class="button-style-2 link @if($section=='corrections') section-selected @endif">{{ __('Corrections') }}</a>
                </div>

                <div id="activity-content-section">
                    @switch($section)
                        @case('claped-posts')
                            <x-user.activities.sections.claped-posts-section />
                            @break
                        @case('saved-posts')
                            
                            @break
                        @case('comments')
                            
                            @break
                        @case('corrections')
                            <x-user.activities.sections.claped-posts-section />
                            @break
                    @endswitch

                    <div class="full-center">
                        <div id="section-error-container" class="informative-message-container align-center relative none my8">
                            <div class="informative-message-container-left-stripe imcls-red"></div>
                            <div class="no-margin fs13 message-text">strong error</div>
                            <div class="close-parent close-informative-message-style">✖</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection