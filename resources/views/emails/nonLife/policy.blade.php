@component('mail::message')
Dear {{ $policy->customer->customer_name ?? 'Customer' }},

You have successfully purchased policy for vehicle number: {{$policy->VEHICLENO ?? "N/A"}} of NRs. {{$policy->PAIDAMT ?? 'N/A'}} on {{$policy->TRANS_DATE ?? 'N/A'}} .
The policy number is : {{$policy->output[0]->policyNo ?? 'N/A'}}.
The reference number is : {{$policy->reference_number ?? 'N/A'}}.

Thank you for choosing,<br>
{{ config('app.name') }}
@endcomponent
