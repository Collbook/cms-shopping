<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Order;
use App\DeliveryAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('ordersProduct')->orderBy('id','DESC')->get();
        // $orders = json_decode(json_encode($orders));
        // echo "<pre>";print_r($orders);die();
        return view('admin.orders.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // details orders
    public function show($id)
    {
        $ordersDetail = Order::with('ordersProduct')->where('id',$id)->first();

        //$ordersDetail = json_decode(json_encode($ordersDetail));
        //echo "<pre>";print_r($ordersDetail);die();
        $user_id = $ordersDetail->user_id;
        $userDetails = User::where('id',$user_id)->first();
        //$userDetails = User::where('id',$user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        return view('admin.orders.details',compact('ordersDetail','userDetails','shippingDetails'));
    }

    public function orderStatus(Request $request)
    {
        $data = $request->all();
        //echo "<pre>";print_r($data);die();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();
        Toastr::success('Updated order status successfully !','Success');
        return redirect()->back();

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
