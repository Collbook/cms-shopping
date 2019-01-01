@extends('admin.layouts.master')

@section('css')
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <style>
        .table td, .table th {
            padding: 10px;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>
@endsection
@section('content')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Dashboard</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">admin orders details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title m-b-0">Orders details</h5>
                </div>
                <div class="table-responsive">
                    <form action="{{ route('admin.orders.status') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $ordersDetail->id }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Customer name</th>
                                    <th scope="col">Order date</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Order Total</th>
                                    <th scope="col">Order Charges</th>
                                    <th scope="col">Order Coupon</th>
                                    <th scope="col">Paypal Method</th>
                                    {{-- <th scope="col">Actions</th> --}}
                                    <th scope="col">Email</th>
                                    <th><input type="submit" value="Update Status" style="margin-left:10px" class="btn btn-sm btn-skype" /> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $ordersDetail->name }}</td>
                                    <td>{{ $ordersDetail->created_at }}</td>
                                    <td class="text-success">
                                        @switch($ordersDetail->order_status)
                                            @case($ordersDetail->order_status == "New")
                                                    <span class="badge badge-pill badge-danger float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                            @case($ordersDetail->order_status == "Pending")
                                                    <span class="badge badge-pill badge-primary float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                            @case($ordersDetail->order_status == "Cancelled")
                                                    <span class="badge badge-pill badge-warning float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                            @case($ordersDetail->order_status == "Process")
                                                    <span class="badge badge-pill badge-secondary float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                            @case($ordersDetail->order_status == "Shipped")
                                                    <span class="badge badge-pill badge-info float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                            @case($ordersDetail->order_status == "Completed")
                                                    <span class="badge badge-pill badge-success float-right">{{ $ordersDetail->order_status }}</span>
                                                @break
                                                    <span class="badge badge-pill badge-danger float-right">{{ $ordersDetail->order_status }}</span>
                                            @default

                                        @endswitch
                                    </td>
                                    <td>{{ number_format($ordersDetail->total_amount,0) }}</td>
                                    <td>
                                        @if ($ordersDetail->shipping_charges == 0)
                                            {{ "Free" }}
                                        @else
                                            {{ $ordersDetail->shipping_charges }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ordersDetail->coupon_code == 0)
                                            {{ "No Coupon" }}
                                        @else
                                            {{ $ordersDetail->coupon_code }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($ordersDetail->payment_method == 'paypal')
                                            {{ "Paypal" }}
                                        @else
                                            {{ "COD" }}
                                        @endif
                                    </td>
                                    <td> {{ $ordersDetail->user_email }}</td>
                                    <td style="width:200px">
                                        <div class="col-md-9" data-select2-id="75">
                                            <select name="order_status" >
                                                <option value="New" @if ($ordersDetail->order_status == "New")
                                                        {{ "selected" }}
                                                @endif>New</option>
                                                <option value="Pending" @if ($ordersDetail->order_status == "Pending")
                                                        {{ "selected" }}
                                                @endif>Pending</option>
                                                <option value="Cancelled" @if ($ordersDetail->order_status == "Cancelled")
                                                        {{ "selected" }}
                                                @endif>Cancelled</option>
                                                <option value="Process" @if ($ordersDetail->order_status == "Process")
                                                        {{ "selected" }}
                                                @endif>Process</option>
                                                <option value="Shipped" @if ($ordersDetail->order_status == "Shipped")
                                                        {{ "selected" }}
                                                @endif>Shipped</option>
                                                <option value="Completed" @if ($ordersDetail->order_status == "Completed")
                                                        {{ "selected" }}
                                                @endif>Completed</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <form action="">
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-body">
                    <h5 class="card-title m-b-0">Website statistics</h5>
                </div> --}}
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Billing Details</th>
                                <th>Billing Address</th>
                                <th>Shipping Address</th>
                            </tr>
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
    </div>
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> &nbsp; List Orders</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Product Code</td>
                                    <td>Product Name</td>
                                    <td>Product Size</td>
                                    <td>Product Color</td>
                                    <td>Product Price</td>
                                    <td>Product Qty<a class="" href="{{ route('admin.orders.index') }}"> &nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span> Back</a> </td>
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
                                                <span>{{ $product->product_qty }} </span>
                                            </td>
                                        </tr>
                                    @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
@endsection

@section('js')
    <!-- this page js -->
    <script src="{{ asset('backend/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('backend/assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

     <!-- SweetAlert2  for detele tag Plugin Js -->
     <script type="text/javascript">
        function deleteProduct(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't delele product this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                // code in here
                event.preventDefault();
                document.getElementById('delete-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })
        }
    </script>

@endsection
