@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Edit Product</a> </div>
    <h1> EditProducts</h1>
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
            <h5>Add Products</h5>
          </div>
          <div class="widget-content nopadding">
            <form multiple enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/edit-product/'.$productdetails->id)}}" name="edit_product" id="edit_product" novalidate="novalidate">{{csrf_field()}}
			
			  <div class="control-group">
              <label class="control-label">Under Category</label>
              <div class="controls">
                <select name="category_id" id="category_id" style="width:220px" >
                  <?php echo $categories_dropdown;?>

                </select>
              </div>
			  
			  <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value ="{{$productdetails->product_name}}">
                </div>
              </div>
			  
            </div>
              <div class="control-group">
                <label class="control-label">Product Code</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code"value ="{{$productdetails->product_code}}">
                </div>
              </div>
			  
			  <div class="control-group">
                <label class="control-label">Product Color</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color" value ="{{$productdetails->product_color}}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea type="text" name="description" id="description" value ="{{$productdetails->description}}"></textarea>
                </div>
              </div>
			  
			  <div class="control-group">
                <label class="control-label">Product Price</label>
                <div class="controls">
                  <input type="text" name="price" id="price" value ="{{$productdetails->price}}">
                </div>
              </div>
			  <div class="control-group">
                <label class="control-label">Image</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
				  <input type="hidden" name="current_image" id="current_image" value ="{{$productdetails->image}}">
				  @if(!empty($productdetails->image))
				  <img src="{{asset('/images/backend_images/products/small/'.$productdetails->image)}}" style="width:50px"> | <a href="{{url('/admin/delete-product-image/'.$productdetails->id)}}">Delete</a> 
				  @endif
                </div>
              </div>
			  <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="feature-item" id="feature-item" @if($productdetails->feature_item=="1") checked @endif value="1">
                </div>
              </div>
			  <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($productdetails->status=="1") checked @endif value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit product" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection