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
            <a href="{{ route('create.new.post') }}" class="dark no-underline align-center" style="padding: 5px 11px;">
                <svg class="flex size13 mr4" fill="#363942" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M58.55,251.39c-9.94,0-15.72-5.59-14.54-14.83,2.77-21.61,6-43.16,9.09-64.73.47-3.3,2.39-5.94,4.78-8.32q40.7-40.6,81.26-81.35c2.57-2.58,3.89-2.93,6.66-.13q33.54,33.93,67.46,67.48c2.68,2.66,2.69,4,0,6.66q-40.81,40.49-81.33,81.27c-3.74,3.76-8.24,4.81-13.18,5.5-18.75,2.6-37.48,5.38-56.22,8.08C61.12,251.22,59.69,251.29,58.55,251.39ZM246.34,89.65c-7.19-36.3-51.11-53.73-81.14-32.19-2,1.43-4.84,2.3-1.42,5.68q34.36,34,68.35,68.34c2.69,2.72,3.75,1.61,5.39-.68,6.47-9.06,9.79-19.13,10.1-32.08C247.74,96.86,247.05,93.25,246.34,89.65ZM142.6,34.57c8.12-.06,13.3-5.32,13.34-12.81s-5.25-13-13.16-13.07c-38.95-.12-77.9-.07-116.84-.06a12.77,12.77,0,0,0-12,7.09C9.22,24.6,15.6,34.48,26.37,34.58c19.37.18,38.74.05,58.11.05S123.23,34.74,142.6,34.57ZM102.41,87c8.81-.07,14.4-5.3,14.35-13.17-.06-7.69-5.36-12.76-14-12.79q-37.92-.16-75.83,0c-8.84,0-14.56,5.36-14.48,13.06s6,12.86,14.73,12.91c12.64.07,25.28,0,37.92,0C77.54,87,90,87.05,102.41,87ZM51.69,139.25c7.56-.53,12.85-5.92,13-12.81.18-7.06-5.31-13-13.09-13.33-8.73-.36-17.5-.36-26.23,0-7.64.32-12.8,5.78-12.94,12.77-.15,7.24,5.11,12.81,13,13.36,4.25.31,8.53.06,12.81.06C42.75,139.31,47.24,139.57,51.69,139.25Z"/></svg>
                <span class="bold fs11 unselectable">Add new post</span>
            </a>
        </div>

        <div class="flex align-center space-between mt8">
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
                    <th class="posts-table-title-column">
                        <span class="blue">Title</span>
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
                    <th class="posts-table-comments-column full-center">
                        <svg class="size16 flex" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
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
                                    <a href="{{ route('view.post', ['category'=>$post->categories->first()->slug, 'post'=>$post->slug]) }}" class="fs12 dark-blue no-underline">
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
                            <a href="" class="dark bold no-underline fs13">{{ $post->author->username }}</a>
                            @else
                            <em class="dark">Unknown</em>
                            @endif
                        </td>
                        <!-- post categories -->
                        <td class="posts-table-categories-column">
                            @foreach($post->categories as $category)
                                @if($loop->index != 0)<span class="bold light-gray">,</span>@endif
                                <a href="" class="dark-blue no-underline fs13">{{ $category->title }}</a>
                            @endforeach
                            @if(!$post->categories->count())
                            <span class="light-gray">--</span>
                            @endif
                        </td>
                        <!-- post tags -->
                        <td class="posts-table-tags-column">
                            @foreach($post->tags as $tag)
                                @if($loop->index != 0)<span class="bold light-gray">,</span>@endif
                                <a href="" class="dark-blue no-underline fs13">{{ $tag->title }}</a>
                            @endforeach
                            @if(!$post->tags->count())
                            <span class="light-gray">--</span>
                            @endif
                        </td>
                        <!-- post comments count -->
                        <td class="posts-table-comments-column full-center">
                            <span>{{ $post->comments_count }}</span>
                        </td>
                        <td class="posts-table-date-column fs13 dark">
                            @if($post->status == 'published' && $post->visibility != 'private')
                            <div>
                                <span class="block bold green">Published</span>
                                <span>{{ $post->publish_date_humans }}</span>
                            </div>
                            @else
                            <div>
                                <span class="block bold">Last modified</span>
                                <span>{{ $post->update_date_humans }}</span>
                            </div>
                            @endif
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