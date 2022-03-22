@extends('layouts.admin')

@section('title', 'Admin- dashboard')

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.dashboard'])
@endsection

@section('content')
    <div class="admin-top-page-box">
        <h1 class="fs24 dark no-margin">Admin Dashboard</h1>
    </div>
    <div class="">
    </div>
@endsection