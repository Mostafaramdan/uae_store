<?php 

namespace App\Services;

use App\Models\products;
use App\Models\orders;
use App\Models\users;
use App\Models\appInfo;

class makeOrderService{

    public static function incrementPoints($carts,users $account, appInfo $appInfo)
    {
        foreach($carts as $cart){
            $account->increment(
                'points',products::find($cart->products_id)->points* $cart->total_quantity
            );
        }
        if(orders::where('users_id',$account->id)->count()==1){
            $account->increment('points',$appInfo->firstOrderPoints);
        }
    }
}