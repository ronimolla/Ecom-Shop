<?php

namespace App\Http\Controllers;
//use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Coupon;
use App\Country;
use App\DeliveryAddress;
use App\User;
use App\order;
use App\OrdersProduct;

use DB;


class ProductsController extends Controller
{
	
    public function addProduct(Request $request){
		
		if($request->isMethod('post')){
			$data = $request->all();
			if(empty($data['status'])){
				$status ='0';
			
			}else{
				$status = '1';
			}
			if(empty($data['feature-item'])){
				$feature_item ='0';
			
			}else{
				$feature_item = '1';
			}
			$product = new Product;
			$product->category_id=$data['category_id'];
			$product->product_name=$data['product_name'];
			$product->product_code=$data['product_code'];
			$product->product_color=$data['product_color'];
			$product->description=$data['product_description'];
			$product->price=$data['product_price'];
			$product->status = $status ;
			$product->feature_item = $feature_item ;
			if($request->hasFile('image')){
				$image_temp = Input::file('image');
		
				if($image_temp->isValid()){
					$extension = $image_temp->getClientOriginalExtension();
					$filename = rand(111,99999).'.'.$extension;
					//echo $filename; die;
					$large_image_path = 'images/backend_images/products/large/'.$filename;
					$medium_image_path = 'images/backend_images/products/medium/'.$filename;
					$small_image_path = 'images/backend_images/products/small/'.$filename;
					
					Image::make($image_temp)->save($large_image_path );
					Image::make($image_temp)->resize(600,600)->save($medium_image_path );
					Image::make($image_temp)->resize(300,300)->save($small_image_path );
					
					$product->image=$filename;
				}
			}
			$product->save();
			
			return redirect()->back()->with('flash_message_success','category added Successfully');
			//return redirect('admin/view-product')->with('flash_message_success','category delete Successfully');
			
		}
		
		//categories dropdown
		$categorydetails = Category::where(['parent_id'=>0])->get();
		$categories_dropdown = "<option selected disabled>Select Category </option>";
		foreach($categorydetails as $cat){ 
			$categories_dropdown .="<option value='".$cat->id."'>".$cat->name."</option>";
			$sub_categorydetails = Category::where(['parent_id'=>$cat->id])->get();
			foreach($sub_categorydetails as $sub_cat){
			$categories_dropdown .="<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
		}
		}
		//end categories dropdown
		return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }
	
	
	
	public function viewProduct(Request $request){

		$products = Product::get();	
		//$products = json_decode(json_encode($products));
		//echo "<pre>"; print_r($products); die;
		foreach($products as $key=>$val){
			$category_name = Category::where(['id'=>$val->category_id])->first();			
			$products[$key]->category_name =$category_name['name'];
		}
		
		//echo "<pre>"; print_r($products); die;
		return view('admin.products.view_product')->with(compact('products'));
    }
	
	
	public function editProduct(Request $request,$id= null){
		//echo "test"; die;
		//get product details
		$productdetails = Product::where(['id'=>$id])->first();
		
	//categories dropdown
		$categorydetails = Category::where(['parent_id'=>0])->get();
		$categories_dropdown = "<option selected disabled>Select Category </option>";
		foreach($categorydetails as $cat){
			if($cat->id==$productdetails->category_id){
				$selected = "selected";
			}else{
				$selected = "";
			}
			$categories_dropdown .="<option value='".$cat->id."'".$selected.">".$cat->name."</option>";
			$sub_categorydetails = Category::where(['parent_id'=>$cat->id])->get();
		foreach($sub_categorydetails as $sub_cat){
			if($sub_cat->id==$productdetails->category_id){
				$selected = "selected";
			}else{
				$selected = "";
			}
			$categories_dropdown .="<option value='".$sub_cat->id."'".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
		}
						
		}
	//end categories dropdown
		
		if($request->isMethod('post')){
			$data = $request->all();
			if(empty($data['status'])){
				$status =0;
			
			}else{
				$status = 1;
			}
			if(empty($data['feature-item'])){
				$feature_item ='0';
			
			}else{
				$feature_item = '1';
			}
			if($request->hasFile('image')){
				$image_temp = Input::file('image');
				if($image_temp->isValid()){
					$extension = $image_temp->getClientOriginalExtension();
					$filename = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/'.$filename;
					$medium_image_path = 'images/backend_images/products/medium/'.$filename;
					$small_image_path = 'images/backend_images/products/small/'.$filename;
					
					Image::make($image_temp)->save($large_image_path );
					Image::make($image_temp)->resize(600,600)->save($medium_image_path );
					Image::make($image_temp)->resize(300,300)->save($small_image_path );
					
					
				}
			}else{
				$filename = $data['current_image'];
			}
			
			//echo "<pre>"; print_r($data); die;
			Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'price'=>$data['price'],'image'=>$filename,'feature_item'=>$feature_item,'status'=>$status]);
			
