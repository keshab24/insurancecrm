@extends('layouts.backend.containerlist')

@section('footer_js')
    <script>
        $(document).ready(function () {
            $('.search-select').select2();
        });

        function findProducts() {
            let data = $('option:selected', '#companies').attr('data-products');
            data = JSON.parse(data);
            let html = '';
            html += '<option selected disabled>Select a Product</>';
            for (let i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '" data-terms="' + JSON.stringify(data[i].terms) + '" data-adb-types="' + data[i].adb_types + '">' + data[i].name + '</option>'
            }
            $('#products').html(html);
        }

        function findTerms() {
            let data = $('option:selected', '#products').attr('data-terms');
            data = JSON.parse(data);
            let html = '';
            html += '<option selected disabled>Select a term</>';
            for (let i = 0; i < data.length; i++) {
                html += '<option value="' + data[i] + '">' + data[i] + '</option>'
            }
            $('#terms').html(html);
        }
    </script>
@endsection

@section('dynamicdata')

    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Add Paying Term</h3>
        </div>
        <div class="box-body">
            @include('layouts.backend.alert')
            <form action="{{ route('paying-term.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <!-- Companies -->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Company</span>
                            </div>
                            <select
                                class="form-control search-select"
                                id="companies"
                                name="company_id"
                                onchange="findProducts()"
                            >
                                <option selected disabled>Select a company</option>
                                @foreach($companies as $company)
                                    <option
                                        value="{{ $company->id }}"
                                        data-products="{{ $company->products }}"
                                    >
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Products-->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Products</span>
                            </div>
                            <select
                                class="form-control search-select"
                                id="products"
                                name="product_id"
                                onchange="findTerms()"
                            >
                                <option selected disabled>Select a product</option>
                            </select>
                        </div>
                    </div>

                    <!-- Terms-->
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Terms</span>
                            </div>
                            <select
                                class="form-control search-select"
                                id="terms"
                                name="term"
                            >
                                <option selected disabled>Select a term</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group  col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Paying Year</span>
                            </div>
                            <input
                                type="number"
                                class="form-control @error('paying_year') is-invalid @enderror"
                                name="paying_year"
                                id="paying_year"
                                value="{{ old('paying_year') }}"
                                placeholder="Paying Year"
                            >
                        </div>
                        @error('paying_year')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@stop
