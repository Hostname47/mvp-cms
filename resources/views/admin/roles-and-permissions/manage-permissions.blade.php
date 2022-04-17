@extends('layouts.admin')

@section('title', 'Admin - Roles & Permissions overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/roles-and-permissions/permissions.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/admin/roles-and-permissions/permissions.js') }}" defer></script>
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rp', 'subpage'=>'admin.rp.permissions-management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"></path></svg>
            <h1 class="fs20 dark no-margin">Roles & Permissions Management</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">Dashboard</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="align-center">
                <span class="fs13 bold">Roles & Permissions</span>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <a href="{{ route('admin.rp.manage.permissions') }}" class="blue-link align-center bold fs13">permissions management</a>
        </div>
    </div>
    <div class="admin-page-content-box">
        @if(Session::has('message'))
        <div class="informative-message-container align-center relative my8">
            <div class="informative-message-container-left-stripe imcls-green"></div>
            <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @endif

        <!-- create permission viewer -->
        <div id="create-permission-viewer" class="global-viewer full-center none">
            <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
            <div class="global-viewer-content-box viewer-box-style-1" style="width: 600px;">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                    <div class="flex align-center">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"/></svg>
                        <span class="fs20 bold dark">{{ __('Create a new permission') }}</span>
                    </div>
                    <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div id="create-permission-viewer-scrollable" class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 430px">
                    <p class="no-margin dark mb8 fs13">The flow of creating permissions is simple; First create the permission, then attach it to a role, then all role members will acquire this permission.</p>
                    <div class="simple-line-separator my4"></div>
                    <div>
                        <div class="flex align-center">
                            <svg class="size15 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="my8 bold dark fs16">Permission Informations</p>
                        </div>
                        <!-- error container -->
                        <div id="create-permission-error-container" class="informative-message-container align-center relative my8 none">
                            <div class="informative-message-container-left-stripe imcls-red"></div>
                            <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                            <div class="close-parent close-informative-message-style">✖</div>
                        </div>
                        <div class="mb8 input-wrapper">
                            <label for="create-permission-title-input" class="flex align-center bold dark">{{ __('Title') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb4 gray">Permission title should only contain characters.</p>
                            <input type="text" autocomplete="off" class="styled-input full-width title" id="create-permission-title-input" placeholder="permission name" style="padding: 8px 10px">
                        </div>
                        <div class="mb8 input-wrapper">
                            <label for="create-permission-slug-input" class="flex align-center bold dark">{{ __('Slug') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb4 gray">Permission slug should be dash separated version of title.</p>
                            <input type="text" autocomplete="off" class="styled-input full-width slug" id="create-permission-slug-input" placeholder="permission slug" style="padding: 8px 10px">
                        </div>
                        <div class="mb8 input-wrapper">
                            <label for="create-permission-description-input" class="flex align-center bold dark mb4">{{ __('Description') }}<span class="error-asterisk ml4">*</span></label>
                            <textarea id="create-permission-description-input" class="styled-input no-textarea-x-resize fs14 description"
                                style="margin: 0; padding: 8px; min-height: 110px; max-height: 200px;"
                                maxlength="2000"
                                spellcheck="false"
                                autocomplete="off"
                                placeholder="Permission description here"></textarea>
                        </div>
                        <div class="mb8 input-wrapper">
                            <label for="create-permission-scope-input" class="flex align-center bold dark">Scope<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb4 gray">Specify the scope where the permission will belong to, or create a new scope</p>
                            <div style="padding: 8px;">
                                <style>
                                    .permission-scope-switch {
                                        height: max-content;
                                        margin-top: 1px;
                                        margin-right: 8px;
                                    }
                                </style>
                                <div class="flex">
                                    <input type="radio" class="permission-scope-switch" name="scope-switch" autocomplete="off" value="existing" checked>
                                    <div>
                                        <p class="fs13 no-margin gray mb4">Choose an existing scope</p>
                                        <select name="create-permission-scope-input" id="create-permission-scope-input" class="styled-input existing-scope" autocomplete="off">
                                            @foreach($scopes as $scope)
                                            <option value="{{ $scope }}">{{ $scope }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="simple-line-separator half-width my8"></div>
                                <div class="flex">
                                    <input type="radio" class="permission-scope-switch" name="scope-switch" autocomplete="off" value="fresh">
                                    <div>
                                        <div class="flex align-center my4 none" id="scope-already-exists">
                                            <svg class="size12 mr4" fill="#8e3c23" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                            <span class="fs12" style="color: #8e3c23;">this scope already exists in the existings. Its better to choose it from there</span>
                                        </div>
                                        <p class="fs13 no-margin gray mb4">Define a new scope (should be lower-case & space between words)</p>
                                        <input type="text" autocomplete="off" class="styled-input full-width fresh-scope" id="create-permission-new-scope-input" placeholder="New scope" style="padding: 8px 10px" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex" style="margin-top: 12px">
                        <div id="create-permission-button" class="typical-button-style green-bs align-center">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold unselectable">Create permission</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(is_null($permission))
            <div class="align-center">
                <svg class="size15 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                <h2 class="dark no-margin">Permission Management</h2>
                <div class="light-gray fs8 bold" style="margin: 0 12px">•</div>
                <div class="typical-button-style green-bs align-center open-create-permission-dialog" style="padding: 6px 10px;">
                    <svg class="size10 flex mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs12 flex bold">create new permission</span>
                </div>
            </div>
            <h2 class="dark no-margin fs16 mb4" style="margin-top: 12px">Permissions</h2>
            <p class="dark no-margin lh15 mb8">Each permission represents the ability to perform a specific action in the system. If a user has a specific permission, that means he can perform the action attached to that permission. The following list, shows all the available permissions and their parent role, so you can select a particular permission to manage.</p>
            <div class="flex">
                <div class="typical-section-style align-center">
                    <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                    <p class="fs13 light-gray no-margin">If a permission does not have a parent role, It will be listed in root permissions list in the bottom section.</p>
                </div>
            </div>
            <h2 class="dark no-margin fs14" style="margin-top: 12px">Roles::Permissions Diagram</h2>
            <p class="dark no-margin lh15 mb8">The following diagram shows permissions by role, so that each role has a set of permissions attached to it.</p>
            <table class="full-width">
                <thead>
                    <tr>
                        <th class="diagram-role-part">
                            <div class="full-center">
                                <span class="dark">Roles</span>
                            </div>
                        </th>
                        <th class="diagram-permissions-part">
                            <div class="full-center">
                                <span class="dark">Permissions</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                @foreach($roles as $role)
                <tr>
                    <!-- role part -->
                    <td class="diagram-role-part">
                        <div class="diagram-role mb4">
                            <h3 class="no-margin fs14 dark no-wrap">Role : <span class="dark-blue">{{ $role->title }}</span></h3>
                            <div class="h-line"></div>
                        </div>
                        <p class="fs13 light-gray no-margin">Members : <strong>{{ $role->users()->count() }}</strong></p>
                        @if($role->slug != 'site-owner')
                        <p class="fs13 light-gray no-margin">Permissions : <strong>{{ $role->permissions()->count() }}</strong></p>
                        @endif
                    </td>
                    <!-- permissions part -->
                    <td class="diagram-permissions-part">
                        @if($role->slug == 'site-owner')
                        <div class="full-center">
                            <svg class="size20 mr8" fill="#2d2d2d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.44,172.34c-10.15,14.26-25.88,18.13-41.5,21.48-43.65,9.35-87.82,10-132.06,5.81-20.18-1.9-40.31-4.88-59.29-12.74-5-2.07-9.8-4.58-13.76-8.36-7.07-6.75-7-14.28.28-20.79s16.06-9.27,25-12c7.48-2.28,7.64-2.16,8.08,5.36.51,8.47,5.39,13.72,12.37,17.54,12.18,6.68,25.66,8.72,39.12,10.42a273.28,273.28,0,0,0,89-2.87c8.2-1.66,16.17-4,23.41-8.45s11.29-10.5,10.57-19c-.41-4.91,1.19-5.3,5.38-4,7.64,2.44,15.22,4.9,22.25,8.84,5.28,3,9.22,7,11.18,12.84Zm-88.5-.17c12-1.77,23.93-3.57,34.76-9.58,5.6-3.11,9.07-7.2,8.51-14.09-.58-7.18-.45-14.41-1.09-21.58-1.28-14.37-3.68-28.52-9.74-41.81-9.14-20-25.42-28.5-46.66-23.8-9.94,2.19-19.17,6.43-28,11.51a23.2,23.2,0,0,1-15.59,2.63,207,207,0,0,0-21.46-2.33c-11.61-.5-21.11,3.7-27.4,14A52.88,52.88,0,0,0,56,98.65c-5.58,17.25-5.48,35.16-5.91,53-.11,4.68,3.07,7.85,6.88,10.09a50.94,50.94,0,0,0,10.65,4.9c20.56,6.33,41.72,7.84,68,7.93A204.19,204.19,0,0,0,167.94,172.17Z"></path></svg>
                            <em class="light-gray fs14">ABSOLUTE CONTROL.</em>
                        </div>
                        @else
                        <div class="diagram-role-permissions-container">
                            @foreach($role->permissions->groupBy('scope') as $scope => $permissions)
                                <div class="align-center mt8 ml8">
                                    <h3 class="blue bold fs16 no-margin">Scope : {{ $scope }}</h3>
                                    <div class="pointer fs12 ml8 open-create-permission-dialog">
                                        <span class="dark bold">+ new permission</span>
                                        <input type="hidden" class="scope" value="{{ $scope }}" autocomplete="off">
                                    </div>
                                </div>
                                @foreach($permissions as $permission)
                                <div class="diagram-role-permission">
                                    <div class="h-line"></div>
                                    <div>
                                        <div class="align-center">
                                            <p class="no-margin bold dark mr8">{{ $permission->title }}</p>
                                            <p class="fs11 no-margin light-gray">- {{ $permission->slug }}</p>
                                            <div class="light-gray fs8 mx8">•</div>
                                            <a href="?permission={{ $permission->slug }}" class="no-underline dark-blue bold fs12">manage</a>
                                        </div>
                                        <p class="fs12 mt2 no-margin light-gray"><strong>Description</strong> : {{ $permission->description }}</p>
                                    </div>
                                </div>
                                <div class="simple-line-separator"></div>
                                @endforeach
                            @endforeach
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            <h2 class="dark no-margin fs14" style="margin-top: 12px">Root permissions</h2>
            <p class="dark no-margin lh15 mb8">The following diagram shows root permissions with no parent role.</p>
            <div class="typical-section-style align-center my4">
                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                <p class="dark no-margin">Notice that all the actions depend on these permissions are <strong>only permitted to site owners</strong>.</p>
            </div>
            <table class="full-width">
                <thead>
                    <tr>
                        <th class="diagram-role-part">
                            <div class="full-center">
                                <span class="dark">Roles</span>
                            </div>
                        </th>
                        <th class="diagram-permissions-part">
                            <div class="full-center">
                                <span class="dark">Root Permissions</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tr>
                    <!-- role part -->
                    <td class="diagram-role-part">
                        <h3 class="no-margin fs14 dark text-center">--</h3>
                    </td>
                    <!-- permissions part -->
                    <td class="diagram-permissions-part">
                        <div class="diagram-role-permissions-container">
                            @foreach($root_permissions->groupBy('scope') as $scope => $permissions)
                                <div class="align-center mt8 ml8">
                                    <h3 class="blue bold fs16 no-margin">Scope : {{ $scope }}</h3>
                                    <div class="pointer ml8 fs12 open-create-permission-dialog">
                                        <span class="dark bold">+ new permission</span>
                                        <input type="hidden" class="scope" value="{{ $scope }}" autocomplete="off">
                                    </div>
                                </div>
                                @foreach($permissions as $permission)
                                <div class="diagram-role-permission">
                                    <div class="h-line"></div>
                                    <div>
                                        <div class="align-center">
                                            <p class="no-margin bold dark mr8">{{ $permission->title }}</p>
                                            <p class="fs11 no-margin light-gray">- {{ $permission->slug }}</p>
                                            <div class="light-gray fs8 mx8">•</div>
                                            <a href="?permission={{ $permission->slug }}" class="no-underline dark-blue bold fs12">manage</a>
                                        </div>
                                        <p class="fs12 mt2 no-margin light-gray"><strong>Description</strong> : {{ $permission->description }}</p>
                                    </div>
                                </div>
                                <div class="simple-line-separator"></div>
                                @endforeach
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        @else
        @endif
    </div>
</main>
@endsection