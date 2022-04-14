@extends('layouts.admin')

@section('title', 'Admin - Roles & Permissions overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/roles-and-permissions.css') }}">
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
            <div class="flex align-center">
                <span class="fs13 bold">Roles Management</span>
            </div>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <a href="{{ route('admin.rp.overview') }}" class="blue-link align-center bold fs13">overview</a>
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

        <!-- create role viewer -->
        <div id="create-role-viewer" class="global-viewer full-center">
            <div class="viewer-box-style-1">
                <div class="flex align-center space-between light-gray-border-bottom" style="padding: 12px 16px;">
                    <div class="flex align-center">
                        <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
                        <span class="fs20 bold dark">Create a new role</span>
                    </div>
                    <div class="pointer size24 full-center fs20 close-global-viewer unselectable">✖</div>
                </div>
                <div class="viewer-scrollable-box y-auto-overflow" style="padding: 14px; max-height: 470px">
                    <!-- messages and inputs -->
                    <input type="hidden" id="existing-roles-titles" value="{{ $roles->pluck('title')->implode(',') }}" autocomplete="off">
                    <input type="hidden" id="existing-roles-slugs" value="{{ $roles->pluck('slug')->implode(',') }}" autocomplete="off">
                    <div class="typical-section-style mb4">
                        <p class="no-margin fs13 dark">The concept of roles here is simple; Create a role, attach some permissions to it, and start grant it to users. Users will get all permissions the role acquires.</p>
                    </div>
                    <p class="no-margin fs13 dark mb4">The following roles are ordered by priority. The created role will come to the last place with lower priority. However you can update it in role management page.</p>
                    <div class="flex align-center">
                        <p class="my8 bold dark mr8">Existing roles :</p>
                        <div class="relative">
                            <div class="button-with-suboptions typical-button-style align-center white-bs" style="padding: 4px 8px;">
                                <span class="fs13">see roles</span>
                                <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                            </div>
                            <div class="suboptions-container typical-suboptions-container width-max-content" style="left: 0; max-height: 260px">
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
                        <div class="flex align-center my8">
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <p class="no-margin bold dark fs15">Role Informations</p>
                        </div>
                        <div class="my8 create-role-error-container none">
                            <div class="flex">
                                <svg class="size12 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                                <span class="error fs13 bold no-margin create-role-error"></span>
                            </div>
                        </div>
                        <div class="mb8">
                            <label for="create-role-name-input" class="flex align-center bold forum-color fs13">{{ __('Name') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Role name should contain only characters.</p>
                            <input type="text" autocomplete="off" class="styled-input full-width" id="create-role-name-input" placeholder="Role name" style="padding: 8px 10px">
                        </div>
                        <div class="mb8">
                            <label for="create-role-slug-input" class="flex align-center bold forum-color fs13">{{ __('Slug') }}<span class="error-asterisk ml4">*</span></label>
                            <p class="no-margin fs12 mb2 gray">Role slug should be a dashed version ot title. (dashed-version-of-title)</p>
                            <input type="text" autocomplete="off" class="styled-input full-width" id="create-role-slug-input" placeholder="Role slug" style="padding: 8px 10px">
                        </div>
                        <div class="mb8">
                            <label for="create-role-description-input" class="flex align-center bold forum-color mb4 fs13">{{ __('Description') }}<span class="error-asterisk ml4">*</span></label>
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
                    <p class="no-margin mb4">Please type <strong>{{ auth()->user()->username }}::create-role</strong> to confirm.</p>
                    <div>
                        <input type="text" autocomplete="off" class="full-width styled-input" id="create-role-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
                        <input type="hidden" id="create-role-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::create-role">
                    </div>
                    <div class="flex align-center full-width" style="margin-top: 12px">
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
            .role-to-manage {
                margin: 0 14px;
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
        <div class="full-center" style="margin-top: 26px">
            @foreach($roles as $role)
            <a href="?role={{ $role->slug }}" class="role-to-manage">
                <h3 class="fs20 dark no-margin">{{ $role->title }}</h3>
                <p class="dark fs13 no-margin mt4">{{ $role->description }}</p>
                <p class="dark fs12 bold no-margin mt4">(click to manage)</p>
            </a>
            @endforeach
        </div>
        @else

        @endif
    </div>
</main>
@endsection