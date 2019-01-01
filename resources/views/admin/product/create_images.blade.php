@extends('admin.layouts.master')

@section('css')

<style>
div#zero_config_paginate {
    float: right;
}
div#zero_config_filter {
    float: right;
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
                        <li class="breadcrumb-item active" aria-current="page">products</li>
                        <li class="breadcrumb-item active" aria-current="page">create images</li>
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
                <form class="form-horizontal" action="{{ route('admin.product.store-images') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row">
                                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                <label for="product_name" style="margin-left:31px" class="col-sm-3 text-right control-label col-form-label">Protduct Name <strong>{{ $productDetails->product_name }}</strong></label>
                            </div>

                            <div class="form-group row">
                                <label for="product_code" class="col-sm-3 text-right control-label col-form-label">Protduct Code <strong>{{ $productDetails->product_code }}</strong></label>
                            </div>

                            <div class="form-group row">
                                <label for="product_color" class="col-sm-3 text-right control-label col-form-label">Protduct Color <strong>{{ $productDetails->product_color }}</strong></label>
                            </div>

                            <div class="form-group row">
                                    <label for="product_name" class="col-sm-3 text-right control-label col-form-label"><strong>Craete Image</strong></label>
                            </div>

                            <div class="form-group row">
                                <div class="field_wrapper" style="margin-left: 100px;">
                                    <div>
                                        <div class="uploader" id="uniform-undefined"><input name="image[]" id="image" type="file" multiple="multiple"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End Bread crumb and right sidebar toggle -->
<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> &nbsp; List images of product</h5>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image ID</th>
                                        <th>Product ID</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>
                                            Action
                                            {{-- <a href="{{ route('admin.product.create-images',['id'=>$productDetails->id]) }}" class="btn btn-sm btn-success">Create Product</a> --}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productImages as $image)
                                        <tr>
                                            <td class="center">{{ $image->id }}</td>
                                            <td class="center">{{ $image->product_id }}</td>
                                            <td class="center">{{ $category_name }}</td>
                                            <td class="center"><img width=65px src="{{ asset('backend/assets/images/products/small/'.$image->image) }}"></td>
                                            <td>
                                                <button onclick="deleteImage({{ $image->id }})" href="{{ route('admin.product.images.delete',['id'=>$image->id]) }}" class="btn btn-sm btn-danger">
                                                    delete
                                                </button>
                                                <form id="delete-form-{{ $image->id }}" action="{{ route('admin.product.images.delete',['id'=>$image->id]) }}" method="POST" style="display:none;">
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

    <script src="{{ asset('backend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><input required title="Required" type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;"> <input required title="Required" type="text" name="size[]" id="size" placeholder="Size" style="width:120px;"><input style="width:120px;margin-left: 3px;" required title="Required" type="text" name="price[]" id="price" placeholder="Price"><input required title="Required" type="text" name="stock[]" id="stock" placeholder="Stock" style="width:120px;margin-left: 3px;"><a href="javascript:void(0);" class="remove_button"><i class="m-r-10 mdi mdi-delete" style="font-size:22px;vertical-align: middle;"></i></a></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });


    </script>


     <!-- SweetAlert2  for detele tag Plugin Js -->
     <script type="text/javascript">
        function deleteImage(id) {
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

            swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't delele image this!",
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
