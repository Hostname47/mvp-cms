@extends('layouts.admin')

@section('title', 'Admin - Roles & Permissions overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/roles-and-permissions/roles.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/admin/roles-and-permissions/roles.js') }}" defer></script>
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rp', 'subpage'=>'admin.rp.roles-management'])
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
            <a href="{{ route('admin.rp.manage.roles') }}" class="blue-link align-center bold fs13">roles management</a>
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

        <!-- create role viewer -->
        <div id="create-role-viewer" class="global-viewer full-center none">
            <div class="viewer-content-box viewer-box-style-1">
                <div class="align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                    <div class="align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"></path></svg>
                        <span class="fs20 bold dark">Create a new role</span>
                    </div>
                    <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 470px">
                    <div class="typical-section-style mb4">
                        <p class="no-margin fs13 dark">The concept of roles here is simple; Create a role, attach some permissions to it, and start grant it to users. Users will get all permissions the role acquires.</p>
                    </div>
                    <p class="no-margin fs13 dark mb4">The following roles are ordered by priority. The created role will come to the last place with lower priority. However you can update it in role management page.</p>
                    <div class="align-center">
                        <p class="my8 bold dark mr8">Existing roles :</p>
                        <div class="relative">
                            <div class="button-with-suboptions typical-button-style align-center white-bs" style="padding: 4px 8px;">
                                <span class="fs13">see roles</span>
                                <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                            </div>
                            <div class="suboptions-container typical-suboptions-container width-max-content y-auto-overflow" style="left: 0; max-height: 240px; width: 170px;">
                                @foreach($roles as $r)
                                <div class="block suboption-style-2">
                                    <span class="fs14 bold dark-blue">{{ $r->title }}</span>
                                    <p class="fs12 gray no-margin">{{ $r->description_slice }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div>
                        <div class="align-center my8">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="no-margin bold dark fs15">Role Informations</p>
                        </div>
                        <div id="create-role-error-container" class="informative-message-container align-center relative my8 none">
                            <div class="informative-message-container-left-stripe imcls-red"></div>
                            <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                            <div class="close-parent close-informative-message-style">✖</div>
                        </div>
                        <div class="mb8">
                            <label for="create-role-title-input" class="align-center bold dark fs13">{{ __('Title') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Role title should contain only characters.</p>
                            <input type="text" autocomplete="off" class="styled-input full-width" id="create-role-title-input" placeholder="Role title" style="padding: 8px 10px">
                        </div>
                        <div class="mb8">
                            <label for="create-role-slug-input" class="align-center bold dark fs13">{{ __('Slug') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Role slug should be a dashed version of title. (dashed-version-of-title)</p>
                            <input type="text" autocomplete="off" class="styled-input full-width" id="create-role-slug-input" placeholder="Role slug" style="padding: 8px 10px">
                        </div>
                        <div class="mb8">
                            <label for="create-role-description-input" class="align-center bold dark mb4 fs13">{{ __('Description') }}<span class="error-asterisk ml4">*</span></label>
                            <textarea id="create-role-description-input" class="styled-input no-textarea-x-resize fs14"
                                style="margin: 0; padding: 8px; min-height: 110px; max-height: 110px;"
                                maxlength="800"
                                spellcheck="false"
                                autocomplete="off"
                                placeholder="{{ __('Role description here') }}"></textarea>
                        </div>
                    </div>
                    <div class="simple-line-separator my8"></div>
                    <p class="mt8 mb4 bold fs15 dark">Confirmation</p>
                    <p class="no-margin dark mb4">Please type <strong>{{ auth()->user()->username }}::create-role</strong> to confirm.</p>
                    <div>
                        <input type="text" autocomplete="off" class="full-width styled-input" id="create-role-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
                        <input type="hidden" id="create-role-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::create-role">
                    </div>
                    <div class="align-center full-width" style="margin-top: 12px">
                        <div id="create-role-button" class="typical-button-style green-bs green-bs-disabled align-center">
                            <div class="relative size14 mr4">
                                <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold">Create role</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(is_null($role))
            <div class="align-center">
                <svg class="size15 mr8" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                <h2 class="blue no-margin">Roles Management</h2>
                <div class="light-gray fs8 bold" style="margin: 0 12px">•</div>
                <div class="typical-button-style green-bs align-center open-create-role-dialog" style="padding: 6px 10px;">
                    <svg class="size10 flex mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs12 flex bold">create new role</span>
                </div>
            </div>
            <p class="dark my8">From the following roles, select a role to manage.</p>
            <style>
                #roles-to-manage-wrapper {
                    margin-top: 30px;
                    gap: 14px;
                    display: flex;
                    flex-wrap: wrap;
                }

                .role-to-manage {
                    padding: 20px;
                    background-color: #eef1f2;
                    border: 1px solid #d4dcdf;
                    border-radius: 3px;
                    width: 20%;
                    height: 80px;
                    user-select: none;
                    text-decoration: none;

                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }
                .role-to-manage:hover {
                    background-color: #ecedee;
                }
            </style>
            <div id="roles-to-manage-wrapper" class="full-center">
                @foreach($roles as $role)
                <a href="?role={{ $role->slug }}" class="role-to-manage">
                    <h3 class="fs20 dark no-margin">{{ $role->title }}</h3>
                    <p class="dark fs13 no-margin mt4">{{ $role->description }}</p>
                    <p class="dark fs12 bold no-margin mt4">(click to manage)</p>
                </a>
                @endforeach
            </div>
        @else
            <input type="hidden" id="role-id" value="{{ $role->id }}" autocomplete="off">
            <!-- grant role to users viewer -->
            <div id="grant-role-to-users-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
                            <span class="fs20 bold dark">Grant "{{ $role->title }}" role to users</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 430px">
                        <div class="section-style fs13 dark mb8">
                            <p class="no-margin dark lh15">Here you can grant "{{ $role->title }}" role to members. Once the selected member(s) get the role, he will <strong>acquired all permissions in that role</strong> that allow him to perform all activities allowed by all its associated permissions.</p>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div class="align-center" style="margin-top: 14px">
                            <span class="block fs12 gray bold mr8">Role to be granted :</span>
                            <h3 class="no-margin dark-blue fs18">{{ $role->title }}</h3>
                        </div>
                        <div style="margin-top: 12px">
                            <span class="block fs12 gray bold mb4">Role permissions :</span>
                            @if($scoped_permissions->count())
                            <div class="flex flex-wrap typical-section-style y-auto-overflow" style="padding: 10px; max-height: 160px; gap: 6px;">
                                @foreach($scoped_permissions as $scope=>$permissions)
                                    <span class="block bold dark-blue fs12" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                    @foreach($permissions as $permission)
                                    <div class="button-style-1 fs11" style="padding: 5px 12px;">{{ $permission->title }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                            @else
                            <div class="align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="no-margin fs13 italic light-gray">This role does not have any attached permissions for the moment</p>
                            </div>
                            @endif
                        </div>
                        <div style="margin-top: 12px">
                            <div class="relative">
                                <span class="block mb4 fs12 gray bold">Select member that you want to grant the role to :</span>
                                <div class="relative">
                                    <div class="relative flex">
                                        <svg class="absolute size14" fill="#5b5b5b" style="top: 10px; left: 12px;" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                        <input type="text" class="search-input-style-1" id="role-member-search-input" autocomplete="off" placeholder="find member by username">
                                        <div class="search-button-style-1 align-center" id="role-search-for-member-to-grant">
                                            <svg class="size14 mr4" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
                                            <span class="bold dark">search</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <div id="role-members-search-result-box" class="full-width y-auto-overflow none" style="max-height: 234px;">
                                        <input type="hidden" id="role-user-k" autocomplete="off">
                                        <div class="results-container none">
                                            results
                                        </div>
                                        <div class="role-member-search-user role-member-search-user-factory mb4 flex none">
                                            <input type="hidden" class="role-user-id" autocomplete="off">
                                            <a href="" class="role-user-user-manage-link" style="height: 42px">
                                                <img src="" class="size36 rounded mr8 role-user-avatar" alt="" style="border: 3px solid #9f9f9f;">
                                            </a>
                                            <div>
                                                <div class="align-center">
                                                    <span class="block bold fs15 dark role-user-fullname">Mouad Nassri</span>
                                                    <div class="button-style-1 align-center ml8 role-select-member none" style="padding: 4px 8px">
                                                        <svg class="size11 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M197.63,2.4C199,4.24,201.19,3.45,203,4.08a32,32,0,0,1,21.4,28.77c.14,4,.18,7.93,0,11.88-.26,6.3-4.8,10.58-10.82,10.44-5.84-.13-9.9-4.25-10.17-10.51-.14-3.3.08-6.61-.09-9.91C202.94,27.81,199,23.86,192,23.52c-3-.14-5.94,0-8.91,0-6-.14-10.05-3-11.2-7.82-1.23-5.13.68-9.09,5.92-12.31a5.8,5.8,0,0,0,1-1ZM38.88,2.4c-.22.78-.87.78-1.52.94C24.43,6.58,16.51,14.91,13.46,27.71c-1.34,5.64-.74,11.53-.53,17.3a10.08,10.08,0,0,0,10.5,10.18c5.78,0,10.14-4.29,10.45-10.36.16-3.13,0-6.28,0-9.42C34.05,27.9,38,23.79,45.5,23.51c3.46-.13,6.94.06,10.4-.14,4.87-.28,7.94-3.08,9.31-7.6s-.25-8-3.59-11.09C60.7,3.83,59.05,4,58.73,2.4Zm55.56,0c-.16,1.13-1.22.84-1.87,1.21-4.47,2.56-6.49,7-5.37,11.67,1.16,4.89,4.64,8,9.88,8.1q21.56.23,43.13,0a9.75,9.75,0,0,0,9.7-7.7c1-4.8-.35-8.79-4.57-11.64-.77-.52-2-.44-2.28-1.63ZM142.29,247c0,3.87.55,7.36,4.66,9,4,1.53,6.55-.77,9.05-3.38,12.14-12.64,24.36-25.2,36.43-37.91a9.54,9.54,0,0,1,7.68-3.37c15.71.18,31.42.06,47.12.09,4,0,7.28-1,8.54-5.19,1.14-3.81-1.26-6.2-3.65-8.58q-47.88-47.85-95.75-95.74c-2.63-2.64-5.24-5.33-9.43-3.7-4.36,1.7-4.66,5.47-4.65,9.46q.06,34.47,0,68.94Q142.31,211.74,142.29,247Zm-87-33c6.06-.34,10.36-4.74,10.35-10.45a10.59,10.59,0,0,0-10.37-10.52c-3.46-.18-6.94,0-10.41-.07-6.56-.23-10.71-4.41-10.92-11-.12-3.64.14-7.29-.12-10.91a10.52,10.52,0,0,0-10-9.8c-5.11-.22-10.18,3.43-10.65,8.43-.61,6.57-1,13.26.49,19.75,3.7,15.82,16.07,24.61,34.23,24.59C50.34,213.94,52.82,214.05,55.3,213.91ZM12.86,128.57C13,135.3,17.31,140,23.27,140s10.57-4.64,10.62-11.27q.15-20.53,0-41.08c0-6.68-4.52-11.11-10.71-11-6,.07-10.17,4.3-10.3,10.87-.15,6.93,0,13.86,0,20.79C12.84,115,12.75,121.81,12.86,128.57ZM203.39,97.73c0,3.63-.16,7.28,0,10.9.32,5.93,4.46,9.91,10.13,10s10.47-3.78,10.72-9.47c.34-7.75.36-15.54,0-23.29-.27-5.64-5.21-9.48-10.87-9.28a10,10,0,0,0-9.93,9.7c-.23,3.78,0,7.6,0,11.4Zm-84,116.12a10.44,10.44,0,0,0,0-20.84c-7.56-.3-15.15-.29-22.71,0a10.44,10.44,0,0,0,0,20.84c3.77.23,7.57,0,11.35.05S115.57,214.09,119.34,213.85Z"></path></svg>
                                                        <span class="fs11 dark bold">select user</span>
                                                    </div>
                                                    <div class="align-center ml8 height-max-content already-has-role none" style="padding: 2px">
                                                        <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"></path></svg>
                                                        <span class="fs12 bold green">Already has this role</span>
                                                    </div>
                                                </div>
                                                <div class="align-center mt2">
                                                    <span class="block fs13 dark role-user-username">codename49</span>
                                                    <div class="light-gray mx4 fs8">•</div>
                                                    <span class="block bold fs12 blue role-user-role">Site owner</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- fetch more users -->
                                        <div id="role-users-fetch-more-results" class="full-center none" style='height: 40px;'>
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
                            <div id="empty-role-members-selected-box" class="align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs13 gray no-margin">Select at least one member that you want to attach this role to</p>
                            </div>
                            <div id="role-members-selected-box" class="flex flex-wrap y-auto-overflow none" style="max-height: 160px"> <!-- sum: selected user member -->
                                
                            </div>
                            <div class="selected-role-member-to-get-role selected-role-member-to-get-role-factory mb4 mr4 full-center flex-column relative none">
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
                            <p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::grant-role::{{ $role->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width styled-input" id="grant-role-confirm-input" style="padding: 8px 10px" placeholder="role grant confirmation">
                                <input type="hidden" id="grant-role-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::grant-role::{{ $role->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div class="align-center full-width">
                                    <div id="grant-role-button" class="typical-button-style green-bs green-bs-disabled full-center full-width" style="padding: 10px">
                                        <div class="relative size14 mr4">
                                            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"></path></svg>
                                            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                            </svg>
                                        </div>
                                        <span class="bold">Grant role to selected user(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- revoke role from a user viewer -->
            <div id="revoke-role-from-users-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                            <span class="fs20 bold dark">Revoke role from user</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="full-center relative">
                        <div class="global-viewer-content-box full-dimensions y-auto-overflow" style="padding: 14px; min-height: 200px; max-height: 450px">

                        </div>
                        <svg class="loading-viewer-spinner size32 absolute black" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- attach permissions to role -->
            <div id="attach-permissions-to-role-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M147,2.42h18.91c1.35,2,3.59,1,5.36,1.5C195.88,10.2,212.71,25.18,220,49.5s1.76,46.27-15.55,64.88c-9,9.71-18.69,18.84-28.07,28.23q-24.8,24.81-49.61,49.62C117,202,105.42,206.8,91.67,204.94c-16.76-2.27-28.49-11.59-33.88-27.58S56.28,146.94,68,134.82c7.74-8,15.69-15.74,23.54-23.6q26.58-26.56,53.16-53.11c5.57-5.53,12.73-6.59,19.14-3.16,6.25,3.36,9.28,9.85,8,17.21-.7,4.17-3.3,7.1-6.15,10q-37.34,37.27-74.6,74.6c-4.71,4.73-5,10.11-1.08,14.06,3.72,3.73,9.14,3.82,13.33-.36,26.32-26.22,52.79-52.3,78.68-78.95,13-13.34,11.8-34.73-1.36-47.5a34,34,0,0,0-48,.15q-40.71,40.23-80.92,81c-18.81,19.13-21.72,49.17-7.67,72.05,20.19,32.87,65.31,38.12,93,10.62,30.73-30.5,61.25-61.21,91.88-91.81,11.22-11.22,23.46-8.73,29.38,6v8c-1.76,2.32-3.27,4.88-5.31,6.93-31.6,31.69-63,63.58-95,94.86-21.81,21.31-48.64,29.56-78.53,24.23-35.29-6.3-59.88-27-71.14-61.12s-4.36-65.49,20.47-91.53c26.76-28.07,54.65-55,82.14-82.42,8.27-8.24,18.31-13.47,29.58-16.47C142.77,3.76,145.25,4.28,147,2.42Z"/></svg>
                            <span class="fs20 bold dark">Attach permissions to role</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 430px">
                        <h2 class="fs17 bold no-margin mb4 dark">Attach permissions to "<span class="blue">{{ $role->title }}</span>" role</h2>
                        <div class="typical-section-style fs13 dark mb8">
                            <p class="no-margin">Here you can attach permissions to "{{ $role->title }}" role. Before proceding this process, consider the following points</p>
                            <div class="ml8 mt8">
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Once you select permissions and attach them to role, all members with that role will <strong>acquired those permissions</strong> that allow them to perform all activities allowed by those permissions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div style="margin-top: 14px">
                            <div class="align-center">
                                <span class="fs12 dark bold mr8">Role :</span>
                                <h3 class="no-margin dark fs18">{{ $role->title }}</h3>
                            </div>
                        </div>
                        <div style="margin-top: 14px">
                            <span class="block fs12 dark bold">Select permissions to attach :</span>
                            <span class="block fs12 gray my4">The following section contains both <strong>already-attached</strong> and <strong>non-attached</strong> permissions, so you can choose only from non-attached permissions</span>
                            <div id="all-permissions-box" class="flex flex-wrap typical-section-style y-auto-overflow" style="padding: 10px; max-height: 160px; gap: 8px;">
                                @foreach($all_permissions_scoped as $scope=>$permissions)
                                    <span class="block bold blue fs11 mb4" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                    @foreach($permissions as $permission)
                                        @if($permission->already_attached_to_role($role->slug))
                                        <div class="role-permission-switch-button already-attached-permission-button-style" title="Permission already attached to '{{ $role->title }}' role">
                                            <span>{{ $permission->title }}</span>
                                            <span class="block fs10 default-weight">(already atached)</span>
                                        </div>
                                        @else
                                        <div class="role-permission-switch-button align-center height-max-content select-permission-to-attach-to-role">
                                            <span class="permission-title">{{ $permission->title }}</span>
                                            <svg class="size8 ml4 x-ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                                            <svg class="size10 ml4 v-ico none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"></path></svg>
                                            <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                                        </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <span class="block mb4 fs12 dark bold">Selected permissions</span>
                            <div id="empty-role-permissions-selected-box" class="flex align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs13 gray no-margin">Select at least one permission that you want to attach to this role</p>
                            </div>
                            <div id="role-permissions-selected-box" class="flex flex-wrap typical-section-style none" style="max-height: 160px; overflow-y: auto; gap: 10px; padding: 12px;">
                                
                            </div>
                            <div class="selected-permission-to-attach-to-role selected-permission-to-attach-to-role-factory button-style-1 full-center relative none" style="padding: 7px 11px;">
                                <span class="permission-title fs12"></span>
                                <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                                <div class="remove-selected-permission-to-attach-to-role x-close-container-style" style="right: -8px; top: -8px; width: 16px; height: 16px; min-width: 16px">
                                    <span class="x-close unselectable fs8">✖</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 bold dark">Confirmation</p>
                            <p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::attach-permissions-to-role::{{ $role->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width styled-input" id="attach-permissions-to-role-confirm-input" style="padding: 8px 10px" placeholder="attach permission(s) from role confirmation">
                                <input type="hidden" id="attach-permissions-to-role-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::attach-permissions-to-role::{{ $role->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div id="attach-permissions-to-role-button" class="typical-button-style green-bs green-bs-disabled full-center">
                                    <div class="relative size14 mr4">
                                        <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M147,2.42h18.91c1.35,2,3.59,1,5.36,1.5C195.88,10.2,212.71,25.18,220,49.5s1.76,46.27-15.55,64.88c-9,9.71-18.69,18.84-28.07,28.23q-24.8,24.81-49.61,49.62C117,202,105.42,206.8,91.67,204.94c-16.76-2.27-28.49-11.59-33.88-27.58S56.28,146.94,68,134.82c7.74-8,15.69-15.74,23.54-23.6q26.58-26.56,53.16-53.11c5.57-5.53,12.73-6.59,19.14-3.16,6.25,3.36,9.28,9.85,8,17.21-.7,4.17-3.3,7.1-6.15,10q-37.34,37.27-74.6,74.6c-4.71,4.73-5,10.11-1.08,14.06,3.72,3.73,9.14,3.82,13.33-.36,26.32-26.22,52.79-52.3,78.68-78.95,13-13.34,11.8-34.73-1.36-47.5a34,34,0,0,0-48,.15q-40.71,40.23-80.92,81c-18.81,19.13-21.72,49.17-7.67,72.05,20.19,32.87,65.31,38.12,93,10.62,30.73-30.5,61.25-61.21,91.88-91.81,11.22-11.22,23.46-8.73,29.38,6v8c-1.76,2.32-3.27,4.88-5.31,6.93-31.6,31.69-63,63.58-95,94.86-21.81,21.31-48.64,29.56-78.53,24.23-35.29-6.3-59.88-27-71.14-61.12s-4.36-65.49,20.47-91.53c26.76-28.07,54.65-55,82.14-82.42,8.27-8.24,18.31-13.47,29.58-16.47C142.77,3.76,145.25,4.28,147,2.42Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold">Attach permissions to role</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- detach permissions from role -->
            <div id="detach-permissions-from-role-viewer" class="global-viewer full-center none">
                <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
                <div class="viewer-box-style-1" style="width: 600px;">
                    <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
                        <div class="flex align-center">
                            <svg class="size16 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                            <span class="fs20 bold dark">Detach permissions from role</span>
                        </div>
                        <div class="pointer fs20 close-global-viewer unselectable">✖</div>
                    </div>
                    <div class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 430px">
                        <h3 class="fs15 bold dark no-margin mb4">Detach permissions from "<span class="blue">{{ $role->title }}</span>" role</h3>
                        <div class="typical-section-style fs13 dark mb8">
                            <p class="no-margin">Here you can detach permissions from "{{ $role->title }}" role. Before proceding this process, consider the following points</p>
                            <div class="ml8 mt8">
                                <div class="flex mt4">
                                    <div class="fs10 mr8 mt4 gray">•</div>
                                    <p class="no-margin" style="line-height: 1.5">Once you select permissions and detach them from role, all members with that role will <strong>miss those permissions</strong> and they cannot perform any activity allowed by those permissions anymore.</p>
                                </div>
                            </div>
                        </div>
                        <div class="simple-line-separator my4"></div>
                        <div style="margin-top: 12px">
                            <div class="align-center">
                                <span class="fs12 dark bold mr8">Role :</span>
                                <h3 class="no-margin dark-blue fs18">{{ $role->title }}</h3>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <div>
                                <span class="block fs12 dark bold">Select permissions to detach :</span>
                                <span class="block fs12 gray my4 lh15">The following list of permissions are already attached to "<strong>{{ $role->title }}</strong>" role. Choose only permission(s) that you want to detach.</span>
                                <div id="all-permissions-box" class="typical-section-style y-auto-overflow" style="padding: 10px; max-height: 250px;">
                                    @foreach($scoped_permissions as $scope => $permissions)
                                        <span class="block bold blue fs11 mb4" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                        <div class="flex flex-wrap" style="gap: 6px;">
                                            @foreach($permissions as $permission)
                                            <div class="button-style-1 align-center fs11 select-permission-to-detach-from-role" style="padding: 7px 12px;">
                                                <span class="permission-title">{{ $permission->title }}</span>
                                                <svg class="size8 ml4 x-ico" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                                                <svg class="size10 ml4 v-ico none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"></path></svg>
                                                <input type="hidden" class="pid" value="{{ $permission->id }}" autocomplete="off">
                                            </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                    @if(!$scoped_permissions->count())
                                    <div class="flex align-center">
                                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                        <p class="no-margin fs13 italic gray">This role has no permissions to detach for the moment</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <span class="block mb4 fs12 dark bold">Selected permissions</span>
                            <div id="empty-role-permissions-to-detach-selected-box" class="flex align-center typical-section-style">
                                <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="fs13 gray no-margin">Select at least one permission that you want to detach from this role</p>
                            </div>
                            <div id="role-permissions-to-detach-selected-box" class="flex flex-wrap typical-section-style none" style="max-height: 160px; overflow-y: auto; padding: 10px; gap: 6px;">
                                
                            </div>
                            <div class="selected-permission-to-detach-from-role selected-permission-to-detach-from-role-factory full-center button-style-1 relative none" style="padding: 7px 12px;">
                                <span class="permission-title fs12"></span>
                                <input type="hidden" class="pid" value="" autocomplete="off">
                                <div class="remove-selected-permission-to-detach-from-role x-close-container-style" style="right: -8px; top: -8px; width: 16px; height: 16px; min-width: 16px">
                                    <span class="x-close unselectable fs8">✖</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 12px">
                            <p class="no-margin mb2 fs15 bold dark">Confirmation</p>
                            <p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::detach-permissions-from-role::{{ $role->slug }}</strong> to confirm.</p>
                            <div>
                                <input type="text" autocomplete="off" class="full-width styled-input" id="detach-permissions-from-role-confirm-input" style="padding: 8px 10px" placeholder="detach permission(s) from role confirmation">
                                <input type="hidden" id="detach-permissions-from-role-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::detach-permissions-from-role::{{ $role->slug }}">
                            </div>
                            <div class="flex" style="margin-top: 12px">
                                <div id="detach-permissions-from-role-button" class="typical-button-style red-bs red-bs-disabled full-center">
                                    <div class="relative size14 mr4">
                                        <svg class="size12 icon-above-spinner" fill="white" viewBox="0 0 260 260"><path d="M167.69,256.92c-4.4-51.22,37.26-92.87,89-89,0,28.5-.05,57,.09,85.51,0,3-.6,3.55-3.55,3.54C224.71,256.86,196.2,256.92,167.69,256.92ZM19.86,3.86c-16.27,0-16.31.05-16.31,16.07q0,94.91,0,189.79c0,7.15,2.26,9.84,8.61,9.85,38.23.05,76.47,0,114.7.08,2.56,0,3.43-.63,3.3-3.27a77.64,77.64,0,0,1,1.45-19.65c8.29-39.74,41.06-66.4,81.87-66.2,5.11,0,6-1.32,6-6.12-.22-36.58-.11-73.15-.12-109.73,0-8.73-2.06-10.81-10.65-10.81H19.86Zm49.8,76.56c-4.07-4.07-4-4.72.84-9.54s5.56-5,9.55-1C90.24,80,100.39,90.26,111.43,101.34c0-5.58,0-10,0-14.31,0-3.5,1.63-5.17,5.14-5,1.64,0,3.29,0,4.94,0,3.26-.07,4.84,1.45,4.82,4.76,0,10.7.07,21.4-.06,32.1-.05,5-2.7,7.64-7.66,7.71-10.7.15-21.41,0-32.11.07-3.27,0-4.87-1.54-4.8-4.82,0-1.48.07-3,0-4.44-.24-3.94,1.48-5.8,5.52-5.66,4.21.14,8.44,0,13.87,0C89.94,100.65,79.78,90.55,69.66,80.42Z"/></svg>
                                        <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="bold">Detach permissions from role</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="align-center space-between" style="margin-bottom: 12px">
                <div class="align-center">
                    <svg class="mr8 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                    <h2 class="no-margin fs20 mb2 dark">Manage "<span class="blue">{{ $role->title }}</span>" role</h2>
                </div>
                <div class="typical-button-style green-bs align-center open-create-role-dialog" style="padding: 6px 10px;">
                    <svg class="size10 flex mr8" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                    <span class="fs12 flex bold">create new role</span>
                </div>
            </div>
            <div class="flex" style="margin-bottom: 16px">
                <div id="update-role-section" class="role-section height-max-content mr8">
                    <div class="align-center mb8">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                        <h2 class="no-margin fs18 dark">Update role informations</h2>
                    </div>
                    <div id="update-role-error-container" class="informative-message-container align-center relative my8 none">
                        <div class="informative-message-container-left-stripe imcls-red"></div>
                        <p class="no-margin fs13 red bold message-text">Title field is required.</p>
                        <div class="close-parent close-informative-message-style">✖</div>
                    </div>
                    <div class="mb8">
                        <label for="update-role-title-input" class="align-center bold dark">{{ __('Title') }}<span class="error-asterisk ml4">*</span></label>
                        <p class="no-margin fs12 mb2 gray">Role title should contain only characters.</p>
                        <input type="text" autocomplete="off" class="styled-input full-width" id="update-role-title-input" value="{{ $role->title }}" placeholder="Role title" style="padding: 8px 10px">
                    </div>
                    <div class="mb8">
                        <label for="update-role-slug-input" class="align-center bold dark">{{ __('Slug') }}<span class="error-asterisk ml4">*</span></label>
                        <p class="no-margin fs12 mb2 gray">Role slug should be a dashed version of title. (dashed-version-of-title)</p>
                        <input type="text" autocomplete="off" class="styled-input full-width" id="update-role-slug-input" value="{{ $role->slug }}" placeholder="Role slug" style="padding: 8px 10px">
                    </div>
                    <div class="mb8">
                        <label for="update-role-description-input" class="align-center bold dark mb4">{{ __('Description') }}<span class="error-asterisk ml4">*</span></label>
                        <textarea id="update-role-description-input" class="styled-input no-textarea-x-resize fs14"
                            style="margin: 0; padding: 8px; min-height: 110px; max-height: 110px;"
                            maxlength="800"
                            spellcheck="false"
                            autocomplete="off"
                            placeholder="{{ __('Role description here') }}">{{ $role->description }}</textarea>
                    </div>
                    <div class="align-center full-width" style="margin-top: 12px">
                        <div id="update-role-button" class="typical-button-style dark-bs width-max-content align-center">
                            <div class="relative size13 mr4">
                                <svg class="size13 flex icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                                <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                </svg>
                            </div>
                            <span class="bold fs11 unselectable">Update role informations</span>
                        </div>
                    </div>
                </div>
                <div id="update-role-settings-section" class="role-section height-max-content">
                    <!-- role members render/grant/revoke -->
                    <div class="align-center mb4">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.12,231.24c2.31-3.71,3.06-8.13,5.64-11.76a36.53,36.53,0,0,1,14.13-11.94c-6-5.69-9.23-12.14-8.34-20.21a21.81,21.81,0,0,1,8-14.77,22.21,22.21,0,0,1,30,1.73c8.91,9.18,8.22,21.91-1.78,32.9,2.87,2.14,5.94,4.06,8.58,6.46,7.19,6.54,10.59,14.89,10.81,24.54.14,6.25.1,12.5.14,18.75-21.12,0-42.23-.05-63.34.06-2.81,0-4.05-.27-3.9-3.64C3.35,246,3.12,238.61,3.12,231.24Zm252.72,25.7c0-6.42.14-12.85,0-19.26-.32-11.65-5.39-20.8-15-27.44-1.46-1-3-1.93-4.51-2.92,10.06-10.85,11-23,2.57-32.36A22.2,22.2,0,0,0,209,172a21.26,21.26,0,0,0-8.41,13.48c-1.51,8.68,1.38,16,7.89,21.91-13.05,7.83-19.22,17.23-19.62,29.81-.21,6.58-.12,13.17-.17,19.75Zm-92.8,0c0-6.42.09-12.85-.09-19.27a33,33,0,0,0-13-26c-2-1.61-4.3-2.92-6.49-4.38,10.35-11,10.92-24.16,1.56-33.38a22.16,22.16,0,0,0-30.72-.32c-9.69,9.21-9.27,22.38,1.27,33.8-1.28.78-2.53,1.49-3.74,2.29-9.73,6.38-15.15,15.39-15.76,27-.36,6.73-.12,13.5-.15,20.25ZM96,77.28a87.53,87.53,0,0,1-.07,11.34c-.45,4.15,1.32,4.76,4.94,4.72,16.77-.17,33.53-.06,50.3-.08,3.77,0,8.79,1.31,11-.59,2.61-2.26.6-7.43.87-11.33,1.1-16.44-4.23-29.59-19.56-37.45C153.86,32,154.27,19,144.7,9.93A22.16,22.16,0,0,0,114,10.2c-9.3,9.07-8.77,22.19,1.61,33.66C102.06,51.07,95.58,62.15,96,77.28ZM33.4,122.86c-3.47,0-4.5,1-4.39,4.42.26,7.41.15,14.83,0,22.24,0,2.26.6,3.1,3,3.26,11.75.78,11.88.86,11.82-10.59,0-3.45.94-4.44,4.4-4.41,20.88.15,41.77.07,62.66.07,10.84,0,10.94,0,11,10.87,0,2.82.48,4,3.73,4.09,11,.13,11.14.28,11.15-10.84,0-3.16.78-4.21,4.09-4.19q35,.21,70.07,0c3.36,0,4,1.15,4.05,4.25,0,11.09.12,10.95,11.17,10.78,3.27-.06,3.75-1.34,3.69-4.12-.16-7.08-.29-14.18,0-21.25.18-3.85-1.16-4.6-4.74-4.58-25.82.14-51.65.08-77.47.08-10.66,0-10.76,0-10.76-10.63,0-3-.48-4.34-4-4.34-10.85,0-11-.17-10.9,10.6,0,3.39-.79,4.5-4.33,4.45-14-.21-28-.08-41.94-.08C61.69,122.94,47.54,123.05,33.4,122.86Z"/></svg>
                        <p class="no-margin bold dark fs16">Members with that role</p>
                    </div>
                    <p class="my4 fs12 dark lh15">The following section includes members that own this role. You can grant this role to more members, or revoke it from its owners.</p>
                    <div class="flex flex-wrap typical-section-style my8" style="padding: 20px; max-height: 250px; overflow-y: auto; gap: 15px;">
                        <div class="flex justify-center role-user-box">
                            <div class="rounded-entity-for-role rounded-blue-when-hover open-grant-role-dialog">
                                <svg class="size10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                            </div>
                        </div>
                        <div class="gray height-max-content mx8 fs10" style="margin-top: 22px">•</div>
                        @foreach($users as $user)
                        <div class="align-center flex-column role-user-box">
                            <div class="relative">
                                <img src="{{ $user->avatar(100) }}" class="rounded-entity-for-role" alt="">
                                <div class="open-revoke-role-dialog">
                                    <span class="unselectable">✖</span>
                                    <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
                                </div>
                            </div>
                            <span class="bold dark-blue fs11 username">{{ $user->username }}</span>
                            <span class="bold dark fs10">{{ $user->high_role()->title }}</span>
                        </div>
                        @endforeach
                        @if(!$users->count())
                        <div class="align-center">
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 no-margin gray">This role is not attached to any user for the moment</p>
                        </div>
                        @endif
                    </div>

                    <!-- manage role permissions -->
                    <div class="flex align-center mb4" style="margin-top: 12px;">
                        <svg class="size15 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130.34,245.7q-40.65,0-81.31,0c-10.29,0-13.65-3.39-13.65-13.66q0-60.49,0-121c0-9.82,3.61-13.39,13.47-13.41,5,0,9.93-.19,14.87.07,3,.15,3.43-1,3.47-3.63C67.32,83.05,66.29,72,69,61c7.38-29.7,34.36-49.32,66.07-47.81,28.86,1.38,53.84,24.47,58.24,53.66,1.36,9.06.6,18.15.71,27.22,0,2.69.58,3.73,3.49,3.61,5.61-.24,11.24-.14,16.86,0,7.2.11,11.43,4.23,11.44,11.43q.09,62.47,0,125c0,7.7-4.13,11.62-12.18,11.63Q172,245.76,130.34,245.7Zm-.09-148c13,0,26.09-.07,39.13,0,2.67,0,3.83-.49,3.71-3.47-.24-5.94.09-11.9-.12-17.83-.79-22.48-16.7-39.91-38.29-42.1-20.86-2.12-40.25,11.75-45.25,32.56-2.11,8.77-.85,17.76-1.32,26.65-.19,3.69,1.22,4.26,4.49,4.21C105.15,97.54,117.7,97.65,130.25,97.65Zm.37,42.41a31.73,31.73,0,0,0-.29,63.46,32,32,0,0,0,32-31.67A31.61,31.61,0,0,0,130.62,140.06Z"/></svg>
                        <p class="no-margin bold dark fs16">Role permissions</p>
                    </div>
                    <p class="mt8 mb4 gray bold fs12">• Attach/Detach permissions</p>
                    <div class="flex align-center">
                        <div class="typical-button-style green-bs align-center open-attach-permissions-to-role-dialog">
                            <svg class="size10 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M156.22,3.31c3.07,2.55,4.08,5.71,4.06,9.78-.17,27.07,0,54.14-.18,81.21,0,3.57.69,4.66,4.49,4.63,27.24-.19,54.47-.11,81.71-.1,7.36,0,9.39,2,9.4,9.25q0,21.4,0,42.82c0,7-2.1,9.06-9.09,9.06-27.24,0-54.48.09-81.71-.09-3.85,0-4.83.95-4.8,4.81.17,27.07.1,54.14.09,81.21,0,7.65-1.94,9.59-9.56,9.6q-21.4,0-42.82,0c-6.62,0-8.75-2.19-8.75-8.91,0-27.4-.1-54.8.09-82.2,0-3.8-1.06-4.51-4.62-4.49-27.08.16-54.15,0-81.22.18-4.07,0-7.23-1-9.78-4.06V102.8c2.55-3.08,5.72-4.08,9.79-4.06,27.09.17,54.18,0,81.27.18,3.68,0,4.58-.87,4.55-4.56-.17-27.09,0-54.18-.18-81.27,0-4.06,1-7.23,4.06-9.78Z"></path></svg>
                            <span class="fs11 bold">attach new permissions</span>
                        </div>
                        <div class="light-gray fs8 mx8">•</div>
                        <div class="typical-button-style red-bs align-center open-detach-permissions-from-role-dialog">
                            <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"/></svg>
                            <span class="fs11 bold">detach permissions</span>
                        </div>
                    </div>
                    <p class="my4 fs12 dark lh15">The following permissions are attached to "<strong>{{ $role->title }}</strong>" role; It means If a member get this role, It will automatically get all those permissions.</p>
                    <p class="mt8 mb4 gray bold fs12">• Permissions attached</p>
                    <div class="typical-section-style border-box y-auto-overflow" style="margin: 2px 0 12px 0; max-height: 250px;">
                        @if($role->permissions()->count())
                        <div class="flex flex-wrap" style="gap: 6px;">
                            @foreach($role->permissions->groupBy('scope') as $scope=>$permissions)
                                <span class="flex bold blue fs12" style="flex-basis: 100%">{{ ucfirst($scope) }}</span>
                                @foreach($permissions as $permission)
                                <div class="button-style-1" style="padding: 6px 10px;">
                                    <span class="permission-name fs11 bold">{{ $permission->title }}</span>
                                </div>
                                @endforeach
                            @endforeach
                        </div>
                        @else
                        <div class="flex align-center">
                            <svg class="size12 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="fs12 no-margin gray">This role does not have any attached permission for the moment</p>
                        </div>
                        @endif
                    </div>

                    <!-- delete role -->
                    <div class="flex align-center mb4">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <p class="no-margin bold dark fs15">Delete role</p>
                    </div>
                    <p class="my4 fs13 dark lh15">Deleting the role will revoke it from all members who have this role already.</p>
                    <div class="typical-section-style dark">
                        <span class="block bold lblack mb8">Important</span>
                        <p class="no-margin fs13 lblack lh15">Notice that when the role is deleted, all its associated permissions will be revoked from members with this role.</p>
                    </div>
                    <div class="typical-button-style red-bs width-max-content flex align-center mt8 open-delete-role-dialog">
                        <svg class="size12 mr4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                        <span class="fs11 bold">Open deletion viewer</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection