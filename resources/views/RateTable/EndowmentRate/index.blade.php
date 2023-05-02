@extends('layouts.backend.containerlist')

@section('header_css')
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}">
    <link href="{{asset('backend/css/select2.min.css')}}" rel="stylesheet"/>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }m

        th, td {
            text-align: left;
            padding: 8px;
            
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>
@endsection
@section('footer_js')
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script
        src="{{asset('backend/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{asset('backend/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $('.xedit').editable({
                url: '{{url("admin/update-rate-table/endowment-rate")}}',
                title: 'Update',
                ajaxOptions: {
                    type: 'post'
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        swal("Done!", "Updated Successfully !", "success");
                    } else {
                        swal("Error!", "Update error !", "error");
                    }
                }
            });

        });

        $(document).ready(function () {
            $('.search-select').select2();
        });

        function findProducts() {
            var data1 = $('option:selected', '#company1').attr('data-products');
            data = JSON.parse(data1);
            console.log(data);
            var html = '';
            html += '<option selected disabled>Select the Product</>'
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '">' + data[i].name + '</option>'
            }
            $('#products1').html(html);
        }

        function findProduct() {
            var data = $('option:selected', '#company').attr('data-products');
            data = JSON.parse(data);
            // console.log(data);
            var html = '';
            html += '<option selected disabled>Select the Product</>'
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '">' + data[i].name + '</option>'
            }
            $('#products').html(html);
        }
    </script>


@endsection
@section('title')
    <p class="h4 align-center mb-0">Endowment Rate Table</p>
@endsection

@section('dynamicdata')

    <div class="box">
        <div class="box-header with-border c-btn-right d-flex-row ">
            <div class="justify-content-end list-group list-group-horizontal ">
            </div>
        </div>
        <div class="box-body">

            @include('layouts.backend.alert')
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseBulkImport"
                    aria-expanded="false" aria-controls="collapseBulkImport">
                Click To Import Rate Data
            </button>
            <div class="collapse" id="collapseBulkImport">
                <hr>
                <div class="card-body">
                    <a href="{{ asset('downloads/endowment_rates_demo.xlsx') }}" download>
                        <button class="btn btn-info">Download Demo CSV</button>
                    </a>
                    {{--                    <a href="{{ route('endowment.rates.export') }}" download>--}}
                    {{--                        <button class="btn btn-info mr-2">Download Rate Endowment CSV</button>--}}
                    {{--                    </a>--}}
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6"><strong>Upload Rate Endowment File</strong></h5>
                    </div>
                    <div class="card-body">
                        <form class="" action="{{ route('endowment.rates.import') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-inline">
                                <div class="form-group mx-sm-12 mr-lg-3">
                                    <label class="">Company Name</label>
                                    <select class="form-control form-control-inline input-medium search-select"
                                            onchange="findProducts()" id="company1" name="company_id" required>
                                        <option selected disabled>Select the Company</option>
                                        @foreach ($companies as $company)
                                            <option data-products="{{$company->products}}"
                                                    value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mx-sm-6">
                                    <label class="">Products</label>
                                    <select class="form-control form-control-inline input-medium search-select"
                                            id="products1"
                                            name="product_id" required>
                                        <option selected disabled>Select the Product</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="formFile" class="form-label">Choose File</label>
                                    <input class="form-control" name="bulk_file" type="file" id="formFile" required>
                                </div>
                            </div>
                            <div class="form-group pl-3">
                                <button type="submit" class="btn btn-info">Upload CSV</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="alert"
                     style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    <strong> Steps :</strong>
                    <p>1. Download the skeleton file and fill it with proper data.</p>
                    <p>2. You can download the example file to understand how the data must be filled.</p>
                    <p>3. Once you have downloaded and filled the skeleton file, upload it in the form and submit.</p>
                    <p>4. To upload the skeleton file, You have to select the Company name and products and only submit.</p>
                </div>
                <br>
            </div>
            <br>
            <hr>
            <form action="{{route('endowment.rate.index')}}" method="get" class="form-inline">
                {!! csrf_field() !!}
                <div class="">
                    <div class="form-group mx-sm-3">
                        <label class="">Company Name</label>
                        <select class="form-control form-control-inline input-medium search-select"
                                onchange="findProduct()" id="company" name="company_id" required>
                            <option selected disabled>Select the Company</option>
                            @foreach ($companies as $company)
                                <option data-products="{{$company->products}}"
                                        value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-sm-3">
                        <label class="">Products</label>
                        <select class="form-control form-control-inline input-medium search-select" id="products"
                                name="product_id" required>
                            <option selected disabled>Select the Product</option>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3">
                        <label class=" mb-2">Action</label>
                        <button type="submit" class="btn btn-info waves-effect">
                            <span>Submit<i class="fa fa-check"></i></span>
                        </button>
                    </div>
                </div>
            </form>
            <span class="ml-5">[Please select Company and product to View data.]</span><br>
            <div class="mx-auto text-center">
                @if($selectedCompany)
                    <label class=" mb-2">Selected Company: {{$selectedCompany ? $selectedCompany->name : 'N/A'}}</label>
                    <br>
                    <label class=" mb-2">Selected Product: {{$selectedProduct ? $selectedProduct->name : 'N/A'}}</label>
                    <br>
                    <a href="{{ route('company.rates.export',(['company_id'=>$selectedCompany->id, 'product_id'=>$selectedProduct->id])) }}"
                       download>
                        <button class="btn btn-info mr-2">Download Company Rate Endowment</button>
                    </a>
                @endif
            </div>
            @if($columns && $rows)
                <div style="overflow-y:scroll;">
                    <label class=" mt-5 mx-auto"><i class="fa fa-arrow-down" aria-hidden="true"></i> Ages |</label>
                    <label class=" mt-5 mx-auto">Terms <i class="fa fa-arrow-right" aria-hidden="true"></i></label>
                    @include('RateTable.EndowmentRate.table')
                </div>
            @else
                <h4 class="text-center mt-5"><strong>No Data Found</strong></h4>
            @endif
        </div>
        <!-- /.box-body -->

        <!-- /.box -->
        @endsection
    </div>
    </div>
    </div>
