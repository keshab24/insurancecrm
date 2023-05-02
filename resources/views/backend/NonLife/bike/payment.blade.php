@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Motor Calculation Result</p>
@endsection
<style>
    .calculation-nav li, .calculation-nav li a {
        padding: 20px 10px;
    }

    .calculation-nav li .active {
        color: #444;
        background: #f7f7f7;
    }

    .calc-from {
        padding: 50px 20px;
    }

    .input-group-prepend {
        width: 20%;
    }

    .next-prepend {
        width: 30%;
    }

    .input-group-text {
        width: 100%;
    }

    .border-attachment {
        border: 1px solid #ced4da;
        padding: 20px 0;
    }

    .make-border-text {
        position: relative;
        top: -32px;
        background: #ffff;
    }
    .debit-note{
        float: right;
    }
</style>
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="result-show container">
            <a class="btn btn-primary btn-sm debit-note" {{--target="_blank"--}} href="{{route('nonLife.calculator.motor.make.debit.note',['motorId'=> Session::get('motorCalcId') ?? ''])}}">Download Debit Note</a>
            <h3>Payment Procedure - {{Session::get('calculationFor') ? Session::get('calculationFor') : 'motor'}} Premium</h3>
            <br>
            <div class="row">
            <div class="col-sm-3"></div>
            <div style="text-align:center;border: 1px solid #000000;padding: 50px 0" class="col-sm-6">
                <div>
                    <p>
{{--                        {{dd($paymentInfo)}}--}}
                    </p>
                    <p class="text-bold">Merchant To Pay: <span class="text-blue"> {{$merchantName}}</span></p>
                    <p class="text-bold">Your Reference Id : <span class="text-blue"> {{$paymentInfo->RefId}}</span></p>
                    <p class="text-bold">Your Amount To Be Paid : <span class="text-blue"> Rs. {{number_format($paymentInfo->Amount, 2, '.', '')}}</span></p>
                </div>
                <h3>Pay With</h3>
                <form action="{{$ime_pay_checkout_url}}"method="post">
                    <input type="hidden" name="TokenId" value="{{$paymentInfo->TokenId}}">
                    <input type="hidden" name="MerchantCode" value="{{$merchantCode}}">
                    <input type="hidden" name="RefId" value="{{$paymentInfo->RefId}}">
                    <input type="hidden" name="TranAmount" value="{{($paymentInfo->Amount)}}">
                    <input type="hidden" name="Method" value="GET">
                    <input type="hidden" name="RespUrl" value="{{route('nonLife.calculator.imepay.success')}}">
                    <input type="hidden" name="CancelUrl" value="{{route('nonLife.calculator.imepay.cancil')}}">
                    <button style="background: transparent;border: none" type="submit">
                        <img src="{{asset('backend/img/SVG RED Logo.svg')}}" width="100" height="100"> </img>
                    </button>
                </form>
{{--                <p><span class="badge badge-pill badge-danger p-2">{{$output}}</span></p>--}}
{{--                <img src="{{asset('/uploads/imepay.png')}}">--}}
            </div>
            <div class="col-sm-3"></div>
        </div>
            <!-- /.box -->
        </div>

        <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
