@extends('layouts.app')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Customer Order details</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td>Product Code</td>
                        <td>Product Name</td>
                        <td>Product Size</td>
                        <td>Product Color</td>
                        <td>Product Price</td>
                        <td>Product Qty</td>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($ordersDetail->ordersProduct as $product)
                            <tr>
                                <td>
                                   <span> {{ $product->product_code }}</span>
                                </td>
                                <td >
                                   <span>{{ $product->product_name }}</span>
                                </td>
                                <td >
                                   <span>{{ $product->product_size }}</span>
                                </td>
                                <td >
                                    <span>{{ $product->product_color }}</span>
                                </td>
                                <td >
                                    {{ number_format($product->product_price,0) }} - <small>VNĐ</small>
                                </td>
                                <td >
                                    <span>{{ $product->product_qty }}</span>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
@endsection
