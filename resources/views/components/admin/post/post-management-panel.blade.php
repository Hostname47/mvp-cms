<div id="post-management-panel">
    <!-- publish section -->
    <x-admin.post.panel-management-sections.publish-section :post="$post"/>
    <!-- status & visibility section -->
    <x-admin.post.panel-management-sections.status-and-visibility-section :post="$post" />
    <!-- categories section -->
    <x-admin.post.panel-management-sections.categories-section :post="$post" />
    <!-- tags section -->
    <x-admin.post.panel-management-sections.tags-section :post="$post" />
    <!-- featured image section -->
    <x-admin.post.panel-management-sections.featured-image-section :post="$post" />
    <!-- summary section -->
    <x-admin.post.panel-management-sections.summary-section :post="$post" />
    <!-- post comments & reactions section -->
    <x-admin.post.panel-management-sections.comments-and-reactions-section :post="$post" />
</div>