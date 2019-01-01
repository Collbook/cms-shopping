@extends('layouts.app')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if ($userCart->count() > 0)
                        <?php $total_amount = 0; ?>
                        @foreach ($userCart as $item)
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img height="120" src="{{ asset('/backend/assets/images/products/small/'.$item->image) }}" alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{ $item->product_name }}</a></h4>
                                    <p>ID: {{ $item->product_code }} - {{ $item->product_color }} - <strong>{{ $item->size }}</strong></p>
                                </td>
                                <td class="cart_price">
                                    <p><span  style="font-size:15px" id="getPrice" >{{ number_format($item->price, 0) }} - VNĐ</span></p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        @if ($item->quantity > 1)
                                            <a class="cart_quantity_down" href="{{ route('cart.update',['id'=>$item->id,'quantity'=>-1]) }}"> - </a>
                                        @endif
                                        <input class="cart_quantity_input"  name="quantity" value="{{ $item->quantity }}" autocomplete="off" type="number" style="width:48px" size="2" >
                                        <a class="cart_quantity_up" href="{{ route('cart.update',['id'=>$item->id,'quantity'=>1]) }}"> + </a>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price"><span  style="font-size:15px" id="getPrice" >{{ number_format($item->price * $item->quantity , 0) }} - VNĐ</span></p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="{{ route('cart.deleteCart',['id'=>$item->id]) }}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        <?php $total_amount = $total_amount + ($item->price * $item->quantity); ?>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="6"><strong>Empty Cart <a href="/">(Continue Shopping)</a></strong></td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        @if (!empty($total_amount))
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
            </div>
            <div class="row">
                <form action="{{ route('cart.apply-coupon') }}" method="POST">
                    @csrf
                    <div class="col-sm-6">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="chose_area">
                            <ul >
                                <li class="single_field zip-field">
                                    <label>Coupon Code:</label>
                                    <input type="text" style="height:30px" name="coupon" />
                                    <button type="submit" class="btn btn-default update" style="margin: 3px 0 5px;">Apply</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            @if (!empty($total_amount))
                                @if (!empty(Session::get('couponAmount')))
                                    <li>Cart Sub Total <span><small><strong>{{ number_format($total_amount , 0) }}</strong> - VNĐ</small></span></li>
                                    <li>Eco Tax <span><small><strong>{{ number_format($total_amount*0.01,0) }}</strong> - VNĐ</small></span></li>
                                    <li>Shipping Cost <span>Free</span></li>
                                    <li>Coupon Discount <span><small><strong>{{ number_format(Session::get('couponAmount'),0) }}</strong> - VNĐ</small></span></li>
                                    <li>Total <span><small><strong>{{ number_format($total_amount + $total_amount*0.01 , 0) }}</strong> - VNĐ</small></span></li>
                                    <li><strong>Total width Coupon </strong><span><small><strong>{{ number_format($total_amount + $total_amount*0.01 - Session::get('couponAmount') , 0) }}</strong> - VNĐ</small></span></li>
                                @else
                                    <li>Cart Sub Total <span><small><strong>{{ number_format($total_amount , 0) }}</strong> - VNĐ</small></span></li>
                                    <li>Eco Tax <span><small><strong>{{ number_format($total_amount*0.01,0) }}</strong> - VNĐ</small></span></li>
                                    <li>Shipping Cost <span>Free</span></li>
                                    <li><strong>Total</strong> <span><small><strong>{{ number_format($total_amount + $total_amount*0.01 , 0) }}</strong> - VNĐ</small></span></li>
                                @endif
                            @endif
                        </ul>
                            <a class="btn btn-default update" href="/">Continue Shopping</a>
                            <a class="btn btn-default check_out" href="{{ route('cart.checkout') }}">Check Out</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section><!--/#do_action-->

@endsection
