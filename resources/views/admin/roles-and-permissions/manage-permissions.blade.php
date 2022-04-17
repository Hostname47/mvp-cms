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
            <input type="hidden" id="permission-id" value="{{ $permission->id }}" autocomplete="off">

            <!-- attach permission to users viewer -->
            <div id="attach-permission-to-users-viewer" class="global-viewer full-center">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                            <span class="fs20 bold dark">Attach "{{ $permission->title }}" permission to users</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box" style="padding: 14px;">
                        <div class="section-style fs13 dark mb8">
                            <p class="no-margin dark lh15">Here you can attach "<strong>{{ $permission->title }}</strong>" permission directly to members.</p>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <p class="fs12 gray bold my4"  style="margin-top: 12px">Permission : <span class="blue fs14 ml4">{{ $permission->title }}</span></p>
                        <!-- parent role -->
                        <div style="margin-top: 12px">
                            @if($role = $permission->role())
                            <div class="align-center mb4">
                                <svg class="size14 mr4" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"></path></svg>
                                <p class="fs12 dark bold no-margin">Parent role : <span class="fs14 ml4">{{ $role->title }}</span></p>
                            </div>
                            @else
                            <div class="align-center mb4">
                                <svg class="size14 mr4" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"></path></svg>
                                <p class="fs12 dark bold no-margin">Parent role</p>
                            </div>
                            <div class="align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="no-margin fs13 italic light-gray">This permission is a root permission. (does not attached to any role)</p>
                            </div>
                            @endif
                        </div>
                        <div style="margin-top: 12px">
                            <div class="relative">
                                <span class="block mb4 fs12 gray bold">Select member that you want to attach the permission to :</span>
                                <div class="relative">
                                    <div class="relative flex">
                                        <svg class="absolute size14" fill="#5b5b5b" style="top: 10px; left: 12px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                        <input type="text" class="search-input-style-1" id="permission-member-search-input" autocomplete="off" placeholder="find member by username">
                                        <div class="search-button-style-1 align-center" id="permission-search-for-member-to-attach">
                                            <svg class="size14 mr4" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                            <span class="bold dark">search</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <div id="permission-members-search-result-box" class="full-width y-auto-overflow none" style="max-height: 250px;">
                                        <input type="hidden" id="permission-user-k" autocomplete="off">
                                        <div class="results-container none">
                                            results
                                        </div>
                                        <div class="permission-member-search-user permission-member-search-user-factory mb4 flex none">
                                            <input type="hidden" class="permission-user-id" autocomplete="off">
                                            <a href="" class="permission-user-user-manage-link" style="height: 42px">
                                                <img src="" class="size36 rounded mr8 permission-user-avatar" alt="" style="border: 3px solid #9f9f9f;">
                                            </a>
                                            <div>
                                                <div class="align-center">
                                                    <span class="block bold fs15 dark permission-user-fullname">Mouad Nassri</span>
                                                    <div class="button-style-1 align-center ml8 permission-select-member none" style="padding: 4px 8px">
                                                        <svg class="size11 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"></path></svg>
                                                        <span class="fs11 dark bold">select user</span>
                                                    </div>
                                                    <div class="align-center ml8 height-max-content already-has-permission none" style="padding: 2px">
                                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"></path></svg>
                                                        <span class="fs12 bold green">Already has this permission</span>
                                                    </div>
                                                </div>
                                                <div class="align-center mt2">
                                                    <span class="block fs13 dark permission-user-username">codename49</span>
                                                    <div class="light-gray mx4 fs8">•</div>
                                                    <span class="block bold fs12 blue permission-user-role">Site owner</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- fetch more users -->
                                        <div id="permission-users-fetch-more-results" class="full-center none" style='height: 40px;'>
                                            <svg class="spinner size20" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <!-- loading -->
                                        <div class="search-loading full-center none" style="height: 42px">
                                            <svg class="spinner size24 absolute black" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <!-- no results found -->
                                        <div class="no-results-found-box full-center none" style='height: 40px;'>
                                            <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                            <p class="fs13 gray no-margin bold">No users found with this username.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <span class="block mb4 fs12 gray bold">Selected members</span>
                            <div id="empty-permission-members-selected-box" class="align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs13 gray no-margin">Select at least one member that you want to attach this permission to</p>
                            </div>
                            <div id="permission-members-selected-box" class="flex flex-wrap y-auto-overflow none" style="max-height: 160px"> <!-- sum: selected user member -->
                                
                            </div>
                            <div class="selected-permission-member-to-get-permission selected-permission-member-to-get-permission-factory mb4 mr4 full-center flex-column relative none">
                                <input type="hidden" class="selected-user-id" autocomplete="off">
                                <a href="" class="selected-user-manage-link" style="height: 42px">
                                    <img src="{{ auth()->user()->avatar(100) }}" class="size36 rounded mr8 selected-user-avatar" alt="" style="border: 3px solid #9f9f9f;">
                                </a>
                                <span class="block bold selected-user-fullname mt4">Mouad Nassri</span>
                                <span class="block my4 fs12 dark selected-user-username">codename49</span>
                                <span class="block bold fs12 blue selected-user-role">Site owner</span>

                                <!-- remove member from selected users -->
                                <div class="remove-selected-user-from-selection x-close-container-style">
                                    <span class="x-close unselectable">✖</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 bold dark">Confirmation</p>
                            <p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::attach-permission::{{ $permission->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width styled-input" id="attach-permission-confirm-input" style="padding: 8px 10px" placeholder="Permission attach confirmation">
                                <input type="hidden" id="attach-permission-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::attach-permission::{{ $permission->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div class="align-center full-width">
                                    <div id="attach-permission-button" class="typical-button-style green-bs green-bs-disabled full-center full-width" style="padding: 10px;">
                                        <div class="relative size14 mr4">
                                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"></path></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="bold">Attach permission to selected user(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex align-end space-between mb8">
                <h2 class="no-margin fs20 mb2 dark">• Manage "<span class="blue">{{ $permission->title }}</span>" permission</h2>
                <div class="typical-button-style green-bs align-center open-create-permission-dialog">
                    <svg class="size10 mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs11 bold">create new permission</span>
                </div>
            </div>
            <div class="flex">
                <div id="update-permission-section" class="permission-section">
                    <div class="align-center mb8">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                        <h2 class="no-margin fs18 dark">Update permission informations</h2>
                    </div>
                    <div class="typical-section-style my8">
                        <p class="fs13 dark no-margin">Please be careful when you update the following informations, because the action attached to the permission depends on the following informations.</p>
                    </div>
                    <div id="update-permission-error-container" class="informative-message-container align-center relative my8 none">
                        <div class="informative-message-container-left-stripe imcls-red"></div>
                        <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                        <div class="close-parent close-informative-message-style">✖</div>
                    </div>
                    <div class="mb8 input-wrapper">
                        <label for="update-permission-title-input" class="align-center bold dark">{{ __('Title') }}<span class="error-asterisk ml4">*</span></label>
                        <p class="no-margin fs12 mb2 gray">Permission title should contain only characters.</p>
                        <input type="text" autocomplete="off" class="styled-input full-width" id="update-permission-title-input" value="{{ $permission->title }}" placeholder="Permission title" style="padding: 8px 10px">
                    </div>
                    <div class="mb8 input-wrapper">
                        <label for="update-permission-slug-input" class="align-center bold dark">{{ __('Slug') }}<span class="error-asterisk ml4">*</span></label>
                        <p class="no-margin fs12 mb2 gray">Permission slug should be a dashed version of title. (dashed-version-of-title)</p>
                        <input type="text" autocomplete="off" class="styled-input full-width" id="update-permission-slug-input" value="{{ $permission->slug }}" placeholder="Permission slug" style="padding: 8px 10px">
                    </div>
                    <div class="mb8 input-wrapper">
                        <label for="update-permission-description-input" class="align-center bold dark mb4">{{ __('Description') }}<span class="error-asterisk ml4">*</span></label>
                        <textarea id="update-permission-description-input" class="styled-input no-textarea-x-resize fs14"
                            style="margin: 0; padding: 8px; min-height: 110px;"
                            maxlength="800"
                            spellcheck="false"
                            autocomplete="off"
                            placeholder="{{ __('Permission description here') }}">{{ $permission->description }}</textarea>
                    </div>
                    <div class="mb8 input-wrapper">
                        <div class="align-center">
                            <label for="update-permission-scope-input" class="align-center bold dark">{{ __('Scope') }}<span class="error-asterisk ml4">*</span></label>
                            <div class="light-gray fs8 mx8">•</div>
                            <div class="relative">
                                <div class="pointer button-with-suboptions">
                                    <span class="fs12 bold dark">select from exisitng</span>
                                    <svg class="size7" style="transform: rotate(180deg); padding-top: 1px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                                </div>
                                <div class="suboptions-container typical-suboptions-container scrolly" style="top: auto; bottom: calc(100% + 2px); max-height: 150px;">
                                    @foreach($scopes as $scope)
                                    <div class="suboption-style-2 select-scope">
                                        <span class="fs13 dark scope">{{ $scope }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <p class="no-margin fs12 mb2 gray">Permission scope should contains only characters. (space between words)</p>
                        <input type="text" autocomplete="off" class="styled-input full-width" id="update-permission-scope-input" value="{{ $permission->scope }}" placeholder="Permission scope" style="padding: 8px 10px">
                    </div>
                    <div class="align-center full-width" style="margin-top: 12px">
                        <div id="update-permission-button" class="typical-button-style dark-bs width-max-content align-center">
                            <div class="relative size13 mr4">
                                <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs11 unselectable">Update permission informations</span>
                        </div>
                    </div>
                </div>
                <div id="update-permission-settings-section" class="permission-section">
                    <!-- Members with that permission -->
                    <div>
                        <div class="align-center mb4">
                            <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path d="M39.46,17.57a2.76,2.76,0,0,1-.11-.7v0c0-.12,0-.23,0-.35C37.5,9.91,33.86,4.78,27.19,2.22A19.23,19.23,0,1,0,14,38.35c.63.22,1.38.21,2,.49l5,.39c.26,0,.51,0,.78,0l.49,0,.17,0A4.16,4.16,0,0,1,23.6,39c.11,0,.21,0,.32,0a10.41,10.41,0,0,1,1.53-.24c6.86-2.22,11.31-6.94,13.7-13.8a4,4,0,0,1,.16-1.09c.06-1.81.14-4.08.21-5.89C39.49,17.87,39.48,17.72,39.46,17.57Zm-20,18.79A16.2,16.2,0,1,1,36.53,20.14,16.34,16.34,0,0,1,19.42,36.36Zm.85-14.83a7.05,7.05,0,0,1-7.18-7.19A7.21,7.21,0,0,1,20.4,7.19a7.32,7.32,0,0,1,7.08,7.12A7.18,7.18,0,0,1,20.27,21.53Zm3.9-8.69a4.11,4.11,0,0,0-2.44-2.37,4.19,4.19,0,0,0-5.63,3.95,4,4,0,0,0,4.18,4.09A4.14,4.14,0,0,0,24.17,12.84ZM21.1,24.18a10.65,10.65,0,0,1,8.35,3.49c.64.68,1.24,1.47.48,2.36s-1.67.52-2.56-.16c-4.84-3.68-9-3.7-13.73-.06-.87.68-1.72,1.23-2.58.27s-.1-1.83.57-2.58C13.59,25.3,16.68,24.16,21.1,24.18Z"></path></svg>
                            <p class="no-margin bold dark fs18">Members already have this permission</p>
                        </div>
                        <p class="my4 fs12 dark lh15">The following members already have this permissions. Normally members get permissions from roles; where a member acquire a role, he gets all permissions attached to that role. But you can attach permissions to users directly as well as revoking.</p>
                        <div class="typical-section-style flex flex-wrap" style="padding: 20px; max-height: 250px; overflow-y: auto; gap: 15px;">
                            <div class="flex justify-center permission-user-box">
                                <div class="rounded-entity-for-permission full-center pointer open-attach-permission-dialog">
                                    <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                                </div>
                            </div>
                            <div class="gray height-max-content fs10" style="margin-top: 22px">•</div>    
                            @foreach($permission->users as $user)
                            <div class="align-center flex-column permission-user-box">
                                <div class="relative">
                                    <img src="{{ $user->avatar(100) }}" class="rounded-entity-for-permission" alt="">
                                    <div class="open-revoke-permission-dialog">
                                        <span class="unselectable">✖</span>
                                        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                                    </div>
                                </div>
                                <span class="bold dark-blue fs11 username">{{ $user->username }}</span>
                                <span class="bold dark fs10">{{ $user->high_role()->title }}</span>
                            </div>
                            @endforeach
                            @if(!$permission->users->count())
                            <div class="align-center">
                                <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs12 no-margin gray">This permission is not attached to any user for the moment.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection