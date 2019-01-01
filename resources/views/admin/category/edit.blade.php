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
                        <li class="breadcrumb-item"><a href="#">Category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">edit</li>
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
                <form class="form-horizontal" action="{{ route('admin.category.update',['id'=>$category->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="fname" value="{{ $category->name }}" placeholder="Category here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Category Level</label>
                            <div class="col-sm-9">
                                <select name="parent_id" style="width:220px;">
                                    <option value="0">Main Category</option>
                                    @foreach($levels as $val)
                                    <option value="{{ $val->id }}" @if($val->id==$category->parent_id) selected @endif>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                            <div class="col-sm-9">
                                <input type="text" name="description" value="{{ $category->description }}" class="form-control" id="lname" placeholder="Description here">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Url</label>
                            <div class="col-sm-9">
                                <input type="text" name="url" value="{{ $category->url }}"  class="form-control" id="lname" placeholder="Url here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="status"  class="" id="status" @if ($category->status == 1)
                                    {{ 'checked' }}
                                @endif style="vertical-align: middle;margin-top: 11px;">
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
