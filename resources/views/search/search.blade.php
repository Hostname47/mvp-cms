@extends('layouts.app')

@section('title', 'Fibonashi - Search')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/search.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding flex">
        <div id="search-main">
            <!-- path -->
            <div class="page-path-wrapper align-center">
                <a href="{{ route('root.slash') }}" class="align-center page-path">
                    <span>{{__('Home')}}</span>
                </a>
                <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
                <a href="{{ route('search') }}" class="page-path">
                    <span>{{__('Search')}}</span>
                </a>
            </div>
            <!-- session message/errors containers -->
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

            @if(is_null($k))
            <div class="full-center">
                <div id="init-search-container">
                    <div class="align-center mb2">
                        <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.51,206.37a4,4,0,0,1,4.71.52c.53.49,1.06,1,1.58,1.51l31.93,31.92a12.14,12.14,0,0,0,16.88.27q5.79-5.42,11.39-11a12.9,12.9,0,0,0,0-18.26q-15.63-15.52-31.31-31c-.29-.28-1.11-1-1.43-1.28a4,4,0,0,1-1-5.25,110.15,110.15,0,0,0,14.58-38.92C229.44,85,195.67,32.54,146.6,20c-6.25-1.59-12.65-2.62-19-3.89L110,16.32c-9.55,2.24-19.51,3.5-28.44,7.22C43,39.57,20.4,68.72,16.72,110.23c-3.59,40.5,12.55,73.32,46.85,95.2,35.87,22.89,73.09,22.32,109.92.95Zm-55-24.64c-35.1-.71-62.94-29.43-62.06-64,.86-34.23,29.56-62,63.37-61.24,34.61.74,62.59,29.41,61.78,63.29C180.72,154.6,152.4,182.42,118.46,181.73Z"></path></svg>
                        <h1 class="title-style">{{__('Search')}}</h1>
                    </div>
                    <span class="sub-title dark">{{ __('Search for posts, authors, tags.. etc') }}</span>
                    <x-search.search-form 
                        route="search" :placeholder="__('Search for anything')" :hasfilter="true" type="all"/>
                </div>
            </div>
            @else
                <div class="align-center mb8">
                    <svg class="title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.51,206.37a4,4,0,0,1,4.71.52c.53.49,1.06,1,1.58,1.51l31.93,31.92a12.14,12.14,0,0,0,16.88.27q5.79-5.42,11.39-11a12.9,12.9,0,0,0,0-18.26q-15.63-15.52-31.31-31c-.29-.28-1.11-1-1.43-1.28a4,4,0,0,1-1-5.25,110.15,110.15,0,0,0,14.58-38.92C229.44,85,195.67,32.54,146.6,20c-6.25-1.59-12.65-2.62-19-3.89L110,16.32c-9.55,2.24-19.51,3.5-28.44,7.22C43,39.57,20.4,68.72,16.72,110.23c-3.59,40.5,12.55,73.32,46.85,95.2,35.87,22.89,73.09,22.32,109.92.95Zm-55-24.64c-35.1-.71-62.94-29.43-62.06-64,.86-34.23,29.56-62,63.37-61.24,34.61.74,62.59,29.41,61.78,63.29C180.72,154.6,152.4,182.42,118.46,181.73Z"></path></svg>
                    <h1 class="title-style">{{__('Search')}}</h1>
                </div>
                <x-search.search-form 
                    route="search" :placeholder="__('Search for anything')" :hasfilter="true" :type="$type" :k="$k"/>
                <p class="search-result-query-text">{{__('Search results for')}} "<span class="blue unselectable">{{ $k }}</span>"</p>
                
                @if($authors->count())<div class="simple-line-separator my12"></div>@endif
                <!-- authors -->
                @if(in_array($type, ['all','authors']))
                    <div class="align-center">
                        <svg class="size16 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M57.44,255.15q.08-23.37.15-46.72c0-12.28,2.72-15.17,15.37-15.81-4-9.44-8-18.74-11.93-28C57.4,156.14,54.1,147.49,50,139.28c-4-7.88-2.37-13.67,3.57-20a332.26,332.26,0,0,0,56.94-81.89,224,224,0,0,0,9.46-22.84c2.09-5.82,5.7-8.68,10.42-8.7s8.48,3,10.51,8.63c14,39.1,37.23,72.37,64.58,103.08,1.3,1.46,2.57,2.94,4,4.3,4.39,4.31,4.84,9.11,2.42,14.65-7.55,17.35-14.95,34.76-22.39,52.15-.51,1.17-1,2.36-1.42,3.52,1.06,1,2.23.54,3.27.59,7.86.34,11.69,4.15,11.85,12.28.16,7.79,0,15.58.05,23.36.07,8.91.23,17.81.36,26.72H182.11c0-12.48,0-25,.21-37.42.07-3.42-.92-4.31-4.31-4.28-19.6.16-39.21.08-58.81.08q-18.48,0-36.95,0c-2,0-3.87-.28-3.79,2.8.32,12.94-.44,25.89.41,38.83Zm73-210.93c-3.34,6.44-6.11,12.06-9.14,17.53-13.54,24.5-30.12,46.83-48.68,67.74-1.66,1.87-2.89,3.32-1.59,6.26,8,18,15.7,36.18,23.42,54.32.88,2.07,2,2.87,4.28,2.8,6-.17,12-.19,18,0,2.63.08,3.24-.78,3.2-3.29-.15-8.59-.21-17.19,0-25.78.08-3.05-.95-4.54-3.63-5.88-10.42-5.2-16.07-14-16.87-25.41-1.15-16.36,9.75-29.67,26.22-32.77,14-2.64,29.38,6.67,34.05,20.66,5.06,15.14-1.4,30.66-16,38-1.95,1-3,1.88-3,4.27q.19,13.62,0,27.25c0,2.42.74,3,3,3,5.84-.15,11.68-.22,17.51,0,2.88.12,4.19-.88,5.29-3.5q11.2-26.58,22.8-53c1.24-2.83.93-4.55-1.1-6.75A372,372,0,0,1,159.77,94,325.54,325.54,0,0,1,130.47,44.22Zm-.22,96.57a10.3,10.3,0,0,0,.48-20.59,10.3,10.3,0,1,0-.48,20.59Z"></path></svg>
                        <h3 class="search-resource-title">{{ __('Authors') }}</h3>
                        @if(!$authors->count())
                        <p class="italic light-gray fs13 no-margin ml8" style="margin-top: 1px;">{{ __('No authors found') }}</p>
                        @endif
                    </div>
                    <div id="authors-section">
                        @foreach($authors as $author)
                        <div class="author-component">
                            <a href="" class="flex mr6">
                                <img src="{{ $author->avatar(100) }}" class="author-avatar" alt="">
                            </a>
                            <div>
                                <span class="name"><a href="" class="blue no-underline">{{ $author->fullname }}</a> - <span class="posts-count">({{ $author->posts()->count() . ' ' . __('posts') }})</span></span>
                                <span class="username">{{ '@' . $author->username }}</span>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @if($hasmore['authors'])
                    <a href="{{ route('search.authors', ['k'=>$k]) }}" id="authors-see-more">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.52,227.47q-33.72,0-67.45,0c-18.09,0-29.55-11.5-29.55-29.56V63c0-19.39,11.1-30.48,30.49-30.48q67,0,134,0c19.41,0,30.48,11.08,30.49,30.49q0,67.7,0,135.38c0,17.41-11.61,29-29.08,29.07C175.43,227.51,152.48,227.47,129.52,227.47Zm82.76-65.05c.08-1.79.19-3.17.19-4.55q0-47.79,0-95.58c0-10.11-4.74-14.77-15-14.77q-67.47,0-134.94,0c-10.4,0-15,4.68-15,15.22q0,47.33,0,94.65c0,1.64.14,3.28.21,5ZM47.52,177.68c0,6.68,0,12.9,0,19.11C47.53,208,52,212.47,63,212.47H169.86c9.84,0,19.68.07,29.52,0,6.41-.07,11.82-3.43,12.38-9.25.82-8.4.21-16.94.21-25.52Zm68.64-92.07c-4-3.89-8.34-4.1-11.54-.74-3,3.12-2.68,7.52.94,11.22q9,9.19,18.21,18.22c4.37,4.3,8.11,4.29,12.55-.06q9-8.85,17.89-17.89c3.84-3.9,4.2-8.4,1.09-11.57-3.35-3.41-7.61-3-11.87,1.23s-8.52,8.69-13.36,13.64C125.13,94.66,120.7,90.07,116.16,85.61Z" style="stroke-miterlimit:10;stroke-width:6px"></path></svg>
                        {{ __('See more authors') }}
                    </a>
                    @endif
                @endif

                @if($tags->count())<div class="simple-line-separator my12"></div>@endif
                <!-- tags -->
                @if(in_array($type, ['all','tags']))
                <div id="tags-section">
                    <div class="align-center height-max-content">
                        <svg class="size14 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"></path></svg>
                        <h3 class="search-resource-title no-wrap">{{ __('Tags') }}</h3>
                    </div>
                    <div class="tags-wrapper">
                        @foreach($tags as $tag)
                        <a href="{{ route('tag.view', ['tag'=>$tag->slug]) }}" class="tag"><span>#{{ $tag->slug }}</span></a>
                        @endforeach
                        @if(!$tags->count())
                            <p class="italic light-gray fs13 no-margin ml4" style="margin-top: 1px;">{{ __('No tags found') }}</p>
                        @endif
                        @if($hasmore['tags'])
                        <a href="{{ route('tags', ['k'=>$k]) }}" class="flex fs12 bold blue no-underline">
                            {{ __('see more') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if($posts->count())<div class="simple-line-separator my12"></div>@endif

                <!-- posts -->
                @if(in_array($type, ['all','posts']))
                <div id="posts-section">
                    <div class="posts-title-and-pagination">
                        <div>
                            <div class="align-center">
                                <svg class="size16 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,17.11h97.27c11.82,0,15.64,3.73,15.64,15.34q0,75.07,0,150.16c0,11.39-3.78,15.13-15.22,15.13-2.64,0-5.3.12-7.93-.06a11.11,11.11,0,0,1-10.53-9.38c-.81-5.69,2-11,7.45-12.38,3.28-.84,3.52-2.36,3.51-5.06-.07-27.15-.11-54.29,0-81.43,0-3.68-1-4.69-4.68-4.68q-85.63.16-171.29,0c-3.32,0-4.52.68-4.5,4.33q.26,41,0,81.95c0,3.72,1.3,4.53,4.56,4.25a45.59,45.59,0,0,1,7.39.06,11.06,11.06,0,0,1,10.58,11c0,5.62-4.18,10.89-9.91,11.17-8.43.4-16.92.36-25.36,0-5.16-.23-8.82-4.31-9.68-9.66a33,33,0,0,1-.24-5.27q0-75.08,0-150.16c0-11.61,3.81-15.34,15.63-15.34Zm22.49,45.22c16.56,0,33.13,0,49.7,0,5.79,0,13.59,2,16.83-.89,3.67-3.31.59-11.25,1.19-17.13.4-3.92-1.21-4.54-4.73-4.51-19.21.17-38.42.08-57.63.08-22.73,0-45.47.11-68.21-.1-4,0-5.27,1-4.92,5a75.62,75.62,0,0,1,0,12.68c-.32,3.89.78,5,4.85,5C110.54,62.21,131.51,62.33,152.49,62.33ZM62.3,51.13c0-11.26,0-11.26-11.45-11.26h-.53c-10.47,0-10.47,0-10.47,10.71,0,11.75,0,11.75,11.49,11.75C62.3,62.33,62.3,62.33,62.3,51.13ZM102,118.66c25.79.3,18.21-2.79,36.49,15.23,18.05,17.8,35.89,35.83,53.8,53.79,7.34,7.35,7.3,12.82-.13,20.26q-14.94,15-29.91,29.87c-6.86,6.81-12.62,6.78-19.5-.09-21.3-21.28-42.53-42.64-63.92-63.84a16.11,16.11,0,0,1-5.24-12.62c.23-9.86,0-19.73.09-29.59.07-8.71,4.24-12.85,13-13C91.81,118.59,96.92,118.66,102,118.66ZM96.16,151c.74,2.85-1.53,6.66,1.41,9.6,17.66,17.71,35.39,35.36,53,53.11,1.69,1.69,2.59,1.48,4.12-.12,4.12-4.34,8.24-8.72,12.73-12.67,2.95-2.59,2.36-4-.16-6.49-15.68-15.46-31.4-30.89-46.63-46.79-4.56-4.76-9.1-6.73-15.59-6.35C96.18,141.8,96.16,141.41,96.16,151Z"></path></svg>
                                <h3 class="search-resource-title">{{ __('Posts') }} <span class="count">({{ $posts->total() }})</span></h3>
                                <span class="fs7 bold light-gray unselectable mx8">●</span>
                                @if($k)
                                <a href="{{ route('discover', ['q'=>$k]) }}" class="discover-link">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.93,253.53c-68-.07-123.6-55.81-123.42-123.74C6.69,61.7,62.5,6.13,130.34,6.48S253.4,62.05,253.49,129.91,197.89,253.6,129.93,253.53Zm.26-24.9A98.63,98.63,0,1,0,31.4,130.47,98.39,98.39,0,0,0,130.19,228.63ZM114.3,110.34a5.81,5.81,0,0,0-3.74,3.27C102.8,133.15,95,152.69,86.88,173.13l59.63-23.74a5.33,5.33,0,0,0,3-3.26c7.72-19.42,15.46-38.83,23.61-59.25C152.81,95,133.57,102.69,114.3,110.34Z"/></svg>
                                    {{ __('discover') }}
                                </a>
                                @endif
                            </div>
                            <span class="title-after-search-resource-title">{{ __('You can filter your search in discover page') }}</span>
                        </div>
                        <div class="pagination-box">
                            {{ $posts->appends(request()->query())->onEachSide(0)->links() }}
                        </div>
                    </div>
                    <div id="posts-box">
                        @foreach($posts as $post)
                        <x-post.post-card :post="$post" />
                        @endforeach
                    </div>
                    @if(!$posts->count())
                    <div id="no-results-found-box">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M173.75,3.35c9.76,2.95,17.47,8.26,21,18.36.68,2,2.26,1.34,3.65,1.45,9.36.76,15.86,5.84,18.25,14.93.7,2.65,1.92,2.88,4,2.84,4.22-.08,8.47-.54,12.66.41a15.18,15.18,0,0,1,11.79,15.79c-.47,7.15-6.44,13.34-13.39,13.94-2.41.21-4.81.22-5.15-2.93-.3-2.83,1.34-3.83,4-4.33,5.13-.93,7.57-4.34,7-8.89-.58-4.18-3.7-6.58-8.78-6.62-4.07,0-8.17-.24-12.21.12-4.84.43-6.71-1.33-6.81-6.26a11.71,11.71,0,0,0-9.64-11.36,12,12,0,0,0-13.21,7,17.05,17.05,0,0,0-1.18,5.69c-.11,3.27-1.69,4.54-4.81,4.89-5.74.63-8.47,3.49-8.22,8.19s3.52,7.36,9.1,7.4q12.23.11,24.44,0c2.7,0,5.2.33,5.27,3.54s-2.31,3.87-5.07,3.85c-8.31,0-16.61,0-24.92,0-7.85-.08-13.4-3.57-15.66-11.35-.49-1.69-1.44-2.23-3-2.7-13.6-4.13-21.49-14.09-21.35-26.8S149.84,7.78,163.39,4c.24-.07.38-.46.58-.69ZM149.06,30.5a19.86,19.86,0,0,0,14.28,19.33c1.7.48,2.92.77,4-1.26,2.25-4.3,7.31-5.23,10.44-8,2.92-2.6,2.87-8.37,6.38-11.6a7.29,7.29,0,0,1,1.46-1.28c3-1.52,2.37-3.53,1.13-6a20.17,20.17,0,0,0-22.6-10.46A20,20,0,0,0,149.06,30.5ZM254.93,195.05c-1.38-2.45-3.65-2.68-6.15-2.66-8.4.06-16.8,0-25.85,0,3.26-5.78,3.54-11.41,3.21-17.12-.14-2.27-1.38-3.69-3.73-3.66s-3.57,1.39-3.64,3.71.1,4.57-.08,6.84a9.86,9.86,0,0,1-6.85,9.18c0-5.2-.05-9.75,0-14.31,0-2.89-.43-5.48-4-5.38-3.33.09-3.55,2.72-3.54,5.32,0,4.64,0,9.28,0,14.79a40.3,40.3,0,0,1-3.76-2.69c-3.75-3.57-3.27-8.27-3.19-12.82.05-2.64-.75-4.62-3.69-4.63s-3.59,2.13-3.58,4.7c0,5.42-.3,10.88,3.54,16.07H171.07c-1.79,0-3.69-.13-4.91,1.51a3.69,3.69,0,0,0-.31,4.14c1,2,2.83,1.87,4.64,1.87,26.39,0,52.79,0,79.18.06a8.87,8.87,0,0,0,5.26-2ZM62.44,42.76c-3.6,1.91-2.09,4.64-.79,7.09.85,1.6.2,2.32-1,3.16-6.38,4.57-8.82,11-8.81,18.61q0,23,0,46c0,2.86-.08,6.08,3.89,6s3.55-3.46,3.55-6.23c0-15.32,0-30.64,0-46,0-9,5.08-14.42,13.44-14.55,8.64-.13,14,5.32,14,14.48,0,13.2,0,26.4,0,39.6,0,6.12,3.24,9.68,8.54,9.73s8.49-3.46,8.62-9.64c.12-5.86-.08-11.73.09-17.6.15-5.16,3-8,7.86-8s7.83,2.73,7.91,7.92c.14,9.45.26,18.91,0,28.35-.27,8.37-6.87,14.52-15.24,14.75-3.58.1-7.17,0-10.75,0-6.88,0-7,.14-7,7.25,0,15,0,30,0,45,0,2.51-.26,3.8-3.33,3.68-7-.29-14-.27-21-.12-2.61.06-3.28-.75-3.22-3.27.17-6.52.07-13,.06-19.56,0-6.18-.37-6.52-6.75-6.54-3.58,0-7.17.06-10.75,0-8.45-.21-15.07-6.11-15.41-14.57-.4-9.92-.26-19.88,0-29.82.1-4.87,3.21-7.54,7.81-7.53s7.47,2.63,8,7.46c.19,1.78.1,3.58.12,5.37,0,5.22-.12,10.44.19,15.64.26,4.37,3.35,7,7.76,7.22s8-2.2,8.84-6.12c.44-2,.55-4.07-1.73-5s-4.16-.62-5.19,1.95c-.33.81-.37,2.19-1.77,1.75-1.24-.38-.76-1.64-.77-2.52,0-5.87-.08-11.73,0-17.6,0-3.2-.5-6.41-2.6-8.7-2.43-2.65-2.29-4.9-.67-7.71,1.24-2.16,1.52-4.54-1.11-5.88-2.86-1.47-4.58.09-5.58,2.79-.21.57-.44,1.25-1.51,1.24-.84-2.61,1.27-7.1-3.68-7.4-5.18-.32-2.9,4.72-4.51,7.3a35.18,35.18,0,0,0-2.3-3.41,3.19,3.19,0,0,0-4-.64c-1.39.64-2.95,2.26-2.12,3.37,4,5.38.31,9.43-1.71,13.94-.75,1.68-.69,3.82-.71,5.75-.06,9-.09,17.92,0,26.89.11,13.9,9.28,23.26,23.13,23.68a44.21,44.21,0,0,0,5.87,0c2.92-.31,4.06.6,3.89,3.73a121.53,121.53,0,0,0,0,14.66c.22,3.45-1.23,3.95-4.2,3.91-11.89-.14-23.79-.06-35.68-.05-1.14,0-2.29,0-3.43,0-2.47.17-4.08,1.5-3.93,4,.13,2.21,1.61,3.46,4,3.44.82,0,1.63,0,2.45,0H141.65c.81,0,1.63,0,2.44,0,2.29-.06,3.87-1.31,4-3.47.15-2.53-1.66-3.74-4-4-1.13-.11-2.28,0-3.42,0-13.85,0-27.7-.13-41.55.08-3.65.05-5-.67-4.89-4.69.3-11.89.1-23.79.1-35.69,0-8.12,0-8.12,8-8.22,15.7-.21,24.75-9.33,24.82-25.06,0-8.31,0-16.62,0-24.93,0-3.69-.54-7.27-3-10.06-1.83-2.06-1.63-3.77-.5-6,1.23-2.43,2.86-5.32-.88-7-3.39-1.56-4.59,1.11-5.67,3.58-.22.5-.44.75-1.08.39-.5-2.72,1-7-3.63-7.2-5.47-.26-3.44,4.65-4.46,8.12-1.63-2.93-2.68-6.84-6.67-4.73s-1.31,5-.25,7.57c.68,1.62.92,2.84-.49,4.35-3.19,3.38-4.11,7.6-4,12.18.13,4.88.1,9.78,0,14.66,0,1.09.87,3.14-1,3.15s-1.06-2-1.07-3.11c-.07-12.71,0-25.42,0-38.13,0-7-2.08-13.24-7.71-17.69-2.14-1.7-3-3-1.4-5.47,1.38-2.21,1.19-4.56-1.45-5.74s-4.28.25-5.24,2.77c-.22.59-.32,1.64-1.45,1.48-.72-2.84,1.16-7.39-4-7.43s-3,4.71-4.1,7.42C66.07,42.61,64.61,41.6,62.44,42.76Zm78.79,193.17a17,17,0,0,1,0,3.42c-.4,1.87,1.46,4.91-1.18,5.39-2.14.38-3.59-2.33-4.69-4.38s-1.06-4.06-1.13-6.17c-.05-1.79,0-3.59-.14-5.37a3.33,3.33,0,0,0-3.68-3.16,3.25,3.25,0,0,0-3.52,3.29c-.07,3.09-.36,6.26.15,9.27,1.32,7.75,5.88,12.88,13.57,15a17.84,17.84,0,0,0,18.64-6.65c3.39-4.41,3.89-9.49,3.76-14.8-.08-2.89,0-6.14-3.76-6.15s-3.8,3.26-3.79,6.13c0,1.79,0,3.59-.14,5.37a9.55,9.55,0,0,1-3.57,6.71c-.72.63-1.5,1.5-2.53,1.14-1.21-.43-.69-1.66-.7-2.54-.06-4.4,0-8.8-.06-13.2,0-2.43-1.61-3.58-3.78-3.52a3.18,3.18,0,0,0-3.37,3.41c0,2.28,0,4.56,0,6.84ZM27.87,217.67c-2.56,0-4.62.71-4.75,3.65s1.82,3.91,4.44,3.91H59.77c2.47,0,4.2-1.12,4.29-3.64.09-2.85-1.79-3.93-4.46-3.92-5.21,0-10.42,0-15.62,0C38.61,217.68,33.24,217.7,27.87,217.67ZM225.48,242c2.57,0,4-1.13,4-3.75s-1.56-3.44-3.81-3.44q-13.92,0-27.84,0c-2.31,0-3.75,1.08-3.78,3.5,0,2.67,1.46,3.73,4,3.7,4.56-.05,9.12,0,13.68,0S220.92,242,225.48,242ZM85.24,217.75a3.46,3.46,0,0,0-3.5,3.85A3.23,3.23,0,0,0,85,225.14c4.21.17,8.45.14,12.66,0a3.33,3.33,0,0,0,3.27-3.58,3.41,3.41,0,0,0-3.51-3.82c-1.94-.11-3.89,0-5.84,0C89.46,217.72,87.34,217.59,85.24,217.75Z" style="fill:#080808"/></svg>
                        <p class="bold-text">{{ __('No posts found') }}.</p>
                        <p class="desc-text">{{ __('We cannot find any post that matches your search query') }}.</p>
                    </div>
                    @endif
                    <div class="flex mt8" style="margin-bottom: 16px;">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
@endsection