
@extends('theme.default')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">{{ trans('labels.dashboard') }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.items') }}</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Session::has('danger'))
                    <div class="alert alert-danger">
                        {{ Session::get('danger') }}
                        @php
                            Session::forget('danger');
                        @endphp
                    </div>
                    @endif

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach

                    <h4 class="card-title">{{ trans('labels.edit_item') }}</h4>
                    <p class="text-muted"><code></code>
                    </p>
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form method="post" action="{{ URL::to('admin/item/update') }}" name="about" id="about" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" id="id" name="id" value="{{$item->id}}">

                            <div class="row">
                                <div class="col-sm-3 col-md-12">
                                    @if (Auth::user()->type == "1")
                                    <div class="form-group">
                                        <label for="branch_id" class="col-form-label">{{ trans('labels.select_branch') }}</label>
                                        <select class="form-control" name="branch_id" id="branch_id">
                                            <option value="">{{ trans('labels.select_branch') }}</option>
                                            @foreach ($getbranch as $branch)
                                                <option value="{{$branch->id}}" {{ $item->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                        <input type="hidden" class="form-control" name="branch_id" id="branch_id" value="{{Auth::user()->id}}">
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-md-12">
                                    <div class="form-group">
                                        <label for="getcat_id" class="col-form-label">{{ trans('labels.category') }}</label>
                                        <select name="getcat_id" class="form-control" id="getcat_id">
                                            <option value="">{{ trans('messages.select_category') }}</option>
                                            <?php
                                            foreach ($getcategory as $category) {
                                            ?>
                                            <option value="{{$category->id}}" {{ $item->cat_id == $category->id ? 'selected' : ''}}>{{$category->category_name}}</option>
                                            <?php
                                            }
                                            ?>
                                            @if ($errors->has('get_cat_id'))
                                                <span class="text-danger">{{ $errors->first('get_cat_id') }}</span>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="getitem_name" class="col-form-label">{{ trans('labels.item_name') }}</label>
                                        <input type="text" class="form-control" id="getitem_name" name="item_name" placeholder="{{ trans('messages.enter_item_name') }}" value="{{$item->item_name}}">
                                        @if ($errors->has('getitem_name'))
                                            <span class="text-danger">{{ $errors->first('getitem_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="getdelivery_time" class="col-form-label">{{ trans('labels.delivery_time') }}</label>
                                        <input type="text" class="form-control" name="getdelivery_time" id="getdelivery_time" placeholder="{{ trans('messages.enter_delivery_time') }}" value="{{$item->delivery_time}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="getaddons_id" class="col-form-label">{{ trans('labels.addons') }}</label>
                                        <?php
                                        $selected = explode(",", $item->addons_id);
                                        ?>
                                        <select name="addons_id[]" class="form-control selectpicker" multiple data-live-search="true" id="getaddons_id">
                                           @foreach($getaddons as $supplier)
                                             <option value="{{ $supplier->id }}" {{ (in_array($supplier->id, $selected)) ? 'selected' : '' }}>{{ $supplier->name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="getingredients_id" class="col-form-label">{{ trans('labels.ingredients') }}</label>

                                        <?php
                                        $iselected = explode(",", $item->ingredients_id);
                                        ?>
                                        <select name="ingredients_id[]" class="form-control selectpicker" multiple data-live-search="true" id="getingredients_id">
                                           @foreach($getingredients as $ingredients)
                                             <option value="{{ $ingredients->id }}" {{ (in_array($ingredients->id, $iselected)) ? 'selected' : '' }}>{{ $ingredients->ingredients}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            
                            @foreach ($getvariation as $ky => $variation)
                            <div class="row panel-body" id="del-{{$variation->id}}">
                                <input type="hidden" class="form-control" id="variation_id" name="variation_id[{{$ky}}]" value="{{$variation->id}}">

                                <div class="col-sm-3 nopadding">
                                    <div class="form-group">
                                        <label for="variation" class="col-form-label">{{ trans('labels.variation') }}</label>
                                        <input type="text" class="form-control" name="variation[{{$ky}}]" id="variation" placeholder="{{ trans('messages.enter_variation') }}" required="" value="{{$variation->variation}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 nopadding">
                                    <div class="form-group">
                                        <label for="product_price" class="col-form-label">{{ trans('labels.product_price') }}</label>
                                        <input type="text" class="form-control" id="product_price" name="product_price[{{$ky}}]" placeholder="{{ trans('messages.enter_product_price') }}" required="" value="{{$variation->product_price}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 nopadding">
                                    <div class="form-group">
                                        <label for="sale_price" class="col-form-label">{{ trans('labels.sale_price') }}</label>
                                        <input type="text" class="form-control" id="sale_price" name="sale_price[{{$ky}}]" placeholder="{{ trans('messages.enter_sale_price') }}" required="" value="{{$variation->sale_price}}">
                                    </div>
                                </div>
                                <div class="col-sm-1 nopadding">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button"  onclick="DeleteVariation('{{$variation->id}}','{{$item->id}}');"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $currentdata[] = array(
                                    "currentkey" => $ky
                                );
                            ?>
                            @endforeach

                            <hr>
                            <p id="counter" style="display: none;">{{count(array_column(@$currentdata, 'currentkey'))-1}}</p>
                            <label> Add Varation <button class="btn btn-success" type="button"  onclick="edititem_fields();"> + </button></label>

                            <div class="customer_records_dynamic"></div>

                            <div id="edititem_fields"></div>

                            <div class="row">
                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="getdescription" class="col-form-label">{{ trans('labels.description') }}:</label>
                                        <textarea class="form-control" rows="3" name="getdescription" id="getdescription" placeholder="Product Description">{{$item->item_description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-6">
                                    <div class="form-group">
                                        <label for="tax" class="col-form-label">{{ trans('labels.tax') }} (%)</label>
                                        <input type="text" class="form-control" name="tax" id="tax" value="{{$item->tax}}" placeholder="{{ trans('messages.enter_tax') }}">
                                    </div>
                                </div>
                            </div>

                            @if (env('Environment') == 'sendbox')
                                <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.update') }}</button>
                            @else
                                <button type="submit" class="btn btn-primary">{{ trans('labels.update') }}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddProduct" data-whatever="@addProduct">{{ trans('labels.add_image') }}</button>
            <div id="card-display">
                <div class="row" style="margin-top: 20px;">
                <?php
                foreach ($getitemimages as $itemimage) {

                ?>
                <div class="col-md-6 col-lg-3 dataid{{$itemimage->id}}" id="table-image">
                    <div class="card">
                        <img class="img-fluid" src='{!! asset("storage/app/public/images/item/".$itemimage->image) !!}' style="max-height: 255px; min-height: 255px;" >
                        <div class="card-body">
                            <button type="button" onClick="EditDocument('{{$itemimage->id}}')" class="btn mb-2 btn-sm btn-primary">{{ trans('labels.edit') }}</button>
                            @if (env('Environment') == 'sendbox')
                                <button type="button" class="btn mb-2 btn-sm btn-danger" onclick="myFunction()">{{ trans('labels.delete') }}</button>
                            @else
                                <button type="submit" onclick="DeleteImage('{{$itemimage->id}}','{{$itemimage->item_id}}')" class="btn mb-2 btn-sm btn-danger">{{ trans('labels.delete') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Images -->
<div class="modal fade" id="EditImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" name="editimg" class="editimg" id="editimg" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.images') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span id="emsg"></span>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('labels.images') }} (500x250)</label>
                        <input type="hidden" id="idd" name="id">
                        <input type="hidden" class="form-control" id="old_img" name="old_img">
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <input type="hidden" name="removeimg" id="removeimg">
                    </div>
                    <div class="galleryim"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btna-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
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

<!-- Add Item Image -->
<div class="modal fade" id="AddProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" name="addproduct" class="addproduct" id="addproduct" enctype="multipart/form-data">
            <span id="msg"></span>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.images') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('labels.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <span id="iiemsg"></span>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="colour" class="col-form-label">{{ trans('labels.images') }}:</label>
                        <input type="file" multiple="true" class="form-control" name="file[]" id="file" accept="image/*" required="">
                    </div>
                    <div class="gallery"></div>

                    <input type="hidden" name="itemid" id="itemid" value="{{request()->route('id')}}">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                    @if (env('Environment') == 'sendbox')
                        <button type="button" class="btn btn-primary" onclick="myFunction()">{{ trans('labels.save') }}</button>
                    @else
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">{{ trans('labels.save') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')
<script type="text/javascript">

    $(document).ready(function() {
    "use strict";
        $('#addproduct').on('submit', function(event){
            event.preventDefault();
            var form_data = new FormData(this);
            form_data.append('file',$('#file')[0].files);
            $('#preloader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/item/storeimages') }}",
                method:"POST",
                data:form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(result) {
                    $('#preloader').hide();
                    var msg = '';
                    $('div.gallery').html('');  
                    if(result.error.length > 0)
                    {
                        for(var count = 0; count < result.error.length; count++)
                        {
                            msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                        }
                        $('#iiemsg').html(msg);
                        setTimeout(function(){
                          $('#iiemsg').html('');
                        }, 5000);
                    }
                    else
                    {
                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message').html(msg);
                        $("#AddProduct").modal('hide');
                        $("#addproduct")[0].reset();
                        location.reload();
                    }
                },
            })
        });

        $('#editimg').on('submit', function(event){
            event.preventDefault();
            var form_data = new FormData(this);
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/item/updateimage') }}",
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
                        location.reload();
                    }
                },
            });
        });
    });

    function EditDocument(id) {
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/item/showimage') }}",
            data: {
                id: id
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                $('#preloader').hide();
                jQuery("#EditImages").modal('show');
                $('#idd').val(response.ResponseData.id);
                $('.galleryim').html("<img src="+response.ResponseData.img+" class='img-fluid' style='max-height: 200px;'>");
                $('#old_img').val(response.ResponseData.image);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
    }

    function DeleteImage(id,item_id) {
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
                    url:"{{ URL::to('admin/item/destroyimage') }}",
                    data: {
                        id: id,
                        item_id: item_id
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            swal.close();
                            location.reload();
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

     $(document).ready(function() {
         var imagesPreview = function(input, placeToInsertImagePreview) {
              if (input.files) {
                  var filesAmount = input.files.length;
                  $('div.gallery').html('');
                  var n=0;
                  for (i = 0; i < filesAmount; i++) {
                      var reader = new FileReader();
                      reader.onload = function(event) {
                           $($.parseHTML('<div>')).attr('class', 'imgdiv').attr('id','img_'+n).html('<img src="'+event.target.result+'" class="img-fluid">').appendTo(placeToInsertImagePreview); 
                          n++;
                      }
                      reader.readAsDataURL(input.files[i]);                                  
                 }
              }
          };

         $('#file').on('change', function() {
             imagesPreview(this, 'div.gallery');
         });
     
    });
    var images = [];
    function removeimg(id){
        images.push(id);
        $("#img_"+id).remove();
        $('#remove_'+id).remove();
        $('#removeimg').val(images.join(","));
    }

    function edititem_fields() {

        var counter = document.getElementById('counter');
        var editroom = counter.innerHTML;

       editroom++;
       var editobjTo = document.getElementById('edititem_fields')
       var editdivtest = document.createElement("div");
       editdivtest.setAttribute("class", "form-group editremoveclass"+editroom);
       var rdiv = 'editremoveclass'+editroom;
       editdivtest.innerHTML = '<input type="hidden" class="form-control" id="variation_id" name="variation_id['+ editroom +']"><div class="row panel-body"><div class="col-sm-3 nopadding"><div class="form-group"><label for="variation" class="col-form-label">{{trans('labels.variation')}}</label><input type="text" class="form-control" name="variation['+ editroom +']" id="variation" placeholder="{{trans('messages.enter_variation')}}" required=""></div></div><div class="col-sm-4 nopadding"><div class="form-group"><label for="product_price" class="col-form-label">{{trans('labels.product_price')}}</label><input type="text" class="form-control" id="product_price" name="product_price['+ editroom +']" placeholder="{{trans('messages.enter_product_price')}}" required=""></div></div><div class="col-sm-4 nopadding"><div class="form-group"><label for="product_price" class="col-form-label">{{trans('labels.sale_price')}}</label><input type="text" class="form-control" id="sale_price" name="sale_price['+ editroom +']" placeholder="{{trans('messages.enter_sale_price')}}" required="" value="0"></div></div><div class="col-sm-1 nopadding"> <div class="form-group"> <div class="input-group"> <div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_edit_fields('+ editroom +');"> - </button></div></div></div></div><div class="clear"></div>';
       counter.innerHTML = editroom;
       editobjTo.appendChild(editdivtest)
    }
    function remove_edit_fields(rid) {
      $('.editremoveclass'+rid).remove();
    }

    function DeleteVariation(id,item_id) {
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
                    url:"{{ URL::to('admin/item/deletevariation') }}",
                    data: {
                        id: id,
                        item_id: item_id,
                    },
                    method: 'POST', //Post method,
                    dataType: 'json',
                    success: function(response) {
                        if (response == 1) {
                            swal.close();
                            location.reload();
                        } else if  (response == 2) {
                            swal("Cancelled", "{{ trans('messages.cannot_delete') }} :(", "error");
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

    $('#tax').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
             val = val.replace(/[^0-9\.]/g,'');
             if(val.split('.').length>2) 
                 val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });
</script>
@endsection