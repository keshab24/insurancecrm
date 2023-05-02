@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Policies</p>
@endsection
@section('footer_js')
    <!-- formValidation -->
    <script src="{{ asset('backend/js/formValidation/formValidation.min.js') }}"></script>
    <script src="{{ asset('backend/js/formValidation/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var oTable = $('#policy-table').dataTable( {
                "ordering": false,
                "scrollX": true
            });
        });
    </script>
@endsection
@section('dynamicdata')


    <div class="box">
        <div class="text-right mr-3">
            <a class="btn btn-primary btn-sm" href="{{route('nonLife.calculator.policy.view',['download'=>1])}}">Download Excel</a>
        </div>
        @include('layouts.backend.alert')
        <div class="box-body">
            <table id="policy-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Reference No.</th>
                    <th>Policy No.</th>
                    <th>Agent Details</th>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Sum Insured</th>
                    <th>Vehicle No</th>
                    <th>Paid Amount</th>
                    <th>Transaction Date</th>
                    {{--   <th>Policy Details</th>--}}
                    <th>Status</th>
                    <th>PDF Download</th>
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
                           {{ $policy->reference_number }}
                        </td>

                        <td>
                            <ul style="list-style: none">
                                <li><b>Name:</b> {{ $policy->agent->username ?? ''  }}</li>
                                <li><b>Contact:</b> {{ $policy->agent->phone_number ?? ''  }}</li>
                            </ul>
                        </td>
                        <td>
                            <ul style="list-style: none">
                                <li><b>Name:</b> {{ $policy->customer->customer_name ?? '' }}</li>
                                <li><b>Contact:</b> {{ $policy->customer->phone ?? '' }} <br>  {{ $policy->customer->email ?? '' }}</li>
                            </ul>

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
                        {{--                        <td>--}}
                        {{--                            <ul>--}}
                        {{--                                @if(is_array($policyDet))--}}
                        {{--                                    @foreach($policyDet[0] as $key=>$ot)--}}
                        {{--                                        <li>{{$key.' : '.$ot}}</li>--}}
                        {{--                                    @endforeach--}}
                        {{--                                @else--}}
                        {{--                                    {{$policy->output}}--}}
                        {{--                                @endif--}}

                        {{--                            </ul>--}}
                        {{--                        </td>--}}
                        <td>@if($policy->status == 1) Payment Successful @elseif($policy->status == 2) Payment Error @else Pending @endif</td>
                        <td>
                            @if(is_array($policyDet))
                                <form action="{{route('nonLife.calculator.pdf.load')}}" method="GET"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="docid" value="{{$policyDet[0]->AcceptanceNo ?? '0'}}">
                                    <input type="hidden" name="proformano" value="{{$policyDet[0]->proformano ?? '0'}}">
                                    <button class="btn btn-primary btn-sm" type="submit">Pdf Download</button>
                                </form>
                                @else
                                @if($policy->status == 1)
                                    {{--Payment Successful--}}
                                N/A
                                    {{--<form action="{{(route('nonLife.calculator.make.draft.policy'))}}" method="POST">
                                        @csrf
                                        <label>{{$policy->output}}</label>
                                        <input type="hidden" name="reference_number" value="{{$policy->payment_ref_id}}">
                                        <input type="hidden" name="policy_id" value="{{$policy->id}}">
                                        <button type="submit" class="btn btn-secondary btn-sm">Make Policy</button>
                                    </form>--}}
                                    @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@stop
