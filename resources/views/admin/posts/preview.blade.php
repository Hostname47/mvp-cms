@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
@endpush

@section('content')
<div class="full-center">
    <article id="post-box">
            @if($post->has_thumbnail())
            <section>
                <img src="{{ $post->thumbnail_image }}" id="post-thumbnail-image" alt="">
            </section> <!-- thumbnail image -->
            @endif
            {!! $post->content !!}
        </article>
    </div>
@endsection