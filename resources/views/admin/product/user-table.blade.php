<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {!! $request->all() ? 'Search results:' : 'Users'
            !!}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-10 col-md-9 col-sm-9">
                {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
                <div class="form-group">
                    {!! Form::select('order_by', ["" => "select column", "first_name" => "First name", "last_name" =>
                    "Last name", "email" => "Email", "last_login" => "Last login", "active" => "Active"],
                    $request->get('order_by',''), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('ordering', ["asc" => "Ascending", "desc" => "descending"],
                    $request->get('ordering','asc'), ['class' =>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Order', ['class' => 'btn btn-default']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <a href="{!! URL::route('products.create') !!}" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(! count($products) == 0 )
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="hidden-xs">Description</th>
                            <th class="hidden-xs">Price</th>

                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{!! $product->name !!}</td>
                            <td class="hidden-xs">{!! $product->description !!}</td>
                            <td class="hidden-xs">{!! $product->price !!}</td>
                            <td>

                                <a href="{!! route('products.edit', ['id' => $product->id]) !!}"><i
                                        class="fa fa-pencil-square-o fa-2x"></i></a>
                                <a href="{!! route('products.delete',['id' => $product->id, '_token' => csrf_token()]) !!}"
                                    class="margin-left-5 delete"><i class="fa fa-trash-o fa-2x"></i></a>


                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <div class="paginator">
                </div>
                @else
                <span class="text-warning">
                    <h5>No results found.</h5>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>