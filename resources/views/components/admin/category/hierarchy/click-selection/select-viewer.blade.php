<div>
    <style>
        .hierarchy-category-wrapper {
            padding: 8px 4px;
        }

        .categories-hierarchy-level {
            padding: 6px;
            background-color: #f4f5f782;
            border: 1px solid #dde0e6;
            border-radius: 3px;
        }

        .expand-subcategories-button {
            height: 16px;
            width: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #2ca0ff;
            fill: white;
            border-radius: 50%;
            margin-left: 4px;
            padding: 1px;
        }

        .angle-before-subcategories-box {
            height: 12px;
            width: 12px;
            position: absolute;
            left: -18px;
            top: -5px;
        }
    </style>
    @if($categories->count())
    <!-- initialize viewer with one deep level and then admin click to expend subcategories -->
    <x-admin.category.hierarchy.click-selection.subcategories-level :categories="$categories"/>
    @else
    <div class="typical-section-style flex align-center mt8">
        <svg class="size14 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
        <p class="fs12 dark no-margin">This blog website has no categories for the moment. Please create a new one in create category page.</p>
    </div>
    @endif
</div>