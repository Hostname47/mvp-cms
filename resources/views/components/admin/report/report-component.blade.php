<tr>
    <td class="resource-reported-column">
        @switch($report->resource_type)
            @case('Comment')
                @if(!$resource)
                    <div class="full-dimensions full-center my8">
                        <svg class="size13 mr8" style="min-width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <span class="fs13">Comment is not available. (It could be deleted or purged by admins)</span>
                    </div>
                @else
                    <div>
                        <div class="bold dark fs12 lh15"><span class="black">comment</span> : {{ $resource->content }}</div>
                    </div>
                @endif
            @break
        @endswitch
    </td>
    <td class="resource-type-column">{{ $report->resource_type }}</td>
    <td class="report-type-column">{{ $report->htype }}</td>
    <td class="reporter-column">
        @if($report->report_user)
        <a href="{{ route('admin.users.management', ['user'=>$report->report_user->username]) }}" class="align-center no-underline dark">
            <img src="{{ $report->report_user->avatar(100) }}" class="size36 mr8" alt="">
            <div>
                <p class="no-margin bold">{{ $report->report_user->fullname }}</p>
                <p class="no-margin mt4 fs12">{{ $report->report_user->username }}</p>
            </div>
        </a>
        @else
        <span>Reporter not available</span>
        @endif
    </td>
</tr>