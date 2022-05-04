@extends('layouts.app')

@section('title', 'Fibonashi - Tags')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
<link rel="stylesheet" href="{{ asset('css/tags.css') }}">
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
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
                <a href="{{ route('tags') }}" class="page-path">
                    <span>{{__('Tags')}}</span>
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
            <div class="align-center mb8">
                <svg class="title-icon" style="max-width: 18px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"></path></svg>
                <h1 class="title-style">{{__('Tags')}}</h1>
            </div>
            <p id="tag-page-description">{{ __("A tag is a keyword or label that categorizes your question with other, similar articles. Using the right tags makes it easier for others to find relevant articles and posts") }}.</p>
            
            <x-search.search-form 
                route="tags" :placeholder="__('Search for tags')" :hasfilter="false" type="authors" :k="$k"/>

            <div id="tags-container">
                @foreach($tags as $tag)
                <div class="tag-component">
                    <div class="flex"><a class="tag" href="?tag={{ $tag->slug }}">#{{ $tag->slug }}</a></div>
                    <span class="tag-description">{{ $tag->description }}</span>
                    <span class="posts-count">{{ $tag->posts_count }} {{ __('posts') }}</span>
                </div>
                @endforeach
            </div>
            <div class="flex bottom-pagination">
                <div class="move-to-right">{{ $tags->appends(request()->query())->onEachSide(0)->links() }}</div>
            </div>
        </div>
    </div>
@endsection