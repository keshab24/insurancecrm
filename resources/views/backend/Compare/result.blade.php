@extends('layouts.backend.containerlist')

@section('title')
    <p class="h4 align-center mb-0">Policy Compare Result</p>
@endsection

@php
    $amountFormatter = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
    $amountFormatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
@endphp

@section('footer_js')
@endsection

@section('header_css')
@endsection

@section('dynamicdata')

    <div class="container">
        <div class="p-5 border">
            <div class="row">
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <form action="/admin/compare" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="download_pdf" value="1">
                        <input type="hidden" name="full_name" value="{{Request::input('full_name') ?? ''}}">
                        <input type="hidden" name="email" value="{{Request::input('email') ?? ''}}">
                        <input type="hidden" name="category" value="{{Request::input('category') ?? ''}}">
                        <input type="hidden" name="sum_assured" value="{{Request::input('sum_assured') ?? ''}}">
                        <input type="hidden" name="age" value="{{Request::input('age') ?? ''}}">
                        <input type="hidden" name="child_age" value="{{Request::input('child_age') ?? ''}}">
                        <input type="hidden" name="proposer_age" value="{{Request::input('proposer_age') ?? ''}}">
                        <input type="hidden" name="term" value="{{Request::input('term') ?? ''}}">
                        <input type="hidden" name="mop" value="{{Request::input('mop') ?? ''}}">
                        <input type="hidden" name="companies[]"
                               value="{{json_encode(Request::input('companies') ?? '')}}">
                        <input type="hidden" name="products" value="{{json_encode(Request::input('products') ?? '')}}">
                        <input type="hidden" name="features" value="{{json_encode(Request::input('features') ?? '')}}">
                        <button type="submit" class="btn btn-primary">Export Pdf</button>
                    </form>
                </div>
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <img src="http://127.0.0.1:8000/uploads/ebeema_logo.png" alt="E-beema_logo">
                    <div>
                        <div>
                            <span class="font-weight-bold">Proposer's Name: </span>
                            <span>{{ $clientName }}</span>
                        </div>
                        <div>
                            <span class="font-weight-bold">Proposer's E-mail:</span>
                            <span>{{ $clientEmail }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                </div>

                <div class="row col-12">
                    @if($isCouplePlan)
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Husband Age:</span>
                            <span>{{ $selectedHusbandAge }}</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Wife Age:</span>
                            <span>{{ $selectedWifeAge }}</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Average Age:</span>
                            <span>{{ $averageAge }}</span>
                        </div>
                    @elseif($isChildPlan)
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Child Age:</span>
                            <span>{{ $selectedChildAge }}</span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Proposer's Age:</span>
                            <span>{{ $selectedProposersAge }}</span>
                        </div>
                    @else
                        <div class="col-6 col-md-4">
                            <span class="font-weight-bold">Proposer's Age:</span>
                            <span>{{ $selectedAge }}</span>
                        </div>
                    @endif
                    <div class="col-6 col-md-4">
                        <span class="font-weight-bold">Proposer's Term:</span>
                        <span>{{ $selectedTerm }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="font-weight-bold">Sum Assured:</span>
                        <span>{{ $amountFormatter->format($selectedSumAssured) }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="font-weight-bold">Mode of Payment:</span>
                        <span>{{ $selectedMop }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <span class="font-weight-bold">Plan Selected:</span>
                        <span>{{ $selectedCategory }}</span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-12 px-0">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Insurer</th>
                        <th>Policy Name</th>
                        <th>Term</th>
                        <th>Annual Premium (Investment)</th>
                        <th>Total Bonus (as per today's rate)</th>
                        <th>Total Return on Maturity</th>
                        <th>Total Investment</th>
                        <th>Net Gain</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td style="width: 20%" class="compare-parts line-rht-cmp" scope="row">
                                <img src="{{asset($product->company->logo)}}">
                                <p class="cont-plan">{{$product->company->name}}</p>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->currentTerm }}</td>
                            <td>
                                {{ $amountFormatter->format($product->premiumAmountWithBenefit) }}
                                @if(count($product->features) > 0)
                                    <br>
                                    <a
                                        class="text-primary mt-2"
                                        data-toggle="collapse"
                                        href="#benefits{{$product->id}}{{$loop->iteration}}"
                                        role="button"
                                        aria-expanded="false"
                                        aria-controls="benefits{{$product->id}}{{$loop->iteration}}"
                                    >
                                        <small>Features</small>
                                    </a>
                                    <div class="collapse" id="benefits{{$product->id}}{{$loop->iteration}}">
                                        <ul>
                                            @foreach($product->features as $feature)
                                                <li class="text-primary text-capitalize">
                                                    <small>
                                                        {{--                                                        {{ $feature['code'] }}--}}
                                                        @if($feature['code'] == 'couple')
                                                            Couple ADB
                                                        @elseif($feature['code'] == 'adb_pwb_ptd')
                                                            ADB/PWB/PTD
                                                        @else
                                                            {{ featureName($feature['code']) }}
                                                        @endif
                                                        : {{ $feature['amount'] }}
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $amountFormatter->format($product->bonus) }}</td>
                            <td>
                                {{ $amountFormatter->format($product->totalPremiumAmount) }}
                                @if($product->paybackSchedules)
                                    <br>
                                    <a
                                        type="button"
                                        class="text-primary mt-2"
                                        data-toggle="modal"
                                        data-target="#paybackSchedules{{$product->id}}{{$loop->iteration}}"
                                    >
                                        <small>View Payback Schedule</small>
                                    </a>
                                @endif
                            </td>

                            <td>{{ $amountFormatter->format($product->actualPremium) }}</td>
                            <td class="d-table-cell">{{ $amountFormatter->format($product->netGain) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($products as $product)
        @if($product->paybackSchedules)
            <div class="modal fade" id="paybackSchedules{{$product->id}}{{$loop->iteration}}" tabindex="-1"
                 aria-labelledby="paybackSchedules{{$product->id}}{{$loop->iteration}}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Payback Schedule</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Term</th>
                                    <th>Premium</th>
                                    @if($product->paybackSchedules->count() > 0)
                                        <th>Money Back</th>
                                    @endif
                                    <th>Bonus</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=1;$i<=$selectedTerm;$i++)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            @if($product->paying_year)
                                                @if($i <= $product->paying_year)
                                                    {{ $amountFormatter->format($product->premiumAmountWithBenefit) }}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                {{ $amountFormatter->format($product->premiumAmountWithBenefit) }}
                                            @endif
                                        </td>
                                        @if($product->paybackSchedules->count() > 0)
                                            <td>
                                                @if($product->paybackSchedules->contains('payback_year', $i))
                                                    @foreach($product->paybackSchedules as $schedule)
                                                        @if($schedule->payback_year == $i)
                                                            {{ $amountFormatter->format($schedule->amount) }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        <td>{{ $amountFormatter->format($product->bonusYearly) }}</td>
                                    </tr>
                                @endfor
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $amountFormatter->format($product->actualPremium) }}</td>
                                    @if($product->paybackSchedules->count() > 0)
                                        <td>
                                            {{ $amountFormatter->format($product->paybackSchedules->sum('amount')) }}
                                        </td>
                                    @endif
                                    <td>
                                        {{ $amountFormatter->format($product->bonus) }}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection
