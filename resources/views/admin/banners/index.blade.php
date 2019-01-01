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
                        <li class="breadcrumb-item active" aria-current="page">banners</li>
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
                    <h5 class="card-title"> &nbsp; List Banner</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>
                                        Action
                                        <a href="{{ route('admin.banner.create') }}" class="btn btn-sm btn-success">Create</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $key => $banner)
                                    <tr>
                                        <td class="center">{{ ++$key }}</td>
                                        <td class="center">{{ $banner->title }}</td>
                                        <td class="center">{{ $banner->link }}</td>
                                        <td class="center">
                                            @if ($banner->status == 1)
                                                <button class="btn btn-sm btn-cyan  bg-cyan">{{ 'Active' }}</button>
                                            @else
                                                <button class="btn btn-sm btn-danger bg-danger">{{ 'Not Active' }}</button>
                                            @endif
                                        </td>
                                        <td class="center">
                                            @if(!empty($banner->image))
                                                <img src="{{ asset('/backend/assets/images/banner/'.$banner->image) }}" style="width:100px;">
                                            @endif
                                        </td>
                                        <td class="center">
                                            <a style="margin-right : 3px" href="{{ route('admin.banner.edit',['id'=>$banner->id]) }}" class="btn btn-warning btn-sm float-left">Edit</a>

                                            <button onclick="deleteBanner({{ $banner->id }})" href="{{ route('admin.banner.destroy',$banner->id) }}" class="btn btn-sm btn-danger">
                                                    delete
                                            </button>
                                            <form id="delete-form-{{ $banner->id }}" action="{{ route('admin.banner.destroy',$banner->id) }}" method="POST" style="display:none;">
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
        function deleteBanner(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't delele banner this!",
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
