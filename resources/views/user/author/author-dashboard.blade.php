@extends('layouts.app')

@section('title', 'Author dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/author.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/author.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />

    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('author.dashboard' ) }}" class="page-path">
                <span>{{ __('Author dashboard') }}</span>
            </a>
        </div>
        <div class="align-center mb8">
            <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
            <h1 class="title-style">{{__('Author dashboard')}}</h1>
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

        <h2>{{ __('My posts') }}</h2>
        @include('user.author.partials.author-header-links', ['tab'=>$tab])

        <div id="posts-box">
            @foreach($posts as $post)
                @php 
                    $scolor = ($post->status == 'published') ? 'green' : 'gray';
                @endphp
                <div class="post-component">
                    <div class="categories-container">
                        @foreach($post->categories as $category)
                        <a href="{{ $category->link }}" class="category">{{ $category->title }}</a>
                        @endforeach
                    </div>
                    <a href="{{ $post->link }}" class="title">{{ $post->title }}</a>
                    <div class="status-and-actions-box">
                        <div class="status-and-visibility-container">
                            @if(is_null($post->deleted_at))
                            <div class="align-center">
                                <svg class="size11 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M149.78,24c-1.59-11.62,9.08-21.73,20.46-18.55,15.86,4.42,30,12.39,42.71,22.8A127,127,0,0,1,253.15,86c.53,1.53,1,3.09,1.41,4.66a9.31,9.31,0,0,1,.21,1.79c.11,8.12-5.09,15-12.24,17-7.65,2.05-16.12-1.28-19.6-8.13-2.5-4.92-4.19-10.23-6.67-15.15-11.35-22.5-28.86-38.21-52.52-46.94C156.42,36.46,150.94,32.45,149.78,24ZM248,148.15c-5.4-4.34-11.48-4.85-17.87-1.91-5.92,2.72-8,8.16-10.21,13.63-15,36.7-42.39,57.53-81.85,60.65-40.68,3.21-78.94-22.13-93.12-60A93.32,93.32,0,0,1,75.22,53.15c9-7,19.25-11.31,29.53-15.84a16.9,16.9,0,0,0,9.17-22c-3.4-8.5-12.58-12.77-21.8-9.4C47,22.42,18.44,53.84,7.24,100.79c-.75,3.13-.76,6.43-1.63,9.53A25.14,25.14,0,0,1,5.15,114,25.78,25.78,0,0,1,4.76,118a25.93,25.93,0,0,1-.34,4.68v15.2c.06.39.13.77.18,1.16a32.61,32.61,0,0,1,.67,4.11C7.12,149,7.35,155.3,9.1,161.28q15.65,53.25,64.46,79.36a117.93,117.93,0,0,0,37.87,12.64c.36,0,.71,0,1.07,0a28.75,28.75,0,0,1,7.33.94,29,29,0,0,1,5.65.56h.15c.78,0,1.55,0,2.31.1s1.33-.1,2-.1a29.69,29.69,0,0,1,4.76.39h3.77a27,27,0,0,1,5.53-.58l.6,0a1.88,1.88,0,0,1,1.14-.38c30-3,55.54-15.52,76.82-36.63,14.91-14.79,25.81-32.2,31.52-52.55C256,158.17,253.28,152.42,248,148.15Z"></path></svg>
                                <span class="">status :</span>
                                <span class="bold ml4 {{ $scolor }}">{{ $post->hstatus }}</span>
                            </div>
                            @else
                            <div class="align-center">
                                <svg class="size11 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M149.78,24c-1.59-11.62,9.08-21.73,20.46-18.55,15.86,4.42,30,12.39,42.71,22.8A127,127,0,0,1,253.15,86c.53,1.53,1,3.09,1.41,4.66a9.31,9.31,0,0,1,.21,1.79c.11,8.12-5.09,15-12.24,17-7.65,2.05-16.12-1.28-19.6-8.13-2.5-4.92-4.19-10.23-6.67-15.15-11.35-22.5-28.86-38.21-52.52-46.94C156.42,36.46,150.94,32.45,149.78,24ZM248,148.15c-5.4-4.34-11.48-4.85-17.87-1.91-5.92,2.72-8,8.16-10.21,13.63-15,36.7-42.39,57.53-81.85,60.65-40.68,3.21-78.94-22.13-93.12-60A93.32,93.32,0,0,1,75.22,53.15c9-7,19.25-11.31,29.53-15.84a16.9,16.9,0,0,0,9.17-22c-3.4-8.5-12.58-12.77-21.8-9.4C47,22.42,18.44,53.84,7.24,100.79c-.75,3.13-.76,6.43-1.63,9.53A25.14,25.14,0,0,1,5.15,114,25.78,25.78,0,0,1,4.76,118a25.93,25.93,0,0,1-.34,4.68v15.2c.06.39.13.77.18,1.16a32.61,32.61,0,0,1,.67,4.11C7.12,149,7.35,155.3,9.1,161.28q15.65,53.25,64.46,79.36a117.93,117.93,0,0,0,37.87,12.64c.36,0,.71,0,1.07,0a28.75,28.75,0,0,1,7.33.94,29,29,0,0,1,5.65.56h.15c.78,0,1.55,0,2.31.1s1.33-.1,2-.1a29.69,29.69,0,0,1,4.76.39h3.77a27,27,0,0,1,5.53-.58l.6,0a1.88,1.88,0,0,1,1.14-.38c30-3,55.54-15.52,76.82-36.63,14.91-14.79,25.81-32.2,31.52-52.55C256,158.17,253.28,152.42,248,148.15Z"></path></svg>
                                <span class="">status :</span>
                                <span class="bold ml4 red">deleted</span>
                            </div>
                            @endif
                            <div class="align-center">
                                <svg class="size14 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M5.22,125.75c1.87-7.6,6.32-13.64,11.46-19.33C37.14,83.8,60,64.32,88.3,52.11c34.75-15,67.81-10,99.59,8.71,22.8,13.44,42.16,30.92,59,51.26,8.74,10.6,9.54,24.93,1.1,35.4-21.67,26.89-47.28,49.07-79.57,62.46-33.49,13.89-65.44,8.84-96.08-8.82-23.52-13.55-43.4-31.42-60.46-52.39-3.05-3.74-4.45-8.82-6.61-13.28ZM131.91,62.67a83.6,83.6,0,0,0-32.8,6.14c-29.08,11.73-52,31.52-71.88,55.27-3.87,4.62-3.66,8.68.4,13.55,16.4,19.67,35.28,36.45,58,48.57,21.45,11.45,43.83,16.45,67.68,8.4,32.51-10.95,57.36-32.39,78.83-58.28,3.4-4.1,2.86-8.18-.95-12.77-14.87-18-32-33.4-52.07-45.28C163.91,69.28,147.79,63,131.91,62.67Zm-2.06,19.42A48.5,48.5,0,1,1,80.91,130,48.62,48.62,0,0,1,129.85,82.09Zm-.42,77.6a29.1,29.1,0,1,0-29.12-29.31A29.19,29.19,0,0,0,129.43,159.69Z"/></svg>
                                <span class="">visibility :</span>
                                <span class="bold ml4">{{ $post->hvisibility }}</span>
                            </div>
                        </div>
                        <div class="post-options-container">
                            @if(is_null($post->deleted_at))
                                <a href="" class="fs12 dark-blue no-underline">
                                    <span>Edit</span>
                                </a>
                                <span class="fs11 dark unselectable">〡</span>
                                <span class="fs12 red pointer align-center delete-post">
                                    <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                    <span>Delete</span>
                                    <input type="hidden" class="post-id" value="{{ $post->id }}" autocomplete="off">
                                </span>
                                <span class="fs11 dark unselectable">〡</span>
                                @if($post->status == 'published')
                                <a href="" class="fs12 dark-blue no-underline">
                                    <span>View</span>
                                </a>
                                @else
                                <a href="" target="_blank" class="fs12 dark-blue no-underline">
                                    <span>Preview</span>
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex mt8" style="margin-bottom: 16px;">
            <div class="move-to-right">
                {{ $posts->appends(request()->query())->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection