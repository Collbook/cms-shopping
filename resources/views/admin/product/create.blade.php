@extends('admin.layouts.master')

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
                        <li class="breadcrumb-item active" aria-current="page">product</li>
                        <li class="breadcrumb-item active" aria-current="page">create</li>
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
                <form class="form-horizontal" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
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
                            <label for="category_id" class="col-sm-3 text-right control-label col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="category_id" id="category_id" style="width:220px;">
                                    {!! $categories_drop_down !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_name" class="form-control"  placeholder="Name here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="description" class="form-control"  placeholder="Description here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Material & Care</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="care" class="form-control"  placeholder="Material & Care here"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_code" class="col-sm-3 text-right control-label col-form-label">Code</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_code" class="form-control"  placeholder="Code here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_color" class="col-sm-3 text-right control-label col-form-label">Color</label>
                            <div class="col-sm-9">
                                <input type="text" name="product_color" class="form-control"  placeholder="Color here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-3 text-right control-label col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" min="0" name="price" class="form-control"  placeholder="Price here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 text-right control-label col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="status"  class="" id="status" value="1" style="vertical-align: middle;margin-top: 11px;">
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
@endsection
