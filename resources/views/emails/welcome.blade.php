@component('mail::message')
Chèr(e) <b>{{$user->formatName()}} </b>
<h4>On vous informe que votre compte a été approuvé avec succés.</h4>
@component('mail::button', ['url' => 'http://35.204.15.100:4600/'])
Connectez vous
@endcomponent

<small>Merci pour votre confiance</small><br>
   <b> {{ config('app.name') }}</b>
@endcomponent
