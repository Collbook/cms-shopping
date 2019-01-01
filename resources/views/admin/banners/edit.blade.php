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
                        <li class="breadcrumb-item active" aria-current="page">banner</li>
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
                <form class="form-horizontal" action="{{ route('admin.banner.update',['id'=>$banner->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            <label for="title" class="col-sm-3 text-right control-label col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" value="{{ $banner->title }}" class="form-control"  placeholder="Title here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 text-right control-label col-form-label">Link</label>
                            <div class="col-sm-9">
                                <input type="text" name="link" value="{{ $banner->link }}" class="form-control"  placeholder="Link here"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 text-right control-label col-form-label">Text1</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="text1" class="form-control"  placeholder="Link here">{{ $banner->text1 }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 text-right control-label col-form-label">Text2</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="text2" class="form-control"  placeholder="Link here">{{ $banner->text2 }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 text-right control-label col-form-label">Text3</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="text3" class="form-control"  placeholder="Link here">{{ $banner->text3 }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 text-right control-label col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" value="{{ $banner->image }}" name="image">
                                @if(!empty($banner->image))
                                    <input type="hidden" name="current_image" value="{{ $banner->image }}">
                                @endif
                                <br><br>
                                <img width="100" src="{{ asset('backend/assets/images/banner/'.$banner->image) }}" alt="">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="status" @if ($banner->status==1)
                                    {{ 'checked' }}
                                @endif  class="" id="status" value="1" style="vertical-align: middle;margin-top: 11px;">
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
