@extends('layouts.backend.containerform')

@section('title')
    <p class="h4 align-center mb-0">Non Life Motor Calculation Policy Result</p>
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
@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="result-show container">
            <h3>Policy Created - Motor Premium</h3>
            <br>
            <div class="row">
                <div class="col-sm-3"></div>
                <div style="text-align:center;border: 1px solid #000000;padding: 50px 0" class="col-sm-6">
                    @include('layouts.backend.alert')

                @if(is_array($data))
                        @foreach($data as $dt)
                            <div>
                                {{--   <p><span class="badge badge-pill badge-danger p-2">{{(dd($output))}}</span></p>--}}
                                <p class="text-bold">Product Type: <span class="text-blue">{{$dt['ClassName']}}</span></p>
                                <p class="text-bold">Insured Name : <span class="text-blue"> {{$dt['insured']}}</span></p>
                                <p class="text-bold">Policy Number : <span class="text-blue">{{$dt['policyNo']}} </span>
                                </p>
                                <p class="text-bold">VAT Invoice Number : <span
                                        class="text-blue">{{$dt['proformano']}} </span></p>
                                <p class="text-bold">Receipt Number : <span class="text-blue">{{$dt['receiptNo']}} </span>
                                </p>
                                <p class="text-bold">Paid Premium Amount : <span
                                        class="text-blue">Rs. {{$dt['tpPremium']}} </span></p>
                            </div>
                            <h3 class="text-bold">Payment Status : <span
                                    class="text-blue">{{$dt['succFailMsg']   }} </span></h3>

                            <form action="{{route('nonLife.calculator.pdf.load')}}" method="GET"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="docid" value="{{$dt['AcceptanceNo']}}">
                                <input type="hidden" name="proformano" value="{{$dt['proformano']}}">
                                <button class="btn btn-primary" type="submit">Pdf Download</button>
                            </form>
                        @endforeach
                    @else
                        <p>Error : <b>{{$data}}</b></p>
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
