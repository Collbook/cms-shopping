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
                        <li class="breadcrumb-item active" aria-current="page">coupons</li>
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
                    <h5 class="card-title"> &nbsp; List Coupons</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Coupon code</th>
                                    <th>Amount</th>
                                    <th>Amount type</th>
                                    <th>Expiry date</th>
                                    <th>Status</th>
                                    <th>
                                        Action
                                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-success">Create</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item->coupon_code }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>
                                            {{-- @if ($item->amount_type == 'percentage')
                                                {{ '20% / Cart' }}
                                            @else
                                                {{ '200,000 - VNĐ' }}
                                            @endif --}}
                                            {{ $item->amount_type }}

                                        </td>
                                        <td>{{ $item->expiry_date }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                               <strong><span class="text-success btn-sm"> {{ 'Active' }}</span></strong>
                                            @else
                                                <strong><span class="text-warning btn-sm"> {{ 'Not Active' }}</span></strong>
                                            @endif
                                        </td>
                                        <td>
                                            <a style="margin-right : 3px" href="{{ route('admin.coupons.edit',['id'=>$item->id]) }}" class="btn btn-warning btn-sm float-left">Edit</a>

                                            <button onclick="deleteCoupon({{ $item->id }})" href="{{ route('admin.coupons.destroy',$item->id) }}" class="btn btn-sm btn-danger">
                                                    delete
                                            </button>
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.coupons.destroy',$item->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE ')
                                            </form>

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
    function deleteCoupon(id) {
        const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        })

        swalWithBootstrapButtons({
        title: 'Are you sure?',
        text: "You won't delele coupon this!",
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
