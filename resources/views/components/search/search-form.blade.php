<form action="{{ $route }}" id="init-search-inputs-container" class="relative">
    <svg class="init-search-input-icon" fill="#5b5b5b" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
    <input type="text" name="k" required id="init-search-input" autocomplete="off" placeholder="{{ $placeholder }}" value="{{ $k }}">
    @if($hasfilter)
    <div id="init-search-filters-box">
        <div class="filter-button button-with-suboptions">
            <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
        </div>
        <div class="suboptions-container filter-panel">
            <span class="fs14 bold dark">{{__('Search for')}} :</span>
            <div class="flex flex-column ml8 mt8">
                <div class="align-center">
                    <input type="radio" name="type" id="search-filter-all" class="mr6" value="all" autocomplete="off" @if($type=='all') checked="checked" @endif>
                    <label for="search-filter-all" class="dark">{{ __('all') }}</label>
                </div>
                <div class="align-center mt4">
                    <input type="radio" name="type" id="search-filter-authors" class="mr6" value="authors" autocomplete="off" @if($type=='authors') checked="checked" @endif>
                    <label for="search-filter-authors" class="dark">{{ __('authors') }}</label>
                </div>
                <div class="align-center mt4">
                    <input type="radio" name="type" id="search-filter-tags" class="mr6" value="tags" autocomplete="off" @if($type=='tags') checked="checked" @endif>
                    <label for="search-filter-tags" class="dark">{{ __('tags') }}</label>
                </div>
                <div class="align-center mt4">
                    <input type="radio" name="type" id="search-filter-posts" class="mr6" value="posts" autocomplete="off" @if($type=='posts') checked="checked" @endif>
                    <label for="search-filter-posts" class="dark">{{ __('posts') }}</label>
                </div>
            </div>
        </div>
    </div>
    @endif
    <button id="init-search-button">
        <svg id="init-search-button-icon" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"></path></svg>
        <span>{{ __('search') }}</span>
    </button>
</form>