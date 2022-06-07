@extends('layouts.app')

@section('title', 'Fibonashi - Guidelines')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/guidelines.css') }}">
@endpush

@section('content')
    <x-layout.left-panel.left-panel page="guidelines"/>
    <div id="about-main" class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('guidelines') }}" class="page-path">
                <span>{{__('Guidelines')}}</span>
            </a>
        </div>
        <h1 class="title-style text-center">{{ __('Guidelines') }}</h1>
        <div class="full-center">
            <em class="quote-after-title">{{__('Fibonashi; A directory of wonderful things')}}.</em>
        </div>

        <div id="guidelines-main">
            <h2 class="no-margin">{{__('INTRODUCTION')}}</h2>
            <p class="text bordered-guideline">
                {{ __("Our website is intended to be a place where people get quality content and usful informations and knowledge in miscellaneous categories. The rules which govern this website have been implemented to protect both the website and its users. Please make yourself familiar with these rules. Members of the Fibonashi's team and Moderators are in the response on a regular basis, and we will enforce these rules whenever necessary") }}.
            </p>
            <h2 class="no-margin">I. {{ __('Rules & Guidelines') }}</h2>
            <div style='margin-left: 16px'>
                <p><b>1.</b> {{ __('Respect authors effort by giving respectful comments and positive impact') }}.</p>
                <p><b>2.</b> {{ __('Make sure to be always a useful member by provide good feedbacks') }}.</p>
                <p><b>3.</b> {{ __("The moderators have the right to delete, edit or move any comment or reply that is in violation of the laws and conditions") }}.</p>
                <p><b>4.</b> {{ __("Links to other websites or products are not allowed") }}.</p>
                <p><b>5.</b> {{ __("Criticism is welcome, but without prejudice or intolerance") }}.</p>
                <p><b>6.</b> {{ __("If you notice something that does not respect our guidelines, please do not hesitate to contact us") }}.</p>
                <div class="simple-line-separator my8"></div>
                <div>
                    <p>{{ __("We confirm what has been mentioned and we wish all our dear visitors to comply. And always remember") }}:</p>
                    <ul>
                        <li class="my8">{{ __("Your participation is a reflection of your personality") }}.</li>
                        <li class="my8">{{ __("Accepting the other opinion is proof that you are a modern person in the truest sense of the word") }}.</li>
                        <li class="my8">{{ __("Your opinion is as valid and wrong as others") }}.</li>
                        <li class="my8">{{ __("These laws were established only to preserve the good relationship of members with each other and to raise the level of our community and It is subject to change and modification if necessary") }}.</li>
                        <li class="my8">{{ __("And when there is any suggestion or problem, please go to the contact section and we'll always be happy to reply") }}.</li>
                    </ul>
                </div>
            </div>
            <h2 class="no-margin">II. {{ __('Items that may result in immediate ban') }}</h2>
            <p>{{ __("Because we provide a beautiful comment section that is developed to create a great sense of community, we like to inform our visitors that the following actions could close and ban your account permanently") }} :</p>
            <div style="margin-left: 16px">
                <div class="simple-line-separator my8"></div>
                <p class="no-margin bold text">{{__('SPAM')}}</p>
                <p class="text mt4">{{ __("Spamming or flooding maliscious links or websites, in which a user posts the same message repeatedly, is prohibited and you will be banned") }}.</p>
                <div class="simple-line-separator my8"></div>
                <p class="no-margin bold text">{{ __("Touts / Advertising / Commerce") }}</p>
                <p class="text mt4">{{ __("Our website will not be used as a place to do your personal business. Phone numbers, home addresses, email addresses that are found in any place other than Website Promotions, will be deleted. Touts involving twitter or Facebook redirects will also result in the user being banned. If you are promoting a service or a product in any website (including that of a ‘bookie’) other than Website Promotions, your account may be suspended or banned at the discretion of our Moderators and Support team") }}.</p>
                <div class="simple-line-separator my8"></div>
                <p class="no-margin bold text">{{ __("Links to External Sites") }}</p>
                <p class="text mt4">{{ __("Links to informational sites or informative articles such as those found on websites that include useful informations are permitted but links to personal sites (Facebook), personal spaces, websites, pick services, and sites solely designed for advertising/commerce are not permitted. If you are unsure if your link is permitted, check with a Support or a moderator first") }}.</p>
            </div>
            <h2 class="no-margin fs17 mb4">III. {{ __('Other Rules') }}</h2>
            <div style="margin-left: 16px">
                <p class="no-margin text my8"><b>1. {{ __("Images") }}</b>: {{ __("Any avatar you're using or URLs containing nudity, pornography, or sexually explicit attire (e.g., bikinis/lingerie) are NOT permitted in our website and will be removed (may cause your account to be banned). This includes, but is not limited to") }}:</p>
                <div class="ml8">                                    
                    <p class="text no-margin">1-1. {{ __("Strategically covered nudity") }}</p>
                    <p class="text no-margin">1-2. {{ __("Sheer or see-through clothing") }}</p>
                    <p class="text no-margin">1-3. {{ __("Lewd or provocative poses") }}</p>
                    <p class="text no-margin">1-4. {{ __("Close-ups of breasts, buttocks or crotches") }}</p>
                </div>
                <p class="text no-margin">{{ __("Avatars are reviewed by our team – if they are deemed inappropriate, they will be removed. If users continue to upload avatars that violate these guidelines, the user will be banned") }}.</p>
                <p class="text my8"><b>2.</b> {{ __("Slanderous comments and replies are not allowed. If a comment is deemed slanderous, the post may be deleted or moved to the penalty box") }}.</p>
                <p class="text my8"><b>3.</b> {{ __("Any obvious site promotions will be assumed to be meant for the promotions area, and will be moved there if not deleted. Any other off-topic comment will be removed") }}.</p>
                <p class="text my8"><b>4.</b> {{ __("Intentionally repetitive comments or replies posted by the same user may be locked, deleted, or consolidated") }}.</p>
                <p class="text my8"><b>6.</b> {{ __("If you have nothing positive to offer our website and are only posting insults, attacks, and/or emoticons, you will be warned, suspended, and/or banned from the website permanently") }}.</p>
            </div>
            <h2 class="no-margin fs17 mb4">IV. {{ __('General Guidelines of Behavior') }}</h2>
            <div style="margin-left: 16px">
                <p class="text my8">{{ __("Our website is only enjoyable for our members as long as everyone plays fair. Therefore, we have come up with a few basic guidelines that we expect all of our users to agree to and respect. We are counting on our dear members to do a lot of self-policing to ensure that guidelines are being followed. Respecting these guidelines will keep the website vibrant, useful, and enjoyable") }}!</p>
                <p class="text my8">{{ __("If you notice a member behaving in a way that is a direct violation of the rules and spirit of the website, please let us know via the contact and feedback page. If this member’s attitude is not violating the rules but is ruining your experience in the website, please consider ignoring them as opposed to engaging in an online battle") }}.</p>
                <p class="text my8">{{ __("With regards to slanderous comments/replies: as mentioned above, we will be notifying members if we deem a post to be unsubstantiated and slanderous. Once a post has been deemed slanderous, it will either be deleted or moved to the Penalty Box") }}.</p>
                <p class="text my8">{{ __("Try to be civil! We know that this can be difficult if someone is being rude and disruptive. However, we also know that nobody wants to read a page full of arguments, either. Please try to maintain a sense of dignity. Refusing to engage in rude or disruptive behavior also shows a lot of class") }}.</p>
                <p class="text my8">{{ __("If you have a good idea about ways to improve the website, let us know in the contact page! We participated in the creation of this site, and we plan to add new features from time to time so feedback from our users is definitely welcome") }}.</p>
            </div>
            <h2 class="no-margin fs20 mb4">{{ __('The Legal Stuff') }}</h2>
            <p id="legal-stuff">
                {{ __("All of the information contained inside this website represents the personal thoughts and opinions of the authors and members. Submissions to this website are not reflective of the thoughts and opinions of our website, nor its employees. Our website and its employees do not endorse or represent any of the opinions within the blog, and shall not be held responsible in any legal action resulting from any of the content contained within the website. Furthermore, our website shall not be responsible for keeping a permanent record of the opinions expressed within it, and we may delete or edit submissions to the website at our discretion if deemed necessary") }}.
            </p>
            <div class="full-center" style="margin: 20px 0">
                <em id="conclusion">
                    {{ __("In conclusion, we would like to point out to all members that all of this was only set for the service of keep the website organized and preserve the great sense of community. We hope that you will abide by these laws and take them seriously and understand them as we promised you") }}.
                </em>
            </div>
        </div>
    </div>
@endsection