<div id="author-header-links">
    <a href="?tab=all" class="button-style-5 @if($tab=='all') blue @endif">{{ __('All') }} ({{ $statistics['all'] }})</a>
    <span class="fs10 unselectable">〡</span>
    <a href="?tab=published" class="button-style-5 @if($tab=='published') blue @endif">{{ __('Published') }} ({{ $statistics['published'] }})</a>
    <span class="fs10 unselectable">〡</span>
    <a href="?tab=awaiting-review" class="button-style-5 @if($tab=='awaiting-review') blue @endif">{{ __('Awaiting review') }} ({{ $statistics['awaiting-review'] }})</a>
    <span class="fs10 unselectable">〡</span>
    <a href="?tab=draft" class="button-style-5 @if($tab=='draft') blue @endif">{{ __('Drafts') }} ({{ $statistics['draft'] }})</a>

    <a href="" class="typical-button-style white-bs align-center" id="create-post-button">
        <svg class="size14 mr6" style="min-width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M130,254C61.82,254.05,5.93,198.12,6,129.89S62.07,5.77,130.23,6A124.29,124.29,0,0,1,254,129.79C254.18,198,198.32,254,130,254Zm99-123.86c.06-54.55-43.36-98.92-98-99C89.94,31.1,59,50.08,41.12,86.79,23.34,123.28,28,158.8,52.29,191.58c2.25,3,3.58,3.77,7,1,43-34.12,98.77-34.07,141.52.13,3.24,2.59,4.48,1.9,6.63-.87C221.6,173.69,229,153.2,229,130.14ZM74.91,212c32.78,23.76,81.48,21.67,110.05-.06C155.36,185.48,105.73,185.4,74.91,212Zm54.77-57.31c-27.29-.17-49.5-22.52-49.31-49.63a49.79,49.79,0,0,1,50.24-49.34c27.12.25,49.43,23,49,50A49.53,49.53,0,0,1,129.68,154.65Zm25-49.32A24.65,24.65,0,1,0,130,130,24.71,24.71,0,0,0,154.65,105.33Z"/></svg>
        <span class="fs13">{{ __('Create a post') }}</span>
    </a>
</div>