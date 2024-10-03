@php
    $companyInfo = App\Models\Company::select('name', 'logo')->whereId(1)->first();
    $appUrl = route('index');
@endphp
@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => $appUrl])
    <img src="{{ asset($companyInfo->logo) }}" alt="Company Logo">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ $companyInfo->name }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
