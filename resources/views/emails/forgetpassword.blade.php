@component('mail::message')
# Forgot Password

Dear {{$data['name']}} ,
Greetings,

Your Forgot Password Request Is Received Successfully. The New Credentials Are


<b>Username :</b> {{ $data['username'] }}<br>
<b>Password :</b> {{$data['password']}}<br>

Sincerely,<br>
SuccessCurve Team

@endcomponent
