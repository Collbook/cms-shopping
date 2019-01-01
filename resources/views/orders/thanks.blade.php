@extends('layouts.app')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">thanks</li>
            </ol>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3 class="text-center">Thank you for your order</h3>
            <h5 class="text-center">Order number is : <small>{{ Session::get('order_id') }}</small> - with total money : <small>{{ number_format(Session::get('total')) }} -  VNĐ</small>  </h5>
            <p class="text-center">You will receive an email confirmation shortly at <small>info-abxshop.com</small>.</p>
        </div>
    </div>
</section><!--/#do_action-->

@endsection

{{ Session::forget('order_id') }}
{{ Session::forget('total') }}
