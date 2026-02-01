
@extends('layout')

@section('title')
Preview Question
@endsection


@section('content')

<div class="main-box">
    <div  class="row">
        <div class="col-md-3 col-12 s-menu">
            
            <div class="s-dash">
                <div class="d-img">
                    <img src= "{{ URL::asset(Session::get('auserImage')) }}" alt="{{Session::get('auserImage')}}" class="ds-img">
                </div>
                  <div class="s-cont">
                    <h3 class="ds-name">{{Session::get('auser')}} </h3>
                      <p class="ds-p">{{Session::get('auserEmail')}}</p>
                  </div>
              </div>
            @include('Admin.adminSidebar')    
        </div>
        
<!--        Dash-Container Starts   -->
        <div class="col-md-9 col-12 dash-container">
            
            
<!--            Error Box       -->
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            <div class="dash-header">
                <span class="dash-header-title">Preview Question: ({{ $qns->qwId }})</span>

            </div>
            @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ Session::get('success') }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            <div class="dash-form-box">

                @if ($paragraphs != null)
                    <h6 class="text-primary">Paragraph: </h6>
                    {!! $paragraphs->prgContent !!}
                @endif
                <h6 class="text-danger m-3">Question: </h6> {!! $qns->qwTitle !!}


                <?php
                    $options = json_decode(json_encode(json_decode($qns->qwOptions)), true);

                    // print_r($options);
                    // die();
                ?>
                <div class="row">
                    @for ($i = 1; $i <= $qns->totalOptions; $i++)
                        <div class="col-md-6 mt-2 p-2" style="border: 1px solid black; border-radius: 10px;">
                            <h6 class="text-primary">Option {{ $i }}</h6>
                            {!! $options['option'.$i] !!}
                        </div>
                    @endfor
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-success">Correct Answer: {{ ($qns->qwType != "nat") ? "Option ":''}} {{ $qns->qwCorrectAnswer }}</h6>

                    </div>
                </div>

                @if(!empty($qns->qwHint))
                            
                <div class="hintbox">
                    <p class="text-white"><b>Question Solution:</b> </p>
                    {!! $qns->qwHint !!}  
                </div>
                  
                @endif

                <!-- Navigation and Action Buttons -->
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Previous Question Button -->
                            <a href="{{ $prevId ? url('admin/qns/preview/' . $prevId) : 'javascript:void(0);' }}" 
                               class="btn btn-outline-primary btn-lg {{ !$prevId ? 'disabled' : '' }}" 
                               style="min-width: 180px;">
                                <i class="fas fa-arrow-left"></i> Previous Question
                            </a>
                            
                            <!-- Next Question Button -->
                            <a href="{{ $nextId ? url('admin/qns/preview/' . $nextId) : 'javascript:void(0);' }}" 
                               class="btn btn-outline-success btn-lg {{ !$nextId ? 'disabled' : '' }}" 
                               style="min-width: 180px;">
                                Next Question <i class="fas fa-arrow-right"></i>
                            </a>
                            
                            <!-- Edit Now Button -->
                            <a href="{{ url($editRoute . $qns->qwId) }}" 
                               class="btn btn-outline-warning btn-lg" 
                               style="min-width: 180px;">
                                <i class="fas fa-edit"></i> Edit Now
                            </a>
                            
                            <!-- Report this Question Button -->
                            <button type="button" 
                                    class="btn btn-outline-danger btn-lg" 
                                    data-toggle="modal" 
                                    data-target="#reportQuestionModal"
                                    style="min-width: 180px;">
                                <i class="fas fa-flag"></i> Report this Question
                            </button>
                        </div>
                        
                        <!-- Helper text below buttons -->
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> After editing, save and the next question will be shown automatically.
                            </small>
                        </div>
                    </div>
                </div>

            </div>        
      <!--        Container End   -->  
        </div>
        
        <!-- Report Question Modal -->
        <div class="modal fade" id="reportQuestionModal" tabindex="-1" role="dialog" aria-labelledby="reportQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportQuestionModalLabel">Report Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="reportQuestionForm">
                        <div class="modal-body">
                            <input type="hidden" name="questionId" value="{{ $qns->qwId }}">
                            <div class="form-group">
                                <label for="reportContent">Report Reason:</label>
                                <textarea class="form-control" id="reportContent" name="report" rows="4" placeholder="Please describe the issue with this question..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')
<script>
// Re-render MathJAX after page load
$(document).ready(function() {
    if (window.MathJax) {
        MathJax.typesetPromise().catch(function (err) {
            console.log('MathJax render error:', err);
        });
    }
    
    // Handle report question form submission
    $('#reportQuestionForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            questionId: $('input[name="questionId"]').val(),
            report: $('#reportContent').val(),
            testId: 0 // Optional, can be set if needed
        };
        
            $.ajax({
            url: '{{ url("result/submitReport") }}',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#reportQuestionModal').modal('hide');
                alert('Question reported successfully!');
                $('#reportQuestionForm')[0].reset();
            },
            error: function(xhr) {
                alert('Error reporting question. Please try again.');
                console.error(xhr);
            }
        });
    });
});
</script>
@endsection
