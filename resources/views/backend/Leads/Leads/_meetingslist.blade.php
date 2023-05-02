<div class="meetings_list">
        @foreach($remarks as $remark)
        <?php  $tempdata=$remark ?>
        <div class="remark_single_item" id="remarks_lead_{{$tempdata->id}}">
                <div class="remark_title">
                {{$tempdata->title}}
                </div>
                <small>created at:</small>
                {{$tempdata->created_at}}
                <small>Meeting date:</small>
                {{$tempdata->start}}
                
                </div>
                
         @endforeach
        
        </div>
        
        