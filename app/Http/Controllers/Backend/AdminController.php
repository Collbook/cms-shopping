<?php

namespace App\Http\Controllers\Backend;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();
            //$pass = Hash::make($data['password']);
            //echo "<pre>";print_r($data);die();
            $adminCount = Admin::where(['username'=>$data['username'],'password'=>md5($request->password),'status'=>'1'])->count();
            //echo $adminCount;die();

            if($adminCount > 0)
            {
                $request->session()->put('adminSession', $data['username']);

                Toastr::success('Authenticate successfully !!', 'Success');
                return redirect()->route('admin.dashboard');
            }
            else
            {
                Toastr::error('Authenticate Faild !!', 'Errors');
                return redirect()->back();
            }

        }
        return view('admin.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Toastr::success('Logout successfully !!', 'Success');
        return redirect()->route('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request){
        $adminSession = $request->session()->get('adminSession', 'default');
        $adminDetails = Admin::where(['username'=>$adminSession])->first();
        //$adminDetails = json_decode(json_encode($adminDetails));
        // /echo "<pre>"; print_r($adminDetails); die;
        return view('admin.settings',compact('adminDetails'));
    }


    public function updatePassword(Request $request){
        if($request->isMethod('post')){

            $adminSession = $request->session()->get('adminSession', 'default');
            //echo "<pre>"; print_r($adminSession); die;
            $adminCount = Admin::where(['username'=>$adminSession,'password'=>md5($request->current_pwd),'status'=>'1'])->count();
            if($adminCount == 0)
            {
                Toastr::error('Current password doesnt not match','Errors');
                return redirect()->back();
            }else {
                $this->validate($request, [
                    'password' => 'required|confirmed|min:5',
                ]);

                Admin::where(['username'=>$adminSession])->update(['password'=>md5($request->password)]);
                Toastr::success('Current password doesnt not match','Success');
                return redirect()->back();
            }
        }
    }





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
