<?php

namespace App\Http\Controllers\Backend;

use App\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //echo "<pre>"; print_r($data);die();


        $coupon = new Coupon;
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->amount = $data['amount'];
        $coupon->amount_type = $data['amount_type'];


        if(!empty($data['status'])){
            $coupon->status = $data['status'];
        }



        $coupon->expiry_date = date($data['expiry_date']);



        $couponsCode = DB::table('coupons')->where(['coupon_code' => $data['coupon_code']])->count();
        //print_r($countProducts);
        //die();

        if($couponsCode>0){
            Toastr::error('Coupons already exist in Cart!','Errors');
            return redirect()->back();
        }


        $coupon->save();

        //Toastr::success('Coupon code update attributes successfully','Success');
        Toastr::success('Create Coupon code successfully !','Success');
        return redirect()->route('admin.coupons.index');

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
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit',compact('coupon'));
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
        $data = $request->all();
        $coupon = Coupon::find($id);
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->amount = $data['amount'];
        $coupon->amount_type = $data['amount_type'];


        if(!empty($data['status'])){
            $coupon->status = $data['status'];
        }

        $coupon->expiry_date = date($data['expiry_date']);

        $coupon->save();

        //Toastr::success('Coupon code update attributes successfully','Success');
        Toastr::success('Update Coupon code successfully !','Success');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Image from Products table
        //Product::where(['id'=>$id])->update(['image'=>'']);

        $coupon = Coupon::find($id);
        $coupon->delete();
        Toastr::success('Coupon has been deleted successfully','Sucess');
        return redirect()->back();
    }
}
