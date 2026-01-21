@component('mail::message')
# Exam Result

Dear {{ $data['name'] }},<br>

Greetings,<br>


You have submitted <b>{{ $data['test'] }}</b> Mock test at <b>{{ $data['time'] }}</b>.
Here we declare the result : You have Scored <b>{{ $data['ymarks']}}</b> out of <b>{{ $data['tmarks'] }}</b> in <b>{{ $data['test'] }}</b>.


To view your details of <b>{{ $data['test'] }}</b> score and report <b><a href="{{ $data['resultUrl'] }}">Click Here</a></b>.<br>


We appreciate your efforts.<br>

Practice it to make it perfect.<br>


Keep practicing and keep improving.<br>

<b>Try our other Mock Test:</b> <a href="https://www.successcurve.in/mock-test">Click Here</a>


Sincerely,<br>
SuccessCurve Team
@endcomponent
