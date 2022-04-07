<div class="post-management-panel-section toggle-box">
    <div class="align-center post-management-panel-section-header pointer toggle-button">
        <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M149.78,24c-1.59-11.62,9.08-21.73,20.46-18.55,15.86,4.42,30,12.39,42.71,22.8A127,127,0,0,1,253.15,86c.53,1.53,1,3.09,1.41,4.66a9.31,9.31,0,0,1,.21,1.79c.11,8.12-5.09,15-12.24,17-7.65,2.05-16.12-1.28-19.6-8.13-2.5-4.92-4.19-10.23-6.67-15.15-11.35-22.5-28.86-38.21-52.52-46.94C156.42,36.46,150.94,32.45,149.78,24ZM248,148.15c-5.4-4.34-11.48-4.85-17.87-1.91-5.92,2.72-8,8.16-10.21,13.63-15,36.7-42.39,57.53-81.85,60.65-40.68,3.21-78.94-22.13-93.12-60A93.32,93.32,0,0,1,75.22,53.15c9-7,19.25-11.31,29.53-15.84a16.9,16.9,0,0,0,9.17-22c-3.4-8.5-12.58-12.77-21.8-9.4C47,22.42,18.44,53.84,7.24,100.79c-.75,3.13-.76,6.43-1.63,9.53A25.14,25.14,0,0,1,5.15,114,25.78,25.78,0,0,1,4.76,118a25.93,25.93,0,0,1-.34,4.68v15.2c.06.39.13.77.18,1.16a32.61,32.61,0,0,1,.67,4.11C7.12,149,7.35,155.3,9.1,161.28q15.65,53.25,64.46,79.36a117.93,117.93,0,0,0,37.87,12.64c.36,0,.71,0,1.07,0a28.75,28.75,0,0,1,7.33.94,29,29,0,0,1,5.65.56h.15c.78,0,1.55,0,2.31.1s1.33-.1,2-.1a29.69,29.69,0,0,1,4.76.39h3.77a27,27,0,0,1,5.53-.58l.6,0a1.88,1.88,0,0,1,1.14-.38c30-3,55.54-15.52,76.82-36.63,14.91-14.79,25.81-32.2,31.52-52.55C256,158.17,253.28,152.42,248,148.15Z"></path></svg>
        <h2 class="dark fs12 no-margin">Status & visibility</h2>
        <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
            <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
        </svg>
    </div>
    <div class="post-management-panel-section-content toggle-container none">
        <!-- post status -->
        <div class="align-center my4">
            <span class="fs12 bold dark mr4">Current post status :</span>
            @if($post)
            <span class="fs12 bold mr4 @if($post->status=='published') green @else dark @endif">{{ $post->status }}</span>
            @else
            <em class="fs12 light-gray">Not saved yet</em>
            @endif
        </div>
        <div class="simple-line-separator my4"></div>
        <!-- post visibility -->
        <div class="align-center visibility-box my4">
            <span class="fs12 bold dark mr4">Visibility :</span>
            <div class="custom-dropdown-box">
                <input type="hidden" class="selected-value" id="post-visibility" value="public" autocomplete="off">
                <div class="custom-dropdown-button custom-dropdown-button-style">
                    <span class="fs11 bold dark custom-dropdown-button-text">Public</span>
                    <svg class="arrow size6 ml4 dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                        <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                    </svg>
                </div>
                <div class="custom-dropdown-items-container custom-dropdown-items-container-style" style="max-width: 166px;">
                    <div class="custom-dropdown-item custom-dropdown-item-style post-visibility-button custom-dropdown-item-selected custom-dropdown-item-selected-style">
                        <span class="custom-dropdown-item-text fs14 dark bold block">Public</span>
                        <span class="fs11 block">Post will be public.</span>
                        <input type="hidden" class="custom-dropdown-item-value visibility" value="public" autocomplete="off">
                    </div>
                    <div class="custom-dropdown-item custom-dropdown-item-style post-visibility-button mt2">
                        <span class="custom-dropdown-item-text fs14 dark bold block">Private</span>
                        <span class="fs11 block">post will be hidden and private.</span>
                        <input type="hidden" class="custom-dropdown-item-value visibility" value="private" autocomplete="off">
                    </div>
                    <div class="custom-dropdown-item custom-dropdown-item-style post-visibility-button mt2">
                        <span class="custom-dropdown-item-text fs14 dark bold block">Password protected</span>
                        <span class="fs11 block">Protected with a password you choose. Only those with the password can view this post.</span>
                        <input type="hidden" class="custom-dropdown-item-value visibility" value="password-protected" autocomplete="off">
                        <div id="post-password-container" class="mt4 none">
                            <span class="block bold mb2 fs12 light-gray">Password</span>
                            <input type="text" class="styled-input" id="post-password-input" autocomplete="off" placeholder="Use a secure password">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>