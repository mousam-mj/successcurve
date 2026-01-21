@component('mail::message')
# Welcome to SUCCESSCURVE Online Courses Portal!

Dear {{ $data['name']}}



Thank you for signing up for our online course "{{ $data['coursetitle'] }}". We wish you an enjoyable and informative learning experience.


Details regarding the course:

<b>Name of the course:</b> {{$data['coursetitle']}}<br>
<b>Course url :</b> <a href="{{ $data['courseURL'] }}"> {{$data['courseURL']}}</a>

Sincerely,<br>
SuccessCurve Team
@endcomponent
