@extends('layouts.adminLayout.admin_design')
@section('content')


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">View Category</a> </div>
    <h1>Categories</h1> 
    
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
            <h5>View Category</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category ID</th>
                  <th>Category Name</th>
				  <th>Category Level</th>
                  <th>Category URL</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @foreach($categories as $category)
                <tr class="gradeX">
                  <td>{{$category->id}}</td>
                  <td>{{$category->name}}</td>
				  <td>{{$category->parent_id}}</td>
                  <td>{{$category->url}}</td>
                  <td class="center"><a href="{{url('/admin/edit-category/'.$category->id)}}" class="btn btn-primary btn-mini">Edit</a> <a id = "delcat" href="{{url('/admin/delete-category/'.$category->id)}}" class="btn btn-danger btn-mini">Delete</a></div></td>
                </tr>
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