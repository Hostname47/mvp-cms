<div>
    <!-- error container -->
    <div class="informative-message-container error-container align-center relative my8 none">
        <div class="informative-message-container-left-stripe imcls-red"></div>
        <p class="no-margin fs13 red bold message-text">Title field is required.</p>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
    <!-- title -->
    <div class="input-container">
        <div class="align-center">
            <label class="input-label dark fs14" for="{{ $action }}-category-title">Category Title<span class="error-asterisk ml4">*</span></label>
            <label class="fs12 bold dark align-center move-to-right">
                <input type="checkbox" checked class="no-margin mr4 live-title-match" autocomplete="off">
                <span>Live title match</span>
            </label>
        </div>
        <p class="fs12 my2 light-gray">By default, meta title and slug will be cloned to match the exact title.</p>
        <input type="text" id="{{ $action }}-category-title" class="styled-input title" maxlength="400" autocomplete="off" placeholder='{{ __("Enter post title here") }}' @if($category) value="{{ $category->title }}" @endif>
    </div>
    <div class="typical-section-style mt4">
        <p class="fs12 mb2 light-gray no-margin">Meta title and slug are useful to <strong>improve SEO</strong> of blog post and ranking. Meta title and slug will match exactly the title while typing title. You can disable this by checking the checkbox above.</p>
        <!-- meta title -->
        <div class="input-container">
            <label class="input-label dark fs13 my2" for="{{ $action }}-category-meta-title">Meta title<span class="error-asterisk ml4">*</span></label>
            <input type="text" id="{{ $action }}-category-meta-title" class="styled-input meta-title" maxlength="400" autocomplete="off" placeholder='{{ __("Enter meta title here (displayed by search engines and browser tab title)") }}' @if($category) value="{{ $category->title_meta }}" @endif>
        </div>
        <!-- slug -->
        <div class="input-container mt8">
            <label class="input-label dark fs13 my2" for="{{ $action }}-category-slug">Slug<span class="error-asterisk ml4">*</span></label>
            <input type="text" id="{{ $action }}-category-slug" class="styled-input slug" maxlength="400" autocomplete="off" placeholder='{{ __("Enter slug here (e.g. xyz-category-and-more)") }}' @if($category) value="{{ $category->slug }}" @endif>
        </div>
    </div>
    <!-- description -->
    <div class="input-container flex flex-column" style="margin-top: 10px">
        <label class="input-label dark fs14" for="{{ $action }}-category-description">Description<span class="error-asterisk ml4">*</span></label>
        <p class="fs12 my2 light-gray">Category description should include all related topics and keywords</p>
        <textarea id="{{ $action }}-category-description" class="styled-input no-textarea-resize description" style="height: 126px;" autocomplete="off" placeholder='Category description'>@if($category){{ $category->description }}@endif</textarea>
    </div>
</div>