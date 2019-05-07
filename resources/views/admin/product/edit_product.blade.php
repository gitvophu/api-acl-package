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
                            '<i class="fa fa-user"></i> Update' !!} product</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
            <form action="{{route('products.update')}}" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="id" id="" value="{{$product->id}}">
                <div class="form-group col-md-6">
                  <label for="">Name</label>
                <input type="text" name="name" id="" class="form-control" placeholder="" aria-describedby="helpId" value="{{$product->name}}">
                  <small id="helpId" class="text-muted">Tên sản phẩm</small>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                 <label for="">Price</label>
                 <input value="{{$product->price}}" type="text" name="price" id="" class="form-control" placeholder="" aria-describedby="helpId">
                 <small id="helpId" class="text-muted">Giá sản phẩm</small>
               </div>
                 <div class="clearfix"></div>
               <div class="form-group col-md-6">
                 <label for="">Description</label>
                 <input value="{{$product->description}}" type="text" name="description" id="" class="form-control" placeholder="" aria-describedby="helpId">
                 <small id="helpId" class="text-muted">Mô tả</small>
               </div>
               <div class="clearfix"></div>
               <button type="submit" class="btn btn-primary">Save</button>
               </form>
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