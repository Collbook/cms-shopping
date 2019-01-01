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
                        <li class="breadcrumb-item active" aria-current="page">category</li>
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
                    <h5 class="card-title"> &nbsp; List Category</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Product Color</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>
                                        Action
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success">Create</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="center">{{ $product->id }}</td>
                                        <td class="center">{{ $product->category_id }}</td>
                                        <td class="center">{{ $product->category_name }}</td>
                                        <td class="center">{{ $product->product_name }}</td>
                                        <td class="center">{{ $product->product_code }}</td>
                                        <td class="center">{{ $product->product_color }}</td>
                                        <td class="center">{{ $product->price }}</td>
                                        <td class="center">
                                            @if(!empty($product->image))
                                            <img src="{{ asset('/backend/assets/images/products/small/'.$product->image) }}" style="height:50px;">
                                            @endif
                                        </td>
                                        <td class="center">
                                            <a href="#Modal{{ $product->id }}" class="btn btn-success btn-sm margin-5" data-toggle="modal" data-target="">View</a>

                                            <a href="{{ route('admin.products.edit',['id'=>$product->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a style="margin: 2px 0px;" href="{{ route('admin.product.create-attributes',['id'=>$product->id]) }}" class="btn btn-success btn-sm">Add Atribute</a>
                                            <a style="margin: 2px 0px;" href="{{ route('admin.product.edit-attributes',['id'=>$product->id]) }}" class="btn btn-success btn-sm">Edit Atribute</a>
                                            <a style="margin-bottom: 2px;" href="{{ route('admin.product.create-images',['id'=>$product->id]) }}" class="btn btn-primary btn-sm">Add Image</a>
                                            <button onclick="deleteProduct({{ $product->id }})" href="{{ route('admin.products.destroy',['id'=>$product->id]) }}" class="btn btn-sm btn-danger">
                                                    delete
                                            </button>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy',['id'=>$product->id]) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE ')
                                            </form>


                                            <div class="modal fade" id="Modal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                <div class="modal-dialog" role="document ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{  $product->product_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true ">&times;</span>
                                                            </button>

                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Product ID: {{ $product->id }}</p>
                                                            <p>Category ID: {{ $product->category_id }}</p>
                                                            <p>Product Code: {{ $product->product_code }}</p>
                                                            <p>Product Color: {{ $product->product_color }}</p>
                                                            <p>Price: {{ $product->price }}</p>
                                                            <p>Fabric: </p>
                                                            <p>Pattern: </p>
                                                            <p>Description: {{ $product->description }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
