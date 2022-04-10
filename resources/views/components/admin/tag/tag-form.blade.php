<div class="tag-form">
    <!-- ERROR block -->
    <div id="tag-{{ $operation }}-error-container" class="informative-message-container error-container align-center relative my8 none">
        <div class="informative-message-container-left-stripe imcls-red"></div>
        <p class="no-margin fs13 red bold message-text"></p>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
    <!-- green message block -->
    <div id="tag-{{ $operation }}-green-message-container" class="informative-message-container green-message-container align-center relative my8 none">
        <div class="informative-message-container-left-stripe imcls-green"></div>
        <p class="no-margin fs13 dark-green bold message-text"></p>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
    <!-- title -->
    <div class="input-wrapper" style="margin-top: 12px;">
        <label class="input-label fs13 dark my4" for="{{ $operation }}-tag-title">Tag title<span class="error-asterisk red ml4">*</span></label>
        <input type="text" id="{{ $operation }}-tag-title" class="styled-input title" autocomplete="off" placeholder='{{ __("Tag title") }}'>
        <p class="fs12 my4 light-gray">This title is displayed in website to represent tag.</p>
    </div>
    <!-- title-meta -->
    <div class="input-wrapper" style="margin-top: 12px;">
        <label class="input-label fs13 dark my4" for="{{ $operation }}-tag-meta-title">Tag meta title<span class="error-asterisk red ml4">*</span></label>
        <input type="text" id="{{ $operation }}-tag-meta-title" class="styled-input meta-title" autocomplete="off" placeholder='{{ __("Tag meta title") }}'>
        <p class="fs12 my4 light-gray">Meta title used to improve <strong>tag SEO</strong> and displayed in browser tab title.</p>
    </div>
    <!-- slug -->
    <div class="input-wrapper" style="margin-top: 12px;">
        <label class="input-label fs13 dark my4" for="{{ $operation }}-tag-slug">Tag slug<span class="error-asterisk red ml4">*</span></label>
        <input type="text" id="{{ $operation }}-tag-slug" class="styled-input slug" autocomplete="off" placeholder='{{ __("Tag slug") }}'>
        <p class="fs12 my4 light-gray">The “slug” is the URL-friendly version of the title. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
    </div>
    <!-- description -->
    <div class="input-wrapper" style="margin-top: 12px;">
        <label class="input-label fs13 dark my4" for="{{ $operation }}-tag-description">Tag description (optional)<span class="error-asterisk red ml4">*</span></label>
        <textarea type="text" id="{{ $operation }}-tag-description" class="styled-input no-textarea-x-resize description" style="height: 110px;" autocomplete="off" placeholder='{{ __("Description here") }}'></textarea>
    </div>

    {{ $bottomline }}
</div>