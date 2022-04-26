<div class="comment-input-box">
    @if($is_root)
        <!-- commenter avatar (link to its profile) -->
        @if(auth()->user())
        <a href="" class="commenter-profile-link">
            <img src="{{ auth()->user()->avatar(100) }}" class="commenter-avatar" alt="">
        </a>
        @else
        <div class="commenter-profile-link commenter-avatar full-center">
            <svg class="f" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M56.69,31H205.78C204.5,44.71,203.3,57.53,202,71.37L191.28,72c-.83-1.56-1.44-2.25-1.57-3-4-24.39,1.61-21.18-25.79-24.67a135.39,135.39,0,0,0-14.38-.91c-7.85-.15-15.71,0-25,0V120.8c13.22,0,27.24,1.45,40.65-.77,4.86-.81,8.27-10.4,10.27-18.34l12.17-.62v59.62H176.14c-.54-.81-1.35-1.48-1.44-2.24-2.6-21.54-2.58-21.67-25-22.86-8.2-.43-16.44-.07-25.59-.07,0,24.42-.31,48.26.15,72.08.19,9.88,8.6,9,15.49,10,6.07.88,15.59-1.06,11.61,11.47h-94c-1.32-9.18-1.36-10,6.22-10.34,12.28-.49,16.17-6.13,16-18.13-.53-46.73-.38-93.46-.16-140.19.15-11.12-2-18.7-15.42-18.78-3.26,0-6.5-4.93-9.74-7.6Z"/></svg>
        </div>
        @endif
    @endif
    <div class="comment-input-container">
        <!-- error container -->
        <div class="informative-message-container align-center relative error-container none">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <div class="no-margin fs13 error"></div>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        <textarea class="comment-input content" placeholder="{{ __('write a comment') }}.." autocomplete="off"></textarea>
        <!-- bottom-section -->
        <div class="comment-bottom-section">
            <div class="move-to-right align-center">
                @if($is_root)
                <span class="button-style-2 comment-display-switch root">{{ __('hide') }}</span>
                @else
                <span class="button-style-2 comment-display-switch">{{ __('cancel') }}</span>
                @endif
                <div class="button-style-3 @guest login-required @endguest share-comment share-comment-disabled">
                    <div class="relative size13 mr4">
                        <svg class="size13 icon-above-spinner" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M242.59,126.87c.39,68.29-60.46,121.59-128.32,112.48a123.89,123.89,0,0,1-36.32-11,11.92,11.92,0,0,0-7.61-.65c-13.33,3.71-26.56,7.76-39.79,11.8-4.5,1.37-8.67,1.27-12.1-2.23s-3.32-7.43-2-11.73c4-13.23,8.11-26.45,11.8-39.78a12.35,12.35,0,0,0-.77-8.06C-4.8,113.42,30.65,35.22,100.35,17.13,172.34-1.55,242.17,52.33,242.59,126.87ZM41.27,214.68c9.75-2.93,18.41-5.28,26.89-8.16,5.92-2,11-1.41,16.51,1.68,18.92,10.6,39.31,14.16,60.63,10.06,49.8-9.58,81.33-52.89,75.62-103.31-5.77-50.85-56-88.36-106.48-79.54C49.89,46.69,16.77,115.7,48.52,172.9a15.29,15.29,0,0,1,1.38,12.91C47,195,44.37,204.23,41.27,214.68Z"></path></svg>
                        <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                    <span>share comment</span>
                    <input type="hidden" class="parent-comment" value="" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>