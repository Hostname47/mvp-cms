@extends('layouts.app')

@section('title', 'Fibonashi - Privacy Policy')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/left-panel.css') }}">
<link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
@endpush

@section('content')
    <x-layout.left-panel.left-panel page="privacy" />
    <div id="about-main" class="page-padding">
        <div class="page-path-wrapper align-center">
            <a href="{{ route('root.slash') }}" class="align-center page-path">
                <span>{{__('Home')}}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"></path></svg>
            <a href="{{ route('privacy') }}" class="page-path">
                <span>{{__('Privacy Policy')}}</span>
            </a>
        </div>
        <h1 class="title-style text-center">{{ __('Privacy Policy') }}</h1>
        <div class="full-center">
            <em class="quote-after-title">{{__('When you use our website, that means you’re trusting us')}}.</em>
        </div>

        <div id="privacy-main">
            <p>{{__('One of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by our website and how we use it')}}.</p>
            <p>{{__('If you have additional questions or require more information about our Privacy Policy, do not hesitate to')}} <a href="{{ route('contact') }}" class="link-path">{{__('contact us')}}</a>.</p>

            <p>{{__('This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in our website. This policy is not applicable to any information collected offline or via channels other than this website')}}.</p>

            <h2>{{__('Consent')}}</h2>

            <p>{{__('By using our website, you hereby consent to our Privacy Policy and agree to its terms')}}.</p>

            <h2 id="data-we-collect">{{__('Information we collect')}}</h2>

            <p>{{ __("The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information") }}.</p>
            <p>{{__("If you contact us directly, we may receive additional information about you such as your name, email address, and the contents of the message with any other information you may choose to provide")}}.</p>
            <p>{{__("When you register for an Account using one of your social media accounts, we may ask for your contact information, including items such as full name, email address, and your avatar")}}.</p>

            <h2>{{__("How we use your information")}}</h2>

            <p>{{__('We use the information we collect in various ways, including')}}:</p>

            <ul>
                <li>{{__('Provide, operate, and maintain our website')}}</li>
                <li>{{__('Improve, personalize, and expand our website')}}</li>
                <li>{{__('Understand and analyze how you use our website')}}</li>
                <li>{{__('Develop new features, services, and functionalities')}}</li>
                <li>{{__('Send you emails')}}</li>
                <li>{{__('Find and prevent fraud')}}</li>
            </ul>

            <h2 id="cookies-and-beacons">{{__('Cookies and Web Beacons')}}</h2>
            <p>{{__("Like any other website, Fibonashi website uses 'cookies'. These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information")}}.</p>

            <h2>{{__('Our Advertising Partners')}}</h2>
            <p>{{__("Some of advertisers on our site may use cookies and web beacons. Our advertising partners are listed below. Each of our advertising partners has their own Privacy Policy for their policies on user data. For easier access, we hyperlinked to their Privacy Policies below")}}.</p>

            <ul>
                <li>
                    <p>Google</p>
                    <p><a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a></p>
                </li>
            </ul>

            <h2>{{__('Advertising Partners Privacy Policies')}}</h2>

            <P>{{__("You may consult this list to find the Privacy Policy for each of the advertising partners of our website")}}.</p>

            <p>{{__("Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on the website, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit")}}.</p>

            <p>{{__("Note that we have no access to or control over these cookies that are used by third-party advertisers")}}.</p>

            <h2>{{__("Third Party Privacy Policies")}}</h2>

            <p>{{__("Our Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options")}}.</p>

            <p>{{__("You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites")}}.</p>

            <h2>{{__("CCPA Privacy Rights (Do Not Sell My Personal Information)")}}</h2>

            <p>{{__("Under the CCPA, among other rights, California consumers have the right to")}}:</p>
            <p>{{__("Request that a business that collects a consumer's personal data disclose the categories and specific pieces of personal data that a business has collected about consumers")}}.</p>
            <p>{{__("Request that a business delete any personal data about the consumer that a business has collected")}}.</p>
            <p>{{__("Request that a business that sells a consumer's personal data, not sell the consumer's personal data")}}.</p>
            <p>{{__("If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us")}}.</p>
        </div>
    </div>
@endsection