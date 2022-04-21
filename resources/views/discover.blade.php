@extends('layouts.app')

@section('title', 'Fibonashi - Discover')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/discover.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/discover.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <div id="discover-left-panel">

    </div>
    <div class="page-padding flex">
        <div id="discover-main">
            <div class="page-path-wrapper align-center">
                <a href="{{ route('root.slash') }}" class="align-center page-path">
                    <span>{{__('Home')}}</span>
                </a>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
                <a href="{{ route('discover') }}" class="page-path">
                    <span>{{__('Discover')}}</span>
                </a>
            </div>
            <div class="align-center">
                <svg class="size22 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.93,253.53c-68-.07-123.6-55.81-123.42-123.74C6.69,61.7,62.5,6.13,130.34,6.48S253.4,62.05,253.49,129.91,197.89,253.6,129.93,253.53Zm.26-24.9A98.63,98.63,0,1,0,31.4,130.47,98.39,98.39,0,0,0,130.19,228.63ZM114.3,110.34a5.81,5.81,0,0,0-3.74,3.27C102.8,133.15,95,152.69,86.88,173.13l59.63-23.74a5.33,5.33,0,0,0,3-3.26c7.72-19.42,15.46-38.83,23.61-59.25C152.81,95,133.57,102.69,114.3,110.34Z"></path></svg>
                <h1 class="title-style">Discover</h1>
            </div>
            <p class="dark my4">Discover latest articles and posts written by our artisans writers</p>
            <div class="posts-box">
                @foreach($posts as $post)
                <div class="post-component">
                    <a href="{{ $post->link }}" class="featured-image-container">
                        <img data-src="{{ $post->featured_image }}" class="featured-image" alt=""> <!-- lazy loaded -->
                    </a>
                    <div class="content-container">
                        <!-- post categories -->
                        <div class="flex flex-wrap mb2">
                            @foreach($post->categories as $category)
                                @if(!$loop->first)
                                <span class="fs10 unselectable dark-blue mt2 mx8">•</span>
                                @endif
                                <a href="" class="category">{{ $category->title }}</a>
                            @endforeach
                        </div>
                        <a href="{{ $post->link }}" class="title">{{ $post->html_title }}</a>
                        <p class="excerpt">{{ $post->excerpt }} <a href="{{ $post->link }}" class="dark-blue no-underline fs12 bold ml4">{{__('read more')}}</a></p>
                        <div class="simple-line-separator half-width my4"></div>
                        <div class="post-bottom-section">
                            <img src="{{ $post->author->avatar(36) }}" class="author-avatar" alt="">
                            <div>
                                <h4 class="dark no-margin align-center author-full-name">{{ $post->author->fullname }} <span class="fs12 default-weight ml4">- {{ $post->author->high_role(true)->title }}</span></h4>
                                <p class="fs12 light-gray no-margin mt2">Published : {{ $post->publish_date }}</p>
                            </div>
                            <div class="move-to-right align-center">
                                <div class="align-center" style="margin-right: 12px">
                                    <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255,166.15c-2.6,8.16-8.17,14.15-14.13,20-15,14.73-29.78,29.71-44.67,44.56-21,21-48.79,21.06-69.77.12q-32.37-32.29-64.67-64.66c-13-13-12.08-26.82,4.17-39.07-2.38-1.79-4.85-3.15-6.7-5.12-12.3-13.06-6.3-32.84,11.11-37.11,1.22-.3,3.1-1.19,3.26-2.07C75.75,71.33,83,65.43,94,63.49c2.22-14.87,15.46-25.23,32.92-18.2,8.26-11.1,16.87-15,26.86-11.21A31.69,31.69,0,0,1,164.19,41c10.56,10.13,20.79,20.6,31.61,31.4.43-3.07.58-5.59,1.17-8,2.76-11.19,12.58-17.91,24.19-16.7C231.65,48.8,240,58.05,240.27,69.09c.16,6.52.13,13,0,19.56-.05,2.66.39,4.42,3.18,5.72,6.34,2.94,9.26,8.8,11.55,15Zm-14.68-28.66c0-7.5,0-15,0-22.5-.05-5.44-2.71-8.56-7.18-8.64-4.66-.09-7.44,3.12-7.47,8.83-.05,9.78-.08,19.57,0,29.35,0,3.75-1,6.84-4.61,8.38s-6.55-.06-9.15-2.7c-7.45-7.54-15-15-22.47-22.5q-22.83-22.83-45.67-45.65c-4.42-4.4-8.59-4.84-11.93-1.44s-2.74,7.46,1.66,11.91c3.89,4,7.83,7.84,11.75,11.77,5.87,5.88,11.84,11.68,17.58,17.7,3.13,3.28,2.94,7.68,0,10.5s-6.73,2.79-10.16,0c-1-.83-1.87-1.81-2.79-2.74L103.18,83a27.46,27.46,0,0,0-3.2-3c-3.39-2.43-6.81-2.27-9.7.74-2.73,2.85-2.65,6.18-.5,9.38a23.88,23.88,0,0,0,3,3.22l47,47a23.78,23.78,0,0,1,3.28,3.61,6.72,6.72,0,0,1-.79,8.95c-2.71,2.84-6,3.2-9.31,1.05a23.27,23.27,0,0,1-3.59-3.3q-23.54-23.5-47.05-47a23.17,23.17,0,0,0-3.22-3c-3.22-2.12-6.55-2.18-9.38.59-3,2.91-3.11,6.33-.65,9.7a33,33,0,0,0,3.36,3.54c15.79,15.8,31.65,31.53,47.3,47.48,1.87,1.91,3.63,5,3.5,7.49-.12,2.14-2.72,5.45-4.71,5.85a10.57,10.57,0,0,1-8.19-2.39c-10-9.39-19.47-19.26-29.2-28.9-4.1-4.07-8.32-4.43-11.56-1.2s-2.9,7.46,1.21,11.58c22.57,22.62,45.08,45.31,67.83,67.75,13.08,12.9,32.14,12.87,45.2,0,17.44-17.15,34.6-34.57,51.94-51.83a14.83,14.83,0,0,0,4.57-11.4C240.22,151.84,240.32,144.66,240.32,137.49ZM211,128.17c0-5.63-.1-10.29,0-14.95.16-6.52,2.19-13,7.79-16,7-3.8,7.29-9.18,6.89-15.62-.24-3.74,0-7.5-.07-11.25-.14-5-3-8-7.3-8s-7.23,3-7.33,8c-.11,5.71-.12,11.42,0,17.12.09,4.09-.09,8.08-4.46,9.93-4.59,2-7.62-.89-10.62-3.91q-20.49-20.65-41.13-41.17a26,26,0,0,0-3.58-3.32c-3.07-2.07-6.25-2-8.94.61s-2.85,5.75-1,8.91a15.8,15.8,0,0,0,2.57,2.93Q175.66,93.19,207.48,125C208.34,125.86,209.29,126.64,211,128.17Zm-95.59-54,10.53-9.71c-2.49-2-4.74-7.67-10.77-6.5A8.81,8.81,0,0,0,109.47,63C107.57,69.36,113.36,71.85,115.39,74.14ZM23.49,87.32c3.91,0,7.82.21,11.71,0,4.61-.32,7.48-3.45,7.35-7.48s-3.09-6.9-7.81-7q-11.22-.21-22.44,0c-4.73.1-7.69,2.92-7.84,7S7.35,87,12.28,87.32c3.72.21,7.47,0,11.21,0ZM77.8,21.87c-.16-4.87-3.17-7.9-7.49-7.79-4.13.1-7,3-7.11,7.67Q63,33,63.2,44.19c.08,4.87,3.15,7.9,7.48,7.79,4.11-.1,6.95-3,7.11-7.68.14-3.73,0-7.48,0-11.22S77.93,25.6,77.8,21.87ZM30.73,29.53c-3.61-3.27-7.87-3.22-10.81,0s-2.7,7.16.57,10.44q7.91,7.95,16.1,15.62c3.55,3.34,7.86,3.24,10.8.06,2.8-3,2.65-7.11-.56-10.46-2.58-2.69-5.35-5.22-8-7.83S33.5,32,30.73,29.53Z"/></svg>
                                    <span class="bold fs14 dark">{{ $post->reactions_count }}</span>
                                </div>
                                <div class="align-center">
                                    <svg class="size18 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M242.59,126.87c.39,68.29-60.46,121.59-128.32,112.48a123.89,123.89,0,0,1-36.32-11,11.92,11.92,0,0,0-7.61-.65c-13.33,3.71-26.56,7.76-39.79,11.8-4.5,1.37-8.67,1.27-12.1-2.23s-3.32-7.43-2-11.73c4-13.23,8.11-26.45,11.8-39.78a12.35,12.35,0,0,0-.77-8.06C-4.8,113.42,30.65,35.22,100.35,17.13,172.34-1.55,242.17,52.33,242.59,126.87ZM41.27,214.68c9.75-2.93,18.41-5.28,26.89-8.16,5.92-2,11-1.41,16.51,1.68,18.92,10.6,39.31,14.16,60.63,10.06,49.8-9.58,81.33-52.89,75.62-103.31-5.77-50.85-56-88.36-106.48-79.54C49.89,46.69,16.77,115.7,48.52,172.9a15.29,15.29,0,0,1,1.38,12.91C47,195,44.37,204.23,41.27,214.68Z"/></svg>
                                    <span class="bold fs14 dark">{{ $post->comments_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($hasmore)
                <div class="post-component posts-fetch-more fetch-more-style">
                    <div class="featured-image-container">
                        <div class="fade-box full-dimensions"></div>
                    </div>
                    <div class="content-container">
                        <div class="flex mb4">
                            <div class="fade-box br2 mr4" style="height: 14px; width: 20%"></div>
                            <div class="fade-box br2" style="height: 14px; width: 20%"></div>
                        </div>
                        <div class="fade-box br2 mb8" style="height: 22px; width: 80%"></div>
                        <div class="fade-box br2 mb4" style="height: 16px; width: 100%"></div>
                        <div class="fade-box br2 mb4" style="height: 16px; width: 100%"></div>
                        <div class="fade-box br2 mb4" style="height: 16px; width: 80%"></div>
                        <div class="flex move-to-bottom mt8">
                            <div class="fade-box rounded size36 mr8"></div>
                            <div class="fade-box br3 mb4" style="height: 34px; width: 40%"></div>
                            <div class="align-center move-to-right" style="width: 30%">
                                <div class="fade-box br2 mr4" style="height: 20px; width: 50%"></div>
                                <div class="fade-box br2" style="height: 20px; width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div id="discover-right-panel">

        </div>
    </div>
@endsection