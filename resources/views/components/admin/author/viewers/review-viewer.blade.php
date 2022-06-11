<div>
    <p class="no-margin dark mb8 fs13">Review carefully the user application for author permission. Once you click accept request, the user will because an author and will be able to create posts.</p>
    <p class="no-margin dark mb8 fs13">You can refuse the request if the user is not not suitable.</p>
    <div class="simple-line-separator my12"></div>
    <div>
        <!-- error container -->
        <div id="create-faq-error-container" class="informative-message-container align-center relative my8 none">
            <div class="informative-message-container-left-stripe imcls-red"></div>
            <p class="no-margin fs13 red bold error"></p>
            <div class="close-parent close-informative-message-style">✖</div>
        </div>
        <div class="align-center">
            <img src="{{ $request->user->avatar(100) }}" class="size36 br4 mr6" alt="">
            <div class="dark">
                <a href="{{ route('admin.users.management', ['user'=>$request->user->username]) }}" target="_blank" class="no-underline dark bold">{{ $request->user->fullname }}</a>
                <p class="no-margin fs12 mt2">{{ $request->user->username }}</p>
            </div>
        </div>
        <div class="author-request-categories-box toggle-box">
            <div class="align-center pointer mb8 toggle-button">
                <p class="no-margin dark bold">Categories</p>
                <svg class="toggle-arrow size7 ml8 mt2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"></path></svg>
            </div>
            <div class="author-request-categories-container toggle-container none">
                @foreach($request->categories('titles') as $category)
                <div class="fs12 bold dark">• {{ $category }}</div>
                @endforeach
            </div>
        </div>
        <div class="message-box">
            <p class="dark bold dark">Message :</p>
            <textarea class="styled-input author-request-message" disabled>{{ $request->message }}</textarea>
        </div>
    </div>
    <div class="align-center" style="margin-top: 12px; gap: 8px;">
        <div id="accept-request" class="typical-button-style green-bs align-center">
            <div class="relative size14 mr4">
                <svg class="size12 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"></path></svg>
                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold fs12 unselectable">Accept request</span>
            <input type="hidden" class="request-id" value="{{ $request->id }}" autocomplete="off">
        </div>
        <div id="refuse-request" class="typical-button-style red-bs align-center">
            <div class="relative size14 mr4">
                <svg class="size12 icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M2.19,144V114.32c2.06-1.67,1.35-4.2,1.78-6.3Q19.81,30.91,94.83,7.28c6.61-2.07,13.5-3.26,20.26-4.86h26.73c1.44,1.93,3.6.92,5.39,1.2C215,14.2,261.83,74.5,254.91,142.49c-6.25,61.48-57.27,110-119,113.3A127.13,127.13,0,0,1,4.9,155.18C4.09,151.45,4.42,147.42,2.19,144Zm126.75-30.7c-19.8,0-39.6.08-59.4-.08-3.24,0-4.14.82-4.05,4,.24,8.08.21,16.17,0,24.25-.07,2.83.77,3.53,3.55,3.53q59.89-.14,119.8,0c2.8,0,3.6-.74,3.53-3.54-.18-8.08-.23-16.17,0-24.25.1-3.27-.85-4.06-4.06-4C168.55,113.4,148.75,113.33,128.94,113.33Z"></path></svg>
                <svg class="spinner size14 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                    <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                </svg>
            </div>
            <span class="bold fs12 unselectable">Refuse request</span>
            <input type="hidden" class="request-id" value="{{ $request->id }}" autocomplete="off">
        </div>

        <span id="delete-request" class="fs12 red pointer align-center move-to-right mr8">
            <svg class="spinner size12 mr4 none" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
            <span>Delete request</span>
            <input type="hidden" class="request-id" value="{{ $request->id }}" autocomplete="off">
        </span>
    </div>
</div>