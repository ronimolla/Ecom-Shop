<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* 
Route::get('/', function () {
    return view('welcome');
}); */

// admin controller steps
Route:: match(['get','post'],'/admin','AdminController@login');
Route::get('/logout','AdminController@logout');

Auth::routes();
Route::get('/home','HomeController@index')->name('home');


Route::group(['middleware' =>['adminlogin']],function(){
	// main admin
	Route::get('/admin/dashboard','AdminController@dashboard');
	Route::get('/admin/settings','AdminController@settings');
	Route::get('/admin/check_pwd','AdminController@checkPassword');
	Route:: match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');
	
	// Admin/Sub-Admins View Route
	Route::get('/admin/view-admins','AdminController@viewAdmins');
	Route::match(['get','post'],'/admin/add-admin','AdminController@addAdmin');
	Route::match(['get','post'],'/admin/edit-admin/{id}','AdminController@editAdmin');
	
	//Category Routes
	Route:: match(['get','post'],'/admin/add-category','categoryController@addCategory');
	Route:: match(['get','post'],'/admin/edit-category/{id}','categoryController@editCategory');
	Route:: match(['get','post'],'/admin/delete-category/{id}','categoryController@deleteCategory');
	Route:: get('/admin/view-category','categoryController@viewCategory');
	// Product routs
	Route:: match(['get','post'],'/admin/add-product','ProductsController@addProduct');
	Route:: match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
	Route:: get('/admin/view-product','ProductsController@viewProduct');
	Route:: get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
	Route:: get('/admin/delete-product/{id}','ProductsController@deleteProduct');
	//product attributes root
	Route:: match(['get','post'],'/admin/add-attribue/{id}','ProductsController@addAttributes');
	Route:: match(['get','post'],'/admin/edit-attribue/{id}','ProductsController@editAttributes');
	Route:: match(['get','post'],'/admin/add-images/{id}','ProductsController@addImages');
	Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteImage');
	Route:: get('/admin/delete-attribute/{id}','ProductsController@deleteAttributes');
	//coupon Routes
	Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
	Route::get('admin/view-coupons','CouponsController@viewCoupons');
	Route::get('/admin/view-coupons','CouponsController@viewCoupons');
	Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
	Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupon'); 
	
	// Admin Users Route
	Route::get('/admin/view-users','UsersController@viewUsers');
	
	// Admin viewOrders Routes
	Route::get('/admin/view-orders','ProductsController@viewOrders');
	Route::get('/admin/view-order/{id}','ProductsController@viewOrderDetails');
	Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');
	
	Route::get('/admin/view-order-invoice/{id}','ProductsController@viewOrderInvoice');
	// Add CMS Route 
	Route::match(['get','post'],'/admin/add-cms-page','CmsController@addCmsPage');
	Route::match(['get','post'],'/admin/edit-cms-page/{id}','CmsController@editCmsPage');
	Route::get('/admin/view-cms-pages','CmsController@viewCmsPages');
	Route::get('/admin/delete-cms-page/{id}','CmsController@deleteCmsPage');
	
	// Currencies Routes
	Route::match(['get','post'],'/admin/add-currency','CurrencyController@addCurrency');
	Route::match(['get','post'],'/admin/edit-currency/{id}','CurrencyController@editCurrency');
	Route::get('/admin/delete-currency/{id}','CurrencyController@deleteCurrency');
	Route::get('/admin/view-currencies','CurrencyController@viewCurrencies');
	
	// Update Shipping Charges
	Route::get('/admin/view-shipping','ShippingController@viewShipping');
	Route::match(['get','post'],'/admin/edit-shipping/{id}','ShippingController@editShipping');
	
});




//view for user without register or login
//first look of the webside for customer
Route::get('/','IndexController@index');
// Category/Listing Page
Route::get('/products/{url}','ProductsController@products');
// Product Detail Page
Route::get('/product/{id}','ProductsController@product');
// Get Product Attribute Price
Route::any('/get-product-price','ProductsController@getProductPrice');

// add to cart
Route:: match(['get','post'],'/add-cart','ProductsController@addtocart');
Route:: match(['get','post'],'/cart','ProductsController@cart');
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');

//Apply coupon code
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');
// Search Products
Route::post('/search-products','ProductsController@searchProducts');

//ending the viewing opting user without register or login





//Register/Login
Route::match(['GET','POST'],'/login-register','UsersController@register');
// Users Register Page
Route::get('/login-register','UsersController@userLoginRegister');
//forget password
Route::match(['get','post'],'forgot-password','UsersController@forgotPassword');
//login
Route::post('user-login','UsersController@login');
// Users Register Form Submit
Route::post('/user-register','UsersController@register');
//check email exit or not
Route::match(['GET','POST'],'/check-email','UsersController@checkEmail');
// Confirm Account
Route::get('confirm/{code}','UsersController@confirmAccount');
//logout for user
Route::get('/user-logout','UsersController@logout'); 



// All Routes after Login
Route::group(['middleware'=>['frontlogin']],function(){
	Route::match(['get','post'],'account','UsersController@account');
	// Check User Current Password
	Route::post('/check-user-pwd','UsersController@chkUserPassword');
	// Update User Password
	Route::post('/update-user-pwd','UsersController@updatePassword');
	//checkout routes
	Route::match(['get','post'],'checkout','ProductsController@checkout');
	//order route
	Route::match(['get','post'],'/order-review','ProductsController@orderReview');
	//Place order route
	Route::match(['get','post'],'/place-order','ProductsController@placeOrder');
	// Thanks Page after order by DOC
	Route::get('/thanks','ProductsController@thanks');
	// Paypal Page
	Route::get('/paypal','ProductsController@paypal');
	// Users Orders Page
	Route::get('/orders','ProductsController@userOrders');
	// User Ordered Products Details
	Route::get('/orders/{id}','ProductsController@userOrderDetails');
	
	

});


// Display CMS Page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage');



