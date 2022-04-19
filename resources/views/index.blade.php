@extends('layouts.app')

@section('title', 'Fibonashi - Welcome')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/index.js') }}" type="text/javascript" defer></script>
@endpush

@section('content')
    <section class="relative" id="welcome-image-container">
        <img src="{{ asset('assets/images/foggy.jpg') }}" id="welcome-image" alt="">
        <div id="above-welcome-section-container" class="relative">
            <div id="welcome-title-and-text-container">
                <h2 id="welcome-title">Simple and <span class="blue">collaborative</span> blogging plateform for enthusiast readers and writers.</h2>
                <p id="welcome-text">Where the internet is about the freedome and availability of information, this website aims to provide useful and valuable content and informations in different areas and make connection between readers and content writers much easier.</p>
                <a href="" class="discover-button">
                    <svg class="mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M129.93,253.53c-68-.07-123.6-55.81-123.42-123.74C6.69,61.7,62.5,6.13,130.34,6.48S253.4,62.05,253.49,129.91,197.89,253.6,129.93,253.53Zm.26-24.9A98.63,98.63,0,1,0,31.4,130.47,98.39,98.39,0,0,0,130.19,228.63ZM114.3,110.34a5.81,5.81,0,0,0-3.74,3.27C102.8,133.15,95,152.69,86.88,173.13l59.63-23.74a5.33,5.33,0,0,0,3-3.26c7.72-19.42,15.46-38.83,23.61-59.25C152.81,95,133.57,102.69,114.3,110.34Z"></path></svg>
                    <span class="bold">DISCOVER</span>
                </a>
            </div>
            <svg id="move-down-button" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M213,130.29c-.74,14.85,1.12,29.77-1.19,44.56A83.61,83.61,0,0,1,45.62,163.63q-.61-33.09,0-66.21c.73-42.86,34.7-79.25,76-81.86,45.51-2.89,83.35,26.67,90.23,70.65C214.11,100.83,212.27,115.6,213,130.29ZM192,133c0-13.07,0-23.53,0-34a58.62,58.62,0,0,0-1.55-13.6C183.13,54,154,32.83,123,36.39,90.16,40.18,66.48,66.51,66.38,99.5c-.06,20.6,0,41.21,0,61.82a71.46,71.46,0,0,0,.88,10.73c4.46,29.83,31.44,52.67,62.21,52.58,30.5-.09,57.34-23,61.64-52.63C193.09,158.16,191.37,144.23,192,133ZM139.73,79.82c-.09-7.5-4.16-12.19-10.46-12.24s-10.58,4.65-10.63,12.07q-.14,19.36,0,38.73c0,7.38,4.39,12.1,10.7,12,6.13-.1,10.26-4.69,10.39-11.83.11-6.37,0-12.74,0-19.12C139.75,92.89,139.81,86.36,139.73,79.82Z"/></svg>
        </div>
    </section>
    <section id="second-section">
        <h2 class="title">welcome to the <span class="blue">best</span> blog in the planet</h2>
        <p class="title-text">where one word is worth thousand images.</p>
        <div class="features-box">
            <div class="feature-box">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M14.74,123.92c14.61-14.63,28.88-29,43.27-43.21a6.74,6.74,0,0,1,4.38-1.54q67.49-.12,135,0a6.84,6.84,0,0,1,4.39,1.52c14.39,14.23,28.66,28.58,43.3,43.23L129.9,244.85ZM129.37,202l1.08-.13,22.82-68.54H106.48C114.18,156.45,121.78,179.22,129.37,202Zm-22.65-7.44.89-.49c-.49-1.63-.94-3.28-1.48-4.89Q98.26,165.58,90.38,142c-3-8.89-2.95-8.89-12.34-8.89H48.33C68.35,154.16,87.53,174.36,106.72,194.56Zm104.73-61.44c-13.29,0-25.36-.08-37.43.14-1,0-2.3,2-2.75,3.31q-9.28,27.38-18.33,54.85a40.2,40.2,0,0,0-.76,4.07ZM107.52,98.31l-.65-1.21c-6.67,0-13.34,0-20,0s-14-1.68-19.56.69c-5.77,2.45-9.86,8.9-14.66,13.63-1,.94-1.77,2-3.21,3.66,13.54,0,26,0,38.4,0a5.21,5.21,0,0,0,3.25-1C96.63,108.85,102.06,103.56,107.52,98.31Zm44.13-1.2c6.17,6.14,11.27,11.41,16.62,16.4a7.77,7.77,0,0,0,4.82,1.52c11.09.13,22.19.08,33.29,0,1.08,0,2.16-.22,4-.43-5.88-5.88-11.14-11.19-16.5-16.41a4.38,4.38,0,0,0-2.78-1.08C178.42,97.09,165.71,97.11,151.65,97.11Zm-34.42,17.67h25.46l-12.34-12.87C126,106.19,121.59,110.5,117.23,114.78Zm54.39-57.36,15.56,9,18-31.13-15.55-9Zm-50.43-7.31h17.46V14.68H121.19ZM72.61,66.42l15.56-9c-6.09-10.53-12-20.73-18-31.13l-15.56,9C60.75,45.9,66.63,56.06,72.61,66.42Z"/></svg>
                <h3 class="dark feature-title">Valuable Content</h3>
                <p class="feature-description">One of our sublime goals is to provide a useful and valuable content to our readers to increase the efficiency of our website.</p>
            </div>
            <div class="feature-box">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M15.35,185.87c1-17.64,8.56-31.13,23.81-39.92a5.67,5.67,0,0,0,3.29-5.08c2.44-28,15-50.16,38.22-66.13,2.37-1.63,2.64-3.41,2.65-5.92.13-24.13,17.56-43.25,42-46.19,22-2.66,43.73,13.11,49,35.77.68,2.87,1.46,5.94,1.1,8.78-.58,4.63,1.79,6.71,5.12,9.16,21.67,15.93,33.51,37.51,35.86,64.25a6.06,6.06,0,0,0,3.48,5.44c22.41,13,30.13,40.82,17.51,62.76-13,22.52-40.92,30-63.61,16.88a6.06,6.06,0,0,0-6.46-.27q-37.7,17.67-75.54.12a6.53,6.53,0,0,0-6.86.22c-15.45,8.73-31.24,8.9-46.55,0S16,203.07,15.35,185.87Zm142.26,24c-8.29-15.51-9.05-31.22-.23-46.64,8.91-15.59,23.13-22.72,41.1-23.47-2.55-20.6-11.91-36.71-28.38-49.09-9.58,15.51-22.92,24-40.64,24C111.58,114.66,98.22,106,88.9,91c-15.47,9.66-29.43,34.29-27.79,48.76,37.91,1.18,57.58,39.62,40.17,70.12C113.88,218.37,144.9,218.38,157.61,209.83Zm.18-141.42a28.35,28.35,0,1,0-28.17,28.53A28.57,28.57,0,0,0,157.79,68.41ZM62,157.78a28.32,28.32,0,0,0-.84,56.64c15.4.39,28.34-12.19,28.72-27.91C90.25,171.1,77.55,158,62,157.78ZM225.59,186.2a28.31,28.31,0,1,0-28.41,28.23A28.43,28.43,0,0,0,225.59,186.2Z"/></svg>
                <h3 class="dark feature-title">Collaborative</h3>
                <p class="feature-description">If you are a good blogger or you are passionate about writing, we provide the ability to share articles and posts to our visitors unlike the other blog websites.</p>
            </div>
            <div class="feature-box">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M154.55,236.55H137.66v-9.46c0-13.31.07-26.61-.06-39.91a5.26,5.26,0,0,1,3-5.33c5.21-2.91,10.39-5.92,15.32-9.27a7,7,0,0,0,2.76-4.86c.21-13.75.33-27.5,0-41.25-.32-15.53-11.57-28-26-29.5-15.28-1.55-28.66,7.67-32.29,22.39a32.34,32.34,0,0,0-.83,7.54c-.09,13.6-.14,27.2.07,40.8a6.92,6.92,0,0,0,2.76,4.81c5.09,3.38,10.55,6.21,15.69,9.52,1.27.81,2.68,2.62,2.69,4,.17,16.29.1,32.58.07,48.87a8.59,8.59,0,0,1-.38,1.57H104.18V222.55c0-8.82,0-17.64,0-26.45,0-2.54-5.66-7.55-8.6-7.73C92.91,188.21,89,192.71,89,196q0,17.7,0,35.42v5.07H72.38c-.1-1.43-.26-2.72-.26-4,0-14.8.07-29.59-.08-44.39,0-2.86.58-5,3.2-6.2,6.57-3.11,8-8.31,7.65-15.28-.58-12.83-.31-25.7-.07-38.55A9.47,9.47,0,0,0,79.14,120c-7.7-6.36-16.32-8-25.54-4.21s-14.49,11-14.85,21.08c-.38,10.75-.2,21.52-.06,32.28,0,1.36,1.29,2.72,2,4.06.12.24.47.36.7.54,4.56,3.6,10.87,6.33,13.17,11s.67,11.4.69,17.23c0,9.86,0,19.72,0,29.59v5H38.59V224c0-9.12-.1-18.24.06-27.35.06-2.82-.7-4.73-3.07-6.39-4.63-3.26-10.84-6-13.06-10.52-2.31-4.73-.76-11.39-.74-17.21,0-10-.85-20.16.51-30,4.16-30.07,36.89-45,62.79-29.13.76.47,1.5,1,2.55,1.62,9.4-15.85,23-25.07,41.61-25,18.47.06,32,9.17,40.92,24.33,6.18-2.27,12-5.3,18.08-6.49a40.75,40.75,0,0,1,48.62,38.81c.46,13.59.17,27.2,0,40.8a6,6,0,0,1-2.06,4c-3.68,3.05-7.51,5.93-11.45,8.62A7,7,0,0,0,220,196.7c.19,13.14.08,26.28.08,39.74H203.46c-.07-1.41-.2-2.85-.2-4.3,0-14.64.06-29.29-.07-43.94,0-2.83.73-4.67,3.1-6.33,4.64-3.25,10.81-6,13-10.55,2.3-4.74.72-11.39.76-17.21s.11-11.36,0-17a24.22,24.22,0,0,0-42.13-15.33,10,10,0,0,0-2.26,6c-.19,14.8,0,29.59-.17,44.39,0,2.87.68,5,3.26,6.22,6.77,3.32,8.43,8.67,8,16-.67,12.36-.18,24.8-.18,37.2v5H169.73v-4.72c0-12,0-23.92,0-35.87,0-5.87-5-8.4-10.22-5.9-4.19,2-5.15,4.77-5.05,9.11C154.74,211.53,154.55,223.9,154.55,236.55ZM129.16,71.87a25.16,25.16,0,1,0-25-25.11A25.19,25.19,0,0,0,129.16,71.87Zm8.45-25.14a8.29,8.29,0,1,1-8.15-8.28A8.13,8.13,0,0,1,137.61,46.73ZM169.75,63.9a25.16,25.16,0,1,0,50.31-.74,25.16,25.16,0,0,0-50.31.74ZM195,55.16a8.35,8.35,0,1,1-8.33,8.19A8.25,8.25,0,0,1,195,55.16ZM63.74,88.78A25.48,25.48,0,0,0,89,63.32a25.21,25.21,0,0,0-25.68-24.9A24.89,24.89,0,0,0,38.64,63.74,25.2,25.2,0,0,0,63.74,88.78Zm-.23-16.93a8.39,8.39,0,0,1-8.14-8.34A8.47,8.47,0,0,1,64,55.16a8.35,8.35,0,0,1-.48,16.69Z"/></svg>
                <h3 class="dark feature-title my8">Interactivity</h3>
                <p class="feature-description">Our website provide a simple interface between content writers and readers to improve the interactivity and trust.</p>
            </div>
        </div>
    </section>
    <div style="height: 800px">
        <p>Next</p>
    </div>
@endsection