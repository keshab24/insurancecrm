@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Policy Compare</p>
@endsection

@section('footer_js')
    <script>
        $(document).ready(function () {
            $('.search-select').select2();
        });

        let i = 1;

        $('#add_more_btn').click(function (e) {
            let products = $("select[name='products[]']")
                .map(function () {
                    return $(this).val();
                }).get();
            console.log(products);
            $.ajax({
                url: '/admin/compare/add',
                data: {id: i, products: JSON.stringify(products)},
                type: 'get',
                success: function (res) {
                    $('.append_fields').append(res)
                    i++;
                },
                error: function (err) {
                    console.log(err);
                }
            })
        });

        function removeRow(id) {
            $(`#option_${id}`).remove();
        }

        function onCategorySelection() {
            const category = $('option:selected', `#category`).val();
            let ageDiv = $('#age_container');
            let coupleDiv = $('#couple_container');
            let childDiv = $('#child_container');

            const style = 'd-none'


            switch (category) {
                case 'couple':
                    ageDiv.addClass(style)
                    coupleDiv.removeClass(style)
                    childDiv.addClass(style)
                    break;
                case 'children':
                    ageDiv.addClass(style)
                    coupleDiv.addClass(style)
                    childDiv.removeClass(style)
                    break;
                case 'education':
                    ageDiv.addClass(style)
                    coupleDiv.addClass(style)
                    childDiv.removeClass(style)
                    break;
                default:
                    ageDiv.removeClass(style)
                    coupleDiv.addClass(style)
                    childDiv.addClass(style)
                    break;
            }
        }

        function findProducts(id) {
            let data = $('option:selected', `#company_${id}`).attr('data-products');
            let category = $('option:selected', `#category`).val();
            data = JSON.parse(data);

            let html = '';
            html += '<option selected disabled>Select a Product</>';
            for (let i = 0; i < data.length; i++) {

                if (category === data[i].category) {
                    html += '<option ' +
                        'value="' + data[i].id +
                        '" data-category="' + data[i].category +
                        '"' +
                        '>'
                        + data[i].name + '</option>'
                }

            }
            $(`#product_${id}`).html(html);
        }
    </script>
@endsection

@section('header_css')
@endsection

@section('dynamicdata')

    <div class="container">
        <section>
            <div class="mb-5">
                <form action="{{ route('admin.policy.compare') }}" method="POST">

                    @csrf

                    <h5 class="text-center mt-4">Create Proposal</h5>
                    <hr class="mb-4">

                    <div class="form-row">

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="full_name" class="font-weight-bold">Name of client</label>
                                <input type="text" id="full_name" name="full_name" class="form-control"
                                       placeholder="Enter full name of client" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                       placeholder="Enter Email Address" required>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-center mt-4">Enter Details</h5>
                    <hr class="mb-4">

                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="category" class="font-weight-bold">Category</label>
                                <select id="category" name="category" class="custom-select search-select"
                                        onchange="onCategorySelection()" required>
                                    <option selected disabled>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="sum_assured" class="font-weight-bold">Sum Assured</label>
                                <input type="number" id="sum_assured" name="sum_assured" class="form-control"
                                       placeholder="Enter Sum to be Assured" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-4" id="age_container">
                            <div class="form-group">
                                <label for="age" class="font-weight-bold">Age</label>
                                <select id="age" name="age" class="custom-select search-select" required>
                                    <option selected disabled>Select an age</option>
                                    @foreach($ages as $age)
                                        <option value="{{ $age }}">{{ $age }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row col-12 col-md-8 d-none" id="couple_container">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="husband_age" class="font-weight-bold">Husband Age</label>
                                    <select id="husband_age" name="husband_age" class="custom-select search-select"
                                            required>
                                        <option selected disabled>Select husband age</option>
                                        @foreach($ages as $age)
                                            <option value="{{ $age }}">{{ $age }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="wife_age" class="font-weight-bold">Wife Age</label>
                                    <select id="wife_age" name="wife_age" class="custom-select search-select" required>
                                        <option selected disabled>Select wife age</option>
                                        @foreach($ages as $age)
                                            <option value="{{ $age }}">{{ $age }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 col-md-8 d-none" id="child_container">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="child_age" class="font-weight-bold">Child Age</label>
                                    <select id="child_age" name="child_age" class="custom-select search-select"
                                            required>
                                        <option selected disabled>Select child age</option>
                                        @foreach($ages as $age)
                                            <option value="{{ $age }}">{{ $age }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="proposer_age" class="font-weight-bold">Proposer's Age</label>
                                    <select id="proposer_age" name="proposer_age" class="custom-select search-select"
                                            required>
                                        <option selected disabled>Select proposer's age</option>
                                        @foreach($ages as $age)
                                            <option value="{{ $age }}">{{ $age }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="term" class="font-weight-bold">Term</label>
                                <select id="term" name="term" class="custom-select search-select" required>
                                    <option selected disabled>Select a term</option>
                                    @foreach($terms as $term)
                                        <option value="{{ $term }}">{{ $term }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="mop" class="font-weight-bold">Mode of Payment</label>
                                <select id="mop" name="mop" class="custom-select search-select" required>
                                    <option selected disabled>Select a mop</option>
                                    @foreach($mops as $mop)
                                        <option value="{{ $mop }}" class="text-capitalize">
                                            {{ str_replace('_', ' ', $mop) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-center mt-4">Choose Company and Policies</h5>
                    <hr class="mb-4">

                    {{--                    <div class="form-row align-items-center">--}}
                    {{--                        <div class="col-12 col-md-5">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="company_0" class="font-weight-bold">Companies</label>--}}
                    {{--                                <select id="company_0" name="companies[]" class="custom-select search-select"--}}
                    {{--                                        onchange="findProducts(0)" required>--}}
                    {{--                                    <option selected disabled>Select company</option>--}}
                    {{--                                    @foreach($companies as $company)--}}
                    {{--                                        <option value="{{ $company->id }}"
                    data-products="{{ $company->products }}">--}}
                    {{--                                            {{ $company->name }}--}}
                    {{--                                        </option>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div class="col-12 col-md-5">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="product_0" class="font-weight-bold">Policies</label>--}}
                    {{--                                <select id="product_0" name="products[]" class="custom-select search-select" required>--}}
                    {{--                                    <option selected disabled>Select products</option>--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        --}}
                    {{--                    </div>--}}

                    <div class="append_fields"></div>

                    <button type="button" class="btn btn-success mt-2" id="add_more_btn">Add Company and Policy
                    </button>

                    <div class="form-group mt-4">
                        <label class="font-weight-bold">Features</label>
                        @foreach($features as $feature)
                            <div class="form-check">
                                <input type="checkbox" name="features[]" class="form-check-input"
                                       id="{{ $feature->code }}"
                                       value="{{ $feature->code }}">
                                <label class="form-check-label text-capitalize"
                                       for="{{ $feature->code }}">{{ $feature->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <button class="btn btn-primary px-5 mt-4">Submit</button>
                </form>
            </div>
        </section>
    </div>

@endsection
