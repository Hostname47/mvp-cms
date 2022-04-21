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
            <div id="posts-box">
                @foreach($posts as $post)
                <x-post.post-card :post="$post" />
                @endforeach
            </div>
            @if($hasmore)
            <div id="posts-fetch-more" class="post-component fetch-more-style">
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
        <div id="discover-right-panel">

        </div>
    </div>
@endsection