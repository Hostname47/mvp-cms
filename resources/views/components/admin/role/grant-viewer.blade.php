
<div class="flex align-center pointer width-max-content back-to-role-grant-to-user-selection">
    <svg class="mr4 size12" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"></path></svg>
    <span class="bold blue fs12">back to role selection</span>
</div>
<div class="flex align-center space-between my8" style="padding: 0 20px">
    <div class="relative">
        <span class="fs12 bold gray absolute width-max-content" style="top: -15px; left: 0">granted role:</span>
        <h3 class="fs20 dark text-center no-margin" style="max-width: 160px">{{ $role->title }}</h3>
    </div>
    <div class="relative full-center" style="flex: 1; margin: 0 8px;">
        <div class="simple-line-separator full-width"></div>
        <span class="absolute fs11 gray bold" style="margin-top: -44px">grant to</span>
        <svg class="size28 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
    </div>
    <div class="flex flex-column align-center">
        <img src="{{ $user->avatar(100) }}" class="size60 rounded" alt="">
        <span class="bold dark fs11 mt4">{{ $user->username }}</span>
        @if($hr = $user->high_role())
        <span class="bold blue fs10">{{ $hr->role }}</span>
        @else
        <em class="gray fs10">normal user</em>
        @endif
    </div>
</div>
<div class="my8 typical-section-style">
    <span class="block mb4 bold dark">Note</span>
    <p class="no-margin fs12 dark lh15">Once the selected user get the role, all associated permissions (listed below) of that role will be given to that user as well; which allow him to perform all activities permitted by those permissions.</p>
</div>
<div class="flex align-center mb8">
    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.24,200.3v3.32a30.82,30.82,0,0,0-.39,4.31,28.06,28.06,0,0,0-.5,3.18,32.86,32.86,0,0,0-1.24,4.14c-1.07,2.69-1.61,5.62-3.06,8.2-8.93,15.9-27.56,24.79-45.09,21.09-18.44-3.89-32.36-19.5-33.59-37.66-1.32-19.48,9.32-36.23,27.33-42.73,2.82-1,4.28-2.17,4.06-5.48a143.06,143.06,0,0,1,0-14.79c.1-2.7-.61-3.71-3.53-3.7q-70.3.12-140.61,0c-3,0-3.75,1.12-3.44,3.75a24.35,24.35,0,0,1,0,3c0,4.77-1.07,9.89.33,14.21s7.51,4.19,11.31,6.51C87.92,179.85,94,207.87,80.35,227.12,66.16,247.18,38.07,251.33,19.58,236,7,225.65,1.71,212.22,4.43,196.22c2.69-15.82,12.12-26.6,27.21-32.14,2.79-1,3.74-2.32,3.61-5.23-.24-5.42-.08-10.85-.07-16.28,0-14.93,8.56-23.47,23.61-23.52,18.75-.07,37.5-.11,56.24.06,3.39,0,4.62-.71,4.37-4.27a104.84,104.84,0,0,1,0-14.29c.22-3.28-1.14-4.45-4-5.48C96.38,88.29,86,70.25,88.5,48.87c2-16.92,18.8-32.94,36.25-34.57,20.93-2,38.93,9.59,45.07,28.89a41.39,41.39,0,0,1-25.35,51.88c-2.87,1-4.24,2.2-4,5.47a119.65,119.65,0,0,1,0,14.79c-.18,3.16.91,3.79,3.87,3.77,18.42-.14,36.84-.08,55.26-.07,17,0,25.08,8.07,25.09,25a28.75,28.75,0,0,1,0,3.94c-1.28,9.39.4,15.76,11,19.93,10.87,4.27,16.79,14.73,19.56,26.33.16.71-.08,1.6.48,2.15.07.44.15.88.23,1.32C256,198.59,256.11,199.45,256.24,200.3Z"></path></svg>
    <span class="dark bold fs15">Role informations</span>
</div>

<div class="flex mb8">
    <p class="no-margin dark fs12 bold mr8">Role :</p>
    <div style="margin-top: -1px">
        <h4 class="no-margin fs16 bold dark">{{ $role->role }}</h4>
        <span class="fs13 gray block" style="margin-top: -1px">{{ $role->slug }}</span>
    </div>
</div>

<p class="dark no-margin fs13"><span class="bold dark fs12 mr4">Description :</span>{{ $role->description }}</p>

