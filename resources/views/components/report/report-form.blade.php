<div class="report-resource-box">
    <div class="report-resource-container">
        <input type="hidden" class="reportable-id" value="">
        <input type="hidden" class="reportable-type" value="">
        <input type="hidden" class="reported-successfully-message" value="{{ __('Your report has been sent successfully') }}." autocomplete="off">
        <!-- close report section -->
        <div class="close-report-container x-close-container-style" style="top: 12px; right: 12px">
            <span class="x-close">✖</span>
        </div>
        <!-- already reported resource -->
        <div class="@if(!$reported) none @endif already-reported-container">
            <div class="align-center justify-center move-to-middle">
                <svg class="size17 mr8" fill="#1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M204.49,43.44A15.74,15.74,0,0,0,198,44.87c-15.45,7.05-26.9,9.45-36.45,9.45-20.27,0-32.06-10.78-55.42-10.78-11.71,0-26.33,2.71-46.39,10.84V51.55a8.13,8.13,0,0,0-16.25,0v156.9a8.12,8.12,0,0,0,16.23,0V173.28c18.12-8.07,32.47-10.75,44.9-10.75,24.9,0,42.24,10.74,67.16,10.74,10.79,0,23-2,37.56-7.81a10.46,10.46,0,0,0,7.27-9.73V53.83C216.56,47.19,210.92,43.44,204.49,43.44Zm-4.16,108.13c-10.25,3.66-19.64,5.45-28.6,5.45-10.42,0-19.72-2.37-29.57-4.88-10.82-2.75-23.09-5.87-37.57-5.87-14.32,0-29.07,3.07-44.9,9.38V71.89l6.09-2.47c16-6.49,29.21-9.65,40.31-9.65,9.55,0,16.61,2.27,24.79,4.9,8.58,2.75,18.3,5.88,30.63,5.88,12,0,24.42-2.88,38.85-9v90Z" style="stroke:#000;stroke-miterlimit:10;stroke-width:9px"></path></svg>
                <h3 class="text-center title gray my8">{{ __('You already report this item') }}.</h3>
            </div>
            <p class="text-center my8 lh15">{{ __('We have received your report submit and we are going to verify if this item respects our guidelines and standards as soon as possible') }}.</p>
        </div>
        @if(!$reported)
        <div class="report-section">
            <div class="align-center" style="margin-bottom: 12px;">
                <svg class="size17 mr4" fill="#1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M204.49,43.44A15.74,15.74,0,0,0,198,44.87c-15.45,7.05-26.9,9.45-36.45,9.45-20.27,0-32.06-10.78-55.42-10.78-11.71,0-26.33,2.71-46.39,10.84V51.55a8.13,8.13,0,0,0-16.25,0v156.9a8.12,8.12,0,0,0,16.23,0V173.28c18.12-8.07,32.47-10.75,44.9-10.75,24.9,0,42.24,10.74,67.16,10.74,10.79,0,23-2,37.56-7.81a10.46,10.46,0,0,0,7.27-9.73V53.83C216.56,47.19,210.92,43.44,204.49,43.44Zm-4.16,108.13c-10.25,3.66-19.64,5.45-28.6,5.45-10.42,0-19.72-2.37-29.57-4.88-10.82-2.75-23.09-5.87-37.57-5.87-14.32,0-29.07,3.07-44.9,9.38V71.89l6.09-2.47c16-6.49,29.21-9.65,40.31-9.65,9.55,0,16.61,2.27,24.79,4.9,8.58,2.75,18.3,5.88,30.63,5.88,12,0,24.42-2.88,38.85-9v90Z" style="stroke:#000;stroke-miterlimit:10;stroke-width:9px"></path></svg>
                <h3 class="no-margin">{{ __('I am flagging to report this item as') }}.. </h3>
            </div>
            <div>
                <label class="resource-report-option">
                    <input type="radio" name="report-option" value="spam" class="height-max-content report-choice-input" autocomplete="off">
                    <div class="ml8">
                        <p class="bold no-margin">{{__('spam')}}</p>
                        <p class="no-margin gray">{{__("Exists only to promote a product or service, does not disclose the author's affiliation, repetitive or out of topic")}}.</p>
                    </div>
                </label>
                <label class="resource-report-option">
                    <input type="radio" name="report-option" value="rude-or-abusive" class="height-max-content report-choice-input" autocomplete="off">
                    <div class="ml8">
                        <p class="bold no-margin">{{__('rude or abusive')}}</p>
                        <p class="no-margin gray">{{__('A reasonable person would find this content inappropriate for respectful discourse')}}.</p>
                    </div>
                </label>
                <label class="resource-report-option">
                    <input type="radio" name="report-option" value="low-quality" class="height-max-content report-choice-input" autocomplete="off">
                    <div class="ml8">
                        <p class="bold no-margin">{{__('very low quality')}}</p>
                        <p class="no-margin gray">{{__('This post has severe formatting or content problems. This post is unlikely to be salvageable through editing, and might need to be removed')}}.</p>
                    </div>
                </label>
                <label class="resource-report-option">
                    <input type="radio" name="report-option" value="moderator-intervention" class="height-max-content report-choice-input body-required" autocomplete="off">
                    <div class="ml8">
                        <p class="bold no-margin">{{__('in need of moderator intervention')}}</p>
                        <p class="no-margin gray">{{__('A problem not listed above that requires action by a moderator')}}. <i>{{__('Be specific and detailed')}}!</i></p>
                        <div class="report-body-input-container none">
                            <textarea name="content" class="report-body-input" placeholder="{{ __('Be specific and detailed') }}"></textarea>
                            <p class="no-margin ml4 fs12 gray report-content-counter"><span class="report-content-count"></span> <span class="report-content-count-phrase">{{ __('Enter at least 10 characters') }}</span></p>
                            <input type="hidden" class="first-phrase-text" value="{{ __('Enter at least 10 characters') }}">
                            <input type="hidden" class="more-to-go-text" value="{{ __('more to go') }}..">
                            <input type="hidden" class="chars-left-text" value="{{ __('characters left') }}">
                            <input type="hidden" class="too-long-text" value="{{ __('Too long by') }}">
                            <input type="hidden" class="characters-text" value="{{ __('characters') }}">
                        </div>
                    </div>
                </label>
            </div>
            <p class="fs12 my8 lh15">{{__('Please check carefully your report before submit it, because inappropriate or random reports can make')}} <strong>{{__('your account banned')}}</strong> !</p>
            <div class="align-center" style="margin-top: 12px">
                <div class="typical-button-style dark-bs dark-bs-disabled align-center">
                    <svg class="spinner size14 none mr8" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                        <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                    </svg>
                    <span class="fs13 unselectable">{{__('Submit')}}</span>
                </div>
                <div class="button-style-2 close-report-container" style="margin-left: 12px;">{{ __('cancel') }}</div>
            </div>
        </div>
        @endif
    </div>
</div>