<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){
		//$productsAll =Product::orderBy('id','DESC')->get();
		$productsAll = Product::inRandomOrder()->where('status',1)->where('feature_item',1)->paginate(3);
		$categories = Category::with('categories')->where(['parent_id' =>0])->get();
		//$categories = json_decode(json_encode($categories));
		
		//"<pre>"; print_r($categories_menu); die;
		return view('index')->with(compact('productsAll','categories'));
		 
    }
}