<div style="margin: 12px 0">
    <span class="dark bold fs12 mb4 block">Role permissions</span>
    <div class="typical-section-style border-box y-auto-overflow" style="margin: 2px 0 12px 0; max-height: 250px;">
        @if($role->permissions()->count())
        <div class="flex flex-wrap" style="gap: 6px">
            @foreach($role->permissions->groupBy('scope') as $scope=>$permissions)
                <span class="flex bold blue fs11 mb4" style="flex-basis: 100%">{{ $scope }}</span>
                @foreach($permissions as $permission)
                <div class="typical-button-style white-bs" style="padding: 6px 12px">
                    <span class="bold fs11">{{ $permission->title }}</span>
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
</div>

<label for="grant-role-to-user-confirm-input" class="block mb4 fs15 bold dark">Confirmation</label>
<p class="no-margin mb4 dark">Please type <strong>{{ auth()->user()->username }}::grant-role::{{ $role->slug }}</strong> to confirm.</p>
<div>
    <input type="text" autocomplete="off" class="full-width styled-input" id="grant-role-to-user-confirm-input" style="padding: 8px 10px" placeholder="confirmation">
    <input type="hidden" id="grant-role-to-user-confirm-value" autocomplete="off" value="{{ auth()->user()->username }}::grant-role::{{ $role->slug }}">
</div>
<div class="flex" style="margin-top: 12px">
    <div id="grant-role-to-user-button" class="typical-button-style green-bs green-bs-disabled full-center">
        <div class="relative size14 mr4">
            <svg class="size12 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M256.69,169.38a27,27,0,0,1-5.88,5.8q-34.91,27.48-69.75,55.06a14.94,14.94,0,0,1-9.89,3.47c-35.2-.18-69.89-4.6-104.24-12.07-2.74-.6-3.6-1.72-3.59-4.61q.21-38.29,0-76.58c0-2.65.72-4.14,3.09-5.4,11.29-6,23-7.36,34.58-1.79,14.76,7.07,30,11.26,46.44,11.65,13.83.32,25.22,12,27.06,25.75.44,3.24-.64,3.76-3.6,3.73-17.78-.13-35.57-.07-53.36-.06-6.18,0-9.58,2.68-9.56,7.43s3.41,7.38,9.61,7.38c16.8,0,33.6-.15,50.39.07a41,41,0,0,0,28.06-10.14c6.9-5.86,13.95-11.55,21.05-17.16s15-8.07,24-6.61c6.41,1,11.74,3.82,15.61,9.14ZM94.61,40.87c-6.3.1-8.86,2.69-8.93,9.09,0,3.13-.2,6.27,0,9.38.22,2.92-.49,4.19-3.7,3.89a88,88,0,0,0-9.88,0C66,63.31,63.6,65.73,63.44,72c-.09,3.29,0,6.59,0,9.88,0,9,2,11,11.15,11,19.94,0,39.87.1,59.8-.07,3.9,0,5.94.79,7.55,4.82,9.06,22.68,31.87,35.3,56,31.43,23-3.68,41.3-23.08,43.06-45.69,2-25.31-12.1-47-35.48-54.7-22.74-7.47-47.27,1.72-60.1,22.15-2.54,4-2.47,10.5-7.18,12s-10.11.34-15.21.34c-7.69,0-7.69,0-7.69-7.68,0-14-.62-14.61-14.79-14.61C98.57,40.87,96.59,40.84,94.61,40.87Zm72.66,37a22.2,22.2,0,1,1,22.27,22.29A22.18,22.18,0,0,1,167.27,77.88ZM48.69,149c.05-3.29-.57-4.55-4.22-4.46-10.52.26-21,.07-31.58.1-6.68,0-9.25,2.58-9.26,9.24q0,35.28,0,70.58c0,6.59,2.63,9.12,9.36,9.14q12.82.06,25.66,0c7.55,0,9.93-2.39,10-10.08,0-12.34,0-24.68,0-37C48.62,174,48.51,161.53,48.69,149ZM182.17,78.39a7.31,7.31,0,1,0,7.08-7.84A7.33,7.33,0,0,0,182.17,78.39Z"/></svg>
            <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
        </div>
        <span class="bold">Grant role</span>
        <input type="hidden" class="role-id" value="{{ $role->id }}" autocomplete="off">
        <input type="hidden" class="user-id" value="{{ $user->id }}" autocomplete="off">
    </div>
</div>