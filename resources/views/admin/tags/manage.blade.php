@extends('layouts.admin')

@section('title', 'Admin - Tags')

@push('scripts')
<script src="{{ asset('js/admin/tags.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/tags.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'tags.management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
            <h1 class="fs20 dark no-margin">Tags Management</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Tags management') }}</span>
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
        <div class="flex">
            <h2 class="blue no-margin">Tags</h2>
            <!-- search section -->
            <div class="move-to-right">
                <form action="" class="align-center relative">
                    <svg class="search-icon-style-1" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                    <input type="text" required name="k" class="search-input-style-1" style="width: 300px" placeholder="search for tags" @if($k) value="{{ $k }}" @endif>
                    <button class="search-button-style-1">
                        <span>Search Tags</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="flex my8">
            <div class="move-to-right">
                {{ $tags->appends(request()->query())->links() }}
            </div>
        </div>
        <div class="flex mt8">
            <div id="create-tag-section">
                <div class="align-center">
                    <svg class="size12 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"></path></svg>
                    <h3 class="dark fs16 no-margin">Create Tag</h3>
                </div>
                <p class="no-margin my4 fs13 dark">Create a new tag, and start classify your posts more precisely.</p>
                <!-- ERROR block -->
                <div id="tag-create-error-container" class="informative-message-container post-top-error-container align-center relative my8 none">
                    <div class="informative-message-container-left-stripe imcls-red"></div>
                    <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
                <!-- green message block -->
                <div id="tag-create-green-message-container" class="informative-message-container align-center relative my8 none">
                    <div class="informative-message-container-left-stripe imcls-green"></div>
                    <p class="no-margin fs13 dark-green bold message-text">Title field is required.</p>
                    <div class="close-parent close-informative-message-style">✖</div>
                </div>
                <!-- title -->
                <div class="input-wrapper" style="margin-top: 16px;">
                    <label class="input-label fs13 dark my4" for="create-tag-title">Tag title<span class="error-asterisk red ml4">*</span></label>
                    <input type="text" id="create-tag-title" class="styled-input" autocomplete="off" placeholder='{{ __("Tag title") }}'>
                    <p class="fs12 my4 light-gray">This title is displayed in website to represent tag.</p>
                </div>
                <!-- title-meta -->
                <div class="input-wrapper" style="margin-top: 12px;">
                    <label class="input-label fs13 dark my4" for="create-tag-meta-title">Tag meta title<span class="error-asterisk red ml4">*</span></label>
                    <input type="text" id="create-tag-meta-title" class="styled-input" autocomplete="off" placeholder='{{ __("Tag meta title") }}'>
                    <p class="fs12 my4 light-gray">Meta title used to improve <strong>tag SEO</strong> and displayed in browser tab title.</p>
                </div>
                <!-- slug -->
                <div class="input-wrapper" style="margin-top: 12px;">
                    <label class="input-label fs13 dark my4" for="create-tag-slug">Tag slug<span class="error-asterisk red ml4">*</span></label>
                    <input type="text" id="create-tag-slug" class="styled-input" autocomplete="off" placeholder='{{ __("Tag slug") }}'>
                    <p class="fs12 my4 light-gray">The “slug” is the URL-friendly version of the title. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
                </div>
                <!-- description -->
                <div class="input-wrapper" style="margin-top: 12px;">
                    <label class="input-label fs13 dark my4" for="create-tag-description">Tag description (optional)<span class="error-asterisk red ml4">*</span></label>
                    <textarea type="text" id="create-tag-description" class="styled-input no-textarea-x-resize" style="height: 130px;" autocomplete="off" placeholder='{{ __("Description here") }}'></textarea>
                </div>

                <div class="flex">
                    <div id="create-tag-button" class="typical-button-style dark-bs full-center mt8" style="padding: 8px 11px;">
                        <div class="relative size12 mr4">
                            <svg class="flex size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M4.41,104.24c2.53-3,5.67-4,9.7-4,26.83.17,53.67,0,80.5.17,3.53,0,4.61-.67,4.58-4.44-.18-27-.1-54-.09-81,0-7.29,2-9.31,9.16-9.32q21.22,0,42.45,0c6.91,0,9,2.09,9,9,0,27,.09,54-.09,81,0,3.82.94,4.79,4.76,4.76,26.83-.17,53.67-.1,80.5-.09,7.58,0,9.5,1.92,9.51,9.47q0,21.23,0,42.45c0,6.55-2.17,8.66-8.83,8.67-27.16,0-54.32.09-81.47-.09-3.77,0-4.47,1-4.45,4.58.15,26.83,0,53.66.17,80.49,0,4-1,7.17-4,9.7H103c-3-2.53-4-5.67-4-9.7.16-26.85,0-53.7.18-80.55,0-3.65-.87-4.54-4.52-4.52-26.85.18-53.7,0-80.55.18-4,0-7.18-1-9.71-4Z"></path></svg>
                            <svg class="spinner size12 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                            </svg>
                        </div>
                        <span class="bold fs12 unselectable">Create Tag</span>
                    </div>
                </div>
            </div>
            <div id="tags-section">
                <table class="full-width">
                    <thead>
                        <tr class="flex">
                            <th class="tags-table-selection-column">
                                <input type="checkbox" class="no-margin size16">
                            </th>
                            <th class="tags-table-title-column">
                                <span class="blue">Tag title</span>
                            </th>
                            <th class="tags-table-slug-column">
                                <span class="dark fs13">Tag slug</span>
                            </th>
                            <th class="tags-table-description-column">
                                <span class="dark fs13">Description</span>
                            </th>
                            <th class="tags-table-count-column">
                                <span class="dark fs13">Count</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tags->count())
                            @foreach($tags as $tag)
                            <tr class="flex tag-row">
                                <!-- tags selection -->
                                <td class="tags-table-selection-column">
                                    <input type="checkbox" class="no-margin size16" autocomplete="off">
                                </td>
                                <!-- tags title -->
                                <td class="tags-table-title-column">
                                    <a href="" class="dark-blue bold no-underline post-title">{{ $tag->title }}</a>
                                    <div class="align-center mt4 tag-actions-links-container">
                                        <a href="" class="fs12 dark-blue no-underline">
                                            <span>Edit</span>
                                        </a>
                                        <span class="fs11 mx8 dark">〡</span>
                                        <span class="fs12 red pointer align-center delete-tag-button">
                                            <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                            <span>Delete</span>
                                            <input type="hidden" class="tag-id" value="{{ $tag->id }}" autocomplete="off">
                                        </span>
                                        <span class="fs11 mx8 dark">〡</span>
                                        <a href="" class="fs12 dark-blue no-underline">
                                            <span>View</span>
                                        </a>
                                    </div>
                                </td>
                                <!-- tags slug -->
                                <td class="tags-table-slug-column">
                                    <p class="dark no-margin fs13">{{ $tag->slug }}</p>
                                </td>
                                <!-- tags description -->
                                <td class="tags-table-description-column">
                                    <p class="dark no-margin fs13">{{ $tag->description }}</p>
                                </td>
                                <!-- tags posts count -->
                                <td class="tags-table-count-column">
                                    <p class="dark no-margin">0</p>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="full-center">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="bold dark fs13 my4">No tags found. <a class="link-style">Click here</a> to create a new tag</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex my8">
            <div class="move-to-right">
                {{ $tags->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</main>
@endsection