<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'HomeController@index')->name('home');

// Category/Listing Page
Route::get('products/{url}', 'ProductsController@products');

// Product Detail Page
Route::get('product/{id}','ProductsController@product');

// Get Product Attribute Price
Route::any('/get-product-price','ProductsController@getProductPrice');

// Add to Cart Route
Route::post('product/add-cart', 'ProductsController@addtocart')->name('addtocart');

// show list cart product
Route::get('cart','ProductsController@showCart')->name('cart.showCart');

// Delete Product from Cart Route
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct')->name('cart.deleteCart');;


// Update Product Quantity from Cart
//Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity')->name('cart.update');

// Apply Coupon
Route::post('/cart/apply-coupon','ProductsController@applyCoupon')->name('cart.apply-coupon');

// User login and register

Route::match(['get', 'post'], '/login-register','UsersController@register')->name('login-register');

// user logout
Route::get('user-logout','UsersController@logout')->name('user.logout');

// user login
//Route::post('user-login','UsersController@login')->name('user.login');
Route::match(['get', 'post'], '/user-login','UsersController@login')->name('user.login');

// confirm email active for register
Route::get('confirm/{code}','UsersController@confirmAccount')->name('confirm');

// check frontlogin middleware
Route::group(['middleware' => ['frontlogin']], function () {
    // user account
    Route::match(['get', 'post'], 'account','UsersController@account')->name('user.account');

    // check password exists user via ajax
    Route::any('/check-user-pwd','UsersController@checkUserPassword');

    Route::post('/update-password','UsersController@userUpdatePassword')->name('userUpate.password');

    // checkout
    Route::match(['get', 'post'],'/cart/checkout','ProductsController@checkout')->name('cart.checkout');

    // order reivew
    Route::match(['get', 'post'],'/cart/order-review','ProductsController@orderReview')->name('cart.orderReview');

    // place order
    Route::match(['get', 'post'],'/cart/place-order','ProductsController@placeOrder')->name('cart.placeOrder');

    //thanks
    Route::get('/thanks','ProductsController@thanks')->name('thanks');

    // paypal
    Route::get('/customer/paypal','ProductsController@paypal')->name('customer.paypal');

    Route::get('/customer/orders','ProductsController@customerOrders')->name('customer.orders');

    // show details order
    Route::match(['get', 'post'],'/customer/orders/{id}','ProductsController@customerOrdersDetails')->name('customer.orders.details');



});
// check exists email in db via jquery ajax

Route::match(['get', 'post'], '/check-email','UsersController@checkEmail');

//Auth::routes();
Auth::routes(['verify' => true]);

Route::prefix('admin')->name('admin.')->namespace('Backend')->group(function () {

    Route::match(['get', 'post'], '/','AdminController@login')->name('login');

    Route::get('logout','AdminController@logout')->name('logout');

    // middleware admin
    Route::group(['middleware' => ['adminlogin']], function(){
        // dashboard
        Route::get('dashboard','AdminController@dashboard')->name('dashboard');
        //setting
        Route::get('settings','AdminController@settings')->name('settings');

        Route::post('password','AdminController@updatePassword')->name('password');

        //category
        Route::resource('category', 'CategoryController');

        // product
        Route::resource('products', 'ProductsController');

        Route::get('product/add-attributes/{id}','ProductsController@createAttributes')->name('product.create-attributes');

        Route::post('product/add-attributes','ProductsController@storeAttributes')->name('product.store-attributes');

        Route::get('product/edit-attributes/{id}','ProductsController@editAttributes')->name('product.edit-attributes');

        Route::post('product/update-attributes','ProductsController@updateAttributes')->name('product.update-attributes');

        Route::delete('product/delete-attributes/{id}','ProductsController@deleteAttribute')->name('product.attributes.delete');

        Route::get('product/add-images/{id}','ProductsController@createImages')->name('product.create-images');

        Route::post('product/add-images','ProductsController@storeImages')->name('product.store-images');

        Route::delete('product/delete-images/{id}','ProductsController@deleteImages')->name('product.images.delete');

        // Admin Coupon Routes
        Route::resource('coupons','CouponsController');

        // Admin Banners Routes
        Route::resource('banner','BannersController');

        // Order
        Route::resource('orders','OrderController');

        // update order status
        Route::post('orders/status','OrderController@orderStatus')->name('orders.status');
    });

});



