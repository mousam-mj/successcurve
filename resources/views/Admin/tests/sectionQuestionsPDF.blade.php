<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Section Questions PDF - {{ $tsec->tsecName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .question-box {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .question-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .option {
            margin-left: 20px;
            margin-bottom: 5px;
        }
        .answer-box {
            margin-top: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            border-left: 3px solid #007bff;
        }
        .paragraph {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #28a745;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js" id="MathJax-script" async></script>
    <script>
    window.MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']],
            processEscapes: true
        }
    };
    </script>
</head>
<body>
    <div class="header">
        <h2>{{ $tsec->tsecName }}</h2>
        <p>Test Section Questions Export - {{ date('d M Y') }}</p>
    </div>

    <?php $count = 1; ?>
    @foreach($questions as $que)
        <div class="question-box">
            @if ($que->paragraphId != 0)
                @php
                    $para = \App\Paragraph::where('prgId', $que->paragraphId)->first();
                @endphp
                @if($para)
                    <div class="paragraph">
                        <strong>Paragraph:</strong> {!! $para->prgContent !!}
                    </div>
                @endif
            @endif
            
            <div class="question-title">
                <strong>Q{{ $count }}.</strong> {!! $que->qwTitle !!}
            </div>
            
            @if ($que->qwType == "radio" || $que->qwType == "checkbox")
                @php
                    if (is_string($que->qwOptions)) {
                        $options = json_decode($que->qwOptions, true);
                    } else {
                        $options = is_array($que->qwOptions) ? $que->qwOptions : json_decode(json_encode($que->qwOptions), true);
                    }
                @endphp
                @for ($i = 1; $i <= $que->totalOptions; $i++)
                    <div class="option">
                        <strong>({{ $i }})</strong> {!! isset($options['option'.$i]) ? $options['option'.$i] : '' !!}
                    </div>
                @endfor
            @elseif ($que->qwType == 'nat')
                <div class="option">
                    <em>Numerical Answer Type</em>
                </div>
            @endif
            
            @if($showAnswers)
                <div class="answer-box">
                    <strong>Correct Answer:</strong> 
                    @if ($que->qwType == "radio" || $que->qwType == "checkbox")
                        Option {{ $que->qwCorrectAnswer }}
                    @else
                        {{ $que->qwCorrectAnswer }}
                    @endif
                </div>
            @endif
            
            @if(!empty($que->qwHint))
                <div class="option" style="margin-top: 5px; font-style: italic;">
                    <strong>Hint:</strong> {!! $que->qwHint !!}
                </div>
            @endif
        </div>
        <?php $count++; ?>
    @endforeach
</body>
</html>
