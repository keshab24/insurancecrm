@extends('frontend.layouts.app')

@section('css')
    <style>
        .sideselect-btn {
            width: 100%;
            margin-bottom: 20px;
        }

        .sideselect-btn {
            text-align: left;
            margin-right: 0px;
            padding: 5px 10px;
        }

        .sideselect-btn .active {
            background: #FAFAFA;
            border-radius: 4px;
        }

        .sideselect-btn.active .selected-cmp {
            display: block;
            float: right;
            padding-top: 4px;
        }
    </style>
@endsection
@php
    $amountFormatter = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
    $amountFormatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
@endphp
@section('content')
    <section class="compare-screen">
        <div class="top-navigation">
            <a href="/">Home</a> / <a href="#">Insurance Calculate</a> / <a class="active"
                                                                            href="#">{{$selectedCategory}}</a>
        </div>
    </section>
    <section class="compare-calc-lists">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3">
                    <form id="policyfilter" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="is_ajax" value="1">
                        <div class="left-filter-cmp">
                            <div class="compare-list-cat">
                                <p>Policy filter</p>
                            </div>


                            <div class="comare-lst">
                                <p>Age</p>
                                <input type="number" id="age" name="age" value="{{$selectedAge}}"
                                       class="cmp-datepkr calc-chg">
                            </div>
                            <div class="comare-lst">
                                <p>Terms</p>
                                <select id="term" name="term"
                                        class="form-control calc-chg radio-select-box sidecalc-btn" required>
                                    <option selected disabled>Select a term</option>
                                    @foreach($terms as $term)
                                        <option value="{{ $term }}"
                                                @if($selectedTerm == $term) selected @endif>{{ $term }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="comare-lst">
                                <p>Sum Assured</p>
                                <input type="number" id="sum_assuredf" name="sum_assured"
                                       value="{{$selectedSumAssured}}" class="cmp-datepkr calc-chg">
                            </div>
                            <div class="comare-lst">
                                <p>Mop</p>
                                <select id="mop" name="mop"
                                        class="custom-select calc-chg form-control radio-select-box sidecalc-btn"
                                        autocomplete="off" required>

                                    <option selected disabled>Select a mop</option>
                                    @if(isset($mops))
                                        @foreach($mops as $mop)
                                            <option value="{{ $mop }}" @if($selectedMop == $mop) selected
                                                    @endif class="text-capitalize">
                                                {{ str_replace('_', ' ', $mop) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="comare-lst btn-group btn-group-toggle" data-toggle="buttons">
                                <p>Company</p>

                                @foreach($products->unique('company_id') as $product)

                                    <label
                                        class="btn btn-secondary radio-select-box sideselect-btn @if($product->company->id == $product->company_id) active @endif">
                                        <input type="checkbox" multiple="multiple" name="company_id[]"
                                               autocomplete="off" class="calc-chg "
                                               value="{{$product->company->id}}"
                                               @if($product->company->id == $product->company_id) checked @endif> {{$product->company->name}}
                                        <i class="fa fa-check selected-cmp d-none"></i>
                                    </label>

                                @endforeach


                            </div>


                            <div class="comare-lst btn-group btn-group-toggle" data-toggle="buttons">
                                <p>Features</p>

                                @if(findcatFeature($selectedCategory))
                                    @foreach(findcatFeature($selectedCategory) as $selfeature)
                                        {{-- {{dd(in_array($selfeature->code,$selectedfeatures))}} --}}
                                        {{-- {{dd($selfeature)}} --}}
                                        <label
                                            class="btn btn-secondary radio-select-box sideselect-btn @if(isset($selectedfeatures)) {{ in_array($selfeature->code,$selectedfeatures) ? "active" : ''}} "@endif>
                                            <input type="checkbox" multiple="multiple" name="features[]"
                                                   autocomplete="off"
                                                   value="{{$selfeature->code}}" class="calc-chg"
                                                   @if(isset($selectedfeatures) && in_array($selfeature->code,$selectedfeatures)) checked @endif> {{$selfeature->name}}
                                            <i class="fa fa-check selected-cmp d-none"></i>
                                        </label>
                                    @endforeach
                                @endif
                            </div>

                            <input type="hidden" name="category" value="{{$selectedCategory}}">
                        </div>
                    </form>
                </div>
                <span id="compare-result">

           @include('frontend.Partials.compareResult')
       </span>
            </div>
        </div>
    </section>



@endsection
@section('script')
    <script>

        var maxLength = 2;
        var showHideBtns = '<span class="show-button"><i class="glyphicon glyphicon-plus"></i> Show more</span><span class="show-button" style="display:none"><i class="glyphicon glyphicon-minus"></i> Show less</span>';

        $('ul.allcats').each(function () {
            if ($(this).children('li').length > maxLength) {
                $(this).children('li:gt(' + (maxLength - 1) + ')').addClass('toggleable').hide();
                $(this).append(showHideBtns);
            }
        });

        $('.show-button').click(function () {
            $(this).parent('li').siblings('.toggleable').slideToggle();
            $(this).parent('li').children('.show-button').toggle();
        });

        $('.calc-chg').on('change', function (e) {
            e.preventDefault();
            $.ajax({
                url: "/compare",
                type: "POST",
                data: $('#policyfilter').serialize(),
                beforeSend: function () {
                    $('#preloader').show(500);
                },
                success: function (response) {
                    $('#preloader').hide(500);
                    $('#compare-result').empty().html(response);
                },
                error: function (e) {
                    $('#preloader').hide(500);
                    console.log('something went wrong');
                }
            });
        });


        $('.feature-list').on('change', function () {
            var checkedVal = [];

            var values = $(".feature-list:checked").each(function () {
                checkedVal.push($(this).val());
            });

            $.ajax({
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "featureCode": checkedVal,
                    "is_ajax": 1,
                    "category": $('#selectedCat').val(),
                    "age": $('#selectedAge').val(),
                    "term": $('#selectedTerm').val(),
                    "sum_assured": $('#selectedSum').val(),
                    "mop": $('#mop').val(),

                    // "sum_assured":<?php echo $selectedSumAssured ?>,
                    // "term" :<?php echo $selectedTerm ?>,
                },
                success: function (response) {

                    var data = response;
                    if (data.length > 0) {

                        for (var i = 0; i < data.length; i++) {

                        }

                    }


                },

                error: function (e) {

                    // $('.sum-title-val').text('2312');
                    //  $('#pamount').text('response.data[j].code');

                    console.log('something went wrong');
                },
            });


        })


    </script>
@endsection
