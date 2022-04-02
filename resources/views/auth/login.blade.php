@extends('layouts.app')

@section('header')
    @include('partials.header')
@endsection

@push('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@section('content')
<div id="auth-section" class="full-center">
    <div id="auth-viewer-box">
        @include('partials.auth.login-form')
    </div>
</div>
@endsection
