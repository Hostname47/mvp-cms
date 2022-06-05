@extends('layouts.admin')

@section('title', 'Admin - Reports')

@push('scripts')
<script src="{{ asset('js/admin/reports.js') }}" type="text/javascript" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/reports.css') }}">
@endpush

@section('left-panel')
    @include('partials.admin.left-panel', ['page'=>'reports.management'])
@endsection

@section('content')
<main class="flex flex-column">
    <div class="admin-top-page-box">
        <div class="align-center">
            <svg class="size20 mr8" style="margin-top: 1px;" fill="#202224" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M204.49,43.44A15.74,15.74,0,0,0,198,44.87c-15.45,7.05-26.9,9.45-36.45,9.45-20.27,0-32.06-10.78-55.42-10.78-11.71,0-26.33,2.71-46.39,10.84V51.55a8.13,8.13,0,0,0-16.25,0v156.9a8.12,8.12,0,0,0,16.23,0V173.28c18.12-8.07,32.47-10.75,44.9-10.75,24.9,0,42.24,10.74,67.16,10.74,10.79,0,23-2,37.56-7.81a10.46,10.46,0,0,0,7.27-9.73V53.83C216.56,47.19,210.92,43.44,204.49,43.44Zm-4.16,108.13c-10.25,3.66-19.64,5.45-28.6,5.45-10.42,0-19.72-2.37-29.57-4.88-10.82-2.75-23.09-5.87-37.57-5.87-14.32,0-29.07,3.07-44.9,9.38V71.89l6.09-2.47c16-6.49,29.21-9.65,40.31-9.65,9.55,0,16.61,2.27,24.79,4.9,8.58,2.75,18.3,5.88,30.63,5.88,12,0,24.42-2.88,38.85-9v90Z" style="stroke:#000;stroke-miterlimit:10;stroke-width:9px"></path></svg>
            <h1 class="fs20 dark no-margin">Resources Reports</h1>
        </div>
        <div class="align-center height-max-content">
            <a href="{{ route('admin.dashboard') }}" class="blue-link align-center">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 260"><path d="M67,14.45c13.12,0,26.23,0,39.35,0C115.4,14.48,119,18,119,26.82q.06,40.09,0,80.19c0,8.67-3.61,12.29-12.23,12.31q-40.35.06-80.69,0c-8.25,0-11.92-3.74-11.93-12.11q-.08-40.33,0-80.68c0-8.33,3.69-12,12-12.06C39.74,14.4,53.35,14.45,67,14.45Zm-31.92,52c0,9.52.11,19-.06,28.56-.05,2.78.73,3.53,3.51,3.52q28.08-.2,56.14,0c2.78,0,3.54-.74,3.52-3.52q-.18-28.06,0-56.14c0-2.78-.73-3.53-3.52-3.52q-28.06.2-56.13,0c-2.78,0-3.58.73-3.52,3.52C35.16,48,35.05,57.2,35.05,66.4Zm157.34,52.94c-13.29,0-26.57,0-39.85,0-8.65,0-12.29-3.63-12.3-12.24q-.06-40.35,0-80.69c0-8.25,3.75-11.91,12.11-11.93q40.35-.06,80.69,0c8.33,0,12,3.7,12.05,12q.07,40.35,0,80.69c0,8.58-3.67,12.15-12.36,12.18C219.28,119.37,205.83,119.34,192.39,119.34Zm.77-84c-9.52,0-19,.1-28.56-.07-2.78,0-3.54.73-3.52,3.52q.18,28.07,0,56.14c0,2.77.73,3.53,3.52,3.52q28.07-.2,56.13,0c2.78,0,3.54-.73,3.52-3.52q-.18-28.06,0-56.14c0-2.77-.73-3.57-3.51-3.52C211.55,35.48,202.35,35.37,193.16,35.37ZM66.23,245.43c-13.29,0-26.57,0-39.85,0-8.62,0-12.22-3.64-12.24-12.31q-.06-40.09,0-80.19c0-8.7,3.59-12.34,12.19-12.35q40.33-.08,80.68,0c8.3,0,12,3.72,12,12.06q.07,40.33,0,80.68c0,8.52-3.73,12.09-12.43,12.12C93.12,245.46,79.67,245.43,66.23,245.43ZM98.1,193c0-9.35-.11-18.71.06-28.07,0-2.79-.74-3.53-3.52-3.51q-28.06.18-56.14,0c-2.78,0-3.53.74-3.51,3.52q.18,28.07,0,56.13c0,2.79.74,3.54,3.52,3.52q28.07-.18,56.13,0c2.79,0,3.57-.74,3.52-3.52C98,211.7,98.1,202.34,98.1,193Zm94.34,52.42a52.43,52.43,0,1,1,52.64-52.85A52.2,52.2,0,0,1,192.44,245.4Zm31.75-52.17a31.53,31.53,0,1,0-31.9,31.28A31.56,31.56,0,0,0,224.19,193.23Z"></path></svg>
                <span class="fs13 bold">{{ __('Dashboard') }}</span>
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="flex align-center">
                <span class="fs13 bold">{{ __('Resources reports') }}</span>
            </div>
        </div>
    </div>
    <div class="admin-page-content-box">
        <p class="dark my12 fs13">The following resources got reports from community for guidelines and rules violations.</p>
        <div class="flex space-between mb4">
            <div class="relative">
                <div class="button-with-suboptions typical-button-style white-bs align-center">
                    <span class="unselectable fs12">Bulk Actions</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"></path></svg>
                </div>
                <div class="suboptions-container typical-suboptions-container width-max-content">
                    <div class="suboption-style-2 align-center mb2 review-reports-bulk">
                        <svg class="spinner size12 mr6 none" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span>Mark as reviewed</span>
                        <input type="hidden" class="state" autocomplete="off" value="1">
                    </div>
                    <div class="suboption-style-2 align-center mb2 review-reports-bulk">
                        <svg class="spinner size12 mr6 none" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span>Mark as Unreviewed</span>
                        <input type="hidden" class="state" autocomplete="off" value="0">
                    </div>
                    <div class="suboption-style-2 align-center delete-reports-bulk">
                        <svg class="spinner size12 mr6 red none" fill="none" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                        </svg>
                        <span class="red">Delete</span>
                        <input type="hidden" class="action" autocomplete="off" value="trash">
                    </div>
                </div>
            </div>
            {{ $reports->appends(request()->query())->onEachSide(0)->links() }}
        </div>
        @include('partials.session-messages')
        <table id="reports-box">
            <thead>
                <tr>
                    <th class="report-bulk-selection-column">
                        <input type="checkbox" id="bulk-select-all-reports" autocomplete="off">
                    </th>
                    <th class="resource-reported-column">Resource Reported</th>
                    <th class="resource-type-column">Resource type</th>
                    <th class="report-type-column">Report Type</th>
                    <th class="reporter-column">Reported by</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <x-admin.report.report-component :report="$report" />
                @endforeach
                <tr id="no-reports-row" class="@if($reports->count()) none @endif">
                    <td colspan="5" class="full-height">
                        <div class="full-dimensions full-center my8">
                            <svg class="size13 mr8" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                            <span class="fs13">There's no reports for the moment.</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="full-center my12">
            {{ $reports->appends(request()->query())->onEachSide(0)->links() }}
        </div>
    </div>
</main>
@endsection