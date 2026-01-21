@component('mail::message')
# Dear {{ $data['name'] }}

Greetings,

Thank you for your registration with SuccessCurve.In - Online Learning and Examination System.

You can login with the below details

<b>Username: -</b> {{ $data['username']}}<br>
<b>Password: -</b> {{$data['password']}}

Sincerely,<br>
SuccessCurve Team


@endcomponent
