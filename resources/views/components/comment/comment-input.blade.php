<div class="comment-input-box">
    @if($is_root)
    <div class="commenter-avatar-and-threadline">
        <!-- commenter avatar (link to its profile) -->
        @if(auth()->user())
        <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" class="commenter-profile-link">
            <img src="{{ auth()->user()->avatar(100) }}" class="commenter-avatar" alt="">
        </a>
        @else
        <div class="commenter-profile-link commenter-avatar full-center">
            <svg class="f" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M56.69,31H205.78C204.5,44.71,203.3,57.53,202,71.37L191.28,72c-.83-1.56-1.44-2.25-1.57-3-4-24.39,1.61-21.18-25.79-24.67a135.39,135.39,0,0,0-14.38-.91c-7.85-.15-15.71,0-25,0V120.8c13.22,0,27.24,1.45,40.65-.77,4.86-.81,8.27-10.4,10.27-18.34l12.17-.62v59.62H176.14c-.54-.81-1.35-1.48-1.44-2.24-2.6-21.54-2.58-21.67-25-22.86-8.2-.43-16.44-.07-25.59-.07,0,24.42-.31,48.26.15,72.08.19,9.88,8.6,9,15.49,10,6.07.88,15.59-1.06,11.61,11.47h-94c-1.32-9.18-1.36-10,6.22-10.34,12.28-.49,16.17-6.13,16-18.13-.53-46.73-.38-93.46-.16-140.19.15-11.12-2-18.7-15.42-18.78-3.26,0-6.5-4.93-9.74-7.6Z"/></svg>
        </div>
        @endif
    </div>
    @endif
    <div class="comment-input-container">
        <!-- error container -->
        <div class="informative-message-container align-center relative error-container none">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <div class="no-margin fs13 error"></div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        @if(is_null($comment))
        <textarea class="comment-input content" placeholder="{{ __('write a comment') }}.." autocomplete="off"></textarea>
        @else
        <textarea class="comment-input comment-update-content" placeholder="{{ __('update comment content') }}.." autocomplete="off">{{ $comment->content }}</textarea>
        @endif
        <!-- bottom-section -->
        <div class="comment-bottom-section">
            @if(is_null($comment))
            <div class="move-to-right align-center">
                @if($is_root)
                <span class="button-style-2 comment-display-switch root">{{ __('hide') }}</span>
                @else
                <span class="button-style-2 comment-display-switch">{{ __('cancel') }}</span>
                @endif
                <div class="button-style-3 @auth share-comment @else login-required @endauth share-comment-disabled @if($is_root) root @endif">
                    <div class="relative size13 mr4">
                        <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>
                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="no-wrap">share comment</span>
                    <input type="hidden" class="parent-comment-id" value="{{ $parent_comment_id }}" autocomplete="off">
                </div>
            </div>
            @else
            <div class="move-to-right align-center">
                <span class="button-style-2 cancel-comment-update">
                    {{ __('cancel') }}
                    <input type="hidden" class="original-content" value="{{ $comment->content }}" autocomplete="off">
                </span>
                <div class="button-style-3 update-comment">
                    <div class="relative size13 mr4">
                        <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M3.53,137.79a8.46,8.46,0,0,1,8.7-4c2.1.23,4.28-.18,6.37.09,3.6.47,4.61-.68,4.57-4.46-.28-24.91,7.59-47.12,23-66.65C82.8,16.35,151.92,9.31,197.09,47.21c3,2.53,3.53,4,.63,7.08-5.71,6.06-11,12.5-16.28,19-2.13,2.63-3.37,3.21-6.4.73-42.11-34.47-103.77-13.24-116,39.81a72.6,72.6,0,0,0-1.61,17c0,2.36.76,3.09,3.09,3,4.25-.17,8.51-.19,12.75,0,5.46.25,8.39,5.55,4.94,9.66-12,14.24-24.29,28.18-36.62,42.39L4.91,143.69c-.37-.43-.5-1.24-1.38-1Z"></path><path d="M216.78,81.86l35.71,41c1.93,2.21,3.13,4.58,1.66,7.58s-3.91,3.54-6.9,3.58c-3.89.06-8.91-1.65-11.33.71-2.1,2-1.29,7-1.8,10.73-6.35,45.41-45.13,83.19-90.81,88.73-28.18,3.41-53.76-3-76.88-19.47-2.81-2-3.61-3.23-.85-6.18,6-6.45,11.66-13.26,17.26-20.09,1.79-2.19,2.87-2.46,5.39-.74,42.83,29.26,99.8,6.7,111.17-43.93,2.2-9.8,2.2-9.8-7.9-9.8-1.63,0-3.27-.08-4.9,0-3.2.18-5.94-.6-7.29-3.75s.13-5.61,2.21-8c7.15-8.08,14.21-16.24,21.31-24.37C207.43,92.59,212,87.31,216.78,81.86Z"></path></svg>
                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span class="unselectable">update</span>
                    <input type="hidden" class="comment-id" value="{{ $comment->id }}" autocomplete="off">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>