@component('mail::message')

    Dear {{ $clientName }},

    Please find the attachment below.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
