<div>
    <div id="newsletter-submission-section" class="full-center flex-column @if($subscribed) none @endif">
        <input type="hidden" class="name-error" autocomplete="off" value="{{ __('Please enter a valid name') }}">
        <input type="hidden" class="email-error" autocomplete="off" value="{{ __('Please enter a valid email address') }}">
        <div class="title">{{ __('SUBSCRIBE TO FIBONASHI') }}</div>
        <span class="description">{{ __('JOIN OUR NEWSLETTER AND GET OUR SPECIAL ARTICLES AND VALUABLE CONTENT') }}</span>
        <div class="align-center mb8 none error-container">
            <p class="error"></p>
            <span class="hide-error close-parent">✖</span>
        </div>
        @if($authenticated)
        <input type="hidden" id="newsletter-subscribe-name-input" value="{{ auth()->user()->fullname }}" class="name" autocomplete="off">
        <input id="newsletter-subscribe-email-input" value="{{ auth()->user()->email }}" class="email input-style-2 disabled" autocomplete="off">
        @else
        <input type="text" id="newsletter-subscribe-name-input" class="input-style-2 name" placeholder="{{ __('Your name') }}" autocomplete="off">
        <input type="text" id="newsletter-subscribe-email-input" class="input-style-2 email" placeholder="{{ __('Email address') }}" autocomplete="off">
        @endif
        <div id="newsletter-subscribe-button">
            <div class="relative size13 mr8">
                <svg class="size13 icon-above-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M215.89,255.22H43.5a5.17,5.17,0,0,0-1.25-.7C18.2,248.81,5.36,232.65,5.34,208q0-35,0-70c0-28.37,18.83-47.14,47.27-47.17q39.15,0,78.31,0c25.94,0,51.88-.13,77.82,0,24.81.15,44.57,18.27,45.1,42.25.59,26.57.47,53.17,0,79.74-.31,18.88-13.39,35-31.5,40.44C220.21,254,218.05,254.59,215.89,255.22ZM119.18,180c-5-5.09-9.75-10-14.62-14.83-5.21-5.14-11.59-5.49-16-1.06s-4,10.73,1.13,16c6.73,6.87,13.55,13.65,20.36,20.45s12.06,6.84,18.84.07q19.91-19.87,39.72-39.82a23.09,23.09,0,0,0,4.13-5.38,10,10,0,0,0-2.42-12,10.07,10.07,0,0,0-12.21-1.32,32.58,32.58,0,0,0-5.15,4.48C141.83,157.56,130.74,168.58,119.18,180ZM55.38,46.67c-3.59,0-7.19-.16-10.76.1a12.56,12.56,0,0,0-1.3,24.94,35.12,35.12,0,0,0,6.33.32q80,0,160,0a40,40,0,0,0,5.37-.15c5.07-.67,8.82-3.23,10.71-8.12,3.39-8.78-3-17.06-13.29-17.08-27.39-.07-54.79,0-82.19,0ZM125.56,4.56c-20.87,0-41.75-.09-62.63.05-10,.06-16.14,9.32-12,17.86,2.73,5.71,7.67,7.47,13.7,7.46q52.11-.11,104.22,0c9.14,0,18.27.07,27.4,0,6.25-.07,10.8-3.14,12.69-8.21,3.23-8.68-3-17-12.88-17.06-22-.09-44,0-66.05,0Z"/></svg>
                <svg class="spinner size13 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span>{{ __('Subscribe') }}</span>
        </div>
    </div>
    <div id="newsletter-thankyou-section" class="full-center flex-column @if(!$subscribed) none @endif">
        <svg class="v-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
        @if($subscribed)
        <div class="title">{{ __('YOU ARE ALREADY SUBSCRIBED') }} !</div>
        @else
        <div class="title">{{ __('THANK YOU') }} !</div>
        @endif
        <span class="description">{{ __('We know your inbox is protected space, so we promise to send only the good stuff') }}</span>
    </div>
</div>