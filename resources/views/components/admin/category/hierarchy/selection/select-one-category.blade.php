<div class="toggle-box category-box">
    <div class="align-center pointer hierarchy-category-wrapper">
        <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
        <input type="radio" name="{{ $inputname }}" id="category-{{ $category->id }}" class="hierarchy-category-id size14 no-margin mr4" value="{{ $category->id }}" autocomplete="off">
        <label for="category-{{ $category->id }}" class="bold dark category-title-text no-margin unselectable pointer" title="{{ $category->title }}">{{ $category->mintitle }}</label>
        @if($category->children->count())
        <div class="relative toggle-button expand-subcategories-button">
            <svg class="toggle-arrow size8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02"><path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/></svg>
            <svg class="spinner size10 opacity0 absolute white" fill="none" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
            </svg>
            <input type="hidden" class="category-id" value="{{ $category->id }}" autocomplete="off">
        </div>
        @endif
    </div>
    @if($category->children->count())
    <div class="flex">
        <div class="relative toggle-container categories-hierarchy-level full-width none" style="margin-left: 28px;">
            <svg class="angle-before-subcategories-box none" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
            <div class="subcategories-box">
                @foreach($category->children as $child)
                    <x-admin.category.hierarchy.selection.select-one-category :category="$child" :inputname="$inputname" :inputclass="$inputclass"/>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>