@extends('layouts.app')

@section('title', "$post->title_meta")

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post/post-section.css') }}">
@endpush

@section('content')
    <section></section> <!-- featured image -->
    <div class="full-center">
        <article id="post-box">
            {!! $post->content !!}
        </article>
    </div>
@endsection