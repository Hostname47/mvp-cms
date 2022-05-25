@extends('layouts.admin')

@section('title', 'Admin - Comments')

@push('scripts')
<script src="{{ asset('js/admin/comments.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/comment.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'comments.management'])
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
                <span class="fs13 bold">{{ __('Comments management') }}</span>
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

        <h2 class="dark" style="margin: 0 0 12px 0;">Comments</h2>

        <!-- search section -->
        <div class="my12">
            <form action="" class="align-center relative">
                <svg class="search-icon-style-1" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                <input type="text" required name="k" class="search-input-style-1" style="width: 360px;" placeholder="search for comments" @if($k) value="{{ $k }}" @endif>
                <button class="search-button-style-1">
                    <span>Search Comments</span>
                </button>
            </form>
        </div>

        @if($k)
            <h3 class="dark">Search result for : "<span class="blue">{{ $k }}</span>" ({{ $comments->total() }})</h3>
        @endif

        <div class="flex space-between">
            <div class="align-center fs13">
                <a href="?tab=all" class="no-underline @if($tab=='all') dark bold @else dark-blue @endif">
                    All <span class="dark default-weight">(<span class="trash-count">{{ $statistics['all'] }}</span>)</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">〡</span>
                <a href="?tab=published" class="no-underline @if($tab=='published') dark bold @else dark-blue @endif">
                    Published <span class="dark default-weight">(<span class="published-count">{{ $statistics['published'] }}</span>)</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">〡</span>
                <a href="?tab=pending" class="no-underline @if($tab=='pending') dark bold @else dark-blue @endif">
                    Pending <span class="dark default-weight">(<span class="pending-count">{{ $statistics['pending'] }}</span>)</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">〡</span>
                <a href="?tab=trashed" class="no-underline @if($tab=='trashed') dark bold @else dark-blue @endif">
                    Trash <span class="dark default-weight">(<span class="trash-count">{{ $statistics['trashed'] }}</span>)</span>
                </a>
            </div>
            {{ $comments->appends(request()->query())->onEachSide(0)->links() }}
        </div>
        <table class="full-width comments-table mt8">
            <thead>
                <tr class="flex">
                    <th class="comments-table-selection-column">
                        <input type="checkbox" autocomplete="off" class="comment-selection-input" disabled>
                    </th>
                    <th class="comments-table-commenter-column">
                        <span class="dark">Commenter</span>
                    </th>
                    <th class="comments-table-comment-column">
                        <span class="dark">Comment</span>
                    </th>
                    <th class="comments-table-in-response-to-column">
                        <span class="dark">In response to</span>
                    </th>
                    <th class="comments-table-date-column">
                        <span class="dark">Date</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($comments->count())
                    @foreach($comments as $comment)
                    <tr class="flex comment-row" id="comment-row-{{ $comment->id }}">
                        <!-- comment selection -->
                        <td class="comments-table-selection-column">
                            <input type="checkbox" autocomplete="off" class="comment-selection-input">
                        </td>
                        <!-- commenter -->
                        <td class="comments-table-commenter-column">
                            <div class="comment-commenter-box">
                                <img src="{{ $comment->user->avatar(100) }}" class="avatar" alt="">
                                <div>
                                    <a href="" class="fullname">{{ $comment->user->fullname }}</a>
                                    <span class="username">{{ $comment->user->username }}</a>
                                </div>
                            </div>
                        </td>
                        <!-- comment -->
                        <td class="comments-table-comment-column">
                            <div class="align-center mb8">
                                <svg class="size6 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M84.56,5.05c0,1-.85,1.29-1.38,1.82C73.12,17,63.08,27.08,52.94,37.08c-1.63,1.61-1.91,2.39-.1,4.19q44.23,44,88.34,88.15-44.29,44.13-88.49,88.35c-1.39,1.39-1.73,2.07-.11,3.66C63,231.64,73.26,242,83.52,252.33c1.16,1.17,1.75,1.29,3,0Q147.17,191.6,208,131c1.41-1.4,1-2-.13-3.18Q147.4,67.44,87.07,7c-.58-.58-1.54-.93-1.54-2Z"></path></svg>
                                <span class="fs11 bold {{ $comment->scolor }}">{{ $comment->status }}</span>
                            </div>
                            <div class="comment-content">
                                {{ $comment->content }}
                            </div>
                            <div class="comment-actions-links">
                                @if(is_null($comment->deleted_at))
                                <!-- view comment -->
                                <a href="{{ $comment->link }}" target="_blank" class="dark-blue link">View</a>
                                <span class="fs11 dark unselectable">〡</span>
                                <!-- reply -->
                                <span class="dark-blue link pointer">Reply</span>
                                <span class="fs11 dark unselectable">〡</span>
                                <!-- trash a comment -->
                                <div class="fs12 red pointer align-center trash-comment-button">
                                    <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                    <span>Trash</span>
                                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                                </div>
                                @else
                                    @if($comment->status == 'pending')
                                    <div class="fs12 green pointer align-center restore-comment-button">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Publish</span>
                                        <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                                    </div>
                                    @else
                                    <div class="fs12 dark pointer align-center untrash-comment-button">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Untrash</span>
                                        <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                                    </div>
                                    @endif
                                    <span class="fs11 dark unselectable">〡</span>
                                    <div class="fs12 red pointer align-center delete-comment-button">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Delete permanently</span>
                                        <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                                    </div>
                                @endif
                            </div>
                        </td>
                        <!-- in response to -->
                        <td class="comments-table-in-response-to-column">
                            <div class="comment-post-box">
                                <p class="fs11 no-margin mb4 dark bold">Post :<span class="light-gray ml4 default-weight">({{ $comment->post->comments_count }} comments)</span></p>
                                <a href="{{ route('edit.post', ['post'=>$comment->post->id]) }}" class="title">{{ $comment->post->html_title }}</a>
                                <a href="{{ $comment->post->link }}" target="_blank" class="align-center no-underline dark">
                                    <svg class="size14 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M5.22,125.75c1.87-7.6,6.32-13.64,11.46-19.33C37.14,83.8,60,64.32,88.3,52.11c34.75-15,67.81-10,99.59,8.71,22.8,13.44,42.16,30.92,59,51.26,8.74,10.6,9.54,24.93,1.1,35.4-21.67,26.89-47.28,49.07-79.57,62.46-33.49,13.89-65.44,8.84-96.08-8.82-23.52-13.55-43.4-31.42-60.46-52.39-3.05-3.74-4.45-8.82-6.61-13.28ZM131.91,62.67a83.6,83.6,0,0,0-32.8,6.14c-29.08,11.73-52,31.52-71.88,55.27-3.87,4.62-3.66,8.68.4,13.55,16.4,19.67,35.28,36.45,58,48.57,21.45,11.45,43.83,16.45,67.68,8.4,32.51-10.95,57.36-32.39,78.83-58.28,3.4-4.1,2.86-8.18-.95-12.77-14.87-18-32-33.4-52.07-45.28C163.91,69.28,147.79,63,131.91,62.67Zm-2.06,19.42A48.5,48.5,0,1,1,80.91,130,48.62,48.62,0,0,1,129.85,82.09Zm-.42,77.6a29.1,29.1,0,1,0-29.12-29.31A29.19,29.19,0,0,0,129.43,159.69Z"></path></svg>
                                    <span class="fs12">view post</span>
                                </a>
                            </div>
                        </td>
                        <!-- Date -->
                        <td class="comments-table-date-column">
                            <a href="{{ $comment->post->link }}" class="fs12 no-underline dark-blue">{{ $comment->at }}</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="7" class="full-center">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="bold dark fs13 my4">You don't have any comments in this tab for the moment.</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="flex my12">
            <div class="move-to-right">
                {{ $comments->appends(request()->query())->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
</main>
@endsection