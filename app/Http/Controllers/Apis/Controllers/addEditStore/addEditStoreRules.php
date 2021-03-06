<?php
namespace App\Http\Controllers\Apis\Controllers\addEditStore;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addEditStoreRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"           =>"required|exists:providers,apiToken",
            "storeId"            =>"exists:stores,id",
            "logo"               =>"required",
            "images"             =>"nullable|array|min:4|max:6",
            "phones"             =>"nullable|array|min:1|max:3",
            "name"               =>"required|min:2|max:50",
            "description"        =>"required|min:5|max:200",
            "categoryId"         =>"required|exists:categories,id",
            "fromDay"            =>"required|exists:days,id",
            "toDay"              =>"required|exists:days,id",
            "fromTime"           =>"required|date_format:H:i:s",
            "toTime"             =>"required|date_format:H:i:s|after:fromTime",
            "facebook"           =>"required|url",
            "twitter"            =>"required|url",
            "instagram"          =>"required|url",
            "location"           =>"required",
            "location.longitude" =>"required",
            "location.latitude"  =>"required",
            "location.address"   =>"required"
        ];
        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "logo.required"         =>400,

            "images.required"       =>400,
            "images.array"          =>405,
            "images.min"            =>405,
            "images.max"            =>405,

            "phones.required"       =>400,
            "phones.array"          =>405,
            "phones.min"            =>405,
            "phones.max"            =>405,

            "name.required"         =>400,
            "name.min"              =>405,
            "name.max"              =>405,
           
            "description.required"  =>400,
            "description.min"       =>405,
            "description.max"       =>405,

            "categoryId.required"   =>400,
            "categoryId.exists"     =>405,

            "fromDay.required"      =>400,
            "fromDay.exists"        =>405,

            "toDay.required"        =>400,
            "toDay.exists"          =>405,

            "fromTime.required"     =>400,
            "fromTime.date_format"  =>405,

            "toTime.required"       =>400,
            "toTime.date_format"    =>405,
            "toTime.after"          =>405,

            "facebook.required"     =>400,
            "facebook.url"          =>405,

            "twitter.required"      =>400,
            "twitter.url"           =>405,

            "instagram.required"    =>400,
            "instagram.url"         =>405,

            "location.required"     =>400,
            "location.*.required"   =>400,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"?????? ?????????? ????????????",
            "apiToken.exists"       =>"?????? ???????????? ?????? ??????????",

            "logo.required"         =>"?????? ?????????? ????????????",
             
            "images.required"       =>"?????? ?????????? ??????",
            "images.array"          =>"?????? ?????????? ?????????? ?????? ???????????? ??????????",
            "images.min"            =>"?????? ?????????? ?????? ?????????? 4 ?????? ????????????",
            "images.max"            =>"?????? ?????????? ?????? ???????????? 6 ?????? ????????????",

            "phones.required"       =>"?????? ?????????? ?????????? ???????????????? ?????????? ??????????????",
            "phones.array"          =>"?????? ?????????? ?????????? ?????? ???????????? ??????????",
            "phones.min"            =>"?????? ?????????? ?????? ?????????? 1 ?????? ???????????? ????????????",
            "phones.max"            =>"?????? ?????????? ?????? ???????????? 3 ?????? ???????????? ????????????",


            "name.required"         =>"?????? ?????????? ??????????",
            "name.min"              =>"?????? ???? ???? ?????? ?????????? ???? ??????????",
            "name.max"              =>"?????? ???? ???? ???????? ?????????? ???? 50 ??????",
           
            "description.required"  =>"?????? ?????????? ??????????",
            "description.min"       =>"?????? ???? ???? ?????? ?????????? ???? 5 ???????? ",
            "description.max"       =>"?????? ???? ???? ???????? ?????????? ???? 200 ??????",

            "categoryId.required"   =>"?????? ?????????? ??????????",
            "categoryId.exists"     =>"?????? ?????????? ?????? ??????????",

            "fromDay.required"      =>"?????? ?????????? ?????? ?????????? ?????????? ",
            "fromDay.exists"        =>" ?????? ?????????? ?????? ?????????? ?????????? ???????? ????????",

            "toDay.required"        =>"?????? ?????????? ?????? ?????????? ?????????? ",
            "toDay.exists"          =>" ?????? ?????????? ?????? ?????????? ?????????? ???????? ????????",

            "fromTime.required"     =>"?????? ?????????? ???????? ?????????? ??????????",
            "fromTime.date_format"  =>"?????? ?????????? ???????? ?????????? ?????????? ???????? ????????",

            "toTime.required"       =>"?????? ?????????? ???????? ?????????? ??????????",
            "toTime.date_format"    =>"?????? ?????????? ???????? ?????????? ?????????? ???????? ????????",
            "toTime.after"          =>"?????? ???? ???????? ???????? ?????????????? ?????? ???????? ?????????????? ",

            "facebook.required"     =>"?????? ?????????? ???????? ?????????? ??????",
            "facebook.url"          =>"?????? ?????????? ???????? ?????????? ?????? ???????? ????????",

            "twitter.required"      =>"?????? ?????????? ???????? ??????????????",
            "twitter.url"           =>"?????? ?????????? ???????? ?????????????? ???????? ????????",

            "instagram.required"    =>"?????? ?????????? ???????? ????????????????????",
            "instagram.url"         =>"?????? ?????????? ???????? ???????????????????? ???????? ????????",

            "location.required"     =>"?????? ?????????? ????????????",
            "location.*.required"   =>"  [longitude , latitude ,address] : ?????? ?????????? ???????????? ???????? ????????  ",
        ];
        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
