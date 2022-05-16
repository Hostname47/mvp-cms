<!-- claped posts section -->
<div>
    <div class="align-center">
        <svg class="size20 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
        <h2 class="section-title">{{ __('Saved posts') }}</h2>
    </div>
    <p class="section-subtitle">{{ __('The following posts are the ones you saved.') }}</p>

    <div class="pagination-box">{{ $posts->appends(request()->query())->onEachSide(0)->links() }}</div>
    <div id="posts-box">
        @foreach($posts as $post)
        <div class="line-post-component">
            <svg class="size16 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
            <span class="fs10 light-gray">•</span>
            <div>
                <a href="{{ $post->link }}" class="title">{{ $post->html_title }}</a>
                <div class="action-date">
                    <span class="no-wrap">{{ __('saved') }} :</span>
                    <span title="{{ DateHelper::format($post->pivot->created_at) }}">{{ DateHelper::humans($post->pivot->created_at) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination-box">{{ $posts->appends(request()->query())->onEachSide(0)->links() }}</div>
</div>