<div class="category-container">
    <a class="category" href="">{{ __($category->title) }}</a>
    
    @foreach ($category->children as $child)
        <x-layout.left-panel.category :category="$child" />
    @endforeach
</div>