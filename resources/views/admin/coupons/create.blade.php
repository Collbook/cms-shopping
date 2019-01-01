@extends('admin.layouts.master')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
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
                <form class="form-horizontal" action="{{ route('admin.coupons.store') }}" method="POST">
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
                            <label for="coupon_code" class="col-sm-3 text-right control-label col-form-label">Coupon Code</label>
                            <div class="col-sm-9">
                                <input type="text" name="coupon_code" minlength="5" maxlength="15" class="form-control"  required autofocus placeholder="Coupon here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Amount" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                            <div class="col-sm-9">
                                <input type="number" min="0" name="amount" class="form-control" required autofocus  placeholder="amount here">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Abouttype" class="col-sm-3 text-right control-label col-form-label">Amout Type</label>
                            <div class="col-sm-9">
                                <select name="amount_type" id="amount_type" class="form-control">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="product_code" class="col-sm-3 text-right control-label col-form-label">Expiry</label>
                            <div class="col-sm-9">
                                <p><input type="expiry_date" name="expiry_date" id="datepicker" class="form-control"  required autofocus placeholder="Expiry here"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Status</label>
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

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate : 0,
        });
    } );
</script>


@endsection
