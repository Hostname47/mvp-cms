@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/view.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/post.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('js/comment.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <input type="hidden" id="post-id" value="{{ $post->id }}" autocomplete="off">
    <input type="hidden" id="comment-id" value="{{ request()->get('comment') }}" autocomplete="off">
    <input type="hidden" id="clap-singular" value="{{ __('clap') }}" autocomplete="off">
    <input type="hidden" id="clap-plural" value="{{ __('claps') }}" autocomplete="off">
    
    @include('partials.viewers.newsletter-viewer')
    <!-- delete a comment -->
    <div id="delete-comment-viewer" class="global-viewer full-center none">
        <div class="viewer-box-style-1">
            <div class="flex align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                <div class="flex align-center">
                    <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                    <span class="fs20 bold dark">{{__('Delete comment')}}</span>
                </div>
                <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
            </div>
            <div style="padding: 14px;" class="dark">
                <div class="flex" style="margin-top: 16px">
                    <div class="align-center">
                        <svg class="size16 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"></path></svg>
                        <p class="fs13 bold no-margin">{{ __('Comment') }} :</p>
                    </div>
                    <div class="fs13 bold ml4 comment-delete-content">hello darkness Lorem ipsum dolor</div>
                </div>
                <div class="simple-line-separator my12"></div>
                <p class="no-margin bold mt8">{{__('Are you sure you want to delete this comment')}} ?</p>
                <div class="flex">
                    <div class="move-to-right align-center" style="margin-top: 12px;">
                        <span class="mr8 bold dark pointer unselectbale close-global-viewer">{{__('cancel')}}</span>
                        <div class="typical-button-style pointer align-center red-bs delete-comment" style="padding: 7px 12px">
                            <div class="relative size13 mr4">
                                <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"/></svg>
                                <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs12 white unselectable">Delete comment</span>
                            <input type="hidden" class="comment-id" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- report viewer -->
    <div id="report-resource-box" class="none"><!-- filled dynamically --></div>
    
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
        @if($post->visibility == 'password-protected')
            <div id="password-protected-box">
                <input type="hidden" id="password-required-message" value="{{ __('password field is required') }}">

                <svg class="lock-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"></path></svg>
                <h2 class="title">{{ __('This post is password protected') }}</h2>
                <!-- error container -->
                <div class="informative-message-container align-center none relative my8" id="password-lock-error-container">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <div class="no-margin fs13 error message-text"></div>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
                <label for="lock-password" class="label">{{ __("The author lock this post by a password. Please fill in the password to unlock") }}</label>
                <input type="text" class="styled-input" id="lock-password" autocomplete="off" placeholder="{{ __('Enter post password') }}">
                <div id="unlock-post" class="typical-button-style pointer align-center dark-bs" style="padding: 7px 12px">
                    <div class="relative size13 mr4">
                        <svg class="size13 flex icon" fill='white' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"></path></svg>
                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="bold fs12 white unselectable">{{__('unlock')}}</span>
                    <input type="hidden" class="comment-id" autocomplete="off">
                </div>
            </div>
        @else
            @if($fimage = $post->featured_image)
            <div id="feature-image-container">
                <img src="{{ $fimage }}" id="feature-image" class="pointer open-image-on-image-viewer" alt="">
            </div>
            @endif
            <div id="body-box">
                <article id="post-content-box">
                    @include('partials.post.sharer')
                    <div id="post-content">
                        {!! $post->content !!}
                    </div>
                </article>
                <div id="right-panel-container" class="sticky-when-bottom-reached">
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
                            @if($post->author)
                            <img src="{{ $post->author->avatar(100) }}" id="author-avatar" alt="">
                            <div>
                                <a href="" id="author-name">{{ $post->author->fullname }}</a>
                                <span id="author-role">{{ $post->author->high_role()->title }}</span>
                            </div>
                            @else
                            <div id="author-avatar">
                                <svg class="f" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M56.69,31H205.78C204.5,44.71,203.3,57.53,202,71.37L191.28,72c-.83-1.56-1.44-2.25-1.57-3-4-24.39,1.61-21.18-25.79-24.67a135.39,135.39,0,0,0-14.38-.91c-7.85-.15-15.71,0-25,0V120.8c13.22,0,27.24,1.45,40.65-.77,4.86-.81,8.27-10.4,10.27-18.34l12.17-.62v59.62H176.14c-.54-.81-1.35-1.48-1.44-2.24-2.6-21.54-2.58-21.67-25-22.86-8.2-.43-16.44-.07-25.59-.07,0,24.42-.31,48.26.15,72.08.19,9.88,8.6,9,15.49,10,6.07.88,15.59-1.06,11.61,11.47h-94c-1.32-9.18-1.36-10,6.22-10.34,12.28-.49,16.17-6.13,16-18.13-.53-46.73-.38-93.46-.16-140.19.15-11.12-2-18.7-15.42-18.78-3.26,0-6.5-4.93-9.74-7.6Z"/></svg>
                            </div>
                            <div>
                                <div href="" id="author-name">{{ __('fibonashi') }}</div>
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
                    @include('partials.ads.250x250')
                    <!-- related posts -->
                    <div id="related-post-box">

                    </div>
                    <div class="compass"></div>
                </div>
            </div>
            <!-- comments section -->
            <div id="comments-section">
                <input type="hidden" id="post-comments-sort-key" value="newest" autocomplete="off">

                <input type="hidden" id="comment-content-required" value="{{ __('Comment content is required') }}" autocomplete="off">
                <input type="hidden" id="comment-shared-successfully" value="{{ __('Comment shared successfully') }}" autocomplete="off">
                <input type="hidden" id="comment-deleted-successfully" value="{{ __('Comment deleted successfully') }}" autocomplete="off">
                
                <!-- comment sorting -->
                <div id="comment-title-and-sort-container" class="align-center space-between">
                    <span id="comments-title">{{ __('Comments') }} (<span class="post-comments-count">{{ $post->comments_count }}</span>)</span>
                    <div class="relative">
                        <div class="align-center">
                            <span id="comments-sortby">{{ __('sort by') }} :</span>
                            <div class="align-center ml4 pointer button-with-suboptions button-style-4">
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
                            <span class="dark fs14 bold unselectable" style="margin-top: -2px;">{{ __('write a comment') }}..</span>
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
        @endif
    </div>
    @include('partials.footer')
@endsection