@extends('layouts.backend.containerlist')

@section('header_css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('footer_js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var editor;
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
        });
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $('.xeditAge').change(function () {
                var id = $(this).attr('data-id');
                var value = $(this).val();
                $.ajax({
                    url: '{{url("admin/update-rate-table/endowment-rate")}}',
                    title: 'UpdateAge',
                    data: {
                        'name': 'age_id',
                        'pk': id,
                        'value': value
                    },
                    type: 'post',
                    success: function (response) {
                        swal("Done!", "Updated Successfully !", "success");
                    }
                });

            });
            $('.xeditTerm').change(function () {
                var id = $(this).attr('data-id');
                var value = $(this).val();
                $.ajax({
                    url: '{{url("admin/update-rate-table/endowment-rate")}}',
                    title: 'UpdateTitle',
                    data: {
                        'name': 'term_id',
                        'pk': id,
                        'value': value
                    },
                    type: 'post',
                    success: function (response) {
                        swal("Done!", "Updated Successfully !", "success");
                    }
                });

            });
            $('.xedit').editable({
                url: '{{url("admin/update-rate-table/endowment-rate")}}',
                title: 'Update',
                ajaxOptions: {
                    type: 'post'
                },
                success: function (response) {
                    swal("Done!", "Updated Successfully !", "success");
                }
            });

        });

        $(document).ready(function () {
            $('.search-select').select2();
        });

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
                {{--                <a href="{{route('admin.discount.create')}}">--}}
                {{--                    <button class="btn btn-primary c-primary-btn add-modal shadow-none mx-2" data-toggle="modal" data-target="#addNewUserModal">--}}
                {{--                        --}}{{-- <img src="{{ asset('uploads/add-circle-16-Regular.svg') }}" alt="Add-icon"> --}}
                {{--                        &nbsp; Add New &nbsp;--}}
                {{--                    </button></a>--}}
            </div>
        </div>
        <div class="box-body">

            @include('layouts.backend.alert')

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
                <!-- #END# Basic Table -->
            </form>
            <span class="ml-5">[Please select Company and product to View data.]</span><br>
            <div class="mx-auto text-center">
                @if($selectedCompany)
                    <label class=" mb-2">Selected Company: {{$selectedCompany ? $selectedCompany->name : 'N/A'}}</label><br>
                    <label class=" mb-2">Selected Product: {{$selectedProduct ? $selectedProduct->name : 'N/A'}}</label>
                @endif
            </div>
            <table id="example1" class="table table-bordered table-hover role-table">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Rate</th>
                    <th>Age</th>
                    <th>Term</th>
                    <th>Premimum Paying Terms</th>
                </tr>
                </thead>
                <tbody id="tablebody">

                @if($rateEndowments)
                    @foreach($rateEndowments as $index=>$dis)
                        <tr class="gradeX" id="row_{{ $dis->id }}">
                            <td class="index">
                                {{ ++$index }}
                            </td>
                            <td class="rate">
                                <a href="#" class="xedit"
                                   data-pk="{{$dis->id}}"
                                   data-name="rate">
                                    {{ $dis->rate }}
                                </a>
                            </td>
                            <td class="age">
                                <select name="age_id" data-id="{{$dis->id}}" class="form-control xeditAge">
                                    @foreach($policyages as $age)
                                        <option value="{{$age->id}}"
                                                @if($dis->age_id == $age->id) selected @endif>{{$age->age}}</option>
                                    @endforeach
                                </select>

                            </td>
                            <td class="term">
                                <select name="term_id" data-id="{{$dis->id}}" class="form-control xeditTerm">
                                    @foreach($terms as $term)
                                        <option value="{{$term->id}}"
                                                @if($dis->term_id == $term->id) selected @endif>{{$term->term}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="premium">
                                <a href="#" class="xedit"
                                   data-pk="{{$dis->id}}"
                                   data-name="premium_paying_terms">
                                    {{ $dis->premium_paying_terms }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->

        <!-- /.box -->
        @endsection
    </div>
    </div>
    </div>
