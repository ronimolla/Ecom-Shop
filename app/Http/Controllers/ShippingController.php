<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingCharge;

class ShippingController extends Controller
{
	
	public function viewShipping(){
		$shipping_charges = ShippingCharge::get();
		return view('admin.shiping.view_shiping')->with(compact('shipping_charges'));
	}      
	
	public function editShipping($id, Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			/*echo "<pre>"; print_r($data); die;*/
			ShippingCharge::where('id',$id)->update(['shipping_charges0_500g'=>$data['shipping_charges0_500g'],'shipping_charges501_1000g'=>$data['shipping_charges501_1000g'],'shipping_charges1001_2000g'=>$data['shipping_charges1001_2000g'],'shipping_charges2001_5000g'=>$data['shipping_charges2001_5000g']]);
			return redirect()->back()->with('flash_message_success','Shipping Charges updated Successfully!');
		}
		$shippingDetails = ShippingCharge::where('id',$id)->first();
		return view('admin.shiping.edit_shiping')->with(compact('shippingDetails'));
	}

}
