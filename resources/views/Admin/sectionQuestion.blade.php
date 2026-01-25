
@extends('layout')
@section('title')
Section Question
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
        
        <div class="col-md-9 col-12 dash-container">
            
            @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>{{ $errors }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
            @if($success)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ $success }}!</strong> 
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="float: left;">Questions of {{ $tsecs->tsecName }}</h3>

                <div class="card-tools" style="float: right;">
                    <div class="btn-group" style="margin-right: 10px;">
                        <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);" id="exportPdfWithAnswers">With Answers</a>
                            <a class="dropdown-item" href="javascript:void(0);" id="exportPdfWithoutAnswers">Without Answers</a>
                        </div>
                    </div>
                    <a class="btn btn-primary" href="{{ url('admin/addQuestionToSection/'.$tsecs->tsecId) }}">Add New</a>
                </div>
              </div>
              
              <div class="card-header">
                <form action="{{ url('admin/sectionQuestion/'.$tsecs->tsecId.'/filter') }}" method="POST" class="form-inline" id="filterForm">
                    @csrf
                    <label class="sr-only" for="type">Type</label>
                    <select class="form-control mb-2 mr-sm-2" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="mcq" {{ (isset($filterType) && $filterType == 'mcq') ? 'selected' : '' }}>MCQ</option>
                        <option value="msq" {{ (isset($filterType) && $filterType == 'msq') ? 'selected' : '' }}>MSQ</option>
                        <option value="nat" {{ (isset($filterType) && $filterType == 'nat') ? 'selected' : '' }}>NAT</option>
                        <option value="pr" {{ (isset($filterType) && $filterType == 'pr') ? 'selected' : '' }}>PRQ</option>
                    </select>
                    
                    <label class="sr-only" for="search">Search</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="search" name="search" placeholder="Search questions..." value="{{ $filterSearch ?? '' }}">
                  
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                    <a href="{{ url('admin/sectionQuestion/'.$tsecs->tsecId) }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
                </form>
              </div>
                
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Questions</th>
                                <th>Answer</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($ques as $que)
                                <tr>
                                    <td>{{ $que->qwId }}</td>
                                    <td>{!! $que->qwTitle !!}</td>
                                    <td>{!! $que->qwCorrectAnswer !!}</td>
                                    <td>
                                        @if ($que->paragraphId != 0)
                                        <span class="typelabel bg-primary text-white">Paragraph</span>
                                        @else
                                            @if ($que->qwType == 'radio')
                                                <span class="typelabel bg-danger text-white">MCQ</span>
                                            @elseif ($que->qwType == 'checkbox')
                                            <span class="typelabel bg-warning text-white">MSQ</span>
                                            @elseif ($que->qwType == 'nat')
                                            <span class="typelabel bg-info text-white">NAT</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-sm" href="{{ url('admin/removeSectionQuestion/'.$que->qwId.'/'.$tsecs->tsecId) }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php $count++;?>
                            @endforeach
                        </tbody>   
                    </table>
                </div>
                <!-- /.table-responsive -->

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>
            
            
        </div>
        
        
        
        
    </div>
    
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#dataTables-example1').DataTable({
            responsive: true,
            drawCallback: function() {
                if (window.MathJax) {
                    MathJax.typesetPromise().catch(function (err) {
                        console.log('MathJax render error:', err);
                    });
                }
            }
    });
    
    if (window.MathJax) {
        MathJax.typesetPromise().catch(function (err) {
            console.log('MathJax render error:', err);
        });
    }
    
    // PDF Export handlers
    $('#exportPdfWithAnswers').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var type = $('#type').val();
        var search = $('#search').val();
        var url = "{{ url('admin/sectionQuestion/'.$tsecs->tsecId.'/export/pdf') }}?withAnswers=1";
        if (type) url += '&type=' + encodeURIComponent(type);
        if (search) url += '&search=' + encodeURIComponent(search);
        window.location.href = url;
    });
    
    $('#exportPdfWithoutAnswers').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var type = $('#type').val();
        var search = $('#search').val();
        var url = "{{ url('admin/sectionQuestion/'.$tsecs->tsecId.'/export/pdf') }}?withAnswers=0";
        if (type) url += '&type=' + encodeURIComponent(type);
        if (search) url += '&search=' + encodeURIComponent(search);
        window.location.href = url;
    });
});
    
</script>

@endsection
