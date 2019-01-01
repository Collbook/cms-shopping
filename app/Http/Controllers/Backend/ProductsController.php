<?php

namespace App\Http\Controllers\Backend;

use App\Product;
use App\Category;
use App\ProductsImage;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        //dd($products);
		foreach($products as $key => $val){
            $category_name = Category::where(['id' => $val->category_id])->first();
            //echo "<pre>"; print_r($category_name); die;
			$products[$key]->category_name = $category_name['name'];
		}
		//$products = json_decode(json_encode($products)); ??
		//echo "<pre>"; print_r($products); die;
		return view('admin.product.index')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where(['parent_id' => 0])->get();
		$categories_drop_down = "<option value='' selected disabled>Select</option>";
		foreach($categories as $cat){
			$categories_drop_down .= "<option value='".$cat->id."'>".$cat->name."</option>";
			$sub_categories = Category::where(['parent_id' => $cat->id])->get();
			foreach($sub_categories as $sub_cat){
				$categories_drop_down .= "<option value='".$sub_cat->id."'>&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";
			}
        }

        return view('admin.product.create',compact('categories_drop_down'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'category_id' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_color' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();

        // echo "<pre>";
        // print_r($data);
        // die();

        $product = new Product;
        if(empty($data['category_id']))
        {
            Toastr::error('Category not empty !','Errors');
            return redirect()->back();
        }
        $product->category_id = $data['category_id'];
        $product->product_name = $data['product_name'];
        $product->product_code = $data['product_code'];
        $product->product_color = $data['product_color'];

        if(!empty($data['description'])){
            $product->description = $data['description'];
        }else{
            $product->description = '';
        }

        if(empty($data['status'])){
            $status='0';
        }else{
            $status='1';
        }


        if(!empty($data['care'])){
            $product->care = $data['care'];
        }else{
            $product->care = '';
        }


        $product->price = $data['price'];

        if($request->hasFile('image')){
            $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111,99999).'.'.$extension;
                $large_image_path = 'backend/assets/images/products/large'.'/'.$fileName;
                $medium_image_path = 'backend/assets/images/products/medium'.'/'.$fileName;
                $small_image_path = 'backend/assets/images/products/small'.'/'.$fileName;

                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                $product->image = $fileName;
            }
        }
        $product->status = $status;
        $product->save();



        Toastr::success('Create products successfully !','Sucess');
        $product->save();

        return redirect()->back();
        // echo "<pre>";
        // print_r($data);
        // die;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Product Details start //
		$product = Product::find($id);
		// Get Product Details End //
		// Categories drop down start //
        $categories = Category::where(['parent_id' => 0])->get();

        $categories_drop_down = "<option value='' disabled>Select</option>";

		foreach($categories as $cat){
			if($cat->id==$product->category_id){
				$selected = "selected";
			}else{
				$selected = "";
			}
            $categories_drop_down .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";

            $sub_categories = Category::where(['parent_id' => $cat->id])->get();

			foreach($sub_categories as $sub_cat){
				if($sub_cat->id==$product->category_id){
					$selected = "selected";
				}else{
					$selected = "";
				}
				$categories_drop_down .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;&nbsp;--&nbsp;".$sub_cat->name."</option>";
			}
		}
		// Categories drop down end //
		return view('admin.product.edit')->with(compact('product','categories_drop_down'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'category_id' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_color' => 'required',
            //'description' => 'required',
            'price' => 'required',
        ]);


        $data = $request->all();

        if($request->hasFile('image')){
            $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111,99999).'.'.$extension;
                $large_image_path = 'backend/assets/images/products/large'.'/'.$fileName;
                $medium_image_path = 'backend/assets/images/products/medium'.'/'.$fileName;
                $small_image_path = 'backend/assets/images/products/small'.'/'.$fileName;

                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
            }
        }else if(!empty($data['current_image'])){
            $fileName = $data['current_image'];
        }else{
            $fileName = '';
        }


        if(empty($data['description'])){
            $data['description'] = '';
        }

        if(empty($data['status'])){
            $status='0';
        }else{
            $status='1';
        }
        if(empty($data['care'])){
            $data['description'] = '';
        }

        Product::where(['id'=>$id])->update(['status'=>$status,'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
				'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$fileName]);

        Toastr::success('Updated products successfully !','Success');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get Product Image
		$productImage = Product::where('id',$id)->first();
        // Get Product Image Paths
        //dd($productImage);

        $large_image_path = 'backend/assets/images/products/large/';
        $medium_image_path = 'backend/assets/images/products/medium/';
        $small_image_path = 'backend/assets/images/products/small/';


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
        // Delete Image from Products table
        Product::where(['id'=>$id])->update(['image'=>'']);

        $product = Product::find($id);
        $product->delete();
        Toastr::success('Product has been deleted successfully','Sucess');
        return redirect()->back();

        //return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully');
    }

    public function createAttributes($id=null){
        //add more attributes
        //$productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $productDetails = Product::where(['id' => $id])->first();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails); die;
        // $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        // $category_name = $categoryDetails->name;
        // if($request->isMethod('post')){
        //     $data = $request->all();
        //     //echo "<pre>"; print_r($data); die;
        //     foreach($data['sku'] as $key => $val){
        //         if(!empty($val)){
        //             $attrCountSKU = ProductsAttribute::where(['sku'=>$val])->count();
        //             if($attrCountSKU>0){
        //                 return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'SKU already exists. Please add another SKU.');
        //             }
        //             $attrCountSizes = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
        //             if($attrCountSizes>0){
        //                 return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'Attribute already exists. Please add another Attribute.');
        //             }
        //             $attr = new ProductsAttribute;
        //             $attr->product_id = $id;
        //             $attr->sku = $val;
        //             $attr->size = $data['size'][$key];
        //             $attr->price = $data['price'][$key];
        //             $attr->stock = $data['stock'][$key];
        //             $attr->save();
        //         }
        //     }
        //     return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been added successfully');
        // }
        // $title = "Add Attributes";
        return view('admin.product.create_attributes',compact('productDetails'));//->with(compact('title','productDetails','category_name'));
    }


    public function storeAttributes(Request $request)
    {
        $data = $request->all();

        foreach ($data['sku'] as $key => $val) {
            if(!empty($val))
            {

                $attrCountSKU = ProductsAttribute::where(['sku'=>$val])->count();
                if($attrCountSKU>0){
                    Toastr::error('SKU already exists. Please add another !','Errors');
                    return redirect()->back();
                }

                $attributeProduct = new ProductsAttribute;
                $attributeProduct->sku = $val;
                $attributeProduct->size = $data['size'][$key];
                $attributeProduct->price = $data['price'][$key];
                $attributeProduct->stock = $data['stock'][$key];
                $attributeProduct->product_id = $data['product_id'];
                $attributeProduct->save();
            }
        }
        Toastr::success('Create Attributes successfully !','Success');
        return redirect()->back();
    }

    public function editAttributes($id){
        $productDetails = Product::where(['id' => $id])->first();
        return view('admin.product.edit_attributes',compact('productDetails'));
    }

    public function updateAttributes(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;

        foreach($data['idAttr'] as $key=> $attr){
            if(!empty($attr)){
                ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
        }
        Toastr::success('Product update attributes successfully','Success');
        return redirect()->back();
    }

    public function deleteAttribute($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        Toastr::success('Deleted products attribute successfully !','Success');
        return redirect()->back();
    }

    public function createImages($id)
    {
        // show detail product
        $productDetails = Product::where(['id' => $id])->first();

        // show list image of a product
        $productImages = ProductsImage::where(['product_id' => $id])->orderBy('id','DESC')->get();

        // show category name
        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();

        $category_name = $categoryDetails->name;
        //echo "<pre>";print_r($category_name);die();
        return view('admin.product.create_images',compact('productDetails','productImages','category_name'));
    }

    public function storeImages(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach($files as $file){
                // Upload Images after Resize
                $image = new ProductsImage;
                $extension = $file->getClientOriginalExtension();
                $fileName = rand(111,99999).'.'.$extension;

                $large_image_path = 'backend/assets/images/products/large'.'/'.$fileName;
                $medium_image_path = 'backend/assets/images/products/medium'.'/'.$fileName;
                $small_image_path = 'backend/assets/images/products/small'.'/'.$fileName;

                Image::make($file)->save($large_image_path);
                Image::make($file)->resize(600, 600)->save($medium_image_path);
                Image::make($file)->resize(300, 300)->save($small_image_path);
                $image->image = $fileName;
                $image->product_id = $data['product_id'];
                $image->save();
            }
        }
        Toastr::success('Product Images has been added successfully','Success');
        return redirect()->back();
    }

    public function deleteImages($id = null){
        ProductsImage::where(['id'=>$id])->delete();
        Toastr::success('Deleted products Image successfully !','Success');
        return redirect()->back();
    }


}
