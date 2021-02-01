@extends('layouts.adminLayout.admin_design')
@section('content')


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1> 
    
  </div>
  <div class="container-fluid">
    <hr>
		@if($message = Session::get('flash_message_error'))
		<div class="alert alert-error alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
		@endif
		@if($message = Session::get('flash_message_success'))
		<div class="alert alert-error alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
		@endif
    <div class="row-fluid">
      <div class="span12">
 
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product ID</th>
				  <th>Category ID</th>
				  <th>Category Name</th>
                  <th>Product Name</th>
				  <th>Product Code</th>
                  <th>Product Color</th>
				  <th>Product Price</th>
				  <th>Product Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @foreach($products as $product)
                <tr class="gradeX">
                  <td>{{$product->id}}</td>
                  <td>{{$product->category_id}}</td>
				  <td>{{$product->category_name}}</td>
				  <td>{{$product->product_name}}</td>
				  <td>{{$product->product_code}}</td>
                  <td>{{$product->product_color}}</td>
				  <td> INR {{$product->price}}</td>
				  <td>
				  @if(!empty($product->image))
					<img src="{{asset('/images/backend_images/products/small/'.$product->image)}}" style="width:50px">
				  @endif
				  </td>
                  <td class="center"><a href="{{url('/admin/edit-product/'.$product->id)}}" class="btn btn-primary btn-mini">Edit</a>
				  <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
				  <a href="{{url('/admin/add-attribue/'.$product->id)}}" class="btn btn-primary btn-mini">AddAttribue</a>
				  <a href="{{url('/admin/add-images/'.$product->id)}}" class="btn btn-info btn-mini" title="Add Images">AddImg</a>
				  <a id = "delproduct" href="{{url('/admin/delete-product/'.$product->id)}}" class="btn btn-danger btn-mini">Delete</a></div></td>
                </tr> 
				<div id="myModal{{$product->id}}" class="modal hide">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">×</button>
						<h3>{{$product->product_name}} Full Details</h3>
					</div>
					<div class="modal-body">
						<p>Product ID :{{$product->id}}</p>
						<p>Category ID : {{$product->category_id}}</p>
						<p>Category Name : {{$product->category_name}}</p>
						<p>Product Name : {{$product->product_name}}</p>
						<p>Product Code : {{$product->product_code}}</p>
						<p>Product Color : {{$product->product_color}}</p>
						<p>Product Price :INR {{$product->price}}</p>
					</div>
				</div>

				@endforeach
				

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection