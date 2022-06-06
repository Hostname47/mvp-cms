@extends('layouts.admin')

@section('title', 'Admin - Contact Messages')

@push('scripts')
<script src="{{ asset('js/admin/contact.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/contact.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'contact.management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size20 mr8" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path d="M39.24,33.2c-6.6.76-13.23.18-19.85.34-3.07.07-6.15,0-9.22,0C9,33.52,7.63,34,7,32.6s.68-2.12,1.46-2.93c2.56-2.63,5-5.36,7.78-7.78,1.81-1.6,1.42-2.48-.13-3.89-2.85-2.6-5.51-5.42-8.26-8.15C7.19,9.21,6.55,8.58,7,7.55c.31-.81,1-.88,1.72-.88q14.58,0,29.16,0a8.6,8.6,0,0,1,1.41.22ZM11.66,30.3H34.34c-2.55-2.44-4.6-4.3-6.52-6.29-1.18-1.22-2.14-2.41-3.64-.39a1.28,1.28,0,0,1-2.08.23c-1.89-2.52-3-.67-4.32.6C16,26.23,14.08,28,11.66,30.3ZM33.55,9.92H12.24c3.44,3.45,6.59,6.58,9.7,9.73.62.64,1.09,1,1.88.18C27,16.58,30.14,13.38,33.55,9.92ZM36,27.84V11.51c-2.61,2.76-4.67,5-6.82,7.19C28.4,19.5,27.94,20,29,21,31.37,23.2,33.61,25.49,36,27.84ZM4.55,21.58a12.17,12.17,0,0,0,1.48,0c.8-.1,1.59-.31,1.68-1.32.07-.77-.21-1.47-1-1.5-1.81-.07-3.74-.81-5.34.62A1.06,1.06,0,0,0,1.49,21a2.81,2.81,0,0,0,1.3.59,10.33,10.33,0,0,0,1.76,0Zm5-7.27c0-2.05-2-1.26-3.31-1.4a8.74,8.74,0,0,0-1.77,0A1.42,1.42,0,0,0,3,14.49a1.38,1.38,0,0,0,1.32,1.35c.59.06,1.19,0,2.13,0C7.4,15.63,9.58,16.65,9.52,14.31ZM6.25,27.2a13,13,0,0,0,2.07,0,1.34,1.34,0,0,0,1.25-1.67C9.27,24,8,24.16,7,24.26c-1.37.13-3.13-.76-3.9,1.14-.36.88.27,1.55,1.12,1.75a9.42,9.42,0,0,0,2.06,0Z"></path></svg>
            <h1 class="fs20 dark no-margin">Contact and feedbacks</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Contact management') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        @include('partials.session-messages')
        <p class="no-margin mb8 dark">The following messages has been received from users in <strong>contact us</strong> page</p>
        <table id="messages-box">
            <thead>
                <tr>
                    <th class="message-bulk-selection-column">
                        <input type="checkbox" id="bulk-select-all-messages" autocomplete="off">
                    </th>
                    <th class="message-column">Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr class="contact-message-component">
                    <td class="message-bulk-selection-column">
                        <input type="checkbox" class="message-selection-input" value="{{ $message->id }}" autocomplete="off">
                    </td>
                    <td class="message-column">
                        <div class="align-center">
                            @if($message->user)
                            <img src="{{ $message->user->avatar(100) }}" class="size36 br4 mr6" alt="">
                            <div class="dark">
                                <a href="{{ route('admin.users.management', ['user'=>$message->user->username]) }}" target="_blank" class="no-underline dark bold">{{ $message->user->fullname }}</a>
                                <p class="no-margin fs12 mt2">{{ $message->user->username }}</p>
                            </div>
                            @else
                            <img src="{{ \App\Models\User::defaultavatar(100) }}" class="size34 br4 mr6" alt="">
                            <div class="dark">
                                <p class="no-margin no-underline light-gray bold">guest user</p>
                            </div>
                            @endif
                        </div>

                        <p class="fs11 dark my8">sumbitted <span title="{{ $message->date }}">{{ $message->date_humans }}</span></p>
                        <div class="typical-section-style">
                            <div class="content"><span class="bold">message :</span> {{ $message->message }}</div>
                        </div>
                        <div class="align-center mt8">
                            <!-- mark as reviewed/unreviewed -->
                            <div>
                                <div class="button-style-5 read-contact-message read-button @if($message->read) none @endif">
                                    <div class="relative size10 mr6">
                                        <svg class="size10 flex icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                        <svg class="spinner size10 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="fs12 dark">mark as read</span>
                                    <input type="hidden" class="message-id" value="{{ $message->id }}" autocomplete="off">
                                    <input type="hidden" class="read" value="1" autocomplete="off">
                                </div>
                                <div class="button-style-5 read-contact-message unread-button @if(!$message->read) none @endif">
                                    <div class="relative size10 mr6">
                                        <svg class="size10 flex icon" fill="#2ca82c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                        <svg class="spinner size10 opacity0 absolute green" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="fs12 green">message read</span>
                                    <input type="hidden" class="message-id" value="{{ $message->id }}" autocomplete="off">
                                    <input type="hidden" class="read" value="0" autocomplete="off">
                                </div>
                            </div>
                            <span class="fs11 mx8 dark unselectable">〡</span>
                            <span class="fs12 red pointer align-center delete-contact-message">
                                <svg class="spinner size10 mr4 none" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                                <span>delete message</span>
                                <input type="hidden" class="message-id" value="{{ $message->id }}" autocomplete="off">
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr id="no-messages-row" class="@if($messages->count()) none @endif">
                    <td colspan="5" class="full-height">
                        <div class="full-dimensions full-center my8">
                            <svg class="size13 mr8" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <span class="fs13">There's no messages for the moment.</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="full-center my12">
            {{ $messages->appends(request()->query())->onEachSide(0)->links() }}
        </div>
    </div>
</main>
@endsection