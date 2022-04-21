@extends('layouts.app')

@section('title', 'Fibonashi - Discover')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/discover.css') }}">
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/discover.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <div id="discover-left-panel">
        <div class="align-center">
            <svg class="size13 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"/></svg>
            <h3 class="no-margin dark">Categories</h3>
        </div>
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