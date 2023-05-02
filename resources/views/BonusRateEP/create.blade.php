@extends('layouts.backend.containerform')

@php
    $oldCompany = old('company_id');
    $oldProduct = old('product_id');
@endphp

@section('footer_js')

    <script>

        $(document).ready(function () {
            $('.search-select').select2();

            let oldCompany = parseInt({{$oldCompany}})

            if(oldCompany){
                findProduct()
            }
        });

        function findProduct() {
            let data = $('option:selected', '#company').attr('data-products');
            data = JSON.parse(data);

            let oldProduct =parseInt({{ $oldProduct }})

            let html = '';
            html += '<option selected disabled>Select the Product</>';
            for (let i = 0; i < data.length; i++) {

                if(oldProduct == data[i].id){
                    html += '<option value="' + data[i].id + '" selected>'
                        + data[i].name +
                        '</option>'
                } else {
                    html += '<option value="' + data[i].id + `">`
                        + data[i].name +
                        '</option>'
                }
            }

            $('#products').html(html);

        }
    </script>
@endsection

@section('dynamicdata')

    <!-- iCheck -->
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Add Bonus Rate on Endowment Plan</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')

            <form action="/bonusCreate" method="post">
                {!! csrf_field() !!}

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label for="company">Company</label>
                        <select
                            class="form-control search-select"
                            onchange="findProduct()"
                            id="company"
                            name="company_id"
                            required
                        >
                            <option selected disabled>Select the Company</option>
                            @foreach ($companies as $company)
                                <option
                                    data-products="{{$company->products}}"
                                    value="{{ $company->id }}"
                                    @if(old('company_id') == $company->id) selected @endif
                                >
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="products">Product</label>
                        <select
                            class="form-control search-select"
                            id="products"
                            name="product_id"
                            required
                        >
                            <option selected disabled>Select the Product</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Starting Year</label>
                        <input
                            class="form-control form-control-inline input-medium"
                            name="first_year"
                            type="text"
                            placeholder="Starting Year"
                            value="{{ old('first_year') }}"
                        />
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Ending Year</label>
                        <input
                            class="form-control form-control-inline input-medium"
                            name="second_year"
                            type="text"
                            placeholder="Ending Year"
                            value="{{ old('second_year') }}"
                        />
                        <small class="text-muted">
                            In the case of above, please tick the checkbox and leave the ending
                            amount empty
                        </small>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Term Rate</label>
                        <input
                            type="number"
                            step="any"
                            min="0.00001"
                            name="term_rate"
                            class="form-control"
                            placeholder="Term Rate"
                            value="{{ old('term_rate') }}"
                        >
                    </div>

                    <div class="form-group form-check col-12 col-md-6">
                        <input
                            class=""
                            id="above_case"
                            name="above_case"
                            size="16"
                            type="checkbox"
                            value="1"
                            @if(old('above_case') == 1) checked @endif
                        />
                        <label for="above_case">In case of above. Eg: 15 years or above</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-info waves-effect">
                    Submit
                    <i class="fa fa-check ml-3"></i>
                </button>

            </form>
        </div>
    </div>
@stop








