@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
	<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Product Attribute</a> </div>
    <h1>Product Attribute</h1>
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
					<h5>Add Attributes</h5>
				</div>
				<div class="widget-content nopadding">
				<form multiple enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add-attribue/'. $productDetails->id)}}" name="add_product" id="add_product" novalidate="novalidate">{{csrf_field()}}
				
			
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
					<label class="control-label">Product Color</label>
					<div class="controls">
					  <label class="control-label"> <strong>{{$productDetails->product_color}}</strong></label>
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label"></label>
					<div class="field_wrapper">
						<div>
							<input type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px"/>
							<input type="text" name="size[]" id="size" placeholder="SIZE" style="width:120px"/>
							<input type="text" name="price[]" id="price" placeholder="PRCE" style="width:120px"/>
							<input type="text" name="stock[]" id="stock" placeholder="STOCK" style="width:120px"/>
							
							<a href="javascript:void(0);" id="add_button" class="add_button" title="Add field" >Add</a>
						</div>
					</div>
				  </div>
				  
				  <div class="form-actions">
					<input type="submit" value="Add Attribute" class="btn btn-success">
				  </div>
            </form>
				
				</div>
			</div>
			
			 <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Attribute</h5>
          </div>
          <div class="widget-content nopadding">
			 <form action="{{ url('admin/edit-attribue/'.$productDetails->id) }}" method="post">{{ csrf_field() }}
				<table class="table table-bordered data-table">
				  <thead>
					<tr>
					  <th>Attribute ID</th>
					  <th>SKU</th>
					  <th>Size</th>
					  <th>Price</th>
					  <th>Stok</th>
					  <th>Actions</th>
					</tr>
				  </thead>
				  <tbody>
				  @foreach($productDetails['attributes'] as $attr)
					<tr class="gradeX">
					  <td class="center"><input type="hidden" name="idAttr[]" value="{{ $attr->id }}">{{ $attr->id }}</td>
					  <td>{{$attr->sku}}</td>
					  <td>{{$attr->size}}</td>
					  <td class="center"><input name="price[]" type="text" value="INR {{ $attr->price }}" /></td>
					  <td class="center"><input name="stok[]" type="text" value="{{ $attr->stok }}" required /></td>
					  <td class="center">
						  <input type="submit" value="Update" class="btn btn-primary btn-mini" />
						  <a id = "delattribute" href="{{url('/admin/delete-attribute/'.$attr->id)}}" class="btn btn-primary btn-mini">Delete</a> </div>
					  </td>
					</tr>
					@endforeach

				  </tbody>
				</table>
			</form>
          </div>	
		</div>
	</div>
  </div>
</div>

@endsection