@extends('theme.default')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">{{ trans('labels.dashboard') }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.branches') }}</a></li>
        </ol>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBranch" data-whatever="@addBranch">{{ trans('labels.add_branch') }}</button>
        <!-- Add Branch -->
        <div class="modal fade" id="addBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.add_branch') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="add_branch" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ trans('labels.name') }}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('messages.enter_name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ trans('labels.email') }}</label>
                            <input type="text" class="form-control" name="email" placeholder="{{ trans('messages.enter_email') }}">
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-form-label">{{ trans('labels.mobile') }}</label>
                            <input type="text" class="form-control" name="mobile" placeholder="{{ trans('messages.enter_mobile') }}">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ trans('labels.password') }}</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('messages.enter_password') }}">
                        </div> 
                        <div class="form-group">
                            <label for="image" class="col-form-label">{{ trans('labels.image') }}</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                        @if (env('Environment') == 'sendbox')
                            <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.save') }}</button>
                        @else
                            <button type="submit" class="btn btn-primary">{{ trans('labels.save') }}</button>
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Branch -->
        <div class="modal fade" id="EditBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" name="editbranch" class="editbranch" id="editbranch" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.edit_branch') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <span id="emsg"></span>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="id" name="id">
                            <input type="hidden" class="form-control" id="old_img" name="old_img">
                            <div class="form-group">
                                <label for="Branch_id" class="col-form-label">{{ trans('labels.name') }}</label>
                                <input type="text" class="form-control" id="get_name" name="name" placeholder="{{ trans('messages.enter_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="get_email" class="col-form-label">{{ trans('labels.email') }}</label>
                                <input type="text" class="form-control" name="email" id="get_email" placeholder="{{ trans('messages.enter_email') }}">
                            </div>
                            <div class="form-group">
                                <label for="get_mobile" class="col-form-label">{{ trans('labels.mobile') }}</label>
                                <input type="text" class="form-control" name="mobile" id="get_mobile" placeholder="{{ trans('messages.enter_mobile') }}">
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-form-label">{{ trans('labels.image') }} (256x256)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                            <div class="gallerys"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.update') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary">{{ trans('labels.update') }}</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('labels.all_branch') }}</h4>
                    <div class="table-responsive" id="table-display">
                        @include('theme.branchtable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')

<script type="text/javascript">
    $('.table').dataTable({
      aaSorting: [[0, 'DESC']]
    });
$(document).ready(function() {
     "use strict";
    $('#add_branch').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/branches/store') }}",
            method:"POST",
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                $('#preloader').hide();
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);
                    setTimeout(function(){
                      $('#msg').html('');
                    }, 5000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    BranchTable();
                    $('#message').html(msg);
                    $("#addBranch").modal('hide');
                    $("#add_branch")[0].reset();
                    setTimeout(function(){
                      $('#message').html('');
                    }, 5000);
                }
            },
        })
    });

    $('#editbranch').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/branches/update') }}",
            method:'POST',
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                $('#preloader').hide();
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#emsg').html(msg);
                    setTimeout(function(){
                      $('#emsg').html('');
                    }, 5000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    BranchTable();
                    $('#message').html(msg);
                    $("#EditBranch").modal('hide');
                    $("#editbranch")[0].reset();
                    setTimeout(function(){
                      $('#message').html('');
                    }, 5000);
                }
            },
        });
    });
});
function GetData(id) {
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/branches/show') }}",
        data: {
            id: id
        },
        method: 'POST', //Post method,
        dataType: 'json',
        success: function(response) {
            $('#preloader').hide();
            jQuery("#EditBranch").modal('show');
            $('#id').val(response.ResponseData.id);
            $('#get_name').val(response.ResponseData.name);
            $('#get_email').val(response.ResponseData.email);
            $('#get_mobile').val(response.ResponseData.mobile);

            $('.gallerys').html("<img src="+response.ResponseData.img+" class='img-fluid' style='max-height: 200px;'>");
            $('#old_img').val(response.ResponseData.profile_image);
        },
        error: function(error) {
            $('#preloader').hide();
        }
    })
}
function StatusUpdate(id,status) {
    swal({
        title: "{{ trans('messages.are_you_sure') }}",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{ trans('messages.yes') }}",
        cancelButtonText: "{{ trans('messages.no') }}",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/branches/status') }}",
                data: {
                    id: id,
                    status: status
                },
                method: 'POST', //Post method,
                dataType: 'json',
                success: function(response) {
                    if (response == 1) {
                        swal.close();
                        BranchTable();
                    } else {
                        swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
                    }
                },
                error: function(e) {
                    swal("Cancelled", "{{ trans('messages.wrong') }} :(", "error");
                }
            });
        } else {
            swal("Cancelled", "{{ trans('messages.record_safe') }} :)", "error");
        }
    });
}
function BranchTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/branches/list') }}",
        method:'get',
        success:function(data){
            $('#preloader').hide();
            $('#table-display').html(data);
            $(".zero-configuration").DataTable()
        }
    });
}

$('#mobile').on('input', function (event) { 
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('#get_mobile').on('input', function (event) { 
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endsection