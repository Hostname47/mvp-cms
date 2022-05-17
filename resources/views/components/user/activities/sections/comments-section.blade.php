<!-- comments section -->
<div>
    <div class="align-center">
        <svg class="section-title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>    
        <h2 class="section-title">{{ __('Your comments') }}</h2>
    </div>
    <p class="section-subtitle">{{ __("The following comments are unique per post. If you would like to see all your comments click on 'all comments' button") }}</p>

    <div class="pagination-box">
        {{ $stats->appends(request()->query())->onEachSide(0)->links() }}
    </div>
    <div id="posts-box">
        @foreach($comments as $comment)
        <div class="line-post-component align-start">
            <svg class="size16 mr6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M73.59,195.36c-6.65,0-12.82,0-19,0-17.48-.15-30.21-12.5-30.31-30q-.22-49.08,0-98.15c.1-17.81,12.88-30,31.2-30,32.71-.09,65.42,0,98.14,0H209.2c20.13,0,32.25,12.15,32.27,32.28q.06,47,0,94c0,19.85-12.2,31.9-32.12,31.92-23,0-46-.07-69,.1a12.43,12.43,0,0,0-7,2.44c-14.14,11-28.13,22.1-42.1,33.29-3.73,3-7.53,4.94-12.25,2.53s-5.54-6.56-5.47-11.35C73.69,213.61,73.59,204.82,73.59,195.36Zm19.68,9.1c2.17-1.64,3.48-2.58,4.76-3.59,8.45-6.71,17-13.31,25.28-20.24a20.56,20.56,0,0,1,14.27-5.06c23.91.24,47.82.13,71.73.09,8.82,0,12.45-3.62,12.46-12.27V69c0-8.34-3.46-11.84-11.82-11.84H55.86C47.48,57.13,44,60.62,44,68.89v94.88c0,8.09,3.72,11.82,11.89,11.89,8.64.07,17.28,0,25.92,0,8.08.07,11.42,3.46,11.48,11.64,0,5.37,0,10.7,0,17.16Z"/></svg>    
            <span class="fs10 light-gray">•</span>
            <div>
                <a href="{{ $comment->post->link . '?comment=' . $comment->id }}" class="title">{{ $comment->content }}</a>
                @if($stats->find($comment->id)->count > 1)
                <p class="post-meta bold">(+{{ ($stats->find($comment->id)->count - 1) . ' ' . __('other comments on this post') }})</p>
                @endif
                <div class="post-meta">
                    <span class="no-wrap">{{ __('commented') }} :</span>
                    <span title="{{ $comment->created_at }}">{{ $comment->created_at }}</span>
                </div>
                <div class="flex ml4 mt4">
                    <svg class="size14 mr6" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
                    <a href="{{ $comment->post->link }}" class="title mt2">{{ $comment->post->html_title }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination-box">
        {{ $stats->appends(request()->query())->onEachSide(0)->links() }}
    </div>
</div>