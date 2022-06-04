<tr class="report-component">
    <td class="report-bulk-selection-column">
        <label for="report-selection-input-{{ $report->id }}" class="report-selection-label">
            <input type="checkbox" id="report-selection-input-{{ $report->id }}" class="report-selection-input" value="{{ $report->id }}" autocomplete="off">
        </label>
    </td>
    <td class="resource-reported-column">
        @switch($report->resource_type)
            @case('Comment')
                @if(!$resource)
                    <div class="full-dimensions full-center my8">
                        <svg class="size13 mr8" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <span class="fs13 light-gray">Comment is not available. (It could be deleted or purged by admins)</span>
                    </div>
                @else
                    <div>
                        <div class="align-center space-between">
                            <div class="meta fs11">reported : {{ $report->date_humans }} 〡 {{ $report->date }}</div>
                            <!-- mark as review/unreview -->
                            <div>
                                <div class="button-style-5 review-report review-button @if($report->reviewed) none @endif">
                                    <div class="relative size11 mr6">
                                        <svg class="size11 flex icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                        <svg class="spinner size11 opacity0 absolute" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="fs12 dark">mark as reviewed</span>
                                    <input type="hidden" class="report-id" value="{{ $report->id }}" autocomplete="off">
                                    <input type="hidden" class="status" value="1" autocomplete="off">
                                </div>
                                <div class="button-style-5 review-report unreview-button @if(!$report->reviewed) none @endif">
                                    <div class="relative size11 mr6">
                                        <svg class="size11 flex icon" fill="#2ca82c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z"/></svg>
                                        <svg class="spinner size11 opacity0 absolute green" style="top: 0; left: 0" fill="none" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-opacity="0.25" stroke-width="2" vector-effect="non-scaling-stroke"></circle>
                                            <path d="M15 8a7.002 7.002 0 00-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path>
                                        </svg>
                                    </div>
                                    <span class="fs12 green">report reviewed</span>
                                    <input type="hidden" class="report-id" value="{{ $report->id }}" autocomplete="off">
                                    <input type="hidden" class="status" value="0" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="dark fs13 lh15 mt4"><span class="black bold">comment</span> : {{ $resource->content }}</div>
                        <div class="align-center">
                            <a href="{{ route('admin.comments.manage', ['comment'=>$resource->id]) }}" target="_blank" class="fs11 dark-blue no-underline">manage</a>
                        </div>
                    </div>
                @endif
            @break
        @endswitch
    </td>
    <td class="resource-type-column">{{ $report->resource_type }}</td>
    <td class="report-type-column">{{ $report->htype }}</td>
    <td class="reporter-column">
        @if($report->report_user)
        <a href="{{ route('admin.users.management', ['user'=>$report->report_user->username]) }}" target="_blank" class="align-center no-underline dark">
            <img src="{{ $report->report_user->avatar(100) }}" class="size36 mr8" alt="">
            <div>
                <p class="no-margin bold">{{ $report->report_user->fullname }}</p>
                <p class="no-margin mt2 fs12">{{ $report->report_user->username }}</p>
            </div>
        </a>
        @else
        <span>Reporter not available</span>
        @endif
    </td>
</tr>