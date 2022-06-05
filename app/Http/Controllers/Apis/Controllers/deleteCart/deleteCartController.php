<?php
namespace App\Http\Controllers\Apis\Controllers\deleteCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;

class deleteCartController extends index
{
    public static function api()
    {
        carts::destroy(self::$request->cartId);
        return [
            "status"=>200,
        ];
    }
}