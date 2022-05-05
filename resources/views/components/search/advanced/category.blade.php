<div class="category-container toggle-box">
    <div class="align-center">
        <input type="checkbox" id="category-input-{{ $category->id }}" name="category[]" class="category" value="{{ $category->id }}" autocomplete="off">
        <label for="category-input-{{ $category->id }}" class="unselectable">{{ __($category->title) }}</label>
        @if($category->children->count())
        <div class="toggle-button category-toggle-button">
            <svg class="category-toggle-arrow toggle-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/></svg>
        </div>
        @endif
    </div>
    @if($category->children->count())
    <div class="toggle-container mt4 none">
        <div class="flex">
            <svg class="category-children-angle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"></polygon></svg>
            <div class="category-children-container">
                @foreach ($category->children as $child)
                    <x-search.advanced.category :category="$child" />
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>