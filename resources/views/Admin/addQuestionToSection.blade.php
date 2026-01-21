
@extends('layout')
@section('title')
Add Question TO Section
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
                <h3 class="card-title" style="float: left;">Add Question to {{ $tcs->tsecName }} </h3>
                  <input type="hidden" value="{{$tcs->tsecId}}" id="tsecid">
                  <input type="hidden" value="{{$tcs->testId}}" id="testid">
              </div>

              <div class="card-body">
                  <h3 class="card-title">Select Question From</h3>
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Question Bank</label>
                                <select id="qbs" name="qbs" class="form-control">
                                    <option vlaue="0">Select Question Bank</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Sub Bank</label>
                                <select id="sqbs" name="sqbs" class="form-control">
                                    <option vlaue="0">Select Sub Bank</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Question Topic</label>
                                <select id="qts" name="qts" class="form-control">
                                    <option vlaue="0">Select Topic</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Sub Topic</label>
                                <select id="sqts" name="sqts" class="form-control">
                                    <option vlaue="0">Select Sub Topic</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cls" class="ds-label"><i class="fas fa-book"></i> Lession</label>
                                <select name="qls" class="form-control" id="qls" required>
                                    <option value="0">Select Lession</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="ds-label" for="subject">Question Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="mcq" selected>Multiple Choice Question</option>
                                    <option value="msq">Multi Select Question</option>
                                    <option value="nat">NAT</option>
                                    <option value="prq">Paragraph</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <button id="filterBtn" class="btn btn-primary">Filter Question</button>
                        </div>
                    </div>
                  </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="mytable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Questions</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="questions">


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
    $('#mytable').DataTable({
            responsive: true
    });
    $.ajax({
        url: "/getquestionbanks",
        type: "POST",
        data:{
            _token: '{{csrf_token()}}'
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
             console.log(dataResult);
            var resultData = dataResult.data;
            var bodyData = '';
            $.each(resultData,function(index,row){
                    bodyData+="<option value="+ row.qbId +">"+ row.qbName +"</option>";
                })
                $("#qbs").append(bodyData);
        }
    });
    $('#qbs').change(function(e){
        e.preventDefault();
        var d = $(this).val();
        $.ajax({
            url: "{{ URL('admin/getsubbanks')}}",
            type: "POST",
            data:{
                _token:'{{ csrf_token() }}',
                pqbId: d,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '<option value="0">Select Sub Bank</option>';
                $.each(resultData,function(index,row){

                    bodyData+="<option value="+ row.qbId +">"+ row.qbName +"</option>";

                })
                $("#sqbs").html(bodyData);
                
                // changeQuestion(pqbs = d);
            }
        });
    });
    $('#sqbs').change(function(e){
        e.preventDefault();
        var d = $(this).val();
        $.ajax({
            url: "{{ URL('admin/getqtopics')}}",
            type: "POST",
            data:{
                _token:'{{ csrf_token() }}',
                qbId: d,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '<option value="0">Select Topic</option>';
                $.each(resultData,function(index,row){

                    bodyData+="<option value="+ row.qtId +">"+ row.qtName +"</option>";

                })
                $("#qts").html(bodyData);
                var pqbs = $('#qbs').val();
                // changeQuestion(pqbs = pqbs, qbs = d);
            }
        });
    });
    $('#qts').change(function(e){
        e.preventDefault();
        var d = $(this).val();
        $.ajax({
            url: "{{ URL('admin/getsqtopics')}}",
            type: "POST",
            data:{
                _token:'{{ csrf_token() }}',
                pqtId: d,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '<option value="0">Select Sub Topic</option>';
                $.each(resultData,function(index,row){

                    bodyData+="<option value="+ row.qtId +">"+ row.qtName +"</option>";

                })
                $("#sqts").html(bodyData);
                var pqbs = $('#qbs').val();
                var qbs = $('#sqbs').val();
                // changeQuestion(pqbs = pqbs, qbs = qbs, pqts = d);
            }
        });
    });
    $('#sqts').change(function(e){
        e.preventDefault();
        var d = $(this).val();
        $.ajax({
            url: "{{ URL('admin/getqlessions')}}",
            type: "POST",
            data:{
                _token:'{{ csrf_token() }}',
                qtId: d,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '<option value="0">Select Lession</option>';
                $.each(resultData,function(index,row){

                    bodyData+="<option value="+ row.qlId +">"+ row.qlName +"</option>";

                })
                $("#qls").html(bodyData);
                var pqbs = $('#qbs').val();
                var qbs = $('#sqbs').val();
                var pqts = $('#qts').val();
                // changeQuestion(pqbs = pqbs, qbs = qbs, pqts = pqts,qts = d);
            }
        });
    });
    // $('#qls').change(function(e){
    //     e.preventDefault();
    //     var pqbs = $('#qbs').val();
    //     var qbs = $('#sqbs').val();
    //     var pqts = $('#qts').val();
    //     var qts = $('#sqts').val();
    //     var qls = $('#qls').val();
    //     var d = $(this).val();
    //     changeQuestion(pqbs = pqbs, qbs = qbs, pqts = pqts,qts = qts, qls = d);
    // });
    // $('#type').change(function(e){
    //     e.preventDefault();
    //     var pqbs = $('#qbs').val();
    //     var qbs = $('#sqbs').val();
    //     var pqts = $('#qts').val();
    //     var qts = $('#sqts').val();
    //     var qls = $('#qls').val();
    //     var d = $(this).val();
    //     changeQuestion(pqbs, qbs, pqts, qts, qls, d);
    // });

    $("#filterBtn").click(function(e){
        e.preventDefault();
        var pqbs = $('#qbs').val();
        var qbs = $('#sqbs').val();
        var pqts = $('#qts').val();
        var qts = $('#sqts').val();
        var qls = $('#qls').val();
        var d = $(this).val();

        if (pqbs > 0 && qbs > 0 && pqts > 0 && qts > 0 && qls > 0) {
            changeQuestion(pqbs, qbs, pqts, qts, qls, d);
        } else if (pqbs > 0 && qbs > 0 && pqts > 0 && qts > 0) {
            changeQuestion(pqbs = pqbs, qbs = qbs, pqts = pqts,qts = qts, qtype = d);
        } else if (pqbs > 0 && qbs > 0 && pqts > 0) {
            changeQuestion(pqbs = pqbs, qbs = qbs, pqts = pqts, qtype = d);
        } else if (pqbs > 0 && qbs > 0) {
            changeQuestion(pqbs = pqbs, qbs = qbs, qtype = d);
        } else if (pqbs > 0) {
            changeQuestion(pqbs = pqbs, qtype = d);
        }
    });
});
function changeQuestion(pqbs = 0, qbs = 0, pqts = 0, qts = 0, qls = 0, qtype = 'mcq'){
    //alert("topic"+topic+"  section "+tsec);
    $('#mytable').DataTable().clear().draw();

    var tsecId = $('#tsecid').val();
    $.ajax({
        url: "{{ URL('admin/getTopicQuestions')}}",
        type: "POST",
        data:{
            _token:'{{ csrf_token() }}',
            pqbId: pqbs,
            qbId: qbs,
            pqtId: pqts,
            qtId: qts,
            qlId: qls,
            qtype: qtype,
            tsecId: tsecId,
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            //console.log(dataResult);
           $('#mytable').DataTable().clear().draw();
            var resultData = dataResult.data;
            var bodyData = '';
            var bodyData2 = '';

            $.each(resultData,function(index,rows){

                $('#mytable').DataTable().row.add([rows.qwId, rows.qwTitle, rows.qwType, '<button class="btn btn-primary addBtn" onclick="addQuestion('+rows.qwId+')">Add</button>']).draw();


            })
        }
    });
}

function addQuestion(qid){
    //alert(qid);
    var tsecId = $('#tsecid').val();
    var testId = $('#testid').val();
    var topicId = $('#topic').val();
    $('.addBtn').attr("disabled", true);
    $.ajax({
        url: "{{ URL('admin/addSectionQuestion')}}",
        type: "POST",
        data:{
            _token:'{{ csrf_token() }}',
            qid: qid,
            tsecId: tsecId,
            testId: testId,
            topicId: topicId,
        },
        cache: false,
        dataType: 'json',
        success: function(dataResult){
            console.log(dataResult);
            var pqbs = $('#qbs').val();
            var qbs = $('#sqbs').val();
            var pqts = $('#qts').val();
            var qts = $('#sqts').val();
            var qls = $('#qls').val();
            var qtype = $('#type').val();
            changeQuestion(pqbs, qbs, pqts, qts, qls, qtype);
        }
    });
}
</script>

@endsection
