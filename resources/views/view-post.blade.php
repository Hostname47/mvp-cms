@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/view.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
@endpush

@section('content')
    <div id="post-box">
        @if($fimage = $post->featured_image)
        <div id="feature-image-container">
            <img src="{{ $fimage }}" id="feature-image" alt="">
        </div>
        @endif
        <div id="body-box">
            <article id="post-content-container">
                {!! $post->content !!}
            </article>
            <div id="right-panel-container">
                <!-- published by & publish date & categories -->
                <div class="post-meta">
                    <!-- date -->
                    <div id="post-date" class="post-meta-text">
                        {{__('PUBLISHED')}} :
                        <time class="entry-date" datetime="{{ $post->published_at }}">{{ strtoupper($post->short_publish_date) }}</time>
                        {{__('BY')}} :
                    </div>
                    <!-- author -->
                    <div id="post-author">
                        <img src="{{ $post->author->avatar(100) }}" id="author-avatar" alt="">
                        <div>
                            <a href="" id="author-name">{{ $post->author->fullname }}</a>
                            <span id="author-role">{{ $post->author->high_role()->title }}</span>
                        </div>
                    </div>
                    <div id="post-categories" class="post-meta-text mt8">
                        <div class="align-center">
                            <svg class="size13 mr8" style="margin-top: -2px;" fill="#2d363e" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.49,146.2q-32.57,0-65.12,0c-7.57,0-10.44-2.8-10.46-10.22q-.06-23.25,0-46.51c0-7.21,2.85-10,10.12-10q65.1,0,130.22,0c7.16,0,10,2.85,10,10.17q.1,23.27,0,46.51c0,7.21-3,10.07-10.13,10.08Q188.8,146.24,156.49,146.2Zm64.63,83.56c7.26,0,10.09-2.83,10.12-10.07q.1-23.25,0-46.5c0-7.23-3-10.26-10-10.27q-65.1-.06-130.21,0c-7.11,0-10.09,3-10.11,10.16,0,15,0,30,0,45,0,9.24,2.36,11.65,11.48,11.66q31.82,0,63.64,0C177.71,229.78,199.41,229.82,221.12,229.76ZM30.64,200c0,3.73.86,5.17,4.86,5,6.67-.33,13.38-.09,20.07-.09,13.45,0,13.37,0,12.78-13.5-.12-2.65-1-3.33-3.45-3.25-4.41.14-8.83-.11-13.22.08-3,.14-4.32-.63-4.29-4q.21-29.62,0-59.26c0-3.11,1.16-3.91,4-3.81,4.57.17,9.14.06,13.71,0,1.42,0,3.19.27,3.12-2-.14-4.7,1.63-10.14-.75-13.87-1.65-2.59-7-.58-10.72-.85a17.62,17.62,0,0,0-3.91,0c-4.17.61-5.58-.77-5.52-5.25.27-19.58.12-39.17.12-58.76,0-11.19,0-10.92-11.31-11.26-4.75-.15-5.55,1.58-5.52,5.81.16,27.26.08,54.52.08,81.79C30.71,144.46,30.78,172.21,30.64,200Z"></path></svg>
                            <span>{{ ($post->categories->count() > 1) ? __('CATEGORIES') : __('CATEGORY')  }} :</span>
                        </div>
                        @foreach($post->categories as $category)
                            @if(!$loop->first)
                            <span class="category-separator">〡</span>
                            @endif
                            <a href="" class="category">{{ $category->title }}</a>
                        @endforeach
                    </div>
                    
                    @if($post->tags->count())
                    <div id="post-tags" class="mt8">
                        <div class="align-center mb4" style="flex-basis: 100%;">
                            <svg class="size12 mr8" fill="#2d363e" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"></path></svg>
                            <span class="post-meta-text">{{ ($post->tags->count() > 1) ? __('TAGS') : __('TAG')  }} :</span>
                        </div>
                        @foreach($post->tags as $tag)
                            <a href="" class="tag">{{ $tag->title }}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection