<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show product
        //$products = Product::all();
        $products = Product::inRandomOrder()->where('status',1)->get();

        // show menu
        $categories = Category::where(['parent_id' => 0])->get();

        // category
        //$categories_menu = "";
        //$categories = Category::with('categories')->where(['parent_id' => 0])->get();
    	// $categories = json_decode(json_encode($categories));
    	// /*echo "<pre>"; print_r($categories); die;*/
		// foreach($categories as $cat){
		// 	$categories_menu .= "
		// 	<div class='panel-heading'>
		// 		<h4 class='panel-title'>
		// 			<a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
		// 				<span class='badge pull-right'><i class='fa fa-plus'></i></span>
		// 				".$cat->name."
		// 			</a>
		// 		</h4>
		// 	</div>
		// 	<div id='".$cat->id."' class='panel-collapse collapse'>
		// 		<div class='panel-body'>
        //             <ul>";

		// 			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
		// 			foreach($sub_categories as $sub_cat){
		// 				$categories_menu .= "<li><a href='#'>".$sub_cat->name." </a></li>";
		// 			}
		// 				$categories_menu .= "</ul>
		// 		</div>
		// 	</div>
		// 	";
        // }

        $banners = Banner::where('status',1)->get();
        //$banners = json_decode(json_encode($banners));

        //echo "<pre>";print_r($banners); die();

        return view('index',compact('products','categories','banners'));
    }
}
