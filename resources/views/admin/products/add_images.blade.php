@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
	<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Product Image</a> </div>
    <h1>Product Image</h1>
  </div>
  <div class="container-fluid"><hr>
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
				<div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
					<h5>Add Images</h5>
				</div>
				<div class="widget-content nopadding">
				<form multiple enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add-images/'. $productDetails->id)}}" name="add_image" id="add_image" novalidate="novalidate">{{csrf_field()}}
			
				  <div class="control-group">
					<label class="control-label">Product Name</label>
					<div class="controls">
					  <label class="control-label"> <strong>{{$productDetails->product_name}}</strong></label>
					</div>
				  </div>
				  
				
				  <div class="control-group">
					<label class="control-label">Product Code</label>
					<div class="controls">
					  <label class="control-label"> <strong>{{$productDetails->product_code}}</strong></label>
					</div>
				  </div>
				 <div class="control-group">
					<label class="control-label">Image(s)</label>
					<div class="controls">
						<input type="file" name="image[]" id="image" multiple="multiple">
					</div>
				 </div>
				  
				  <div class="form-actions">
					<input type="submit" value="Add Images" class="btn btn-success">
				  </div>
            </form>
				
				</div>
			</div>
			
			 <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Category</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Image ID</th>
                  <th>Product ID</th>
				  <th>Image</th>              
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @foreach($productImages as $image)
                <tr class="gradeX">
                  <td class="center">{{ $image->id }}</td>
                  <td class="center">{{ $image->product_id }}</td>
                  <td class="center"><img width=130px src="{{ asset('images/backend_images/products/small/'.$image->image) }}"></td>
                  <td class="center"><a id="delImage" rel="{{ $image->id }}" rel1="delete-alt-image" href="{{url('/admin/delete-alt-image/'.$image->id)}}" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
				

                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
			
		</div>
	</div>
  </div>
</div>

@endsection