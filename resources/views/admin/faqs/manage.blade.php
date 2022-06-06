@extends('layouts.admin')

@section('title', 'Admin - FAQs')

@push('scripts')
<script src="{{ asset('js/admin/faqs.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/faqs.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'faqs.management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size20 mr8" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M172,197.68H26c-.18-.8-.89-.74-1.47-.91-11-3.28-18.21-10.39-21.3-21.53-.13-.5-.23-1-.8-1.13V26.62c1.27-.76,1-2.2,1.42-3.32A29.25,29.25,0,0,1,31.39,3.11q68.41-.12,136.83,0a29,29,0,0,1,28.84,28.81q.19,68.4,0,136.8c0,11.76-6,20.32-16.32,25.9C178,196.13,174.82,196.4,172,197.68ZM99.58,178.1q33.08,0,66.15,0c8.69,0,11.83-3.17,11.84-12q0-65.76,0-131.51c0-8.79-3.16-12-11.84-12q-66,0-131.91,0c-8.7,0-11.85,3.19-11.85,12q0,65.76,0,131.52c0,8.79,3.15,12,11.84,12Q66.69,178.12,99.58,178.1Zm7.85-61c3.14-.87,5.22-2.92,5.21-6.17,0-2.74,1.41-3.54,3.56-4.47,11.86-5.17,19.24-14,20-27.14A35,35,0,0,0,110.7,43.61C93.47,38.71,75.17,45.29,67.23,60c-6.88,12.7-5.68,17.26,8.94,21.75,6,1.84,9.24,0,11.55-5.9,2.82-7.2,6-9.23,13.77-8.87,5.59.26,8.42,2.22,9.76,6.75,1.64,5.5.36,9.44-4.09,12.66-2.5,1.82-5.43,2.62-8.26,3.71-6.13,2.34-10,6.46-11,13.25-1.6,10.93,1.42,14.65,12.34,14.54A26.08,26.08,0,0,0,107.43,117.1ZM85.35,144.17c0,.76,0,1.52,0,2.27.2,8.27,3,11.28,11.32,12.1a36,36,0,0,0,9.45-.38,8.54,8.54,0,0,0,7.5-7,31.91,31.91,0,0,0,.44-10.93c-.73-7.14-3.78-10-11-10.42a51.5,51.5,0,0,0-8,.17c-6.13.57-9,3.51-9.66,9.63a43.13,43.13,0,0,0,0,4.55Z"></path></svg>
            <h1 class="fs20 dark no-margin">Faqs</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="align-center">
                <span class="fs13 bold">{{ __('Faqs management') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        @include('partials.session-messages')
        <h2 class="no-margin fs18 dark">Frequently asked questions management</h2>
        <p class="dark lh15 my8">The following faqs section includes faqs defined by admins as well as received faqs from users. Also we have two parts : the first one includes the faqs that are live (accessible in faqs page), and the second part is the unverified faqs either defined by admins or submitted by users.</p>

        <!-- Live faqs -->
        <div class="faqs-wrapper">
            <h3 class="fs16 bold blue mb4">1. Live FAQs (<span class="faqs-count">{{ $live_faqs->count() }}</span>)</h3>
            <p class="dark my8">The following faqs are live (accessible by users in faqs page). You can change their priority to decide which comes first.</p>
            <div class="my8 typical-section-style flex">
                <svg class="size14 mr8" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="no-margin dark fs12">Please remember, before accepting or updating any record, don't forget to <strong>handle i18n</strong> of the question and its answer.</p>
            </div>
            <div class="flex align-end space-between mt8 mb4">
                <p class="gray no-margin mr8">The faqs in client side will be displayed similar to the following order after you click on order by priority button</p>
                <div class="align-center">
                    <div id="sort-faqs-components-by-priority" class="typical-button-style align-center" style="padding: 4px 8px;">
                        <svg class="size12 mr4" style="min-width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M158.72,140.8c4.15-4.28,8.25-8.63,12.48-12.85,5.68-5.67,12.6-6.18,17.5-1.41s4.6,11.89-1,17.52q-16.15,16.31-32.48,32.46c-5.85,5.79-12.26,5.71-18.15-.13q-16.45-16.33-32.78-32.8c-5.26-5.31-5.52-12-.84-16.81s11.83-4.65,17.18.61c4.38,4.3,8.63,8.74,13.16,13.34,1.25-1.69.76-3.35.77-4.84,0-19.06,0-38.12,0-57.18,0-8,4.33-12.94,11.1-13.18,6.95-.23,12,4.74,12,12.21.07,19.36,0,38.72,0,58.08v4.41ZM114.88,42.33c10.51,0,21,.12,31.53-.07a11.33,11.33,0,0,0,11.32-11.12c.19-6-4-10.81-10.21-11.72a31.93,31.93,0,0,0-4.49-.23q-60.36,0-120.74,0a27.88,27.88,0,0,0-4.92.34A11.32,11.32,0,0,0,8.16,33.59c1.22,5.37,5.95,8.72,12.56,8.73q31.08,0,62.17,0Q98.88,42.33,114.88,42.33ZM98.71,88.4c7.69,0,12.88-4.66,12.93-11.39s-5.13-11.5-12.79-11.52q-39.19-.1-78.38,0c-7.79,0-12.67,4.68-12.59,11.61s5.06,11.27,12.9,11.3c13.06,0,26.13,0,39.19,0C72.88,88.41,85.8,88.45,98.71,88.4ZM20.34,111.64c-7.45.07-12.36,4.56-12.46,11.24s4.65,11.58,12,11.64q22.48.19,45,0c7.38-.07,12.13-4.89,12-11.68-.12-6.54-4.93-11.1-12-11.2-7.49-.09-15,0-22.47,0C35,111.62,27.68,111.57,20.34,111.64Z"/></svg>
                        <div class="btn-text fs12 bold unselectable no-wrap">{{ __('order by priority') }}</div>
                    </div>
                    <div id="update-faqs-priorities" class="typical-button-style dark-bs align-center ml8" style="padding: 5px 8px;">
                        <div class="relative size12 mr4">
                            <svg class="size12 icon-above-spinner" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"/><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"/></svg>
                            <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <div class="btn-text fs12 bold unselectable no-wrap">{{ __('save priorities') }}</div>
                    </div>
                </div>
            </div>
            <div id="live-faqs-container" class="typical-section-style">
                @foreach($live_faqs as $faq)
                <x-admin.faqs.faq :faq="$faq" />
                @endforeach

                @if(!$live_faqs->count())
                <div class="full-center">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="dark bold my4 fs12">You don't have any live faqs available fr the moment.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Unverified faqs -->
        <div class="faqs-wrapper">
            <h3 class="fs16 bold blue mb4">2. Unverified FAQs (<span class="faqs-count">{{ $unverified_faqs->total() }}</span>)</h3>
            <p class="dark my8">The following faqs are unverified (not accessible by users in faqs page) faqs that are received from users in faqs page.</p>
            <div id="unverified-faqs-container">
                @foreach($unverified_faqs as $faq)
                <x-admin.faqs.faq :faq="$faq"/>
                @endforeach

                @if(!$unverified_faqs->count())
                <div class="full-center">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="dark bold my4 fs12">There's no received faqs for the moment.</p>
                </div>
                @endif
            </div>

            <div class="full-center my12">
                {{ $unverified_faqs->appends(request()->query())->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
</main>
@endsection