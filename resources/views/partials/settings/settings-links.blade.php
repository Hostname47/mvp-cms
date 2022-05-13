<div class="settings-links">
    <a href="{{ route('user.settings') }}" class="button-style-2 @if($page=='profile-settings') blue @endif">{{ __('profile') }}</a>
    <a href="{{ route('password.settings') }}" class="button-style-2 @if($page=='password-settings') blue @endif">{{ __('password settings') }}</a>
    <a href="{{ route('account.settings') }}" class="button-style-2 @if($page=='account-settings') blue @endif">{{ __('account settings') }}</a>
</div>