@section('css')
    <link href="{{ asset('frontend/css/easyzoom.css') }}" rel="stylesheet">
@endsection
@extends('layouts.app')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>

                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        @foreach ($categories as $cat)
                            @if ($cat->status == '1')
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordian" href="#{{ $cat->id }}">
                                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                {{ $cat->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ $cat->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul>
                                                @foreach ($cat->categories as $subcat)
                                                    @if ($subcat->status == '1')
                                                        <li><a href="{{ asset('products/'.$subcat->url) }}"><strong> - </strong>{{ $subcat->name }} </a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div><!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                                <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                                <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                                <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                            </ul>
                        </div>
                    </div><!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Price Range</h2>
                        <div class="well">
                                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                                <b>$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div><!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="{{ asset('frontend/images/home/shipping.jpg') }}" alt="" />
                    </div><!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                {{-- <a href="{{ asset('/backend/assets/images/products/large/'.$productDetails->image) }}"> --}}
                                <a href="{{ asset('/backend/assets/images/products/medium/'.$productDetails->image) }}">
                                    <img  style="width:300px" class="mainImage" src="{{ asset('/backend/assets/images/products/medium/'.$productDetails->image) }}" alt="" />
                                    {{-- <h3>ZOOM</h3> --}}
                                </a>
                            </div>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                    @foreach ($productAltImages as $item)
                                        {{-- <a href="{{ asset('backend/assets/images/products/large/'.$item->image) }}" data-standard="{{ asset('backend/assets/images/products/small/'.$item->image) }}"> --}}
                                        <a href="{{ asset('backend/assets/images/products/medium/'.$item->image) }}" data-standard="{{ asset('backend/assets/images/products/small/'.$item->image) }}">
                                            <img class="changeImage" style="cursor:pointer;" width="82" src="{{ asset('backend/assets/images/products/small/'.$item->image) }}" alt="">
                                        </a>
                                    @endforeach
                                    </div>
                                    <div class="item">
                                        @foreach ($productAltImages as $item)
                                        {{-- <a href="{{ asset('backend/assets/images/products/large/'.$item->image) }}" data-standard="{{ asset('backend/assets/images/products/small/'.$item->image) }}"> --}}
                                        <a href="{{ asset('backend/assets/images/products/medium/'.$item->image) }}" data-standard="{{ asset('backend/assets/images/products/small/'.$item->image) }}">
                                            <img class="changeImage" style="cursor:pointer;" width="82" src="{{ asset('backend/assets/images/products/small/'.$item->image) }}" alt="">
                                        </a>
                                        @endforeach
                                    </div>

                                </div>

                                <!-- Controls -->
                                <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                                </a>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <form name="addtoCartForm" id="addtoCartForm" action="{{ route('addtocart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                            <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                            <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                            <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                            <input type="hidden" name="product_image" value="{{ $productDetails->image }}">
                            {{-- using id=price when add addtocart --}}
                            <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">

                            <div class="product-information"><!--/product-information-->
                                <img src="{{ asset('frontend/images/product-details/new.jpg') }}" class="newarrival" alt="" />
                                <h2>{{ $productDetails->product_name }}</h2>
                                <p>Web ID: {{ $productDetails->product_code }}</p>
                                <p>
                                    @if ($total_stock > 0)
                                    <select id="selSize" name="size" style="width:150px;" required>
                                        <option value="">Select</option>
                                        @foreach($productDetails->attributes as $sizes)
                                            <option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </p>

                                <img src="{{ asset('frontend/images/product-details/rating.png') }}" alt="" />
                                <span>
                                    {{-- using id getPrice for update price via ajax --}}
                                    @if ($total_stock > 0)
                                    {{-- cartButton check stock in a product,if stock for a product > 0, show add to car and else --}}
                                    <div id="cartButton">
                                        <span  style="font-size:15px" id="getPrice" >{{ number_format($productDetails->price, 0) }} - VNĐ</span>
                                        <label>Quantity:</label>
                                        <input name="quantity" type="number" min="1" value="1" />
                                        <button type="submit" class="btn btn-fefault cart">
                                            <i class="fa fa-shopping-cart"></i>
                                            Add to cart
                                        </button>
                                    </div>
                                    @endif
                                </span>
                                <p><b>Availability:</b> <span id="Availability">@if ($total_stock > 0)
                                    In Stock
                                @else
                                    Out of stock
                                @endif </span> </p>
                                <p><b>Condition:</b> New</p>
                                <p><b>Brand:</b> E-SHOPPER</p>
                                <a href=""><img src="{{ asset('frontend/images/product-details/share.png') }}" class="share img-responsive"  alt="" /></a>
                            </div><!--/product-information-->
                        </form>
                    </div>
                </div><!--/product-details-->

                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
                            <li><a href="#care" data-toggle="tab">Material & Care</a></li>
                            <li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="description" >
                            <div class="col-sm-12">
                                <p>{{ $productDetails->description }}</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="care" >
                            <div class="col-sm-12">
                                <p>{{ $productDetails->care }}</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="delivery" >
                            <div class="col-sm-12">
                                <p>100% Original Products <br>
                                Cash on delivery might be available</p>
                            </div>
                        </div>
                    </div>
                </div><!--/category-tab-->

                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">recommended items</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            {{-- get 3 product in 1 line, if $count == 1 => one line --}}
                            <?php $count = 1 ?>
                            @foreach ($relatedProducts->chunk(3) as $chunk)
                                <div @if ($count == 1)
                                    class="item active">
                                @else
                                    class="item">
                                @endif
                                    @foreach ($chunk as $item)
                                        <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <a href="{{ asset("product/$item->id") }}">
                                                            <img src="{{ asset('backend/assets/images/products/small/'.$item->image) }}" alt="" />
                                                        </a>
                                                        <h2><span  style="font-size:15px">{{ number_format($item->price, 0) }} - VNĐ</span></h2>
                                                        <p>{{ $item->product_name }}n</p>
                                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            <?php $count++; ?>
                            @endforeach
                        </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                            </a>
                    </div>
                </div><!--/recommended_items-->

            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function(){
       // Change Price with Size
        $("#selSize").change(function(){
            var idsize = $(this).val();
            //alert(idsize);
            if(idsize == ""){
                return false;
            }
            $.ajax({
                type:'get',
                url:'/get-product-price',
                data:{idsize:idsize},
                success:function(resp){
                    //alert(resp);
                    var arr = resp.split('#');
                    $("#getPrice").html(arr[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' - VNĐ');
                    // when addtocart
                    $("#price").val(arr[0]);
                    if(arr[1]==0){
                        $("#cartButton").hide();
                        $("#Availability").text("Out Of Stock");
                    }else{
                        $("#cartButton").show();
                        $("#Availability").text("In Stock");
                    }


                },error:function(){
                    alert("Error");
                }
            });
        });

        // Replace Main Image for product
        $(".changeImage").click(function(){
            //alert('ok');
            var image = $(this).attr('src');
            //alert(image);
            $(".mainImage").attr("src",image);
        });
    });
</script>
<script src="{{ asset('frontend/js/easyzoom.js') }}"></script>

<script>
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

    // Setup toggles example
    var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

    $('.toggle').on('click', function() {
        var $this = $(this);

        if ($this.data("active") === true) {
            $this.text("Switch on").data("active", false);
            api2.teardown();
        } else {
            $this.text("Switch off").data("active", true);
            api2._init();
        }
    });
</script>

@endsection
