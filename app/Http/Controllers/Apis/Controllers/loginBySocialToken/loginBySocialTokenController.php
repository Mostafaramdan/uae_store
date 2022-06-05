<?php
namespace App\Http\Controllers\Apis\Controllers\loginBySocialToken;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\notifications;
use App\Http\Controllers\Apis\Helper\helper ;

class loginBySocialTokenController extends index
{
    public static function api(){

        return  [
            'status'=>200,
            'account'=>objects::account( self::$account),
            'message'=>index::$lang=='ar'?'تم تسجيل الدخول بنجاح':'login successfully'
        ];
    }
    
}
