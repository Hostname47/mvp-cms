<!-- saved posts section -->
<div>
    <div class="align-center">
        <svg class="size20 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
        <h2 class="section-title">{{ __('Saved posts') }}</h2>
    </div>
    <p class="section-subtitle">{{ __('The following posts are the ones you saved.') }}</p>

    <div class="pagination-box">{{ $posts->appends(request()->query())->onEachSide(0)->links() }}</div>
    <div id="posts-box">
        @foreach($posts as $post)
        <div class="line-post-component align-start">
            <svg class="size16" style="min-width: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
            <span class="fs10 light-gray">•</span>
            <div style="margin-top: -3px;">
                <a href="{{ $post->link }}" class="title dark-blue">{{ $post->html_title }}</a>
                <div class="meta">
                    <span class="no-wrap">{{ __('saved') }} :</span>
                    <span title="{{ DateHelper::format($post->pivot->created_at) }}">{{ DateHelper::humans($post->pivot->created_at) }}</span>
                </div>
            </div>
        </div>
        @endforeach
        @if(!$posts->count())
        <div class="empty-activity-section">
            <svg class="icon" fill="#1d2226" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
            <p class="title">{{ __("You don't have any saved post yet for the moment") }} !</p>
            <p class="description">{{ __("When you find an interesting post and you want to go back to it later you can save it by clicking on save button in the post view page") }}.</p>
        </div>
        @endif
    </div>
    <div class="pagination-box">{{ $posts->appends(request()->query())->onEachSide(0)->links() }}</div>
</div>