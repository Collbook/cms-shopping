@extends('layouts.app')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Customer orders</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td>Order Id</td>
                        <td >Ordered Product</td>
                        <td >Payment Method</td>
                        <td >Order Total</td>
                        <td >Created On</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                   <span style="margin-left:5px"> {{ $order->id }}</span>
                                </td>
                                <td >
                                   @foreach ($order->ordersProduct as $pro)
                                       <span class="text-success"> <small>{{ $pro->product_code }} </small> <br></span>
                                   @endforeach
                                </td>
                                <td >
                                    {{ $order->payment_method  }}
                                </td>
                                <td >
                                    {{ number_format($order->total_amount,0) }} - <small>VNĐ</small>
                                </td>
                                <td >
                                    {{ $order->created_at  }}
                                </td>
                                <td >
                                   <a href="{{ route('customer.orders.details',['id'=>$order->id]) }}">View details</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="6"><strong>Empty Order <a href="/">(Continue Shopping)</a></strong></td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
@endsection
