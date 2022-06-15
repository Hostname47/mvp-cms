@extends('layouts.app')

@section('title', 'Fibonashi - Author Request')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/author-request.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/author-request.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    @include('partials.viewers.newsletter-viewer')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('author-request') }}" class="page-path">
                <span>{{__('Author request')}}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="size22 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
            <h1 class="title-style">{{ __('Author Request') }}</h1>
        </div>
        @include('partials.session-messages')

        <div class="informative-message-container error-container align-center relative none my8">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <div class="no-margin fs13 error message-text"></div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>

        @guest
        <div class="typical-section-style align-center my8">
            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
            <p class="no-margin dark">{{ __('Please login first before filling the form below') }}</p>
        </div>
        @endguest
        
        <!-- not-yet : guest user or auth user that does not sent any author request -->
        @switch($status)
            @case('not-yet')
                <div>
                    <p class="mb8 dark lh15">{{ __("Whether you'd like to share your knowledge, experiences or content on different topics, we provide the ability to acquire author permission and start publishing posts and content") }}. <span class="bold">{{ __('Keep in mind that author permission can only create posts, and the admins need to verify the content before publishing it publicly.') }}</span> </p>
                    <p class="mt8 dark lh15">{{ __("Choose the categories that you are passionate about, along with a detailed message with all the informations about you and your skills and passions in order for us to accept your request. If your preffered category does not exists within the list of categories below, please include it in the message.") }}</p>
                    <div id="request-form">
                        <input type="hidden" id="select-at-least-one-category" value="{{ __('You need to select at least one category') }}" autocomplete="off">
                        <input type="hidden" id="request-message-is-required" value="{{ __('Message field is required') }}" autocomplete="off">
                        <!-- select categories -->
                        <div id="categories-box">
                            <div class="align-center">
                                <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
                                <h2 class="title">{{ __('Categories') }}</h2>
                            </div>
                            <p class="sub-title">{{ __('Select at least one category') }}</p>
                
                            <div id="select-categories-box">
                                <div class="categories">
                                    @foreach($categories as $category)
                                        <x-category.category-select :category="$category" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
    
                        <!-- message -->
                        <div id="message-box">
                            <div class="align-center">
                                <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"></path></svg>
                                <h2 class="title">{{ __('Message') }}</h2>
                            </div>
                            <p class="sub-title">{{ __('Please, be concise and to the point') }}</p>
                            <textarea id="request-message" class="styled-input" placeholder="{{ __('Enter message body') }}"></textarea>
                            <p class="notice-after-message">{{ __('Please review your application before submitting it; once the request is submitted you will not be able to update it.') }}</p>
                        </div>
    
                        <div class="flex">
                            <div @auth id="submit-request" @endauth class="typical-button-style dark-bs @guest login-required dark-bs-disabled @endguest align-center">
                                <div class="relative size15 mr6">
                                    <svg class="size15 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
                                    <svg class="spinner size15 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="unselectable">{{ __('submit request') }}</span>
                            </div>
                        </div>
                    </div>    
                </div>
                @break
            @case('approved')
                <div class="message-container">
                    <svg class="size20 my8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                    <p class="message my8">{{ __('we have verified your application and accepted your request. Now you can start creating blog posts.') }}</p>
                    <div>
                        <p class="">• {{ __('Application date') }} : <strong>{{ $application->date }}</strong></p>
                        <p class="">• {{ __('Approved at') }} : <strong>{{ $application->update_date }}</strong></p>
                        <a href="" class="button-style-1 no-underline dark-blue full-center">
                            <svg class="size15 mr6" fill="#2777b9" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
                            {{ __('Go to author area') }}
                        </a>
                    </div>
                </div>
                @break
            @case('refused')
                <div class="message-container">
                    <svg class="size24 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                    <p class="my12 bold dark message">{{ __('Author request refused') }}</p>
                    <p class="no-margin fs13 lh15 dark message">{{ __("Your recent author request is refused by our admins. Try to include more informations about you to convince us to accept your application. We'll open the author request form later for next application.") }}</p>
                </div>
                @break
            @case('under-review')
                <div class="message-container">
                    <svg class="size24 my12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M135.59,253l3.06.06H142c2.71,0,5.42,0,8.13,0-.26,0,1.19,0,2.27,0,4.14-.8,8.27-1.65,12.32-2.78Z"/><path d="M224.07,5.89V29.47H207.58c0,4.15-.24,7.82,0,11.44C209.29,62.28,200.23,79,185,93c-6.28,5.77-12.8,11.29-19.29,16.83-12,10.28-12.07,23.68,0,33.59,11.22,9.17,22.79,17.92,31.24,30,6.84,9.8,10.61,20.49,10.56,32.48,0,7.7,0,15.39,0,23.64h16.49v23.62H38.34V229.84h16.6c0-2.23,0-3.92,0-5.62.1-8.21-.29-16.46.41-24.62C56.73,183.45,65.54,171,76.9,160.3c6.55-6.18,13.67-11.75,20.59-17.52,10.88-9.07,11.08-22.69.39-32-6.9-6-14-11.88-20.74-18.11-15-13.91-23.91-30.54-22.24-51.71.25-3.2,0-6.44,0-9.66a7,7,0,0,0-.49-1.44H38.46V5.89ZM133.82,135.38l-4.95.26c-4.45,14-7.34,18.12-18.5,27.23-5.48,4.48-10.77,9.19-16.27,13.65-14.83,12-17.29,28-14.67,46,1.53-.53,3-1,4.49-1.56,10.78-4.2,21.4-8.86,32.38-12.44,5.8-1.9,12.46-3.45,18.3-2.48,9.05,1.5,17.78,5.11,26.53,8.15,7.39,2.57,14.61,5.61,22.58,8.7,0-5.55-.19-10.35,0-15.13.5-10.32-3.23-19-10.39-26.07-6.64-6.53-13.67-12.7-20.92-18.54C143.43,155.94,136.19,147.66,133.82,135.38Zm-55-105.45c0,6.38,0,12.16,0,17.94a27.92,27.92,0,0,0,7.11,19,10.24,10.24,0,0,0,6.69,3.35q38.64.34,77.29,0a10.34,10.34,0,0,0,6.7-3.34c9.62-10.83,6.81-24,7-36.95Z"/></svg>
                    <p class="no-margin dark message">{{ __("we have received your author request successfully and we are going to inform you about approval once we verify your application.") }}</p>
                </div>
                @break
        @endswitch
    </div>
@endsection