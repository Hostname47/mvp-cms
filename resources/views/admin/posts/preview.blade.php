@extends('layouts.admin')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/post/preview.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/admin/post/preview.js') }}" type="text/javascript" defer></script>
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts'])
@endsection

@section('content')
    <div id="main-box">
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

        <div id="raw-post-box">
            <div class="align-center space-between">
                <h2 class="section-title">Raw post content</h2>
                <a href="{{ route('edit.post', ['post'=>$post->id]) }}" class="button-style-2">configure post</a>
            </div>
            <xmp id="raw-post-content">
                {!! $post->content !!}
            </xmp>
            <div id="display-switch" class="0">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
            </div>
        </div>

        <div id="content-post-box">
            <h2 class="section-title">Post content</h2>

            @if($post->has_thumbnail())
            <div id="thumbnail-image-container">
                <img src="{{ $post->thumbnail_image }}" id="thumbnail-image" class="pointer open-image-on-image-viewer" alt="">
            </div>
            @endif
            <article id="post-content-box">
                <div id="post-content">
                    {!! $clean_content !!}
                </div>
            </article>
            <div class="simple-line-separator" style="margin: 16px 0 32px 0"></div>
            <div class="post-meta">
                <!-- date -->
                <div id="post-date" class="post-meta-text">
                    {{__('CREATED')}} :
                    <time class="entry-date" datetime="{{ $post->published_at }}">{{ strtoupper($post->creation_date) }}</time>
                    {{__('BY')}} :
                </div>
                <!-- author -->
                <div id="post-author">
                    @if($post->author)
                    <img src="{{ $post->author->avatar(100) }}" id="author-avatar" alt="">
                    <div>
                        <a href="{{ $post->author->profile }}" id="author-name">{{ $post->author->fullname }}</a>
                        <span id="author-role">{{ $post->author->high_role()->title }}</span>
                    </div>
                    @else
                    <div id="author-avatar">
                        <svg class="f" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M56.69,31H205.78C204.5,44.71,203.3,57.53,202,71.37L191.28,72c-.83-1.56-1.44-2.25-1.57-3-4-24.39,1.61-21.18-25.79-24.67a135.39,135.39,0,0,0-14.38-.91c-7.85-.15-15.71,0-25,0V120.8c13.22,0,27.24,1.45,40.65-.77,4.86-.81,8.27-10.4,10.27-18.34l12.17-.62v59.62H176.14c-.54-.81-1.35-1.48-1.44-2.24-2.6-21.54-2.58-21.67-25-22.86-8.2-.43-16.44-.07-25.59-.07,0,24.42-.31,48.26.15,72.08.19,9.88,8.6,9,15.49,10,6.07.88,15.59-1.06,11.61,11.47h-94c-1.32-9.18-1.36-10,6.22-10.34,12.28-.49,16.17-6.13,16-18.13-.53-46.73-.38-93.46-.16-140.19.15-11.12-2-18.7-15.42-18.78-3.26,0-6.5-4.93-9.74-7.6Z"/></svg>
                    </div>
                    <div>
                        <div id="author-name">{{ __('fibonashi') }}</div>
                        <span id="author-role">{{ __('Contributor Author') }}</span>
                    </div>
                    @endif
                    
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
                        <a href="{{ $category->link }}" class="category">{{ $category->title }}</a>
                    @endforeach
                </div>
                
                @if($post->tags->count())
                <div id="post-tags">
                    <div class="align-center mb4" style="flex-basis: 100%;">
                        <svg class="size12 mr8" fill="#2d363e" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"></path></svg>
                        <span class="post-meta-text">{{ ($post->tags->count() > 1) ? __('TAGS') : __('TAG')  }} :</span>
                    </div>
                    @foreach($post->tags as $tag)
                        <a href="{{ $tag->link }}" class="tag">{{ $tag->title }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection