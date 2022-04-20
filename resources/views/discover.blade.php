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
        <div>
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
            @foreach($posts as $post)
            <div class="post-component">
                <div class="featured-image-container">
                    <img src="{{ $post->featured_image }}" class="featured-image" alt="">
                </div>
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
                    <a href="" class="title">Lorem ipsum dolor sit amet consectetur adipisicing elit.</a>
                    <p class="summary">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad veritatis id porro delectus velit provident dicta reiciendis optio? Eveniet obcaecati recusandae ex mollitia voluptas esse nesciunt doloremque delectus, fugit earum <a href="" class="dark-blue no-underline ml4">{{__('read more')}}</a></p>
                    <div class="simple-line-separator my8"></div>
                    <div class="flex mt8">
                        <img src="{{ $post->author->avatar(36) }}" class="author-avatar" alt="">
                        <div>
                            <h4 class="dark no-margin align-center author-full-name">{{ $post->author->fullname }} <span class="fs12 default-weight ml4">- {{ $post->author->high_role(true)->title }}</span></h4>
                            <p class="fs12 light-gray no-margin mt2">Published : {{ $post->publish_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div id="discover-right-panel">

        </div>
    </div>
@endsection