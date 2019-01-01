<?php

namespace App;

use App\Country;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function ordersProduct()
    {
        return $this->hasMany('App\OrderProduct','order_id');
    }

    public static function getOrderDetails($order_id)
    {
        $getOrderDetails = Order::where('id',$order_id)->first();
        return $getOrderDetails;
    }

    public static function getContryCode($country)
    {
        $getContryCode = Country::where('country_name',$country)->first();
        return $getContryCode;
    }
}
