<!-- post title -->
<div class="input-wrapper">
    <div>
        <div class="align-center">
            <label class="input-label dark fs14" for="post-title">Post Title <span class="error-asterisk red ml4">*</span></label>
            <span class="fs8 bold light-gray unselectable mx8">●</span>
            <div id="toggle-meta-and-slug" class="align-center pointer">
                <span class="blue fs12 bold unselectable">meta & slug</span>
                <svg class="toggle-arrow size6 ml4" fill="#2cb2ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.02 30.02">
                    <path d="M13.4,1.43l9.35,11a4,4,0,0,1,0,5.18l-9.35,11a4,4,0,1,1-6.1-5.18L14.46,15,7.3,6.61a4,4,0,0,1,6.1-5.18Z"/>
                </svg>
            </div>
        </div>
        <p class="fs12 my2 light-gray no-margin">This title is not displayed in blod post; It is title used to identify the blog post in th adin section only</p>
    </div>
    <input type="text" id="post-title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter post title here") }}'>
</div>
<!-- post meta title & slug -->
<div id="meta-and-slug-section" class="typical-section-style mt4 none">
    <p class="fs12 mb2 light-gray no-margin">Meta title and slug are useful to <strong>improve SEO</strong> of blog post and ranking. By default, meta title and slug match the title, but you can edit them.</p>
    <div class="input-wrapper mb8">
        <label class="input-label dark fs13 my2" for="post-meta-title">Meta title<span class="error-asterisk red ml4">*</span></label>
        <input type="text" id="post-meta-title" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter meta title here (displayed by search engines and browser tab title)") }}'>
    </div>
    <div class="input-wrapper">
        <label class="input-label dark fs13 my2" for="post-slug">Slug<span class="error-asterisk red ml4">*</span></label>
        <input type="text" id="post-slug" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Enter slug here (e.g. 3-reasons-why-mouad-is-so-special)") }}'>
    </div>
</div>
<div id="content-input-box" class="flex flex-column input-wrapper" style="margin: 10px 0">
    <div>
        <label class="input-label dark fs14" for="content">Content<span class="error-asterisk red ml4">*</span></label>
        <p class="fs12 my2 light-gray no-margin">Summary will be taken from the first 55 words of the first paragraph by default. (you can update it in the right sidebar) </p>
    </div>
    <textarea id="post-content" class="styled-input" spellcheck="false" autocomplete="off" placeholder='Post content'></textarea>
</div>