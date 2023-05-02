<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compare PDF</title>

    @php
        $amountFormatter = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
        $amountFormatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
    @endphp

    <style>
        table, td, th {
            border: 1px solid #1d2124;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 5px;
        }
    </style>

</head>
<body>
<div>
    <div>
        <div>
            {{--            <img src="data:image/png+xml;base64,' . base64_encode('/uploads/ebeema_logo.png') . '" alt="E-beema_logo">--}}
            <img src="{{ public_path('uploads/ebeema_logo.png') }}" alt="E-beema_logo">
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

        <hr>

        <div>
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

    <div>
        <table>
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
                    <td style="text-align: center">
                        <img src="{{public_path($product->company->logo)}}" alt="{{$product->company->name}}"
                             width="90">
                        <p class="cont-plan">{{$product->company->name}}</p>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->currentTerm }}</td>
                    <td>
                        Rs. {{ $amountFormatter->format($product->premiumAmountWithBenefit) }}
                        @if(count($product->features) > 0)
                            <br>
                            <p style="color: #0a53be">Features</p>
                            <ul>
                                @foreach($product->features as $feature)
                                    <li class="text-primary text-capitalize">
                                        <small>
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
                        @endif
                    </td>
                    <td>Rs. {{ $amountFormatter->format($product->bonus) }}</td>
                    <td>
                        Rs. {{ $amountFormatter->format($product->totalPremiumAmount) }}
                    </td>

                    <td>Rs. {{ $amountFormatter->format($product->actualPremium) }}</td>
                    <td>Rs. {{ $amountFormatter->format($product->netGain) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

