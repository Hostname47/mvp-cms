<div>
    <h2 class="fs16 dark no-margin mb4">Categories hierarchy</h2>
    <p class="no-margin fs13 dark">The following hierarchy represents the categories and their subcategories. Select a category to set it as the parent of the current category</p>
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
            background-color: #1f2324;
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
    <x-admin.category.hierarchy.select-parent.subcategories-level :categories="$categories"/>
</div>