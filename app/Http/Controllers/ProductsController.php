<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Coupon;
use App\Country;
use App\Product;
use App\Category;
use App\OrderProduct;
use App\ProductsImage;
use App\DeliveryAddress;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products($url = null)
    {
        // show category in left menu
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // Show 404 Page if Category does not exists
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();

    	if($categoryCount==0){
    		abort(404);
        }


        // show name category
        $categoryDetails = Category::where(['url'=>$url])->first();
        // $categoryDetails = json_decode(json_encode($categoryDetails));
        // echo "<pre>";
        // print_r($categoryDetails);
        // die();

    	if($categoryDetails->parent_id==0){
            $subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();
            // convert to array
            $subCategories = json_decode(json_encode($subCategories));
            // echo "<pre>";
            // print_r($subCategories);
            // die();
    		foreach($subCategories as $subcat){
    			$cat_ids[] = $subcat->id;
    		}
            //$productsAll = Product::whereIn('category_id', $cat_ids)->where('status','1')->get();

            // show all product
            $productsAll = Product::whereIn('category_id', $cat_ids)->where('status','1')->get();
            //dd($productsAll->count());
            // $productsAll = json_decode(json_encode($productsAll));
            // echo "<pre>";
            // print_r($productsAll);
            // die();
    	}else{
            //$productsAll = Product::where(['category_id'=>$categoryDetails->id])->where('status','1')->get();
            $productsAll = Product::where(['category_id'=>$categoryDetails->id])->where('status','1')->get();
            // $productsAll = json_decode(json_encode($productsAll));
            // echo "<pre>";
            // print_r($productsAll);
            // die();
    	}

        return view('products.listing')->with(compact('categories','productsAll','categoryDetails'));


    }

    public function product($id = null)
    {
        // show category in left menu
        // show all category in category parent
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        //Show 404 Page if Product is disabled, if use try access
        // default = 1, if product has disable => count = 0
        $productCount = Product::where(['id'=>$id,'status'=>1])->count();
        //echo $productCount;die();
        if($productCount==0){
            abort(404);
        }
        // Get Product Details
        // show all attributes
        $productDetails = Product::with('attributes')->where('id',$id)->first();
        //$productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>";
        // print_r($productDetails);
        // die();

        $relatedProducts = Product::where('id','!=',$id)->where(['category_id' => $productDetails->category_id])->where('status',1)->get();
        //$relatedProducts = json_decode(json_encode($relatedProducts));
        //echo "<pre>";print_r($relatedProducts); die();
        // foreach($relatedProducts->chunk(3) as $chunk){
        //     foreach($chunk as $item){
        //         echo $item; echo "<br>";
        //     }
        //     echo "<br><br><br>";
        // }
        // die();

        // // Get Product Alt Images
        $productAltImages = ProductsImage::where('product_id',$id)->get();
        //$productAltImages = json_decode(json_encode($productAltImages));
        //echo "<pre>";print_r($productAltImages);die();
        // /*$productAltImages = json_decode(json_encode($productAltImages));
        // echo "<pre>"; print_r($productAltImages); die;*/
        // $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        // sum stock attibutes of product
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        //echo $total_stock;die();

        //return view('products.detail')->with(compact('productDetails','categories','productAltImages','total_stock','relatedProducts'));
        return view('products.detail',compact('productDetails','categories','productAltImages','total_stock','relatedProducts'));

    }

    // using ajax
    public function getProductPrice(Request $request)
    {
        $data = $request->all();

        $proArr = explode("-",$data['idsize']);
        // echo $proArr[0];
        // echo $proArr[1];
        // die();

        //dd($proArr);
        // $proArr[0] = 2 == product_id;
        // $proArr[1] = small == size
         $proAttr = ProductsAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }


    public function addtocart(Request $request)
    {
        $request->session()->forget('couponAmount');
        $request->session()->forget('couponCode');


        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        if(empty(Auth::user()->email))
        {
            $data['user_email'] = '';
        }
        else
        {
            $data['user_email'] = Auth::user()->email;
        }

        $sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];

        // check session_id, if empty , we are create session_id
        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = str_random(40);
            Session::put('session_id',$session_id);
        }


        $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'session_id' => $session_id])->count();
        //print_r($countProducts);
        //die();

        if($countProducts>0){
            Toastr::error('Product already exist in Cart!','Errors');
            return redirect()->back();
        }

        // insert sku form ProductsAttribute for check updateCartQuantity
        $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();

        DB::table('cart')
        ->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' => $getSKU->sku,'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'image'=>$data['product_image'],'user_email' => $data['user_email'],'session_id' => $session_id]);

        Toastr::success('add cart successfully !','Success');
        return redirect()->back();
        //return redirect()->route('cart.showCart');
    }

    public function showCart()
    {
        // if(Auth::check())
        // {
        //     $user_email = Auth::user()->email;
        //     $userCart = $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        // }
        // else
        // {
        //     $session_id = Session::get('session_id');
        //     $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
        // }

        // node #endregion
        $session_id = Session::get('session_id');
        $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();

        return view('products.cart',compact('userCart'));



        //echo "<pre>";print_r($userCart); die();
        // add field image for cart
        // foreach($userCart as $key => $product){
        //     $productDetails = Product::where('id',$product->product_id)->first();
        //     $userCart[$key]->image = $productDetails->image;
        // }
        //echo "<pre>";print_r($userCart[$key]); die();

    }

    public function deleteCartProduct(Request $request,$id = null)
    {
        $request->session()->forget('couponAmount');
        $request->session()->forget('couponCode');

        DB::table('cart')->where('id',$id)->delete();
        Toastr::success('delete a cart successfully !','Success');
        return redirect()->back();
    }

    public function updateCartQuantity($id=null,$quantity = null)
    {
        // $request->session()->forget('couponAmount');
        // $request->session()->forget('couponCode');

        // get product_code, quantity with $id in cart
        $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$id)->first();
        //echo "<pre>";print_r($getProductSKU); die();

        // get sku, via getProductSKU
        $getProductStock = ProductsAttribute::where('sku',$getProductSKU->product_code)->first();
        //$getProductStock = json_decode(json_encode($getProductStock));
        //echo "<pre>";print_r($getProductStock); die();
        $updated_quantity = $getProductSKU->quantity+$quantity; // default $quantity = 1 or -1

        // check product in stock with product update munber
        if($getProductStock->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
            Toastr::success('update a cart successfully !','Success');
            return redirect()->back();
        }else{
            Toastr::error('Required Product Quantity is not available !','Errors');
            return redirect()->back();
            //return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');
        }
    }

    public function applyCoupon(Request $request)
    {
        $this->validate($request,[
            'coupon' => 'required'
        ]);

        $request->session()->forget('couponAmount');
        $request->session()->forget('couponCode');

        $data = $request->all();

        $couponCount = Coupon::where('coupon_code',$data['coupon'])->count();

        if($couponCount == 0)
        {
            Toastr::error('Counpon is not correct !','Errors');
            return redirect()->back();
        }else
        {
            $couponDetail = Coupon::where('coupon_code',$data['coupon'])->first();
            $expiry_date = $couponDetail->expiry_date;
            //echo $expiry_date . "<br/>";
            $curent_date = date('d-m-Y');
            //echo "<pre>";print_r($expiry_date); die();
            if($couponDetail->status == 0)
            {
                Toastr::error('Counpon is not active !','Errors');
                return redirect()->back();
            }
            else if(($curent_date > $expiry_date))
            {
                Toastr::error('Counpon has expiry date !','Errors');
                return redirect()->back();
            }
            else
            {
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
                // /echo "<pre>";print_r($userCart); die();
                //add field image for cart

                // check node again
                // if(Auth::check())
                // {
                //     $user_email = Auth::user()->email;
                //     $userCart = $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
                // }
                // else
                // {
                //     $session_id = Session::get('session_id');
                //     $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();
                // }



                // get $total_amount
                $total_amount = 0;
                foreach($userCart as $item){
                    $total_amount = $total_amount + ($item->price * $item->quantity);
                    //$productDetails = Product::where('id',$product->product_id)->first();
                    //$userCart[$key]->image = $productDetails->image;
                }

                // set method for dis coupon.
                if($couponDetail->amount_type == "fixed")
                {
                    $couponAmount = $couponDetail->amount;
                }
                else
                {
                    $couponAmount = $total_amount * ($couponDetail->amount / 100);
                }

                // put to session

                $request->session()->put('couponAmount', $couponAmount);
                $request->session()->put('couponCode', $data['coupon']);

                //echo $couponAmount;
                Toastr::success('Coupon code successfully applied. You are availing discount !');
                return redirect()->back();
            }
            //var_dump($curent_date < $expiry_date);
        }
        //echo $couponCount;die();
        //echo "<pre>";print_r($request->all()); die();
    }
    public function checkout(Request $request)
    {
        $user_id = Auth::user()->id;
        $userEmail = Auth::user()->email;

        $userDetails = User::find($user_id);
        $countries = Country::all();
        //echo "<pre>";print_r($userDetail); die();
        // check if shipping address exits
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        //echo "<pre>";print_r($shippingCount); die();
        if($shippingCount > 0)
        {
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        // update email when user has login to cart table
        $session_id = $request->session()->get('session_id', 'default');
        DB::table('cart')->where('session_id', $session_id)->update(['user_email' => $userEmail]);

        if($request->isMethod('post'))
        {
            $this->validate($request,[
                'shipping_name' => 'required',
                'shipping_address' => 'required',
                'shipping_city' => 'required',
                'shipping_state' => 'required',
                'shipping_country' => 'required',
                'shipping_pincode' => 'required',
                'shipping_mobile' => 'required',
            ]);

            $data = $request->all();
            //echo "<pre>";print_r($data); die();
            // update users table
            User::where('id',$user_id)->update(['name'=>$data['builling_name'],'address'=>$data['builling_address'],'city'=>$data['builling_city'],'state'=>$data['builling_state'],'country'=>$data['builling_country'],'pincode'=>$data['builling_pincode'],'mobile'=>$data['builling_mobile']]);

            //
            if($shippingCount > 0)
            {
                // updated shipping address
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'country'=>$data['shipping_country'],'pincode'=>$data['shipping_pincode'],'mobile'=>$data['shipping_mobile']]);
                Toastr::success('Checkout successffully !','Success');
                return redirect()->route('cart.orderReview');
            }else
            {
                // add new shipping address
                $shipping = new DeliveryAddress;
                $shipping->user_id = Auth::user()->id;
                $shipping->user_email = Auth::user()->email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->country = $data['shipping_country'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
                Toastr::success('Checkout successffully !','Success');
                return redirect()->route('cart.orderReview');
            }

        }

        return view('products.checkout',compact('userDetails','countries','shippingDetails'));
    }

    public function orderReview(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();

        //$shippingDetails = json_decode(json_encode($shippingDetails));

        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();

        //echo "<pre>";print_r($userCart);die();
        return view('products.order-review',compact('userDetails','shippingDetails','userCart'));
    }

    public function placeOrder(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();

            if(empty($data['payment_method']))
            {
                Toastr::error("Please select payment method",'Errors');
                return redirect()->back();
            }
            //echo "<pre>";print_r($data);die();

            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            $shippingDetails = DeliveryAddress::where('user_email',$user_email)->first();
            //$shippingDetails = json_decode(json_encode($shippingDetails));
            //echo "<pre>";print_r($user_id);die();

            //$request->session()->put('couponAmount', $couponAmount);
            //$request->session()->put('couponCode', $data['coupon']);

            // get coupon code
            if(empty($request->session()->get('couponCode', '0')))
            {
                $data['coupon_code'] = "";
            }
            else
            {
                $data['coupon_code'] = $request->session()->get('couponCode', '0');
            }

            // get coupon amount
            if(empty($request->session()->get('couponAmount', '0')))
            {
                $data['coupon_amount'] = "";
            }
            else
            {
                $data['coupon_amount'] = $request->session()->get('couponAmount', '0');
            }

            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $data['coupon_code'];
            $order->coupon_amount = $data['coupon_amount'];
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->total_amount = $data['total'];
            $order->save();

            //get last id in order table
            $order_id = DB::getPdo()->lastInsertId();

            // insert to orderproduct via email
            $cartProducts = DB::table('cart')->where('user_email',$user_email)->get();
            //echo "<pre>";print_r($cartProducts);die();
            foreach ($cartProducts as $item) {
                $cartPro = new OrderProduct;
                $cartPro->order_id = $order_id;
                $cartPro->product_id = $item->product_id;
                $cartPro->product_code = $item->product_code;
                $cartPro->product_name = $item->product_name;
                $cartPro->product_size = $item->size;
                $cartPro->product_color = $item->product_color;
                $cartPro->product_price = $item->price;
                $cartPro->product_qty = $item->quantity;
                $cartPro->save();

            }

            $request->session()->put('order_id', $order_id);
            $request->session()->put('total', $data['total']);
            //echo "<pre>";print_r($cartProducts);die();


            if($data['payment_method'] == 'paypal' )
            {
                Toastr::success("Paypal Order successfully",'Success');
                return redirect()->route('customer.paypal');
            }
            else {
                Toastr::success("Order successfully, please confirm email for verify order !",'Success');
                return redirect()->route('thanks');
            }


        }

    }

    public function thanks()
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }

    public function paypal()
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
    }

    public function customerOrders(Request $request)
    {
        $user_id = Auth::user()->id;
        // funciton hasMany ordersProduct in Order Model
        $orders = Order::with('ordersProduct')->where('user_id',$user_id)->orderBy('id','DESC')->get();

        return view('orders.custormer_order',compact('orders'));
    }

    public function customerOrdersDetails(Request $request ,$id)
    {
        //$user_id = Auth::user()->id;
        // funciton hasMany ordersProduct in Order Model
        $ordersDetail = Order::with('ordersProduct')->where('id',$id)->orderBy('id','DESC')->first();

        //$ordersDetail = json_decode(json_encode($ordersDetail));
        //echo "<pre>";print_r($ordersDetail);die();
        return view('orders.custormer_order_details',compact('ordersDetail'));
    }


}
