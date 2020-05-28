@component('mail::message')
<style>
    table.inner-body {
        width: 100%;
    }

</style>
Chèr(e) <b> {{$user->formatName()}}</b>
{!! $message !!}

@endcomponent
