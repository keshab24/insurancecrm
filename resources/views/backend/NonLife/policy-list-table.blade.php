<table>
    <thead>
    <tr>
        <th><b>No.</b></th>
        <th><b>Policy No.</b></th>
        <th><b>Agent Name</b></th>
        <th><b>Agent Number</b></th>
        <th><b>Customer Name</b></th>
        <th><b>Customer Number</b></th>
        <th><b>Customer email</b></th>
        <th><b>Type</b></th>
        <th><b>Sum Insured</b></th>
        <th><b>Vehicle No</b></th>
        <th><b>Paid Amount</b></th>
        <th><b>Transaction Date</b></th>
        <th><b>Policy Details</b></th>
        <th><b>Status</b></th>
    </tr>
    </thead>
    <tbody id="tablebody">
    @foreach($policies as $index=>$policy)
        <tr class="gradeX" id="row_{{ $policy->id }}">
            <td>
                <b># {{ $loop->iteration }}</b>
            </td>
            <td>
                <b> {{ $policy->reference_number }}</b>
            </td>

            <td>
                {{ $policy->agent->username ?? ''  }}
            </td>
            <td>
                {{ $policy->agent->phone_number ?? ''  }}
            </td>
            <td>
                {{ $policy->customer->customer_name ?? '' }}
            </td>
            <td>
                {{ $policy->customer->phone ?? '' }}
            </td>
            <td>
                {{ $policy->customer->email ?? '' }}
            </td>
            <td>
                {{$policy->TYPECOVER}}
            </td>
            <td>
                Rs. {{number_format($policy->EXPUTILITIESAMT, 2, '.', ',')}}
            </td>
            <td>
                {{$policy->VEHICLENO}}
            </td>
            <td>
                Rs. {{number_format($policy->PAIDAMT, 2, '.', ',')}}
            </td>
            <td>
                {{$policy->TRANS_DATE}}
            </td>
            @php
                $policyDet = json_decode($policy->output);
            @endphp
            <td>{{$policyDet[0]->policyNo ?? 'N/A'}}
                {{--                <ul>--}}
{{--                    @if(is_array($policyDet))--}}
{{--                        @foreach($policyDet[0] as $key=>$ot)--}}
{{--                            <li>{{$key.' : '.$ot}}</li>--}}
{{--                        @endforeach--}}
{{--                    @else--}}
{{--                        {{$policy->output}}--}}
{{--                    @endif--}}

{{--                </ul>--}}
            </td>
            <td>@if($policy->status == 1) Payment Successful @elseif($policy->status == 2) Payment Error @else
                    Pending @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
