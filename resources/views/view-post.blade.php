@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/view.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/comment.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <input type="hidden" id="post-id" value="{{ $post->id }}" autocomplete="off">
    <input type="hidden" id="clap-singular" value="{{ __('clap') }}" autocomplete="off">
    <input type="hidden" id="clap-plural" value="{{ __('claps') }}" autocomplete="off">

    <!-- newsletter viewer -->
    <div id="newsletter-viewer" class="global-viewer full-center none" style="background-color: #16171c9c; z-index: 555555">
        <div id="newsletter-viewer-container">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div id="newsletter-loading-section">
                <svg class="spinner size20 white" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
        </div>
    </div>

    
    <div id="post-box">
        <!-- nav links -->
        <div id="post-nav-links-container">
            <a href="{{ route('root.slash') }}" class="post-nav-link">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="post-nav-link-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('discover') }}" class="post-nav-link">
                <span>{{__('Discover')}}</span>
            </a>
            <svg class="post-nav-link-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('discover', ['category'=>$category->slug]) }}" class="post-nav-link">
                <span>{{ $category->title }}</span>
            </a>
            <svg class="post-nav-link-separator" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('view.post', ['category'=>$category->slug, 'post'=>$post->slug]) }}" class="post-nav-link">
                <span>{{ $post->slug }}</span>
            </a>
        </div>
        @if($fimage = $post->featured_image)
        <div id="feature-image-container" class="none">
            <img src="{{ $fimage }}" id="feature-image" class="pointer open-image-on-image-viewer" alt="">
        </div>
        @endif
        <div id="body-box">
            <article id="post-content-box">
                <div class="post-share-section">
                    <div class="share-container">
                        <span class="mr4 no-wrap">{{ __('Share on') }} :</span>
                        <a href="https://www.facebook.com/Apathosdude/" target='_blank' class="share-anchor">
                            <svg class="facebook share-anchor-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><path d="M54.32.28H5.68a5.4,5.4,0,0,0-5.4,5.4V54.32a5.4,5.4,0,0,0,5.4,5.4h27V35.4H24.6V27.3h8.1V23c0-8.24,4-11.86,10.87-11.86a39.89,39.89,0,0,1,5.83.35v7.75H44.73c-2.91,0-3.92,1.54-3.92,4.64V27.3h8.52l-1.16,8.1H40.81V59.72H54.32a5.4,5.4,0,0,0,5.4-5.4V5.68A5.4,5.4,0,0,0,54.32.28Z"/></svg>
                        </a>
                        <a href="#" class="share-anchor">
                            <svg class="twitter share-anchor-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 310 310"><path d="M303,57.39a117.23,117.23,0,0,1-15,5.46,66.26,66.26,0,0,0,13.5-23.73,5,5,0,0,0-7.32-5.82,118,118,0,0,1-34.88,13.78A66.58,66.58,0,0,0,146.15,94.64a68.24,68.24,0,0,0,.55,8.6,170.37,170.37,0,0,1-116.94-62,5,5,0,0,0-8.19.65,66.61,66.61,0,0,0,6.82,76.59,56.29,56.29,0,0,1-8.91-4,5,5,0,0,0-7.42,4.25c0,.3,0,.59,0,.89a66.76,66.76,0,0,0,32.58,57.23c-1.7-.17-3.39-.41-5.07-.73a5,5,0,0,0-5.7,6.43,66.54,66.54,0,0,0,48.75,44.61,117.71,117.71,0,0,1-62.93,18,120.15,120.15,0,0,1-14.09-.83,5,5,0,0,0-3.29,9.18A179.44,179.44,0,0,0,99.35,281.9c67.75,0,110.14-31.95,133.76-58.75,29.46-33.42,46.36-77.66,46.36-121.37,0-1.82,0-3.67-.09-5.51a129.26,129.26,0,0,0,29.78-31.53A5,5,0,0,0,303,57.39Z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/in/mouad-nassri-2290a5182/" target='_blank' class="share-anchor">
                            <svg class="linkedin share-anchor-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M235.41,2H20.59C10.3,2,2,10.05,2,20V236C2,246,10.3,254,20.59,254H235.41C245.7,254,254,246,254,236V20C254,10.05,245.7,2,235.41,2Zm-157,214H40.3V102.15H78.38Zm-19-129.36h-.25c-12.78,0-21-8.74-21-19.66,0-11.17,8.52-19.67,21.54-19.67s21,8.5,21.29,19.67C80.88,77.87,72.61,86.61,59.34,86.61ZM215.66,216H177.59V155.08c0-15.3-5.51-25.74-19.29-25.74-10.52,0-16.78,7-19.53,13.84-1,2.43-1.25,5.83-1.25,9.23V216H99.44s.5-103.14,0-113.82h38.08v16.12c5.06-7.76,14.11-18.79,34.31-18.79,25,0,43.83,16.27,43.83,51.23Z"/></svg>
                        </a>
                    </div>
                    <div class="post-share-stats-section">
                        <svg class="size24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255,166.15c-2.6,8.16-8.17,14.15-14.13,20-15,14.73-29.78,29.71-44.67,44.56-21,21-48.79,21.06-69.77.12q-32.37-32.29-64.67-64.66c-13-13-12.08-26.82,4.17-39.07-2.38-1.79-4.85-3.15-6.7-5.12-12.3-13.06-6.3-32.84,11.11-37.11,1.22-.3,3.1-1.19,3.26-2.07C75.75,71.33,83,65.43,94,63.49c2.22-14.87,15.46-25.23,32.92-18.2,8.26-11.1,16.87-15,26.86-11.21A31.69,31.69,0,0,1,164.19,41c10.56,10.13,20.79,20.6,31.61,31.4.43-3.07.58-5.59,1.17-8,2.76-11.19,12.58-17.91,24.19-16.7C231.65,48.8,240,58.05,240.27,69.09c.16,6.52.13,13,0,19.56-.05,2.66.39,4.42,3.18,5.72,6.34,2.94,9.26,8.8,11.55,15Zm-14.68-28.66c0-7.5,0-15,0-22.5-.05-5.44-2.71-8.56-7.18-8.64-4.66-.09-7.44,3.12-7.47,8.83-.05,9.78-.08,19.57,0,29.35,0,3.75-1,6.84-4.61,8.38s-6.55-.06-9.15-2.7c-7.45-7.54-15-15-22.47-22.5q-22.83-22.83-45.67-45.65c-4.42-4.4-8.59-4.84-11.93-1.44s-2.74,7.46,1.66,11.91c3.89,4,7.83,7.84,11.75,11.77,5.87,5.88,11.84,11.68,17.58,17.7,3.13,3.28,2.94,7.68,0,10.5s-6.73,2.79-10.16,0c-1-.83-1.87-1.81-2.79-2.74L103.18,83a27.46,27.46,0,0,0-3.2-3c-3.39-2.43-6.81-2.27-9.7.74-2.73,2.85-2.65,6.18-.5,9.38a23.88,23.88,0,0,0,3,3.22l47,47a23.78,23.78,0,0,1,3.28,3.61,6.72,6.72,0,0,1-.79,8.95c-2.71,2.84-6,3.2-9.31,1.05a23.27,23.27,0,0,1-3.59-3.3q-23.54-23.5-47.05-47a23.17,23.17,0,0,0-3.22-3c-3.22-2.12-6.55-2.18-9.38.59-3,2.91-3.11,6.33-.65,9.7a33,33,0,0,0,3.36,3.54c15.79,15.8,31.65,31.53,47.3,47.48,1.87,1.91,3.63,5,3.5,7.49-.12,2.14-2.72,5.45-4.71,5.85a10.57,10.57,0,0,1-8.19-2.39c-10-9.39-19.47-19.26-29.2-28.9-4.1-4.07-8.32-4.43-11.56-1.2s-2.9,7.46,1.21,11.58c22.57,22.62,45.08,45.31,67.83,67.75,13.08,12.9,32.14,12.87,45.2,0,17.44-17.15,34.6-34.57,51.94-51.83a14.83,14.83,0,0,0,4.57-11.4C240.22,151.84,240.32,144.66,240.32,137.49ZM211,128.17c0-5.63-.1-10.29,0-14.95.16-6.52,2.19-13,7.79-16,7-3.8,7.29-9.18,6.89-15.62-.24-3.74,0-7.5-.07-11.25-.14-5-3-8-7.3-8s-7.23,3-7.33,8c-.11,5.71-.12,11.42,0,17.12.09,4.09-.09,8.08-4.46,9.93-4.59,2-7.62-.89-10.62-3.91q-20.49-20.65-41.13-41.17a26,26,0,0,0-3.58-3.32c-3.07-2.07-6.25-2-8.94.61s-2.85,5.75-1,8.91a15.8,15.8,0,0,0,2.57,2.93Q175.66,93.19,207.48,125C208.34,125.86,209.29,126.64,211,128.17Zm-95.59-54,10.53-9.71c-2.49-2-4.74-7.67-10.77-6.5A8.81,8.81,0,0,0,109.47,63C107.57,69.36,113.36,71.85,115.39,74.14ZM23.49,87.32c3.91,0,7.82.21,11.71,0,4.61-.32,7.48-3.45,7.35-7.48s-3.09-6.9-7.81-7q-11.22-.21-22.44,0c-4.73.1-7.69,2.92-7.84,7S7.35,87,12.28,87.32c3.72.21,7.47,0,11.21,0ZM77.8,21.87c-.16-4.87-3.17-7.9-7.49-7.79-4.13.1-7,3-7.11,7.67Q63,33,63.2,44.19c.08,4.87,3.15,7.9,7.48,7.79,4.11-.1,6.95-3,7.11-7.68.14-3.73,0-7.48,0-11.22S77.93,25.6,77.8,21.87ZM30.73,29.53c-3.61-3.27-7.87-3.22-10.81,0s-2.7,7.16.57,10.44q7.91,7.95,16.1,15.62c3.55,3.34,7.86,3.24,10.8.06,2.8-3,2.65-7.11-.56-10.46-2.58-2.69-5.35-5.22-8-7.83S33.5,32,30.73,29.53Z"/></svg>
                        <span class="mx8 ligh-gray fs12">〡</span>
                        <svg class="size22" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>
                    </div>
                </div>
                <div id="post-content" class="none">
                    {!! $post->content !!}
                </div>
                <!-- comments section -->
                <div id="comments-section">
                    <input type="hidden" id="post-comments-sort-key" value="newest" autocomplete="off">

                    <input type="hidden" id="comment-content-required" value="{{ __('Comment content is required') }}" autocomplete="off">
                    <input type="hidden" id="comment-shared-successfully" value="{{ __('Comment shared successfully') }}" autocomplete="off">
                    
                    <!-- comment sorting -->
                    <div id="comment-title-and-sort-container" class="align-center space-between">
                        <span id="comments-title">{{ __('Comments') }} (<span class="post-comments-count">{{ $post->comments_count }}</span>)</span>
                        <div class="relative">
                            <div class="align-center fs13">
                                <span id="comments-sortby">{{ __('sort by') }} :</span>
                                <div class="align-center ml8 pointer button-with-suboptions button-style-4">
                                    <span id="comments-sortby-key" class="unselectable">{{ __('Newest') }}</span>
                                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255.89,84.23c-1.2,1.08-2.45,2.11-3.58,3.25L134.85,204.91c-1.24,1.24-2.54,2.41-3.51,3.32L6.93,83.83l33.4-33.39Q85,95,130.34,140.33l91-91c9.5,9.51,18.44,18.49,27.43,27.41,2.28,2.27,4.73,4.37,7.11,6.55Z"/></svg>
                                </div>
                                <div class="suboptions-container typical-suboptions-container" style="right: 0">
                                    <div class="suboption-style-2 mb2 sort-comments sort-comments-key-selected">
                                        <input type="hidden" class="sort-key-text" value="{{ __('Newest') }}" autocomplete="off">
                                        <input type="hidden" class="sort-key" value="newest" autocomplete="off">
                                        <span>{{ __('Newest first') }}</span>
                                    </div>
                                    <div class="suboption-style-2 mb2 sort-comments">
                                        <input type="hidden" class="sort-key-text" value="{{ __('Oldest') }}" autocomplete="off">
                                        <input type="hidden" class="sort-key" value="oldest" autocomplete="off">
                                        <span>{{ __('Oldest first') }}</span>
                                    </div>
                                    <div class="suboption-style-2 mb2 sort-comments">
                                        <input type="hidden" class="sort-key-text" value="{{ __('Most claps') }}" autocomplete="off">
                                        <input type="hidden" class="sort-key" value="claps" autocomplete="off">
                                        <span>{{ __('Most claps') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($post->allow_comments)
                        <!-- comment input -->
                        <div id="root-comment-input">
                            <x-comment.comment-input root="true" />
                            <div class="align-center pointer comment-display-switch root open none">
                                <svg class="size18 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>    
                                <span class="dark fs13 bold unselectable" style="margin-top: -2px;">{{ __('write a comment') }}..</span>
                            </div>
                        </div>
                    @else
                        <p class="light-gray text-center fs13">{{ __('The author is not currently accepting comments on this post') }}.</p>
                    @endif
                    <div id="comment-input-comments-separator"></div>
                    <div id="post-comments-box">
                        
                    </div>
                    <!-- 
                        if post has comments then we display loading section and only fetch 
                        comments if the visitor reaches the comments section by scroll down to it.
                    -->
                    <div id="post-comments-loading-box" class="@if($post->comments_count == 0) none @endif">
                        <svg class="spinner size24" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="fs12 mt8 dark bold">{{ __('loading comments') }}</span>
                    </div>
                    <div id="comments-fetch-more" class="none">
                        <div class="relative full-center size18 mr8">
                            <svg class="size18 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.52,227.47q-33.72,0-67.45,0c-18.09,0-29.55-11.5-29.55-29.56V63c0-19.39,11.1-30.48,30.49-30.48q67,0,134,0c19.41,0,30.48,11.08,30.49,30.49q0,67.7,0,135.38c0,17.41-11.61,29-29.08,29.07C175.43,227.51,152.48,227.47,129.52,227.47Zm82.76-65.05c.08-1.79.19-3.17.19-4.55q0-47.79,0-95.58c0-10.11-4.74-14.77-15-14.77q-67.47,0-134.94,0c-10.4,0-15,4.68-15,15.22q0,47.33,0,94.65c0,1.64.14,3.28.21,5ZM47.52,177.68c0,6.68,0,12.9,0,19.11C47.53,208,52,212.47,63,212.47H169.86c9.84,0,19.68.07,29.52,0,6.41-.07,11.82-3.43,12.38-9.25.82-8.4.21-16.94.21-25.52Zm68.64-92.07c-4-3.89-8.34-4.1-11.54-.74-3,3.12-2.68,7.52.94,11.22q9,9.19,18.21,18.22c4.37,4.3,8.11,4.29,12.55-.06q9-8.85,17.89-17.89c3.84-3.9,4.2-8.4,1.09-11.57-3.35-3.41-7.61-3-11.87,1.23s-8.52,8.69-13.36,13.64C125.13,94.66,120.7,90.07,116.16,85.61Z" style="stroke:#000;stroke-miterlimit:10;stroke-width:6px"/></svg>
                            <svg class="spinner size15 opacity0 absolute" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span>{{ __('Load more comments') }}</span>
                    </div>
                </div>
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
                    <div id="post-tags">
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
                <!-- newsletter subscription -->
                <div id="newsletter-box">
                    <svg class="icon" fill="#2c3237" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M5.22,96.23c5.69-2.47,11.29-5.14,17.07-7.38Q71.87,69.68,121.52,50.7q50.1-19.19,100.23-38.27c4.78-1.83,9.4-4.3,14.33-5.52,3-.74,7-.56,9.38,1,1.25.82.68,5.79-.32,8.41-4.93,12.88-10.62,25.48-15.41,38.4Q217.94,86.51,207,118.58c-5.84,17-11.16,34.15-16.79,51.21-1.76,5.32-3.65,5.87-8.54,3.18a55.87,55.87,0,0,0-8.68-4.1c-12.71-4.4-25.47-8.6-38.32-12.91-5.13,10.65-12.71,20.65-21,30.24S97.76,205.53,90,215.38c-1.85,2.36-3.89,4.6-6.66,3.29-2.09-1-4.58-3.56-4.82-5.67-1.93-16.74-3.71-33.5-4.86-50.31-.88-12.95-.67-26-1.31-39-.08-1.6-2.16-3.76-3.84-4.52a208.7,208.7,0,0,0-52-15.44c-3.93-.67-7.57-3-11.35-4.65Zm235-80.08-1.51-.87c-15.1,11.64-31,22.38-45.13,35.12-29.34,26.51-57.8,54-86.34,81.35a24.62,24.62,0,0,0-6.3,12.06c-2.49,11.6-3.84,23.43-6,35.1-1.58,8.33-3.82,16.53-5.77,24.79l.82.45,40.7-51.7L108,142l-5.89,25.54-1.6-.35c.91-8.51,1.44-17.09,2.85-25.52,1.06-6.29,3.13-7.38,9.16-5,8.94,3.52,17.52,7.95,26.43,11.54,14.82,6,29.79,11.56,45,17.45C201.16,115.07,216.4,64,240.2,16.15ZM76.66,114.77C90.8,104.39,104,93,119.85,85,130,79.94,139.3,73.17,148.79,66.86,169.53,53,190.16,39,210.83,25.1L210,23.57,19.63,97.39A147.54,147.54,0,0,1,76.66,114.77Zm7.41,83.75,1.67.07c2.43-14.38,5.58-28.7,7.1-43.18,1.55-14.75,6.66-26.62,18-36.83,21.17-19,41.25-39.21,61.77-58.93.15-.13.1-.48.21-1.2-1.08.54-1.92.88-2.68,1.35-7.81,4.77-15.58,9.61-23.42,14.33-13.34,8-27,15.59-40,24.05-9.56,6.19-18.4,13.49-27.51,20.36a4.31,4.31,0,0,0-1.72,2.64c-.44,6.38-1.22,12.81-.85,19.16.56,9.77,1.8,19.52,3.06,29.24S82.6,188.87,84.07,198.52Zm16.69,54c2.79-.54,5.63-.91,8.35-1.7a3.89,3.89,0,0,0,2.45-2.48c.09-.78-1.24-2.28-2.2-2.54-7-1.94-13.51.19-20.11,1.67L89,249l8.86,3.56ZM203.7,209.4c5.75,1.9,11.51,3.77,17.29,5.56a11.37,11.37,0,0,0,4.2.7c2.87-.24,3.52-1.84,2-4.3-4.36-7.23-18.9-9.48-26.29-3.53A18.13,18.13,0,0,0,203.7,209.4Zm-28.49-4c-6,1.87-11,5.2-13.76,10.91l.82,1.47,24.32-8.94C182.77,203.5,178.92,204.23,175.21,205.38Zm-46.33,33c-.36.36.6,3.12,1.26,3.25,5.35,1.07,17.39-7.65,18.79-13.89C140.11,228,134.31,232.94,128.88,238.42ZM52.71,233c3.2,10.83,13.53,17.87,21.15,13.68C66.45,242.07,62,234.47,52.71,233Zm-7.87-6.58c-.9-8.53-4-15.72-7.59-23.3C32,210,36.36,223.21,44.84,226.45Zm206.89,1.28c-3.62-3-7.29-5.91-10.95-8.85-.73,1.12-2.32,2.92-2.06,3.27,2.6,3.32,5.21,6.77,8.44,9.43,2.32,1.91,5.12.17,5-2.64C252,228.61,252,228,251.73,227.73ZM37.58,166.48a29.66,29.66,0,0,0-5.33,17.07c0,1.1,1.35,2.18,2.08,3.27,1-1.07,2.49-2,2.8-3.23a96.8,96.8,0,0,0,2-11.24,42.87,42.87,0,0,0,0-5.67Zm3.73-12.67a3,3,0,0,0,1.71,2,2.74,2.74,0,0,0,2.4-1c2.64-4.45,5.1-9,8.08-14.33C48.08,140.9,40.42,150.27,41.31,153.81ZM115.18,156c-.31,1.34-1.13,2.81-.82,4,.45,1.72,1.72,3.22,2.64,4.81.6-.88,1.79-1.84,1.68-2.63a42.14,42.14,0,0,0-1.74-6.3Zm-3,13.17v-10C108.39,163.5,108.5,166.4,112.14,169.21ZM100,120.26c1.06-1.26,1.28-3.32,1.6-5.07.07-.43-.93-1-1.44-1.58-.77,1.18-1.53,2.35-2.32,3.51a3.23,3.23,0,0,1-.54.5l1.08-1.13-3.54-3.57L92.9,114.4l1.3,9.09C96.84,122.09,98.89,121.57,100,120.26Zm-12.48,7A2.16,2.16,0,0,0,89,128.79a2.07,2.07,0,0,0,1.68-1.17c.37-3.18.7-6.45-3.22-9.29C87.46,121.85,87.38,124.58,87.53,127.3Z"/></svg>
                    <span class="title">{{ __('SUBSCRIBE TO OUR NEWSLETTER') }}</span>
                    <p class="description">{{ __('Receive insightful articles and topics chosen by our expert artisans') }}</p>
                    <div id="newsletter-subscribe-opener-button">
                        <span>{{ __('SUBSCRIBE') }}</span>
                    </div>
                </div>
                <!-- advertisement -->
                <div id="post-square-advertisement-box">
                    <span class="fs11 bold light-gray mb4">{{ __('ADVERTISEMENT') }}</span>
                    <div class="square-advertisement-box">
                        <!-- 340x340 ad -->
                    </div>
                </div>
                <!-- related posts -->
                <div id="related-post-box">

                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection