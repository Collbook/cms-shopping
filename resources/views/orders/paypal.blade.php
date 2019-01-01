@extends('layouts.app')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">paypal</li>
            </ol>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        @if (Session::get('order_id'))
            <div class="heading">
                <h3 class="text-center">Thank you for your order</h3>
                <h5 class="text-center">Order number is : <small>{{ Session::get('order_id') }}</small> - with total money : <small>{{ number_format(Session::get('total')) }} -  VNĐ</small>  </h5>
                <p class="text-center">Please make payment by click on below payment button</p>
                <p class="text-center">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="lnqSeller@gmail.com">
                        <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
                        <input type="hidden" name="amount" value="{{ Session::forget('total') }}">
                        <input type="hidden" name="currency_code" value="US">

                        <input type="image" name="submit"
                            src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
                            alt="PayPal - The safer, easier way to pay online">
                    </form>
                </p>
            </div>
        @else
            <div class="heading">
                <h3 class="text-center">Sorry,No orders</h3>
            </div>
        @endif

    </div>
</section><!--/#do_action-->

@endsection

