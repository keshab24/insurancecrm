@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Draft Policies</p>
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
{{--        <div class="text-right mr-3">--}}
{{--            <a class="btn btn-primary btn-sm" href="{{route('nonLife.calculator.policy.view',['download'=>1])}}">Download Excel</a>--}}
{{--        </div>--}}
        @include('layouts.backend.alert')
        <div class="box-body">
            <table id="policy-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Agent Name</th>
                    <th>Customer</th>
                    <th>Customer Contact</th>
                    <th>Type</th>
                    <th>Sum Insured</th>
                    <th>Vehicle No</th>
                    <th>Paid Amount</th>
                    <th>Transaction Date</th>
                    <th>Status</th>
                    <th>Proceed</th>
                </tr>
                </thead>
                <tbody id="tablebody">
                @foreach($policies as $index=>$policy)
                    <tr class="gradeX" id="row_{{ $policy->id }}">
                        <td>
                            <b># DP-{{ $policy->id }}</b>
                        </td>
                        <td>
                            {{ $policy->agent->username??''  }} / {{ $policy->agent->phone_number ??''  }} / {{ $policy->agent->email ??''  }}
                        </td>
                        <td>
                            {{ $policy->customer->INSUREDNAME_ENG ?? '' }}
                        </td>
                        <td>
                            {{ $policy->customer->MOBILENO ?? '' }} /  {{ $policy->customer->EMAIL ?? '' }} /  {{ $policy->customer->ADDRESS ?? '' }}
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
                            <ul>
                                <li>
                                    Rs. {{number_format($policy->TOTALNETPREMIUM, 2, '.', ',')}}
                                </li>
                                <li>Ref. No : {{$policy->payment_ref_id ?? 'N/A'}}</li>
                            </ul>
                        </td>
                        <td>
                            {{$policy->created_at->format('d/M/Y')}}
                        </td>
                        <td>@if($policy->status == 1) Payment Successful @elseif($policy->status == 2) Payment Error @else Pending @endif</td>
                        @php
                            $policyDet = json_decode($policy->output);
                        @endphp
                        <td>
                            @if (Auth::user()->role_id == 1)
                                N/A
                            @else
                            @if($policy->status == 1)
                                {{--Payment Successful--}}
                                <form action="{{(route('nonLife.calculator.make.draft.policy'))}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reference_number" value="{{$policy->payment_ref_id}}">
                                    <input type="hidden" name="policy_id" value="{{$policy->id}}">
                                    <input type="hidden" name="status" value="{{$policy->status}}">
                                    <button type="submit" class="btn btn-primary">Make Policy</button>
                                </form>
                            @elseif($policy->status == 2 || $policy->status == 0)
                                {{--Payment Error--}}
{{--                                N/A--}}
                                    <form action="{{(route('nonLife.calculator.make.draft.policy'))}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="reference_number" value="{{$policy->payment_ref_id}}">
                                        <input type="hidden" name="policy_id" value="{{$policy->id}}">
                                        <input type="hidden" name="status" value="{{$policy->status}}">
                                        <button type="submit" class="btn btn-secondary btn-sm">Proceed to Payment</button>
                                    </form>
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
