@extends('layouts.admin')

@section('title', 'Admin - Roles & Permissions overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/roles-and-permissions.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/admin/roles-and-permissions/hierarchy.js') }}" defer></script>
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'admin.rp', 'subpage'=>'admin.rp.overview'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size15 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
            <h1 class="fs20 dark no-margin">Roles & Permissions Management</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">Dashboard</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">Roles and permissions</span>
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
        <h2 class="blue no-margin">Roles & Permissions Management</h2>
        <p class="dark my4">Manage users roles and permissions as well as creating new roles and permissions and perform different actions.</p>
        <div class="typical-section-style mb8 fs13 dark" style="padding: 10px">
            <p class="no-margin">Every role, has a default permissions attached to it. Once a user own a role, he will get all the permissions attached to that role.</p>
            <p class="no-margin mt4">Permissions could be revoked directly from a user; Means we can have an author user, without create posts permission.</p>
        </div>
        <h2 class="no-margin fs18 dark mb4">Hierarchy</h2>
        <p class="dark no-margin mb4">The following diagram lists all existing roles and their default attached permissions. the table below shows all members with roles from higher to lower priority.</p>
        <div>
            <div class="flex role-users-row role-users-header-row">
                <div class="role-users-role-informations-section full-center border-box">
                    <span class="bold dark">Role</span>
                </div>
                <div class="role-users-users-section full-center">
                    <span class="bold dark">Role Owners</span>
                </div>
            </div>
            @foreach($roleusers as $roleslug=>$roleusers)
            @php $role = $roles->where('slug', $roleslug)->first(); @endphp
            <div class="flex role-users-row">
                <div class="role-users-role-informations-section dark fs13 border-box">
                    <div class="flex mb4">
                        <div>
                            <div class="align-center pointer preview-role">
                                <div class="relative size15 mr4">
                                    <svg class="size15 icon-above-spinner" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M122.25,202.87C82.73,201.11,48,180,27.42,136.91a16.18,16.18,0,0,1-.09-14.48A110.74,110.74,0,0,1,139.06,56.8c43.49,4.07,74.38,26.22,93.2,65.52a16.15,16.15,0,0,1,.09,14.48C214.46,177.33,175,202.86,122.25,202.87Zm8.19-115.11c-22.64-.57-41.77,18-42.44,41.13-.66,22.64,17.73,41.74,41,42.57,22.72.82,42.24-18.08,42.71-41.36C172.16,107.39,153.61,88.35,130.44,87.76Zm-21.39,41.52a20.79,20.79,0,1,0,21-20.45A20.57,20.57,0,0,0,109.05,129.28Z"></path></svg>
                                    <svg class="spinner size15 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                    </svg>
                                </div>
                                <p class="no-margin bold blue fs15 unselectable">{{ $role->title }}</p>
                                <input type="hidden" class="role-id" value="{{ $role->id }}" autocomplete="off">
                            </div>
                            <p class="no-margin light-gray fs13">{{ $role->slug }}</p>
                        </div>
                        <a href="" class="typical-button-style align-center white-bs no-underline move-to-right height-max-content dark" style="padding: 4px 10px;">
                            <svg class="mr4 size11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                            <span class="no-wrap fs11 bold">manage</span>
                        </a>
                    </div>
                    <p class="no-margin fs12"><strong>Description</strong> : {{ $role->description }}</p>
                </div>
                <div class="role-users-users-section">
                    @foreach($roleusers as $user)
                    <div class="role-user-item relative">
                        <div class="relative">
                            <img src="{{ $user->avatar(100) }}" class="avatar" alt="">
                            <div class="role-user-manage-button-and-section relative">
                                <svg class="size14 button-with-suboptions pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><g><path d="M5 13h90v14H5z"/><path d="M5 43h90v14H5z"/><path d="M5 73h90v14H5z"/></g></svg>
                                <div class="suboptions-container typical-suboptions-container width-max-content" style="top: calc(100% + 2px); left: 0">
                                    <a href="" class="no-underline mb4 suboption-style-2" style="padding: 5px 12px">
                                        <svg class="mr8 size12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M254.7,64.53c-1.76.88-1.41,2.76-1.8,4.19a50.69,50.69,0,0,1-62,35.8c-3.39-.9-5.59-.54-7.89,2.2-2.8,3.34-6.16,6.19-9.17,9.36-1.52,1.6-2.5,2.34-4.5.28-8.79-9-17.75-17.94-26.75-26.79-1.61-1.59-1.87-2.49-.07-4.16,4-3.74,8.77-7.18,11.45-11.78,2.79-4.79-1.22-10.29-1.41-15.62C151.74,33.52,167,12.55,190.72,5.92c1.25-.35,3,0,3.71-1.69H211c.23,1.11,1.13.87,1.89,1,3.79.48,7.43,1.2,8.93,5.45s-1.06,7-3.79,9.69c-6.34,6.26-12.56,12.65-19,18.86-1.77,1.72-2,2.75,0,4.57,5.52,5.25,10.94,10.61,16.15,16.16,2.1,2.24,3.18,1.5,4.92-.28q9.83-10.1,19.9-20c5.46-5.32,11.43-3.47,13.47,3.91.4,1.47-.4,3.32,1.27,4.41Zm0,179-25.45-43.8-28.1,28.13c13.34,7.65,26.9,15.46,40.49,23.21,6.14,3.51,8.73,2.94,13.06-2.67ZM28.2,4.23C20.7,9.09,15,15.89,8.93,22.27,4.42,27,4.73,33.56,9.28,38.48c4.18,4.51,8.7,8.69,13,13.13,1.46,1.53,2.4,1.52,3.88,0Q39.58,38,53.19,24.49c1.12-1.12,2-2,.34-3.51C47.35,15.41,42.43,8.44,35,4.23ZM217.42,185.05Q152.85,120.42,88.29,55.76c-1.7-1.7-2.63-2-4.49-.11-8.7,8.93-17.55,17.72-26.43,26.48-1.63,1.61-2.15,2.52-.19,4.48Q122,151.31,186.71,216.18c1.68,1.68,2.61,2,4.46.1,8.82-9.05,17.81-17.92,26.74-26.86.57-.58,1.12-1.17,1.78-1.88C218.92,186.68,218.21,185.83,217.42,185.05ZM6.94,212.72c.63,3.43,1.75,6.58,5.69,7.69,3.68,1,6.16-.77,8.54-3.18,6.27-6.32,12.76-12.45,18.81-19,2.61-2.82,4-2.38,6.35.16,4.72,5.11,9.65,10.06,14.76,14.77,2.45,2.26,2.1,3.51-.11,5.64C54.2,225.32,47.57,232,41,238.73c-4.92,5.08-3.25,11.1,3.57,12.9a45,45,0,0,0,9.56,1.48c35.08,1.51,60.76-30.41,51.76-64.43-.79-3-.29-4.69,1.89-6.65,3.49-3.13,6.62-6.66,10-9.88,1.57-1.48,2-2.38.19-4.17q-13.72-13.42-27.14-27.14c-1.56-1.59-2.42-1.38-3.81.11-3.11,3.3-6.56,6.28-9.53,9.7-2.28,2.61-4.37,3.25-7.87,2.31C37.45,144.33,5.87,168.73,5.85,202.7,5.6,205.71,6.3,209.22,6.94,212.72ZM47.57,71.28c6.77-6.71,13.5-13.47,20.24-20.21,8.32-8.33,8.25-8.25-.35-16.25-1.82-1.69-2.69-1.42-4.24.14-8.85,9-17.8,17.85-26.69,26.79-.64.65-1.64,2.06-1.48,2.24,3,3.38,6.07,6.63,8.87,9.62C46.08,73.44,46.7,72.14,47.57,71.28Z"/></svg>
                                        <div class="fs13">{{ __('Manage user r&p') }}</div>
                                    </a>
                                    <a href="" class="no-underline suboption-style-2" style="padding: 5px 12px">
                                        <svg class="mr8 size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                                        <div class="fs13">{{ __('User admin profile') }}</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="bold dark">{{ $user->lightusername }}</span>
                        <div class="fs10 text-center" style="max-width: 80px">
                            <span class="bold fs10 block blue">{{ $role->title }}</span>
                        </div>
                        <div class="straight-vline absolute" style="bottom: 100%"></div>
                        <div class="straight-vline absolute" style="top: 100%"></div>
                    </div>
                    @endforeach
                    @if(!count($roleusers))
                    <div class="flex align-center border-box" style="margin-left: 12px">
                        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <p class="no-margin fs13 italic gray">There are no members acquire this role for the moment</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection