@extends('admin.layouts.master')

@section('css')
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
                        <li class="breadcrumb-item active" aria-current="page">panel admin orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<div class="container-fluid">
    <!-- ============================================================== -->
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
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Custormer Name</th>
                                    <th>Custormer Email</th>
                                    <th>Ordered Product</th>
                                    <th>Order Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="center">{{ $order->id }}</td>
                                        <td class="center">{{ $order->created_at }}</td>
                                        <td class="center">{{ $order->name }}</td>
                                        <td class="center">{{ $order->user_email }}</td>
                                        <td class="center">
                                            @foreach ($order->ordersProduct as $item)
                                                <a href=""><span class="text-success"> <small><strong>{{ $item->product_code }}</strong></small> <br></span></a>
                                            @endforeach
                                        </td>
                                        <td class="center"><small>{{ number_format($order->total_amount,0) }} (VNĐ)</small> </td>
                                        {{-- <td class="center"><span class="badge badge-pill badge-info float-right">{{ $order->order_status }}</span></td> --}}
                                        <td class="text-success">
                                            @switch($order->order_status)
                                                @case($order->order_status == "New")
                                                        <span class="badge badge-pill badge-danger float-right">{{ $order->order_status }}</span>
                                                    @break
                                                @case($order->order_status == "Pending")
                                                        <span class="badge badge-pill badge-primary float-right">{{ $order->order_status }}</span>
                                                    @break
                                                @case($order->order_status == "Cancelled")
                                                        <span class="badge badge-pill badge-warning float-right">{{ $order->order_status }}</span>
                                                    @break
                                                @case($order->order_status == "Process")
                                                        <span class="badge badge-pill badge-secondary float-right">{{ $order->order_status }}</span>
                                                    @break
                                                @case($order->order_status == "Shipped")
                                                        <span class="badge badge-pill badge-info float-right">{{ $order->order_status }}</span>
                                                    @break
                                                @case($order->order_status == "Completed")
                                                        <span class="badge badge-pill badge-success float-right">{{ $order->order_status }}</span>
                                                    @break
                                                        <span class="badge badge-pill badge-danger float-right">{{ $order->order_status }}</span>
                                                @default

                                            @endswitch
                                        </td>

                                        <td class="center">{{ $order->payment_method }}</td>
                                        <td><a href="{{ route('admin.orders.show',['id'=>$order->id]) }}">View Details</a></td>
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
