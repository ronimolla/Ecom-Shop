<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
	public function orders(){
		 return $this->hasMany('App\OrdersProduct','order_id');
	}
	  public static function getOrderDetails($order_id){
    	$getOrderDetails = Order::where('id',$order_id)->first();
    	return $getOrderDetails;
    }
   
}
