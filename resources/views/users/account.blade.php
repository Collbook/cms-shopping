@extends('layouts.app')
@section('css')
    <link href="{{ asset('frontend/css/passtrength.css') }}" rel="stylesheet">
    <style>
        .category-tab ul {
            background: #ffffff;
            border-bottom: 1px solid #FE980F;
            list-style: none outside none;
            margin: 0 0 30px;
            padding: 0;
            width: 100%;
        }

        .login-form {
            margin: 26px;
        }



    </style>
@endsection
@section('content')
<section id="form" style="margin-top:0;"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#account" data-toggle="tab">Updated Account</a></li>
                            <li><a href="#password" data-toggle="tab">Updated password</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="account" >
                            <div class="col-sm-12">
                                <div class="login-form"><!--login form-->
                                    <h2>Update to your account</h2>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form id="updateForm" name="updateForm" action="{{ route('user.account') }}" method="POST">
                                        @csrf
                                        <input type="text" value="{{ $userDetail->name }}" id="name" name="name" placeholder="Name" />
                                        <input type="text" id="address"  value="{{ $userDetail->address }}" name="address" placeholder="Address" />
                                        <input type="text" id="city" value="{{ $userDetail->city }}" name="city" placeholder="City" />
                                        <input type="text" id="state"  value="{{ $userDetail->state }}"  name="state" placeholder="State" />

                                        <select style="height:38px" id="country" name="country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $item)
                                                <option value="{{ $item->country_name }}" @if ($item->country_name == Auth::user()->country)
                                                        {{ "selected" }}
                                                @endif>{{ $item->country_name }}</option>
                                            @endforeach
                                        </select>
                                        <input style="margin-top:10px" value="{{ $userDetail->pincode }}"  type="text" id="pincode" name="pincode" placeholder="Pincode" />
                                        <input type="text" id="mobile" value="{{ $userDetail->mobile }}" name="mobile" placeholder="Mobile" />
                                        <button type="submit" class="btn btn-default">Update</button>
                                    </form>
                                </div><!--/login form-->
                            </div>
                        </div>

                        <div class="tab-pane fade in" id="password" >
                            <div class="col-sm-12">
                                <div class="login-form"><!--login form-->
                                    <h2>Update password</h2>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form id="updatePassword" name="updatePassword" action="{{ route('userUpate.password') }}" method="POST">
                                        @csrf
                                        <input type="password" id="curent_pwd" name="curent_pwd" placeholder="current password" />
                                        <p id="chkPwd"></p>
                                        <input type="password" id="new_pwd" name="new_pwd" placeholder="new password" />
                                        <input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="new password confirm" />
                                        <button type="submit" class="btn btn-default">Update</button>
                                    </form>
                                </div><!--/login form-->
                            </div>
                        </div>
                    </div>
                </div><!--/category-tab-->
            </div>
        </div>
    </div>
</section><!--/form-->


@endsection
@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

<script src="{{ asset('frontend/js/jquery.passtrength.js') }}"></script>
<script>

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#registerForm").validate();

        // validate signup form on keyup and submit
        $("#updateForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                address: {
                    required: true,
                    minlength: 2
                },
                city: {
                    required: true,
                    minlength: 2
                },

                state: {
                    required: true,
                    minlength: 2
                },

                country: {
                    required: true,
                    //minlength: 2
                },
                pincode: {
                    required: true,
                    minlength: 2,
                },

                mobile: {
                    required: true,
                    minlength: 8,
                    maxlength:12,
                    matches: {matches:"[0-9]+",minlength:10, maxlength:10}  // <-- no such method called "matches"!

                }
            },
            messages: {
                name: {
                    required: "Please enter a your name",
                    minlength: "Your username must consist of at least 2 characters"
                },
                address: {
                    required: "Please enter a your address",
                    minlength: "Your address must consist of at least 2 characters"
                },
                city: {
                    required: "Please enter a your city",
                    minlength: "Your city must consist of at least 2 characters"
                },
                state: {
                    required: "Please enter a your state",
                    minlength: "Your state must consist of at least 2 characters"
                },
                country: {
                    required: "Please enter a your country",
                    //minlength: "Your username must consist of at least 2 characters"
                },
                pincode: {
                    required: "Please enter a your pincode",
                    minlength: "Your pincode must consist of at least 2 characters"
                },
                mobile: {
                    required: "Please mobile a your pincode",
                    minlength: "Your mobile must consist of at least 8 characters"
                }
            }
        });

        // check curent password
        $("#curent_pwd").keyup(function(){
            var current_pwd = $(this).val();
            //alert(current_pwd);

            // if using TYPE MEDTHOD "post", we need add headers 'X-CSRF-TOKEN'
            // if using TYPE MEthod "get", we do not add headers 'X-CSRF-TOKEN'

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/check-user-pwd',
                // send data current_pwd via function checkUserPassword of Usercontroller
                data:{current_pwd:current_pwd},
                success:function(resp){
                    //alert(resp);
                    if(resp == "false")
                    {
                        $("#chkPwd").html("<font color='red'>Current password is not correct</font>");
                    }else
                    {
                        $("#chkPwd").html("<font color='green'> Current password is correct </font>");
                    }

                },error:function(){
                    alert("Error");
                }
            });
        });
        // validate signup form on keyup and submit
        $("#updatePassword").validate({
            rules : {
                curent_pwd : {
                    required: true,
                    minlength : 5,
                    maxlength : 20
                },
                new_pwd : {
                    required: true,
                    minlength : 5,
                    maxlength : 20
                },
                confirm_pwd : {
                    required: true,
                    minlength : 5,
                    maxlength : 20,
                    equalTo : "#new_pwd"
                }
            },
            messages: {
                curent_pwd: {
                    required: "Please enter a password",
                    minlength: "Your curent password must consist of at least 5 characters",
                    maxlength: "Your curent password must consist of at least 20 characters"
                },
                new_pwd: {
                    required: "Please enter a new password",
                    minlength: "Your new password must consist of at least 5 characters",
                    maxlength: "Your new password must consist of at least 20 characters"
                },
                confirm_pwd: {
                    required: "Please enter a confirm new password",
                    minlength: "Your confirm new password must consist of at least 5 characters",
                    maxlength: "Your confirm new password must consist of at least 20 characters",
                    equalTo : "Your password confirm not match"
                }
            }
        });

    });
</script>
@endsection
