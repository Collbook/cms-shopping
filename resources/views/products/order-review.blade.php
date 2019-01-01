@extends('layouts.app')

@section('css')
<style>
input.btn.btn-default.update.float-right {
    margin-top: -7px;
    margin-left: 0px;
}
</style>
@endsection

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Order Review</li>
            </ol>
        </div><!--/breadcrums-->

        <!--/ order-review-->
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-condensed total-result">
                        <thead>
                            <th>Billing Details</th>
                            <th>Billing Address</th>
                            <th>Shipping Address</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><small>Full name</small></strong></td>
                                <td>{{ $userDetails->name }}</td>
                                <td>{{ $shippingDetails->name }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>Address</small></strong></td>
                                <td>{{ $userDetails->address }}</td>
                                <td>{{ $shippingDetails->address }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>City</small></strong></td>
                                <td>{{ $userDetails->city }}</td>
                                <td>{{ $shippingDetails->city }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>State</small></strong></td>
                                <td>{{ $userDetails->state }}</td>
                                <td>{{ $shippingDetails->state }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>Country</small></strong></td>
                                <td>{{ $userDetails->country }}</td>
                                <td>{{ $shippingDetails->country }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>Pincode</small></strong></td>
                                <td>{{ $userDetails->pincode }}</td>
                                <td>{{ $shippingDetails->pincode }}</td>
                            </tr>
                            <tr>
                                <td><strong><small>Mobile</small></strong></td>
                                <td>{{ $userDetails->mobile }}</td>
                                <td>{{ $shippingDetails->mobile }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="review-payment">
            <h2>Review & Payment</h2>
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
                        {{-- <td></td> --}}
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
                                        <span>{{ $item->quantity }}</span>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price"><span  style="font-size:15px" id="getPrice" >{{ number_format($item->price * $item->quantity , 0) }} - VNĐ</span></p>
                                </td>
                            </tr>
                        <?php $total_amount = $total_amount + ($item->price * $item->quantity); ?>
                        @endforeach

                        {{-- // total --}}
                        @if (!empty($total_amount))
                            @if (!empty(Session::get('couponAmount')))
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td colspan="2">
                                        <table class="table table-condensed total-result">
                                            <tr>
                                                <td>Cart Sub Total</td>
                                                <td><span><small><strong>{{ number_format($total_amount , 0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                            <tr>
                                                <td>Exo Tax</td>
                                                <td><span><small><strong>{{ number_format($total_amount*0.01,0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                            <tr class="shipping-cost">
                                                <td>Shipping Cost</td>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <td>Coupon discount</td>
                                                <td><span><small><strong>{{ number_format(Session::get('couponAmount'),0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td><span><small><strong>{{ number_format($total_amount + $total_amount*0.01 , 0) }}</strong> - VNĐ</small></span></td>
                                            </tr>

                                            <tr>
                                                <td>Total width Coupon</td>
                                                <?php $total = $total_amount + $total_amount*0.01 - Session::get('couponAmount'); ?>
                                                <td><span><small><strong>{{ number_format($total , 0) }}</strong> - VNĐ</small></span></td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td colspan="2">
                                        <table class="table table-condensed total-result">
                                            <tr>
                                                <td>Cart Sub Total</td>
                                                <td><span><small><strong>{{ number_format($total_amount , 0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                            <tr>
                                                <td>Exo Tax</td>
                                                <td><span><small><strong>{{ number_format($total_amount*0.01,0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                            <tr class="shipping-cost">
                                                <td>Shipping Cost</td>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <?php $total = $total_amount + $total_amount*0.01; ?>
                                                <td><span><small><strong>{{ number_format($total , 0) }}</strong> - VNĐ</small></span></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endif

                    @else
                        <tr>
                            <td class="text-center" colspan="6"><strong>Empty Cart <a href="/">(Continue Shopping)</a></strong></td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <form action="{{ route('cart.placeOrder') }}" method="POST" id="paymentForm" name="paymentForm">
            @csrf
            <div class="payment-options">
                <input type="hidden" value="{{  $total }}" name="total">
                <span>
                    <label><strong>Select Payment method : </strong></label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="cod" value="cod"><strong> COD</strong></label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="paypal" value="paypal"><strong> Paypal</strong></label>
                </span>

                <span>
                    <label><input type="submit" class="btn btn-default update float-right" value="Confirm order" onclick="return PaypalMenthodOrder();" /></label>
                </span>
            </div>
        </form>
    </div>
</section> <!--/#cart_items-->

@endsection


@section('js')
<script>
    function PaypalMenthodOrder()
    {
        if($("#paypal").is(":checked") || $("#cod").is(":checked"))
        {
            //alert("checked");
        }
        else
        {
            alert("Please select payment method");
            return false;
        }
    }
</script>
@endsection


