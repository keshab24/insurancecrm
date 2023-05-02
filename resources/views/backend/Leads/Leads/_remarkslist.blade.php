<div class="remarks_list">
@foreach($remarks as $remark)
<?php  $tempdata=$remark ?>
        @include('leads::Leads._remarkssingle')
 @endforeach

</div>