			return redirect('/admin/view-product')->with('flash_message_success','product eddit successfully'); 
			
		}
		
		
		return view('admin.products.edit_product')->with(compact('productdetails','categories_dropdown'));
		
    }
	
	
	public function deleteProductImage($id= null){		
		Product::where(['id'=>$id])->update(['image'=>'']);
		
		return redirect()->back()->with('flash_message_success','category delete Successfully'); 
		  
	}
	
	
	public function deleteProduct($id= null){	
		// Get Product Image
        $productImage = ProductsImage::where('id',$id)->first();

        // Get Product Image Paths
        $large_image_path = 'images/backend_images/product/large/';
        $medium_image_path = 'images/backend_images/product/medium/';
        $small_image_path = 'images/backend_images/product/small/';

        // Delete Large Image if not exists in Folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Medium Image if not exists in Folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Small Image if not exists in Folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
		Product::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success','category delete Successfully'); 
		  
	}
	
	//Add attribute for product
	public function addAttributes(Request $request, $id=null){
		
		$productDetails = Product::with('attributes')->where(['id' => $id])->first();
		if($request->isMethod('post')){
        $data = $request->all();
		foreach($data['sku'] as $key => $val){
				//echo "$val"; die;
            if(!empty($val)){
		         $attrCountSKU = ProductsAttribute::where(['sku'=>$val])->count();
				/* //echo "$attrCountSKU"; die;
                if($attrCountSKU>1){
                    return redirect('admin/add-attribue/'.$id)->with('flash_message_error', 'SKU already exists. Please add another SKU.');    
                } 
                $attrCountSizes = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                if($attrCountSizes>1){
                    return redirect('admin/add-attribue/'.$id)->with('flash_message_error', 'Attribute already exists. Please add another Attribute.');    
                }   */
				$attr = new ProductsAttribute;
                $attr->product_id = $id;
                $attr->sku = $val;
                $attr->size = $data['size'][$key];
                $attr->price = $data['price'][$key];
                $attr->stok = $data['stock'][$key];
                $attr->save();
				} 
			} 
		 return redirect()->back()->with('flash_message_success', 'Product Attributes has been added successfully');
		 } 
		return view('admin.products.add_attributes')->with(compact('productDetails'));
		
	}
	
	//Add attribute for product
	public function editAttributes(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach($data['idAttr'] as $key=> $attr){
                if(!empty($attr)){
                    ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stok' => $data['stok'][$key]]);
                }
            }
            return redirect()->back()->with('flash_message_success', 'Product Attributes has been updated successfully');
        }
    }
	
	
	public function deleteAttributes($id = null){
			ProductsAttribute::where(['id'=>$id])->delete();
			return redirect()->back()->with('flash_message_success', 'Product Attribute has been deleted successfully');
		}
	
	
	public function addImages(Request $request, $id=null){
		//echo "test"; die;
		$productDetails = Product::with('attributes')->where(['id' => $id])->first();
	
		if($request->isMethod('post')){
			$data =$request->all();
			if ($request->hasFile('image')) {
                $files = $request->file('image');
				foreach($files as $file){
					$image = new ProductsImage;
					
					$extension = $file->getClientOriginalExtension();
					$fileName = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/'.$fileName;
					$medium_image_path = 'images/backend_images/products/medium/'.$fileName;  
					$small_image_path = 'images/backend_images/products/small/'.$fileName;  
					Image::make($file)->save($large_image_path);
					Image::make($file)->resize(600, 600)->save($medium_image_path);
					Image::make($file)->resize(300, 300)->save($small_image_path);
					$image->image = $fileName;  
					$image->product_id = $id;
					$image->save();
				}
				
			}
			return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Product Images has been added successfully'); 
		}
		
		$productImages = ProductsImage::where(['product_id' => $id])->orderBy('id','DESC')->get();
        $title = "Add Images";
            
		return view('admin.products.add_images')->with(compact('title','productDetails','category_name','productImages'));
		
	}
	

	public function deleteImage($id= null){		
		ProductsImage::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success','category delete Successfully'); 
		  
	}


	public function products($url=null){
		// Show 404 Page if Category does not exists
     	$categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
    	if($categoryCount==0){
    		abort(404);
    	}
		
		$categories = Category::with('categories')->where(['parent_id' => 0])->get();
	
		$categoryDetails = Category::where(['url'=>$url])->first();
		if($categoryDetails->parent_id==0){
    		$subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();
    		//$subCategories = json_decode(json_encode($subCategories));
    		foreach($subCategories as $subcat){
    			$cat_ids[] = $subcat->id;
    		}
    	    $productsAll = Product::whereIn('category_id', $cat_ids)->get();
			 $breadcrumb = "<a href='/'>Home</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
    	}else{
    		$productsAll = Product::where(['category_id'=>$categoryDetails->id])->get();	
			 $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$mainCategory->url."'>".$mainCategory->name."</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
    	}
		
		
		//$colorArray = array('Black','Blue','Brown','Gold','Green','Orange','Pink','Purple','Red','Silver','White','Yellow');
		
	
		return view('products.listing')->with(compact('categories','productsAll','categoryDetails','breadcrumb'));
	
	
	}
	
	
	public function searchProducts(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            $search_product = $data['product'];
           $productsAll = Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->get();

             /*$productsAll = Product::where(function($query) use($search_product){
                $query->where('product_name','like','%'.$search_product.'%')
                ->orWhere('product_code','like','%'.$search_product.'%')
                ->orWhere('description','like','%'.$search_product.'%')
                ->orWhere('product_color','like','%'.$search_product.'%');
            })->where('status',1)->get();

            //$breadcrumb = "<a href='/'>Home</a> / ".$search_product;*/

            return view('products.listing')->with(compact('categories','productsAll','search_product','breadcrumb')); 
        }
    }
	
	
    
	public function product($id = null){
		
		// Show 404 Page if Category does not exists
     	$productsCount = Product::where(['id'=>$id,'status'=>1])->count();
    	if($productsCount==0){
    		abort(404);
    	}
		 // Get Product Details
        $productDetails = Product::with('attributes')->where('id',$id)->first();
		//gets other product same category
		$relatedProducts = Product::where('id','!=',$id)->where(['category_id' => $productDetails->category_id])->get();
		$categories = Category::with('categories')->where(['parent_id' => 0])->get();
	
		// Get Product Alt Images
        $productAltImages = ProductsImage::where('product_id',$id)->get();
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stok');
	
		  return view('products.detail')->with(compact('productDetails','categories','productAltImages','total_stock','relatedProducts'));

	 }


	public function getProductPrice(Request $request){
        $data = $request->all(); 
        $proArr = explode("-",$data['idsize']);
        $proAttr = ProductsAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
        echo $proAttr->price; 
        echo "#";
        echo $proAttr->stok; 
    }
	

	// add to cart function
	public function addtocart(Request $request){
		
		Session::forget('CouponAmount');
        Session::forget('CouponCode'); 
		$data = $request->all();
	 
	   if(empty(Auth::user()->email)){
            $data['user_email'] = '';    
        }else{
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = str_random(40);
            Session::put('session_id',$session_id);
        }
		$sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];
		
		$getSKU = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
		$getProductStock = ProductsAttribute::where('sku',$getSKU->sku)->first();
		/* $products = json_decode(json_encode($getProductStock));
		echo "<pre>"; print_r($products); die;
		 */
		
		//prevent to add dupticate product
		$countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_code'=>$getSKU['sku'],'size' => $product_size,'session_id' => $session_id])->count();
	
         if($countProducts>0 ){
            return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
        }
		  
		 if($getProductStock->stok>=$data['quantity']){
			DB::table('cart')->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' =>  $getProductStock['sku'],'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id]);
			return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
             
        } else{
			return redirect()->back()->with('flash_message_error','Product outof stoke!');  
		}

		
	}
	
	// show the added card product
	public function cart(){ 

        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();     
        }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();    
        }
		
         foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
           $product->image = $productDetails->image;
        }  
        //echo "<pre>"; print_r($userCart); die;
        return view('products.cart')->with(compact('userCart'));
    }


	public function updateCartQuantity($id=null,$quantity=null){
		
		Session::forget('CouponAmount');
        Session::forget('CouponCode'); 
    
        $getProductSKU = DB::table('cart')->where('id',$id)->first();
        $getProductStock = ProductsAttribute::where('sku',$getProductSKU->product_code)->first();
		
        $updated_quantity = $getProductSKU->quantity+$quantity;
	   
        if($getProductStock->stok>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity); 
            return redirect('cart')->with('flash_message_success','Product Quantity has been updated in Cart!');   
        }else{
            return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');    
        } 
  
    }

	
    public function deleteCartProduct($id=null){
	 
        Session::forget('CouponAmount');
        Session::forget('CouponCode'); 
		
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Product has been deleted in Cart!');
    }
	
	
	public function applyCoupon(Request $request){
		
		Session::forget('CouponAmount');
        Session::forget('CouponCode'); 
		
        $data = $request->all();
		
		$couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error','This coupon does not exists!');
        }else{
			// Get Coupon Details
            $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();

			 if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error','This coupon is not active!');
            } 
			// If coupon is Expired
            $expiry_date = $couponDetails->expire_date;
            $current_date = date('Y-m-d');			
           if($expiry_date < $current_date){
                return redirect()->back()->with('flash_message_error','This coupon is expired!');
            }
			 if(Auth::check()){
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();     
            }else{
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();    
            }
            $total_amount = 0;
			foreach($userCart as $item){
               $total_amount = $total_amount + ($item->price * $item->quantity);
            }
			
			// Check if amount type is Fixed or Percentage
            if($couponDetails->amount_type=="Fixed"){
                $couponAmount = $couponDetails->amount;
            }else{
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }
			
			// Add Coupon Code & Amount in Session
            Session::put('CouponAmount',$couponAmount);
            Session::put('CouponCode',$data['coupon_code']);

            return redirect()->back()->with('flash_message_success','Coupon code successfully
                applied. You are availing discount!');
		}
	}

	
    public function checkout(Request $request){
		$user_id = Auth::user()->id;
		$user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
		$countries = Country::get();
		
		$shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
		$shippingDetails = array();
		  if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        } 
	
		 // Update cart table with user email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
		if($request->isMethod('post')){
			 $data = $request->all();
            //echo "<pre>"; print_r($data); die;
			// Return to Checkout page if any of the field is empty
            if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])){
                    return redirect()->back()->with('flash_message_error','Please fill all fields to Checkout!');
            }
			
			// Update User details
            User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);
			
			
			if($shippingCount>0){
                // Update Shipping Address
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
            }else{
                // Add New Shipping Address
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->country = $data['shipping_country'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }
			return redirect()->action('ProductsController@orderReview');
			
			
		}
		
		
		
		return view('products.checkout')->with(compact('countries','userDetails','shippingDetails'));
	}
	

    public function orderReview(){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        foreach($userCart as  $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $product->image = $productDetails->image;
        }
        /*echo "<pre>"; print_r($userCart); die;*/
        return view('products.order_review')->with(compact('userDetails','shippingDetails','userCart'));
    }	

	
	public function placeOrder(Request $request){
		
		if($request->isMethod('post')){
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
		    //echo "<pre>"; print_r($data); die;
			
			 $userCart = DB::table('cart')->where('user_email',$user_email)->get();
			 foreach($userCart as $cart){
				 
				$getAttributeCount = Product::getAttributeCount($cart->product_id,$cart->size);
                if($getAttributeCount==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','One of the product is not available. Try again!');
                }
				 
				$product_stock = Product::getProductStock($cart->product_id,$cart->size);
                 if($product_stock==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','Sold Out product removed from Cart. Try again!');
                } 
				if($cart->quantity>$product_stock){
                    return redirect('/cart')->with('flash_message_error','Reduce Product Stock and try again.');    
                }
				
				$product_status = Product::getProductStatus($cart->product_id);
                if($product_status==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','Disabled product removed from Cart. Please try again!');
                }
				
				
			}
			
			// Get Shipping Address of User
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
		
			if(empty(Session::get('CouponCode'))){
               $coupon_code = ''; 
            }else{
               $coupon_code = Session::get('CouponCode'); 
            }

            if(empty(Session::get('CouponAmount'))){
               $coupon_amount = ''; 
            }else{
               $coupon_amount = Session::get('CouponAmount'); 
            }
			
			$order = new order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();
			
			$order_id = DB::getPdo()->lastInsertId();
			$cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
			
			foreach($cartProducts as $pro){
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();
				
				$getProductStock = ProductsAttribute::where('sku',$pro->product_code)->first();
                $newStock = $getProductStock->stok - $pro->quantity;
                if($newStock<0){
                    $newStock = 0;
                }
               ProductsAttribute::where('sku',$pro->product_code)->update(['stok'=>$newStock]);
                // Reduce Stock Script Ends
            }
			Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);
			
			 if($data['payment_method']=="COD"){
			//redurect user to thanks page
			return redirect('/thanks');
			 }else{
                // Paypal - Redirect user to paypal page after saving order
                return redirect('/paypal');
            }
		}
		 
			
	}
	
	
	public function paypal(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
	
    }
	
	
	public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }
	

	public function userOrders(){
        $user_id = Auth::user()->id;
        $orders = order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        return view('orders.users_orders')->with(compact('orders'));
    }
	
	
	public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }
	
	
	//for admin pannel
	public function viewOrders(){
        $orders = order::with('orders')->orderBy('id','Desc')->get();
        $orders = json_decode(json_encode($orders));
        /*echo "<pre>"; print_r($orders); die;*/
        return view('admin.orders.view_orders')->with(compact('orders'));
    }
	
	
	public function viewOrderDetails($order_id){
        $orderDetails = order::with('orders')->where('id',$order_id)->first();
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
       
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }
	
	
	public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            return redirect()->back()->with('flash_message_success','Order Status has been updated successfully!');
        }
    }
	
	public function viewOrderInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
	
}



