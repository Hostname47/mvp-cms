@extends('layouts.admin')

@section('title', 'Admin - Comments')

@push('scripts')
<script src="{{ asset('js/admin/comments.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/comment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.comments', 'subpage'=>'admin.comments.manage'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size18 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"></path></svg>
            <h1 class="fs20 dark no-margin">Comments Management</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Manage a comment') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">

        @if(Session::has('message'))
        <div class="informative-message-container flex align-center relative my8">
            <div class="informative-message-container-left-stripe imcls-green"></div>
            <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @endif

        @if(is_null($comment))
        <div class="select-a-comment-box">
            <svg class="size14 mb8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"></path></svg>
            <p class="dark no-margin fs13">please select a comment to manage in comments <a href="{{ route('admin.comments.dashboard') }}" class="blue no-underline bold">dashboard</a> page</p>
        </div>
        @else
        <h2 class="dark" style="margin: 0 0 12px 0;">Manage comment</h2>

        <!-- comment content -->
        <div class="flex dark comment-to-manage">
            <span class="bold mr6 no-wrap">comment :</span>
            <div class="flex1">
                <div class="commenter-box flex">
                    <img src="{{ $commenter->avatar(100) }}" class="avatar" alt="">
                    <div>
                        <span class="block bold">{{ $commenter->fullname }} - <a href="" class="blue bold no-underline">manage</a></span>
                        <span class="block fs13">{{ $commenter->username }}</span>
                    </div>
                </div>
                <input type="hidden" id="comment-content" value="{{ $comment->content }}" autocomplete="off">
                <div class="typical-section-style content">
                    {{ $comment->content }}
                </div>
                <div class="comment-edit-box my8 none">
                    <div class="comment-input-container">
                        <!-- error container -->
                        <div class="informative-message-container align-center relative error-container my8 mx8 none">
                            <div class="informative-message-container-left-stripe imcls-red"></div>
                            <div class="no-margin fs13 error"></div>
                            <div class="close-parent close-informative-message-style">✖</div>
                        </div>
                        <textarea class="comment-input comment-update-content" placeholder="{{ __('update comment content') }}.." autocomplete="off">{{ $comment->content }}</textarea>
                        <!-- bottom-section -->
                        <div class="comment-bottom-section">
                            <div class="move-to-right align-center">
                                <span class="button-style-2 cancel-comment-update">
                                    cancel
                                    <input type="hidden" class="original-content" value="{{ $comment->content }}" autocomplete="off">
                                </span>
                                <div class="button-style-3 update-comment">
                                    <div class="relative size13 mr4">
                                        <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="unselectable">update</span>
                                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="align-center mt4">
                    <div class="open-edit-container">
                        <svg class="size13 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"></path></svg>
                        <span class="bold fs12 dark">Edit</span>
                    </div>
                    <span class="fs8 bold light-gray unselectable mx8">〡</span>
                    <div class="fs13" title="{{ $comment->at }}"><strong>Commented :</strong> {{ $comment->date_humans }}</div>
                    <span class="fs8 bold light-gray unselectable mx8">〡</span>
                    <div class="align-center">
                        <svg class="size14 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255,166.15c-2.6,8.16-8.17,14.15-14.13,20-15,14.73-29.78,29.71-44.67,44.56-21,21-48.79,21.06-69.77.12q-32.37-32.29-64.67-64.66c-13-13-12.08-26.82,4.17-39.07-2.38-1.79-4.85-3.15-6.7-5.12-12.3-13.06-6.3-32.84,11.11-37.11,1.22-.3,3.1-1.19,3.26-2.07C75.75,71.33,83,65.43,94,63.49c2.22-14.87,15.46-25.23,32.92-18.2,8.26-11.1,16.87-15,26.86-11.21A31.69,31.69,0,0,1,164.19,41c10.56,10.13,20.79,20.6,31.61,31.4.43-3.07.58-5.59,1.17-8,2.76-11.19,12.58-17.91,24.19-16.7C231.65,48.8,240,58.05,240.27,69.09c.16,6.52.13,13,0,19.56-.05,2.66.39,4.42,3.18,5.72,6.34,2.94,9.26,8.8,11.55,15Zm-14.68-28.66c0-7.5,0-15,0-22.5-.05-5.44-2.71-8.56-7.18-8.64-4.66-.09-7.44,3.12-7.47,8.83-.05,9.78-.08,19.57,0,29.35,0,3.75-1,6.84-4.61,8.38s-6.55-.06-9.15-2.7c-7.45-7.54-15-15-22.47-22.5q-22.83-22.83-45.67-45.65c-4.42-4.4-8.59-4.84-11.93-1.44s-2.74,7.46,1.66,11.91c3.89,4,7.83,7.84,11.75,11.77,5.87,5.88,11.84,11.68,17.58,17.7,3.13,3.28,2.94,7.68,0,10.5s-6.73,2.79-10.16,0c-1-.83-1.87-1.81-2.79-2.74L103.18,83a27.46,27.46,0,0,0-3.2-3c-3.39-2.43-6.81-2.27-9.7.74-2.73,2.85-2.65,6.18-.5,9.38a23.88,23.88,0,0,0,3,3.22l47,47a23.78,23.78,0,0,1,3.28,3.61,6.72,6.72,0,0,1-.79,8.95c-2.71,2.84-6,3.2-9.31,1.05a23.27,23.27,0,0,1-3.59-3.3q-23.54-23.5-47.05-47a23.17,23.17,0,0,0-3.22-3c-3.22-2.12-6.55-2.18-9.38.59-3,2.91-3.11,6.33-.65,9.7a33,33,0,0,0,3.36,3.54c15.79,15.8,31.65,31.53,47.3,47.48,1.87,1.91,3.63,5,3.5,7.49-.12,2.14-2.72,5.45-4.71,5.85a10.57,10.57,0,0,1-8.19-2.39c-10-9.39-19.47-19.26-29.2-28.9-4.1-4.07-8.32-4.43-11.56-1.2s-2.9,7.46,1.21,11.58c22.57,22.62,45.08,45.31,67.83,67.75,13.08,12.9,32.14,12.87,45.2,0,17.44-17.15,34.6-34.57,51.94-51.83a14.83,14.83,0,0,0,4.57-11.4C240.22,151.84,240.32,144.66,240.32,137.49ZM211,128.17c0-5.63-.1-10.29,0-14.95.16-6.52,2.19-13,7.79-16,7-3.8,7.29-9.18,6.89-15.62-.24-3.74,0-7.5-.07-11.25-.14-5-3-8-7.3-8s-7.23,3-7.33,8c-.11,5.71-.12,11.42,0,17.12.09,4.09-.09,8.08-4.46,9.93-4.59,2-7.62-.89-10.62-3.91q-20.49-20.65-41.13-41.17a26,26,0,0,0-3.58-3.32c-3.07-2.07-6.25-2-8.94.61s-2.85,5.75-1,8.91a15.8,15.8,0,0,0,2.57,2.93Q175.66,93.19,207.48,125C208.34,125.86,209.29,126.64,211,128.17Zm-95.59-54,10.53-9.71c-2.49-2-4.74-7.67-10.77-6.5A8.81,8.81,0,0,0,109.47,63C107.57,69.36,113.36,71.85,115.39,74.14ZM23.49,87.32c3.91,0,7.82.21,11.71,0,4.61-.32,7.48-3.45,7.35-7.48s-3.09-6.9-7.81-7q-11.22-.21-22.44,0c-4.73.1-7.69,2.92-7.84,7S7.35,87,12.28,87.32c3.72.21,7.47,0,11.21,0ZM77.8,21.87c-.16-4.87-3.17-7.9-7.49-7.79-4.13.1-7,3-7.11,7.67Q63,33,63.2,44.19c.08,4.87,3.15,7.9,7.48,7.79,4.11-.1,6.95-3,7.11-7.68.14-3.73,0-7.48,0-11.22S77.93,25.6,77.8,21.87ZM30.73,29.53c-3.61-3.27-7.87-3.22-10.81,0s-2.7,7.16.57,10.44q7.91,7.95,16.1,15.62c3.55,3.34,7.86,3.24,10.8.06,2.8-3,2.65-7.11-.56-10.46-2.58-2.69-5.35-5.22-8-7.83S33.5,32,30.73,29.53Z"/></svg>
                        <span class="bold fs11">{{ $post->reactions_count }} claps</span>
                    </div>
                    <span class="mx4 ligh-gray fs12 unselectable">〡</span>
                    <div class="align-center post-stats-button move-to-comments">
                        <svg class="size14 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>
                        <span class="bold fs11">{{ $post->comments_count }} replies</span>
                    </div>
                    <span class="mx4 ligh-gray fs12 unselectable">〡</span>
                    <div class="fs13">status : <span class="bold {{ $comment->scolor }}">{{ $comment->status }}</span></div>
                </div>
            </div>
        </div>
        <!-- parent post -->
        <div class="flex dark mt8 ml8">
            <svg class="size12" style="margin-right: 14px; min-width: 12px;" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
            <span class="bold mr6 no-wrap">post :</span>
            <a href="{{ $post->link }}" target="_blank" class="blue no-underline bold">{{ $post->html_title }}</a>
        </div>
        <div class="simple-line-separator my12"></div>
        <!-- actions -->
        <div class="align-center">
            <span class="bold dark mr8 no-wrap">actions :</span>
            @if($comment->trashed())
                @if($comment->status == 'pending')
                <div class="fs12 green pointer align-center restore-comment-button">
                    <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span>Restore</span>
                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                </div>
                @else
                <div class="fs12 dark-green pointer align-center untrash-comment-button">
                    <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span>Untrash</span>
                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                </div>
                @endif
            @else
                <!-- view comment -->
                <a href="{{ $comment->link }}" target="_blank" class="dark-blue fs12 no-underline">View</a>
                <span class="fs11 dark unselectable mx8">〡</span>
                <!-- trash a comment -->
                <div class="fs12 red pointer align-center trash-comment-button">
                    <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span>Trash</span>
                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                </div>
            @endif
            <span class="fs11 dark unselectable mx8">〡</span>
            <div class="fs12 red pointer align-center destroy-comment-button">
                <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
                <span>Delete permanently</span>
                <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
            </div>
        </div>
        <!-- reports -->
        <div class="my12">
            <span class="bold dark">reports - {{ $reports->total() }}</span>
            @if($reports->count())
                @foreach($reports as $report)
                <div class="report-box">
                    <div class="flex reporter-box">
                        <span class="bold no-wrap mr6">reporter :</span>
                        <img src="{{ $report->report_user->avatar(100) }}" class="avatar" alt="">
                        <div>
                            <span class="block bold">{{ $report->report_user->fullname }}</span>
                            <span class="block fs13">{{ $report->report_user->username }}</span>
                        </div>
                    </div>
                    <span class="mx4 light-gray fs12 unselectable">〡</span>
                    <div>
                        <div class="fs11 light-gray"><span class="bold mr6">reported : </span> {{ $report->date }}</div>
                        <div class="mt4"><span class="bold mr6">type : </span> {{ $report->htype }}</div>
                        @if($report->type == 'moderator-intervention')
                        <div class="flex mt8">
                            <svg class="size10 ml8 mr8" style="min-width: 10px;" fill="#575757" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                            <span class="bold no-wrap mr6">message : </span> {{ $report->body }}
                        </div>
                        @endif
                    </div>

                </div>
                @endforeach
            @else
            <div class="typical-section-style align-center my12">
                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                <span class="green fs14 bold">clean comment with no reports</span>
            </div>
            @endif
        </div>
        @endif
    </div>
</main>
@endsection