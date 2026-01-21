@component('mail::message')
# Welcome to SUCCESSCURVE Online Courses Portal!

Dear {{ $data['name']}}



Thank you for signing up for our online Mock Test "{{ $data['testtitle'] }}". We wish you an enjoyable and informative learning experience.


Details regarding the course:

<b>Mock Test Title:</b> {{$data['testtitle']}}<br>
<b>Mock Test url :</b> <a href="{{ $data['testURL'] }}"> {{$data['testURL']}}</a>

Sincerely,<br>
SuccessCurve Team
@endcomponent
