<div class="signup-user-component">
    <div class="size32 rounded" style="background-color: #dddfe1;">
        <img src="{{ $user->avatar(36) }}" class="rounded size32" alt="">
    </div>
    <div>
        <div class="align-center" style="gap: 8px;">
            <a href="{{ $user->profile }}" target="_blank" class="bold blue fs13 no-underline">{{ $user->fullname }}</a>
            <div class="gray fs10">•</div>
            <p class="no-margin fs11 align-center tooltip-pointer light-gray" title="{{ $user->join_date }}">joined {{ $user->join_date_humans }}</p>
        </div>
        <p class="dark fs11 bold no-margin">{{ $user->username }}</p>
    </div>
</div>