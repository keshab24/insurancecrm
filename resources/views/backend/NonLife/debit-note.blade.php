<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ebeema Debit Note</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
            color: #333542;
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }
        .border-all {
            border: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {

        }

        .text-bold {
            font-weight: bold;
        }
        .text-capitalize{
            text-transform: capitalize;
        }
    </style>
</head>
<body onload="window.print();">
<div style="background: #eceff4;padding: 1.5rem;">
    <table>
        <tr>
            <td>
                <p>Ebeema</p>
            </td>
            <td class="text-right small"><span class="gry-color small">Debit Note No</span>: <br><span class="strong">EB-{{$data->id}}</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="font-size: 1.2rem;" class="strong">{{ date('d-M-Y') }}</td>
            <td class="text-right small"><span class="gry-color small">Insured Name / Address:</span></td>
        </tr>
        <tr>
            <td class="small"><span class="gry-color small">Phone:</span> <span class="strong">12345678</span></td>
            <td class="text-right">{{$data->customer->INSUREDNAME_ENG ?? 'N/A' .' , '.ucfirst($data->customer->ADDRESS ?? 'N/A')}}</td>
        </tr>
        <tr>
            <td class="small"><span class="gry-color small">Email:</span> <span class="strong">abcd@mail.com</span></td>

            <td class="text-right small"><span class="gry-color small"></span> <span class="strong"></span></td>
        </tr>
        <tr>
            <td class="gry-color small"></td>
            <td class="text-right small"><span class="gry-color small"></span> <span class=" strong"></span></td>
        </tr>
    </table>

</div>
<div style="padding: 1.5rem;padding-bottom: 0">
    <table>
        <tr>
            <td><span class="gry-color small strong">D.O. / Agency D. O. Date</span> :</td>
            <td><span class="gry-color small strong">Issuing Office </span>: <span class="strong">Kathmandu</span></td>
            <td><span class="gry-color small strong">Date </span>: <span
                    class="strong">{{$data->created_at->format('d-M-Y')}}</span></td>
        </tr>
    </table>
</div>

<div style="padding: 1.5rem;">
    <hr>
    <table>
        <tr>
            <td><span class="text-bold small strong">Sum Insured</span> :
                Rs. {{number_format($data->EXPUTILITIESAMT, 2, '.', ',')}}</td>
            <td><span class="text-bold small strong">Period From </span>: <span
                    class="strong">{{$data->created_at->format('d/M/y')}} <b>&nbsp;  TO  &nbsp;</b> {{$data->created_at->addYear(1)->format('d/M/y')}}</span></td>
            <td><span class="text-bold small strong">Insurance </span>: <span
                    class="strong"> Rs. {{number_format($data->EXPUTILITIESAMT, 2, '.', ',')}} </span></td>
        </tr>
        <tr>
            <td><span class="text-bold small strong">Engine Number</span> : {{$data->ENGINENO}}</td>
            <td><span class="text-bold small strong">Chasis Number</span> : {{$data->CHASISNO}}</td>
            <td><span class="text-bold small strong">Basic Premium </span>: <span
                    class="strong"> Rs. {{number_format($data->BASICPREMIUM_A, 2, '.', ',')}} </span></td>
        </tr>
        <tr>
            <td><span class="text-bold small strong">Vehicle Number</span> : {{$data->VEHICLENO}}</td>
            <td><span class="text-bold small strong">Make/ Model</span> : ---</td>
            <td><span class="text-bold small strong">Third Party</span>: <span
                    class="strong"> Rs. {{number_format($data->THIRDPARTYPREMIUM_B, 2, '.', ',')}} </span></td>
        </tr>
        <tr>
            <td><span class="text-bold small strong">Vehicle Name</span> : ---</td>
            <td><span class="text-bold small strong">Model of Use</span> : {{$data->MODEUSE}}</td>
            <td><span class="text-bold small strong">Stamp Duty</span>: <span
                    class="strong"> Rs. {{number_format($data->stamp, 2, '.', ',')}} </span></td>
        </tr>
        <tr>
            <td><span class="text-bold small strong">CCHP</span> : {{$data->CCHP}}</td>
            <td><span class="text-bold small strong">Manufacture Year</span> : {{$data->YEARMANUFACTURE}}</td>
        </tr>
        <tr>
            <td><span class="text-bold small strong">Reg. Date</span> : {{$data->REGISTRATIONDATE}}</td>
        </tr>
    </table>
</div>

<div style="padding:0 1.5rem;">
    <table style="width: 40%;margin-left:auto;" class="text-right sm-padding small strong">
        <tbody>
        <tr>
            <th class="text-bold text-left">{{('Sub Total') }}</th>
            <td class="currency">Rs. {{number_format($data->NETPREMIUM, 2, '.', ',')}}</td>
        </tr>
        <tr class="border-bottom">
            <th class="text-bold text-left">VAT 13%</th>
            <td class="currency">Rs. {{number_format($data->VATAMT, 2, '.', ',')}}</td>
        </tr>
        <tr class="border-bottom">
            <th class="text-bold text-left strong">Total</th>
            <td class="currency">Rs. {{number_format($data->TOTALNETPREMIUM, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <th class="text-bold text-left strong">Rupees.</th>
        </tr>
        <tr>
            @php
                $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
                $word = $f->format($data->TOTALNETPREMIUM);
            @endphp
            <th class="text-left text-capitalize">{{$word}}.</th>
        </tr>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
`
