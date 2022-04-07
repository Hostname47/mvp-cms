<div class="post-management-panel-section toggle-box">
    <div class="align-center post-management-panel-section-header pointer toggle-button">
        <svg class="size12 ml4 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M155.32,3.3h78.12c11.19,3.13,18.39,10.25,21.48,21.49v79.09c-1.28.34-1,1.52-1.23,2.38-2.34,9.41-7.32,17.21-14.14,24Q183.26,186.47,127,242.73C112.72,257,95,256.88,80.58,242.52Q48.47,210.45,16.4,178.35C.91,162.85,1,145.73,16.51,130.17Q67,79.62,117.55,29C128.53,18,139.19,6.68,155.32,3.3ZM197.4,86.52a26,26,0,1,0-25.7-26.18A25.94,25.94,0,0,0,197.4,86.52Z"/></svg>
        <h2 class="dark fs12 no-margin">Tags</h2>
        <svg class="toggle-arrow size7 mr4 move-to-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
            <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
        </svg>
    </div>
    <div class="post-management-panel-section-content toggle-container none">
        <label class="fs13 dark bold" for="post-tags-input">Enter post tags</label>
        <p class="no-margin fs12 light-gray mt2">(separate tags by pressing enter)</p>
        <div class="post-tags-wrapper mt4">
            @if($post)
                @foreach($post->tags as $tag)
                <div class="post-tag-item align-center">
                    <span class="fs13 tag-text">{{ $tag->title }}</span>
                    <span class="unselectable post-tag-remove remove-parent">✖</span>
                </div>
                @endforeach
            @endif
            <input type="text" id="post-tags-input" class="post-tags-input" autocomplete="off">
        </div>
        <div class="post-tag-item-skeleton post-tag-item align-center none">
            <span class="fs13 tag-text">post tag</span>
            <span class="unselectable post-tag-remove remove-parent">✖</span>
        </div>
    </div>
</div>