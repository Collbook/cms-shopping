<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        // get url
        //$url = $request->fullUrl();

        if($request->isMethod('post'))
        {
            $this->validate($request,[
                'name' => 'required|string|min:2|max:25',
                'email' => 'required|email',
                'password' => 'required|min:5'
            ]);



            $data = $request->all();
            $userCount = User::where('email',$data['email'])->count();
            //echo "<pre>";print_r($userCount);die();
            if($userCount > 0)
            {
                Toastr::error('Account alreadly exists,please try again account other !','Errors');
                return redirect()->back();
            }
            else
            {
                //echo "<pre>";print_r($data);die();
                $user = new User;
                $user->name  = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();

                // send mail register email
                $email = $data['email'];
                $messageData = ['email'=>$email,'name'=>$data['name']];
                Mail::send('emails.register', $messageData, function ($message) use($email){
                    $message->to($email)->subject('Registration with Mentoza e-conomere website');
                });

                // send mail active account
                $emailactive = $data['email'];
                $messageDataActive = ['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageDataActive, function ($message) use($emailactive){
                    $message->to($emailactive)->subject('Confirmation email account Mentoza e-conomere website');
                });

                return redirect()->back()->with('status','Account register successfully, Please confirm your email to active your account !');

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
                {
                    //Session::put('session_id',$data['email']);
                    //$request->session()->forget('couponAmount');
                    //$request->session()->forget('couponCode');
                    $request->session()->put('frontendSession', $data['email']);

                    Toastr::success('Authencation successffuly !','Success');
                    return redirect()->route('cart.showCart');
                }
            }



        }
        return view('users.login_register');
    }

    public function confirmAccount($email)
    {
        $email = base64_decode($email);

        $userCount = User::where('email',$email)->count();

        if($userCount > 0)
        {
            $userDetail = User::where('email',$email)->first();

            if($userDetail->status == 1)
            {
                // send mail wellcom to active email
                 $email = $email;
                 $messageData = ['email'=>$email,'name'=>$userDetail->name];
                 Mail::send('emails.wellcom', $messageData, function ($message) use($email){
                     $message->to($email)->subject('Wellcom to Mentoza e-conomere website');
                 });

                return redirect()->route('login-register')->with('status','Your email account is actived, You can login now!');
            }
            else {
                User::where('email',$email)->update(['status'=>1]);

                 // send mail wellcom to register  account successfully after active email
                 $email = $email;
                 $messageData = ['email'=>$email,'name'=>$userDetail->name];
                 Mail::send('emails.wellcom', $messageData, function ($message) use($email){
                    $message->to($email)->subject('Wellcom to Mentoza e-conomere website');
                 });
                return redirect()->route('login-register')->with('status','Your email account is actived, You can login now!');
            }
        }


    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('couponAmount');
        $request->session()->forget('couponCode');
        // distroy session
        $request->session()->forget('frontendSession');
        $request->session()->forget('session_id');

        Toastr::success('Logout successfully','Success');
        return redirect('/');
    }

    public function login(Request $request)
    {

       if($request->isMethod('post'))
       {
           $this->validate($request,[
               //'name' => 'required|string|min:2|max:25',
               'user_email' => 'required|email',
               'user_password' => 'required|min:5'
           ]);

           $data = $request->all();

           if (Auth::attempt(['email' => $data['user_email'],'password' => $data['user_password']])) {

                // check email actived
                $userStatus = User::where('email',$data['user_email'])->first();
                //$userStatus = json_decode(json_encode($userStatus));
                //echo "<pre>";print_r($userStatus);die();
                if($userStatus->status == 0)
                {
                    Toastr::error('Your account not actived, please confirm email for active account.');
                    return redirect()->back();
                }

                $request->session()->put('frontendSession', $data['user_email']);
                Toastr::success('Authencation successffuly !','Success');
                return redirect()->route('cart.showCart');
           }else {
                Toastr::error('Authencation faild !','Error');
                return redirect()->back();
           }
           //echo "<pre>";print_r($data);die();
       }
       //return view('users.login_register');

    }
    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $userCount = User::where('email',$data['email'])->count();
        //echo "<pre>";print_r($userCount);die();
        if($userCount > 0)
        {
            return "false";
        }
        else {
            return "true";// die();
        }
    }

    public  function account(Request $request)
    {
        $countries = Country::all();
        $user_id = Auth::user()->id;
        $userDetail = User::find($user_id);

        if($request->isMethod('post'))
        {
            $this->validate($request,[
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'pincode' => 'required',
                'mobile' => 'required'
            ]);

            // get all request data
            $data = $request->all();

            $user_id = Auth::user()->id;
            $userDetail = User::find($user_id);

            $userDetail->name = $data['name'];
            $userDetail->address = $data['address'];
            $userDetail->city = $data['city'];
            $userDetail->state = $data['state'];
            $userDetail->country = $data['country'];
            $userDetail->pincode = $data['pincode'];
            $userDetail->mobile = $data['mobile'];
            $userDetail->save();

            Toastr::success('Updated profile successffuly !','Success');
            return redirect()->back();

            //echo "<pre>";print_r($data);die();
        }

        return view('users.account',compact('countries','userDetail'));
    }

    // using ajax
    public function checkUserPassword(Request $request)
    {
        $data = $request->all();
        //echo "<pre>";print_r($data);die();
        $current_passowrd = $data['current_pwd'];
        //echo $current_passowrd;
        $user_id = Auth::user()->id;

        $check_password = User::where('id',$user_id)->first();

        if(Hash::check($current_passowrd, $check_password->password))
        {
            echo "true";
        }
        else
        {
            echo "false";
        }

    }


    public function userUpdatePassword(Request $request)
    {
        $data = $request->all();

        $current_passowrd = $data['curent_pwd'];
        //echo $current_passowrd;
        $user_id = Auth::user()->id;

        $check_password = User::where('id',$user_id)->first();

        if(!Hash::check($current_passowrd, $check_password->password))
        {
            Toastr::error('Your password confirm not match !','Error');
            return redirect()->back();
        }
        else
        {


             $userUpdate = User::find($user_id);

             $userUpdate->password = \bcrypt($data['new_pwd']);
             $userUpdate->save();

             Toastr::success('Updated password successffuly !','Success');
             return redirect()->back();

        }
    }

}
