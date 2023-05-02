@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Motor Calculation Payment Result</p>
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
</style>
@section('footer_js')
    <script>

        $(document).ready(function () {
            $('.search-select').select2();
            $("#makePolicySbtn").submit();
        });
    </script>
@endsection
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="result-show container">
            <h3>Payment Result - {{Session::get('calculationFor') ? Session::get('calculationFor') : 'motor'}} Premium</h3>
            <br>
            @include('layouts.backend.alert')
            <div class="row">
                <div class="col-sm-3"></div>
                <div style="text-align:center;border: 1px solid #000000;padding: 50px 0" class="col-sm-6">
                    <div>
                        {{--                        <p><span class="badge badge-pill badge-danger p-2">{{json_encode($pieces)}}</span></p>--}}
                        <p class="text-bold">Merchant Payed: <span class="text-blue"> {{$merchantName}}</span></p>
                        <p class="text-bold">Your Reference Id : <span class="text-blue"> {{$pieces[4]}}</span></p>
                        <p class="text-bold">Your Amount : <span class="text-blue"> Rs.{{number_format($pieces[5], 2, '.', '')}}</span></p>
                    </div>
                    <h3 class="text-bold">Payment Status : <span class="text-blue"> {{$pieces[1]}}</span></h3>
                    <br>
                    <hr>

                    @if(isset($makePolicy))
                        <form id="makePolicySbtn" action="{{route('nonLife.calculator.bike.first.party.make.policy')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="merchant_name" value="{{$merchantName}}">
                            <input type="hidden" name="paymnet_ref_id" value="{{$pieces[4]}}">
                            <button class="btn btn-primary" type="submit">Make Policy</button>
                        </form>
                    @endif
                    <a href="{{route('nonLife.calculator.bike',['classId'=>21])}}" class="btn btn-primary fa fa-arrow-left"> Go Back</a>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <!-- /.box -->
        </div>

        <!-- /.col (right) -->
    </div>
    <!-- /.row -->
@stop
