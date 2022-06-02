@if(Session::has('message'))
    <div class="informative-message-container align-center relative my8">
        <div class="informative-message-container-left-stripe imcls-green"></div>
        <div class="no-margin fs13 message-text">{!! Session::get('message') !!}</div>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
@endif
@if(Session::has('errors'))
    <div class="informative-message-container align-center relative my8">
        <div class="informative-message-container-left-stripe imcls-red"></div>
        <div class="no-margin fs13 message-text">{!! Session::get('errors')->first() !!}</div>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
@endif
@if(Session::has('error'))
    <div class="informative-message-container align-center relative my8">
        <div class="informative-message-container-left-stripe imcls-red"></div>
        <div class="no-margin fs13 message-text">{!! Session::get('error') !!}</div>
        <div class="close-parent close-informative-message-style">✖</div>
    </div>
@endif