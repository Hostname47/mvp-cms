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
            <h2 class="section-title">Raw post content</h2>
            <xmp id="raw-post-content">
                {!! $post->content !!}
            </xmp>
            <div id="display-switch" class="0">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
            </div>
        </div>
    </div>
@endsection