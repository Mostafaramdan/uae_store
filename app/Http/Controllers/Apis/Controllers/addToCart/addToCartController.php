<?php
namespace App\Http\Controllers\Apis\Controllers\addToCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\prices;
use App\Models\products;

class addToCartController extends index
{
    public static function api()
    {
        $product= products::find(self::$request->productId);
        if( $product->quantity < 1){
            return [
                "status"=>430,
                "notAvailable"=>[
                    'product'=>objects::product( $product),
                    'availableQuantity'=>$product->quantity

                ],
                "message"=>self::$messages['order']["430"]
            ];
        }

        $cart= carts::where('products_id',$product->id)
                ->where('users_id',self::$account->id)
                ->where('orders_id',null)
                ->first();

        if(self::$request->priceId){
            $priceRecord= prices::find(self::$request->priceId);
            $price= $priceRecord->price;
            $total_quantity= $priceRecord->quantity;
            $quantity=($total_quantity) * (($cart->quantity??0)+1);
        }else{
            $quantity=($cart->total_quantity??1) * (($cart->quantity??0)+1);
        }

        carts::updateOrCreate([
            'products_id'=>$product->id,
            'users_id'=>self::$account->id,
            'orders_id'=>null,
        ],[
            'quantity'=>(($cart->quantity??0)+1),
            'price'=>$price??$product->price,
            'total_quantity'=>$quantity??1 ,
            'createdAt'=>now()
        ]);
        return [
            "status"=>200,
            "message"=>self::$messages['cart'][200]
        ];
    }
}