@extends('layouts.admin')

@section('title', 'Admin - all post')

@push('scripts')
<script type="module" src="{{ asset('js/admin/post/manage.js') }}" defer></script>
<script type="module" src="{{ asset('js/admin/post/all-posts.js') }}" defer></script>
@endpush

@push('styles')
<link href="{{ asset('css/admin/post/admin-post.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin/post/all-posts.css') }}" rel="stylesheet">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.posts', 'subpage'=>'admin.posts.all'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M250.29,9.76V250.24H9.71V9.76ZM116,116.17V36.55H36.37v79.62Zm27.87-.09h79.62V36.48H143.83ZM36.3,223.56h79.76V144.14H36.3Zm107.43-.05h79.75V144.13H143.73Z"/></svg>
            <h1 class="fs20 dark no-margin">All Posts</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('All posts') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        <!-- post permanent delete viewer -->
        <div id="permanent-delete-post-viewer" class="global-viewer full-center none" style="z-index:11112">
            <div class="viewer-box-style-1">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                    <div class="flex align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"></path></svg>
                        <span class="fs20 bold dark">Post Deletion</span>
                    </div>
                    <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div style="padding: 14px;" class="dark fs13">
                    <h3 class="dark fs16 no-margin">Delete post permanently</h3>
                    <p class="no-margin mt8">Post title :<span class="bold blue ml4 post-title"></span></p>
                    <p class="no-margin mt8">This will delete the selected post permanently from your website. Once the post get deleted, all its related content will get deleted as well including comments, reactions, media .. etc.</p>
                    <p class="no-margin mt8">Please make sure about the selected post, because this action cannot be undone.</p>
                    <div class="flex">
                        <div class="move-to-right align-center" style="margin-top: 12px;">
                            <div class="typical-button-style pointer align-center red-bs permanent-delete-post-button" style="padding: 7px 12px">
                                <div class="relative size13 mr4">
                                    <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.3,99.52c24.62,0,49.23.06,73.84-.08,3.27,0,4.38.56,4.36,4.14-.15,37.49-.05,75-.11,112.48,0,14.25-10.08,24.28-24.35,24.3q-53.79.09-107.58,0c-14.57,0-24.53-10-24.55-24.6,0-37.33.07-74.66-.13-112,0-4,1.35-4.35,4.68-4.33C81.07,99.58,105.69,99.52,130.3,99.52Zm24,93.89a7.65,7.65,0,0,0,6.44-4.63c1.59-3.43.68-6.43-1.76-8.95-5-5.15-10-10.26-15.23-15.2-2-1.89-2.14-3-.06-5,5-4.69,9.77-9.59,14.55-14.49,4-4.12,4.31-8.7.92-12.06s-7.93-3-12.05,1c-4.66,4.56-9.43,9-13.76,13.9-2.59,2.91-4.05,2.41-6.41-.17-4.29-4.69-8.9-9.08-13.44-13.53-4.35-4.28-9-4.64-12.4-1.09s-2.9,7.9,1.18,12c4.8,4.88,9.6,9.78,14.56,14.49,1.84,1.76,2,2.8.06,4.63-5,4.7-9.76,9.61-14.56,14.48-4.11,4.17-4.54,8.6-1.3,12.05,3.38,3.6,8.09,3.28,12.41-1,4.77-4.69,9.6-9.32,14.13-14.23,2.14-2.33,3.33-2,5.34.1,4.56,4.88,9.41,9.49,14.12,14.23C148.89,192,151,193.48,154.26,193.41ZM130.19,83.87h-88c-12.52,0-13.8-1.36-13.81-14.07a17.33,17.33,0,0,1,2.69-10.19,15.58,15.58,0,0,1,13.7-7c13.85,0,27.71-.13,41.55.1,3.73.06,5.14-.77,4.77-4.71a23.51,23.51,0,0,1,4.81-17.44,22.89,22.89,0,0,1,18.55-9.22q15.41-.12,30.8,0c13.93.12,23.85,10.14,24,24.14.09,7.15.09,7.15,7.05,7.15H214c11.9,0,17.89,6.09,17.92,18.13,0,1.14,0,2.28,0,3.42-.08,7-2.79,9.74-9.79,9.74Q176.14,83.89,130.19,83.87Zm-.28-31.3c6.82,0,13.65,0,20.47,0,1.11,0,2.54.79,3.25-1.09,2.78-7.39-1.95-14.48-9.83-14.52-8.29,0-16.57,0-24.85,0-10.39,0-12.53,2.31-12.36,12.57,0,2.7.94,3.19,3.34,3.14C116.59,52.48,123.25,52.57,129.91,52.57Z"/></svg>
                                    <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <span class="bold fs12 white unselectable">Delete Permanently</span>
                                <input type="hidden" class="post-id" autocomplete="off">
                            </div>
                            <span class="ml8 bold dark pointer unselectbale close-global-viewer">Cancel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Session::has('message'))
        <div class="informative-message-container flex align-center relative my8">
            <div class="informative-message-container-left-stripe imcls-green"></div>
            <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @endif
        <div class="align-center">
            <h2 class="dark no-margin">Posts</h2>
            <span class="fs7 bold light-gray unselectable mx8">●</span>
            <a href="{{ route('create.new.post') }}" class="dark no-underline align-center">
                <svg class="flex size13 mr4" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M58.55,251.39c-9.94,0-15.72-5.59-14.54-14.83,2.77-21.61,6-43.16,9.09-64.73.47-3.3,2.39-5.94,4.78-8.32q40.7-40.6,81.26-81.35c2.57-2.58,3.89-2.93,6.66-.13q33.54,33.93,67.46,67.48c2.68,2.66,2.69,4,0,6.66q-40.81,40.49-81.33,81.27c-3.74,3.76-8.24,4.81-13.18,5.5-18.75,2.6-37.48,5.38-56.22,8.08C61.12,251.22,59.69,251.29,58.55,251.39ZM246.34,89.65c-7.19-36.3-51.11-53.73-81.14-32.19-2,1.43-4.84,2.3-1.42,5.68q34.36,34,68.35,68.34c2.69,2.72,3.75,1.61,5.39-.68,6.47-9.06,9.79-19.13,10.1-32.08C247.74,96.86,247.05,93.25,246.34,89.65ZM142.6,34.57c8.12-.06,13.3-5.32,13.34-12.81s-5.25-13-13.16-13.07c-38.95-.12-77.9-.07-116.84-.06a12.77,12.77,0,0,0-12,7.09C9.22,24.6,15.6,34.48,26.37,34.58c19.37.18,38.74.05,58.11.05S123.23,34.74,142.6,34.57ZM102.41,87c8.81-.07,14.4-5.3,14.35-13.17-.06-7.69-5.36-12.76-14-12.79q-37.92-.16-75.83,0c-8.84,0-14.56,5.36-14.48,13.06s6,12.86,14.73,12.91c12.64.07,25.28,0,37.92,0C77.54,87,90,87.05,102.41,87ZM51.69,139.25c7.56-.53,12.85-5.92,13-12.81.18-7.06-5.31-13-13.09-13.33-8.73-.36-17.5-.36-26.23,0-7.64.32-12.8,5.78-12.94,12.77-.15,7.24,5.11,12.81,13,13.36,4.25.31,8.53.06,12.81.06C42.75,139.31,47.24,139.57,51.69,139.25Z"/></svg>
                <span class="bold fs11 unselectable">Add new post</span>
            </a>
            <!-- search section -->
            <div class="move-to-right">
                <form action="" class="align-center relative">
                    <svg class="search-icon-style-1" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                    <input type="text" required name="k" class="search-input-style-1" style="width: 360px" placeholder="search posts by title, slug or keywords" @if($k) value="{{ $k }}" @endif>
                    <button class="search-button-style-1">
                        <span>Search Posts</span>
                    </button>
                </form>
            </div>
        </div>
        @if($k)
        <div class="typical-section-style my4">
            <p class="dark fs15 bold no-margin">Search result for : "<strong class="blue fs14">{{ $k }}</strong>" ({{ $posts->total() }})</p>
        </div>
        @endif

        <div class="flex align-center space-between my8">
            <div class="align-center fs13">
                <a href="{{ route('admin.all.posts') }}" class="@if($status=='all') dark bold @else blue @endif no-underline">
                    All <span class="dark default-weight">({{ $statistics['all'] }})</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">●</span>
                <a href="{{ route('admin.all.posts', ['status'=>'published']) }}" class="@if($status=='published') dark bold @else blue @endif no-underline">
                    Published <span class="dark default-weight">({{ $statistics['published'] }})</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">●</span>
                <a href="{{ route('admin.all.posts', ['status'=>'draft']) }}" class="@if($status=='draft') dark bold @else blue @endif no-underline">
                    Draft <span class="dark default-weight">({{ $statistics['draft'] }})</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">●</span>
                <a href="{{ route('admin.all.posts', ['status'=>'awaiting-review']) }}" class="@if($status=='awaiting-review') dark bold @else blue @endif no-underline">
                    Awaiting review <span class="dark default-weight">({{ $statistics['awaiting-review'] }})</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">●</span>
                <a href="{{ route('admin.all.posts', ['status'=>'private']) }}" class="@if($status=='private') dark bold @else blue @endif no-underline">
                    Private <span class="dark default-weight">({{ $statistics['private'] }})</span>
                </a>
                <span class="fs7 bold light-gray unselectable mx8">●</span>
                <a href="{{ route('admin.all.posts', ['status'=>'trashed']) }}" class="@if($status=='trashed') dark bold @else blue @endif no-underline">
                    Trash <span class="dark default-weight">({{ $statistics['trashed'] }})</span>
                </a>
            </div>
            <div>
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>

        <table class="full-width posts-table mt8">
            <thead>
                <tr class="flex">
                    <th class="posts-table-selection-column">
                        <input type="checkbox" class="no-margin size16">
                    </th>
                    <th class="posts-table-title-column align-center">
                        <span class="blue">Title</span>
                        <div class="move-to-right relative">
                            <div class="button-style-2 align-center button-with-suboptions">
                                <span class="fs13">order by</span>
                                <svg class="size7 ml4" fill="#4b5155" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                            </div>
                            <div class="suboptions-container typical-suboptions-container" style="top: calc(100% + 4px); right: 0; width: max-content;">
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'last-updated', 'page'=>1]) }}" class="suboption-style-2 mb2">
                                    <span @if($order_key=='last-updated') class="blue" @endif>last updated</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'date-newest-first', 'page'=>1]) }}" class="suboption-style-2 mb2">
                                    <span @if($order_key=='date-newest-first') class="blue" @endif>date (newest first)</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'date-oldest-first', 'page'=>1]) }}" class="suboption-style-2 mb2">
                                    <span @if($order_key=='date-oldest-first') class="blue" @endif>date (oldest first)</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'views', 'page'=>1]) }}" class="suboption-style-2 mb2">
                                    <span @if($order_key=='views') class="blue" @endif>views</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'comments', 'page'=>1]) }}" class="suboption-style-2 mb2">
                                    <span @if($order_key=='comments') class="blue" @endif>comments</span>
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['order'=>'reactions', 'page'=>1]) }}" class="suboption-style-2">
                                    <span @if($order_key=='reactions') class="blue" @endif>reactions</span>
                                </a>
                            </div>
                        </div>
                    </th>
                    <th class="posts-table-author-column">
                        <span class="dark">Author</span>
                    </th>
                    <th class="posts-table-categories-column">
                        <span class="dark">Categories</span>
                    </th>
                    <th class="posts-table-tags-column">
                        <span class="dark">Tags</span>
                    </th>
                    <th class="posts-table-stats-column">
                        <span class="dark">Stats</span>
                    </th>
                    <th class="posts-table-date-column">
                        <span class="dark">Dates</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($posts->count())
                    @foreach($posts as $post)
                    <tr class="flex post-row">
                        <!-- post selection -->
                        <td class="posts-table-selection-column">
                            <input type="checkbox" class="no-margin size16">
                        </td>
                        <td class="posts-table-title-column">
                            <div>
                                <a href="{{ route('view.post', ['category'=>$post->categories->first()->slug, 'post'=>$post->slug]) }}" class="dark-blue bold no-underline post-title">{{ $post->title }}</a>
                                @if($post->status != 'published')
                                <span class="light-gray"> - {{ $post->status }}</span>
                                @endif
                            </div>
                            <div class="align-center mt4 post-actions-links-container">
                                @if(is_null($post->deleted_at))
                                    <a href="{{ route('edit.post', ['post'=>$post->id]) }}" class="fs12 dark-blue no-underline">
                                        <span>Edit</span>
                                    </a>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <span class="fs12 red pointer align-center trash-post-button">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Trash</span>
                                        <input type="hidden" class="post-id" value="{{ $post->id }}" autocomplete="off">
                                    </span>
                                    <span class="fs11 mx8 dark">〡</span>
                                    @if($post->status == 'published')
                                    <a href="{{ route('view.post', ['category'=>$post->categories->first()->slug, 'post'=>$post->slug]) }}" target="_blank" class="fs12 dark-blue no-underline">
                                        <span>View</span>
                                    </a>
                                    @else
                                    <a href="{{ route('preview.post', ['post'=>$post->id]) }}" target="_blank" class="fs12 dark-blue no-underline">
                                        <span>Preview</span>
                                    </a>
                                    @endif
                                @else
                                    <span class="fs12 dark-blue pointer align-center fix-row-hover-event untrash-post-button">
                                        <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                        <span>Restore</span>
                                        <input type="hidden" class="post-id" value="{{ $post->id }}" autocomplete="off">
                                    </span>
                                    <span class="fs11 mx8 dark">〡</span>
                                    <span class="fs12 red pointer align-center open-post-permanent-delete-viewer">
                                        <span>Delete Permanently</span>
                                        <input type="hidden" class="post-id" value="{{ $post->id }}" autocomplete="off">
                                    </span>
                                @endif
                            </div>
                        </td>
                        <!-- post author -->
                        <td class="posts-table-author-column">
                            @if($post->author)
                            <a href="{{ route('user.profile', ['user'=>$post->author->username]) }}" class="dark bold no-underline fs13">{{ $post->author->username }}</a>
                            @else
                            <em class="dark">Unknown</em>
                            @endif
                        </td>
                        <!-- post categories -->
                        <td class="posts-table-categories-column">
                            @foreach($post->categories as $category)
                                @if($loop->index != 0)<span class="bold light-gray">,</span>@endif
                                <a href="{{ $category->link }}" class="dark-blue no-underline fs13">{{ $category->title }}</a>
                            @endforeach
                            @if(!$post->categories->count())
                            <span class="light-gray">--</span>
                            @endif
                        </td>
                        <!-- post tags -->
                        <td class="posts-table-tags-column">
                            @foreach($post->tags as $tag)
                                @if($loop->index != 0)<span class="bold light-gray">,</span>@endif
                                <a href="{{ $tag->link }}" class="dark-blue no-underline fs13">{{ $tag->title }}</a>
                            @endforeach
                            @if(!$post->tags->count())
                            <span class="light-gray">--</span>
                            @endif
                        </td>
                        <!-- post stats -->
                        <td class="posts-table-stats-column full-center flex-column">
                            <div class="align-center mb8">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M126.89,237.41C66.74,234.75,20,185.15,22.59,126.63c2.62-59.8,52.22-106.51,110.51-104,60.06,2.53,107,52.36,104.3,110.77C234.65,193.27,185,240,126.89,237.41Zm89-107.53a85.84,85.84,0,1,0-86,86A85.63,85.63,0,0,0,215.84,129.88ZM99.26,174a53.71,53.71,0,0,0,73.48-76.55c-15.11-20.13-42.38-25-57.26-18.42,10.73,6.73,16.21,16.2,14,28.84-2,11.26-9,18.7-20.2,21.28C96,132.24,86.17,126.59,79,115.48,72.52,131.07,77.23,158.79,99.26,174Z"/></svg>
                                <span class="bold fs14 dark">{{ $post->views }}</span>
                            </div>
                            <div class="align-center mb8">
                                <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M255,166.15c-2.6,8.16-8.17,14.15-14.13,20-15,14.73-29.78,29.71-44.67,44.56-21,21-48.79,21.06-69.77.12q-32.37-32.29-64.67-64.66c-13-13-12.08-26.82,4.17-39.07-2.38-1.79-4.85-3.15-6.7-5.12-12.3-13.06-6.3-32.84,11.11-37.11,1.22-.3,3.1-1.19,3.26-2.07C75.75,71.33,83,65.43,94,63.49c2.22-14.87,15.46-25.23,32.92-18.2,8.26-11.1,16.87-15,26.86-11.21A31.69,31.69,0,0,1,164.19,41c10.56,10.13,20.79,20.6,31.61,31.4.43-3.07.58-5.59,1.17-8,2.76-11.19,12.58-17.91,24.19-16.7C231.65,48.8,240,58.05,240.27,69.09c.16,6.52.13,13,0,19.56-.05,2.66.39,4.42,3.18,5.72,6.34,2.94,9.26,8.8,11.55,15Zm-14.68-28.66c0-7.5,0-15,0-22.5-.05-5.44-2.71-8.56-7.18-8.64-4.66-.09-7.44,3.12-7.47,8.83-.05,9.78-.08,19.57,0,29.35,0,3.75-1,6.84-4.61,8.38s-6.55-.06-9.15-2.7c-7.45-7.54-15-15-22.47-22.5q-22.83-22.83-45.67-45.65c-4.42-4.4-8.59-4.84-11.93-1.44s-2.74,7.46,1.66,11.91c3.89,4,7.83,7.84,11.75,11.77,5.87,5.88,11.84,11.68,17.58,17.7,3.13,3.28,2.94,7.68,0,10.5s-6.73,2.79-10.16,0c-1-.83-1.87-1.81-2.79-2.74L103.18,83a27.46,27.46,0,0,0-3.2-3c-3.39-2.43-6.81-2.27-9.7.74-2.73,2.85-2.65,6.18-.5,9.38a23.88,23.88,0,0,0,3,3.22l47,47a23.78,23.78,0,0,1,3.28,3.61,6.72,6.72,0,0,1-.79,8.95c-2.71,2.84-6,3.2-9.31,1.05a23.27,23.27,0,0,1-3.59-3.3q-23.54-23.5-47.05-47a23.17,23.17,0,0,0-3.22-3c-3.22-2.12-6.55-2.18-9.38.59-3,2.91-3.11,6.33-.65,9.7a33,33,0,0,0,3.36,3.54c15.79,15.8,31.65,31.53,47.3,47.48,1.87,1.91,3.63,5,3.5,7.49-.12,2.14-2.72,5.45-4.71,5.85a10.57,10.57,0,0,1-8.19-2.39c-10-9.39-19.47-19.26-29.2-28.9-4.1-4.07-8.32-4.43-11.56-1.2s-2.9,7.46,1.21,11.58c22.57,22.62,45.08,45.31,67.83,67.75,13.08,12.9,32.14,12.87,45.2,0,17.44-17.15,34.6-34.57,51.94-51.83a14.83,14.83,0,0,0,4.57-11.4C240.22,151.84,240.32,144.66,240.32,137.49ZM211,128.17c0-5.63-.1-10.29,0-14.95.16-6.52,2.19-13,7.79-16,7-3.8,7.29-9.18,6.89-15.62-.24-3.74,0-7.5-.07-11.25-.14-5-3-8-7.3-8s-7.23,3-7.33,8c-.11,5.71-.12,11.42,0,17.12.09,4.09-.09,8.08-4.46,9.93-4.59,2-7.62-.89-10.62-3.91q-20.49-20.65-41.13-41.17a26,26,0,0,0-3.58-3.32c-3.07-2.07-6.25-2-8.94.61s-2.85,5.75-1,8.91a15.8,15.8,0,0,0,2.57,2.93Q175.66,93.19,207.48,125C208.34,125.86,209.29,126.64,211,128.17Zm-95.59-54,10.53-9.71c-2.49-2-4.74-7.67-10.77-6.5A8.81,8.81,0,0,0,109.47,63C107.57,69.36,113.36,71.85,115.39,74.14ZM23.49,87.32c3.91,0,7.82.21,11.71,0,4.61-.32,7.48-3.45,7.35-7.48s-3.09-6.9-7.81-7q-11.22-.21-22.44,0c-4.73.1-7.69,2.92-7.84,7S7.35,87,12.28,87.32c3.72.21,7.47,0,11.21,0ZM77.8,21.87c-.16-4.87-3.17-7.9-7.49-7.79-4.13.1-7,3-7.11,7.67Q63,33,63.2,44.19c.08,4.87,3.15,7.9,7.48,7.79,4.11-.1,6.95-3,7.11-7.68.14-3.73,0-7.48,0-11.22S77.93,25.6,77.8,21.87ZM30.73,29.53c-3.61-3.27-7.87-3.22-10.81,0s-2.7,7.16.57,10.44q7.91,7.95,16.1,15.62c3.55,3.34,7.86,3.24,10.8.06,2.8-3,2.65-7.11-.56-10.46-2.58-2.69-5.35-5.22-8-7.83S33.5,32,30.73,29.53Z"/></svg>
                                <span class="bold fs14 dark">{{ $post->reactions_count }}</span>
                            </div>
                            <div class="align-center">
                                <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M242.59,126.87c.39,68.29-60.46,121.59-128.32,112.48a123.89,123.89,0,0,1-36.32-11,11.92,11.92,0,0,0-7.61-.65c-13.33,3.71-26.56,7.76-39.79,11.8-4.5,1.37-8.67,1.27-12.1-2.23s-3.32-7.43-2-11.73c4-13.23,8.11-26.45,11.8-39.78a12.35,12.35,0,0,0-.77-8.06C-4.8,113.42,30.65,35.22,100.35,17.13,172.34-1.55,242.17,52.33,242.59,126.87ZM41.27,214.68c9.75-2.93,18.41-5.28,26.89-8.16,5.92-2,11-1.41,16.51,1.68,18.92,10.6,39.31,14.16,60.63,10.06,49.8-9.58,81.33-52.89,75.62-103.31-5.77-50.85-56-88.36-106.48-79.54C49.89,46.69,16.77,115.7,48.52,172.9a15.29,15.29,0,0,1,1.38,12.91C47,195,44.37,204.23,41.27,214.68Z"/></svg>
                                <span class="bold fs14 dark">{{ $post->comments_count }}</span>
                            </div>
                        </td>
                        <td class="posts-table-date-column fs13 dark">
                            <div>
                                <div class="align-center">
                                    <svg class="size12 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M149.78,24c-1.59-11.62,9.08-21.73,20.46-18.55,15.86,4.42,30,12.39,42.71,22.8A127,127,0,0,1,253.15,86c.53,1.53,1,3.09,1.41,4.66a9.31,9.31,0,0,1,.21,1.79c.11,8.12-5.09,15-12.24,17-7.65,2.05-16.12-1.28-19.6-8.13-2.5-4.92-4.19-10.23-6.67-15.15-11.35-22.5-28.86-38.21-52.52-46.94C156.42,36.46,150.94,32.45,149.78,24ZM248,148.15c-5.4-4.34-11.48-4.85-17.87-1.91-5.92,2.72-8,8.16-10.21,13.63-15,36.7-42.39,57.53-81.85,60.65-40.68,3.21-78.94-22.13-93.12-60A93.32,93.32,0,0,1,75.22,53.15c9-7,19.25-11.31,29.53-15.84a16.9,16.9,0,0,0,9.17-22c-3.4-8.5-12.58-12.77-21.8-9.4C47,22.42,18.44,53.84,7.24,100.79c-.75,3.13-.76,6.43-1.63,9.53A25.14,25.14,0,0,1,5.15,114,25.78,25.78,0,0,1,4.76,118a25.93,25.93,0,0,1-.34,4.68v15.2c.06.39.13.77.18,1.16a32.61,32.61,0,0,1,.67,4.11C7.12,149,7.35,155.3,9.1,161.28q15.65,53.25,64.46,79.36a117.93,117.93,0,0,0,37.87,12.64c.36,0,.71,0,1.07,0a28.75,28.75,0,0,1,7.33.94,29,29,0,0,1,5.65.56h.15c.78,0,1.55,0,2.31.1s1.33-.1,2-.1a29.69,29.69,0,0,1,4.76.39h3.77a27,27,0,0,1,5.53-.58l.6,0a1.88,1.88,0,0,1,1.14-.38c30-3,55.54-15.52,76.82-36.63,14.91-14.79,25.81-32.2,31.52-52.55C256,158.17,253.28,152.42,248,148.15Z"></path></svg>
                                    <span class="block bold">{{ $post->status }}</span>
                                </div>
                                <div class="align-center mt4">
                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M5.22,125.75c1.87-7.6,6.32-13.64,11.46-19.33C37.14,83.8,60,64.32,88.3,52.11c34.75-15,67.81-10,99.59,8.71,22.8,13.44,42.16,30.92,59,51.26,8.74,10.6,9.54,24.93,1.1,35.4-21.67,26.89-47.28,49.07-79.57,62.46-33.49,13.89-65.44,8.84-96.08-8.82-23.52-13.55-43.4-31.42-60.46-52.39-3.05-3.74-4.45-8.82-6.61-13.28ZM131.91,62.67a83.6,83.6,0,0,0-32.8,6.14c-29.08,11.73-52,31.52-71.88,55.27-3.87,4.62-3.66,8.68.4,13.55,16.4,19.67,35.28,36.45,58,48.57,21.45,11.45,43.83,16.45,67.68,8.4,32.51-10.95,57.36-32.39,78.83-58.28,3.4-4.1,2.86-8.18-.95-12.77-14.87-18-32-33.4-52.07-45.28C163.91,69.28,147.79,63,131.91,62.67Zm-2.06,19.42A48.5,48.5,0,1,1,80.91,130,48.62,48.62,0,0,1,129.85,82.09Zm-.42,77.6a29.1,29.1,0,1,0-29.12-29.31A29.19,29.19,0,0,0,129.43,159.69Z"></path></svg>
                                    <span class="block bold">{{ $post->visibility }}</span>
                                </div>
                                <div class="simple-line-separator my8"></div>
                                <div class="flex mt4">
                                    <svg aria-hidden="true" class="size14 mr4 mt2" viewBox="0 0 18 18"><path d="M9 17c-4.36 0-8-3.64-8-8 0-4.36 3.64-8 8-8 4.36 0 8 3.64 8 8 0 4.36-3.64 8-8 8Zm0-2c3.27 0 6-2.73 6-6s-2.73-6-6-6-6 2.73-6 6 2.73 6 6 6ZM8 5h1.01L9 9.36l3.22 2.1-.6.93L8 10V5Z"></path></svg>
                                    <div>
                                        <span class="block bold">created :</span>
                                        <span class="block fs12" title="{{ $post->creation_date }}">{{ $post->creation_date_humans }}</span>
                                        <span class="block bold mt8">last update :</span>
                                        <span class="block fs12" title="{{ $post->update_date }}">{{ $post->update_date_humans }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="7" class="full-center">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="bold dark fs13 my4">No posts found. <a href="{{ route('create.new.post') }}" class="link-style">Click here</a> to create a new post</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="flex mt8">
            <div class="move-to-right">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</main>
@endsection