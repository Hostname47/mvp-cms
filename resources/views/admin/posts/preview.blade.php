@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
@endpush

@section('content')
<div class="full-center">
    <article id="post-box">
            @if($post->has_featured_image())
            <section>
                <img src="{{ $post->featured_image }}" id="post-featured-image" alt="">
            </section> <!-- featured image -->
            @endif
            {!! $post->content !!}
        </article>
    </div>
@endsection