@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
@endpush

@section('content')
    @if($post->has_featured_image())
    <section>
        <img src="{{ $post->featured_image }}" id="post-featured-image" alt="">
    </section> <!-- featured image -->
    @else
    @endif
    <div class="full-center">
        <article id="post-box">
            {!! $post->content !!}
        </article>
    </div>
@endsection