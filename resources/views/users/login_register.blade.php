@extends('layouts.app')
@section('css')
    <link href="{{ asset('frontend/css/passtrength.css') }}" rel="stylesheet">
@endsection
@section('content')
<section id="form" style="margin-top:0;"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="loginForm" name="loginForm" action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <input type="email" id="user_email" name="user_email" placeholder="Email Address" />
                        <input type="password" id="user_password" name="user_password" placeholder="Enter password" />
                        <button type="submit" class="btn btn-default">Login</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2>New User Signup!</h2>

                    <form method="POST" id="registerForm" name="registerForm" action="{{ route('login-register') }}">
                        @csrf
                        <input type="text" id="name" name="name" placeholder="Name"/>
                        <input type="email" id="email" name="email" placeholder="Email Address"/>
                        <input type="password" id="myPassword" name="password" placeholder="Password"/>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
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
        $("#registerForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true,
                    // if we are recive true or flase, we need using remote for replace ajax
                    remote:"/check-email"
                }
            },
            messages: {
                name: {
                    required: "Please enter a your name",
                    minlength: "Your username must consist of at least 2 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },

                email: {
                    required : "Please enter a valid email address",
                    email : "Please enter valied email",
                    remote : "Email already exists !"
                }
            }
        });

        $('#myPassword').passtrength({
          minChars: 4,
          passwordToggle: true,
          tooltip: true,
          eyeImg : "/frontend/images/eye.svg" // toggle icon

        });
    });
</script>
@endsection
