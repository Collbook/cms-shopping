@extends('layouts.app')

@section('css')
<style>
.shopper-informations {
    margin-top: -53px;
}
</style>
@endsection

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Check out and comfirmation</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="bill-to">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><small>Billing To</small></p>
                            </div>
                            <div class="col-sm-6">
                                <p style="margin-left:5px"><small>Shipping To</small></p>
                            </div>
                        </div>
                        <div class="form-one">
                            <form>
                                <input type="text" value="{{ $userDetails->name }}" id="builling_name" name="builling_name" placeholder=" Name *" disabled>
                                <input type="text" value="{{ $userDetails->address }}" id="builling_address" name="builling_address" placeholder=" Address *" disabled>
                                <input type="text" value="{{ $userDetails->city }}" id="builling_city" name="builling_city" placeholder=" City *" disabled>
                                <input type="text" value="{{ $userDetails->state }}" id="builling_state" name="builling_state" placeholder=" State *" disabled>
                                <select style="margin-bottom:10px;height: 38px" id="builling_country" name="builling_country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->country_name }}" @if ($item->country_name == $userDetails->country)
                                            {{ 'selected' }}
                                        @else
                                            {{ '' }}
                                        @endif>{{ $item->country_name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" value="{{ $userDetails->pincode }}" id="builling_pincode" name="builling_pincode" placeholder=" Pincode *" disabled>
                                <input type="text" value="{{ $userDetails->mobile }}" id="builling_mobile" name="builling_mobile" placeholder=" Mobile *" disabled>
                                <label><input type="checkbox" id="coppyAdress"> Shipping address same as billing address</label>
                            </form>
                        </div>

                        <div class="form-two">
                            <form id="updateForm" name="updateForm" action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden"  name="builling_name" value="{{ $userDetails->name }}">
                                <input type="hidden"  name="builling_address" value="{{ $userDetails->address }}">
                                <input type="hidden"  name="builling_city" value="{{ $userDetails->city }}">
                                <input type="hidden"  name="builling_state" value="{{ $userDetails->city }}">
                                <select style="margin-bottom:10px;height: 38px; display:none;" id="builling_country" name="builling_country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->country_name }}" @if ($item->country_name == $userDetails->country)
                                            {{ 'selected' }}
                                        @else
                                            {{ '' }}
                                        @endif>{{ $item->country_name }}</option>
                                    @endforeach
                                </select>

                                <input type="hidden"  name="builling_pincode" value="{{ $userDetails->pincode }}">
                                <input type="hidden"  name="builling_mobile" value="{{ $userDetails->mobile }}">
                                {{-- end building  --}}


                                <input type="text" id="shipping_name" name="shipping_name" value="@if (!empty($shippingDetails)){{ $shippingDetails->name }}@endif" placeholder=" Name *" autofocus>

                                <input type="text" id="shipping_address" name="shipping_address" value="@if (!empty($shippingDetails)){{ $shippingDetails->address }}@endif" placeholder=" Address *" autofocus>

                                <input type="text" id="shipping_city" name="shipping_city" value="@if (!empty($shippingDetails)){{ $shippingDetails->city }}@endif" placeholder=" City *" autofocus>

                                <input type="text" id="shipping_state" name="shipping_state" value="@if (!empty($shippingDetails)){{ $shippingDetails->state }}@endif" placeholder=" State *" autofocus>

                                <select id="shipping_country" style="margin-bottom:10px;height: 38px" name="shipping_country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $item)
                                        @if (!empty($shippingDetails))
                                            <option value="{{ $item->country_name }}" @if ($item->country_name == $shippingDetails->country)
                                                {{ 'selected' }}
                                            @endif >{{ $item->country_name }}</option>
                                        @else
                                            <option value="{{ $item->country_name }}">{{ $item->country_name }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                <input type="text" id="shipping_pincode" name="shipping_pincode" value="@if (!empty($shippingDetails)){{ $shippingDetails->pincode }}@endif" placeholder=" Pincode *" autofocus>

                                <input type="text" id="shipping_mobile" name="shipping_mobile" value="@if (!empty($shippingDetails)){{ $shippingDetails->mobile }}@endif" placeholder=" Mobile *" autofocus>
                                <br>
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </form>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <br>
</section> <!--/#cart_items-->

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script>

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#registerForm").validate();


        // validate signup form on keyup and submit
        $("#updateForm").validate({
            rules: {
                shipping_name: {
                    required: true,
                    minlength: 2
                },
                shipping_address: {
                    required: true,
                    minlength: 2
                },
                shipping_city: {
                    required: true,
                    minlength: 2
                },

                shipping_state: {
                    required: true,
                    minlength: 2
                },

                shipping_country: {
                    required: true,
                    //minlength: 2
                },
                shipping_pincode: {
                    required: true,
                    minlength: 2,
                },

                shipping_mobile: {
                    required: true,
                    minlength: 8,
                    maxlength:12,
                    matches: {matches:"[0-9]+",minlength:10, maxlength:10}  // <-- no such method called "matches"!

                }
            },
            messages: {
                shipping_name: {
                    required: "Please enter a your name",
                    minlength: "Your username must consist of at least 2 characters"
                },
                shipping_address: {
                    required: "Please enter a your address",
                    minlength: "Your address must consist of at least 2 characters"
                },
                shipping_city: {
                    required: "Please enter a your city",
                    minlength: "Your city must consist of at least 2 characters"
                },
                shipping_state: {
                    required: "Please enter a your state",
                    minlength: "Your state must consist of at least 2 characters"
                },
                shipping_country: {
                    required: "Please enter a your country",
                    //minlength: "Your username must consist of at least 2 characters"
                },
                shipping_pincode: {
                    required: "Please enter a your pincode",
                    minlength: "Your pincode must consist of at least 2 characters"
                },
                shipping_mobile: {
                    required: "Please mobile a your pincode",
                    minlength: "Your mobile must consist of at least 8 characters"
                }
            }
        });

        $("#coppyAdress").on('click',function(){
            if(this.checked)
            {
                $("#shipping_name").val($("#builling_name").val());
                $("#shipping_address").val($("#builling_address").val());
                $("#shipping_city").val($("#builling_city").val());
                $("#shipping_state").val($("#builling_state").val());
                $("#shipping_country").val($("#builling_country").val());
                $("#shipping_pincode").val($("#builling_pincode").val());
                $("#shipping_mobile").val($("#builling_mobile").val());

                // $('#shipping_name').attr("disabled","");
                // $('#shipping_address').attr("disabled","");
                // $('#shipping_mobile').attr("disabled","");
                // $('#shipping_city').attr("disabled","");
                // $('#shipping_state').attr("disabled","");
                // $('#shipping_country').attr("disabled","");
                // $('#shipping_pincode').attr("disabled","");
                // $('#shipping_mobile').attr("disabled","");
            }
            else{
                $("#shipping_name").val("");
                $("#shipping_address").val("");
                $("#shipping_city").val("");
                $("#shipping_state").val("");
                $("#shipping_country").val("");
                $("#shipping_pincode").val("");
                $("#shipping_mobile").val("");

                // //$('#shipping_name').attr("disabled");
                // $("#shipping_name").removeAttr("disabled");
                // $("#shipping_address").removeAttr("disabled");
                // $("#shipping_city").removeAttr("disabled");
                // $("#shipping_state").removeAttr("disabled");
                // $("#shipping_country").removeAttr("disabled");
                // $("#shipping_pincode").removeAttr("disabled");
                // $("#shipping_mobile").removeAttr("disabled");

            }
        })
    });
</script>
@endsection
