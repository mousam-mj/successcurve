@component('mail::message')
# Welcome to SUCCESSCURVE Online Courses Portal!

Dear {{ $data['name']}}



Thank you for signing up for our online Test Series "{{ $data['tstitle'] }}". We wish you an enjoyable and informative learning experience.


Details regarding the course:

<b>Test Series Title:</b> {{$data['tstitle']}}<br>
<b>Test Series url :</b> <a href="{{ $data['tsURL'] }}"> {{$data['tsURL']}}</a>

Sincerely,<br>
SuccessCurve Team
@endcomponent
