@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit user
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{!! $message !!}</div>
        @endif
        @if($errors->has('model') )
        <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin">{!! isset($user->id) ? '<i class="fa fa-pencil"></i> Edit' :
                            '<i class="fa fa-user"></i> Create' !!} user</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
               <div class="form-group col-md-6">
                 <label for="">Name</label>
                 <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                 <small id="helpId" class="text-muted">Tên sản phẩm</small>
               </div>
               <div class="clearfix"></div>
               <div class="form-group col-md-6">
                <label for="">Price</label>
                <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Giá sản phẩm</small>
              </div>
                <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="">Description</label>
                <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                <small id="helpId" class="text-muted">Mô tả</small>
              </div>
              <div class="clearfix"></div>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
<script>
    $(".delete").click(function () {
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop