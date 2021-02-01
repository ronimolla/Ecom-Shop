<!--sidebar-menu-->
<?php $url = url()->current(); ?>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i>Dashboard</a>
  <ul>
    <li  <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
	 
	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
		<ul <?php if (preg_match("/categor/i", $url)){ ?> style="display: block;" <?php } ?>>
		  <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?> ><a href="{{url('/admin/add-category')}}">Add category</a></li>
		  <li <?php if (preg_match("/view-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view-category')}}">View categories</a></li>

		</ul>
    </li>
	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>products</span> <span class="label label-important">2</span></a>
		<ul <?php if (preg_match("/product/i", $url)){ ?> style="display: block;" <?php } ?>>
		  <li <?php if (preg_match("/add-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/add-product')}}">Add Products</a></li>
		  <li <?php if (preg_match("/view-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view-product')}}">View Products</a></li>

		</ul>
    </li>
	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
		<ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
		  <li <?php if (preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/add-coupon')}}">Add Coupons</a></li>
		  <li <?php if (preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view-coupons')}}">View Coupons</a></li>

		</ul>
    </li> 

	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> <span class="label label-important">1</span></a>
		<ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
		  <li <?php if (preg_match("/view-orders/i", $url)){ ?> class="active" <?php } ?>><a href="{{url('/admin/view-orders')}}">View Orders</a></li>

		</ul>
    </li>  
	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/users/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-users/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users')}}">View Users</a></li>
      </ul>
    </li>	
	
	<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Admins/Sub-Admins</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/admins/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-admin/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-admin')}}">Add Admin/Sub-Admin</a></li>
        <li <?php if (preg_match("/view-admins/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-admins')}}">View Admins/Sub-Admins</a></li>
      </ul>
    </li>
	
   
   <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>CMS Pages</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/cms-page/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-cms-page/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-cms-page')}}">Add CMS Page</a></li>
        <li <?php if (preg_match("/view-cms-pages/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-cms-pages')}}">View CMS Pages</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Enquiries</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/enquiries/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-enquiries/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-enquiries')}}">View Enquiries</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Currencies</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/currencies/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-currency/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-currency')}}">Add Currency</a></li>
        <li <?php if (preg_match("/view-currencies/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-currencies')}}">View Currencies</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Shipping</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/shipping/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-shipping/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-shipping')}}">Shipping Charges</a></li>
      </ul>
    </li>
   

    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->