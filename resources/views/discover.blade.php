@extends('layouts.app')

@section('title', 'Fibonashi - Discover')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/discover.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    
@endsection