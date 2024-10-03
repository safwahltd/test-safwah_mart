@component('mail::message')
@component('mail::panel')
{{ $messageData['description'] }}
@endcomponent

Thanks,<br>
{{ $messageData['companyName'] }}
@endcomponent
