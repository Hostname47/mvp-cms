@extends('layouts.app')

@section('title', 'Fibonashi - Credits')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/credits.css') }}">
@endpush

@section('content')
    <x-layout.left-panel.left-panel />
    <div class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('credits') }}" class="page-path">
                <span>{{__('Credits')}}</span>
            </a>
        </div>
        <h1 class="title-style text-center">{{ __('Credits') }}</h1>
        <em class="quote-after-title">{{ __('All credits goes to ALLAH') }}.</em>

        <div id="credits-main">
            <p class="text">I want to thank god who gave me the energy and will to create this website under toughest conditions. Before publishing this website, I got a lot of negative feedbacks and opinions in different aspects. As the saying goes : 'What doesn't kill you, makes you stronger', I took these negativity as a challenge and I start to work on this website for more than 8 hours a day until I finish the first stable version that I'm really proud of.</p>
            <p class="text">Most blog and content websites does not offer the ability for their members to contribute and share content, the thing that make this website different than any other blog. By giving members the ability to publish and write content about things they are passionate about creates a feeling of community and not just consuming content. Also we provide reactions to posts and comments to improve interactivity between readers and content writers.</p>
            <p class="text">We are currently working on 'corrections' feature where members can fix typos and suggest corrections about fake or wrong informations to improve the quality of our authors content.</p>
            <p class="text">Please, If you find any error, bug or anything inappropriate, don't hesitate to contact us.</p>
            <p class="text">Founder : <strong><a href="https://twitter.com/NassriMouad" class="link-style">MOUAD NASSRI</a></strong></p>
        </div>
    </div>
@endsection