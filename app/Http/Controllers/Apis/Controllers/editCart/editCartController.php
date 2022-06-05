<?php
namespace App\Http\Controllers\Apis\Controllers\editCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;
use App\Models\prices;

class editCartController extends index
{
    public static function api()
    {
        $cart= carts::find(self::$request->cartId);
        $product= products::find($cart->products_id);
        if( $product->quantity < self::$request->quantity){
            return [
                "status"=>430,
                "notAvailable"=>[
                    'product'=>objects::product( $product),
                    'availableQuantity'=>$product->quantity
                ],
                "message"=>self::$messages['order']["430"]
            ];
        }
        if(self::$request->priceId){
            $priceRecord= prices::find(self::$request->priceId);
            $price= $priceRecord->price;
            $total_quantity= $priceRecord->quantity * self::$request->quantity;

        }

        $cart->update([
            'quantity'=>self::$request->quantity,
            'total_quantity'=>$total_quantity??1
            ]);
        return [
            "status"=>200,
        ];
    }
}