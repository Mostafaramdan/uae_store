<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\stores as model;
use App\Models\locations;
use App\Models\bills;
use App\Models\orders;
use App\Models\stores_has_regions;
use App\Models\regions;
use Illuminate\Support\Str;

class stores extends Controller
{
    public static $model;
    
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        $regions = regions::where('type','city')->get();
        // $regions = regions::where('isActive',1)->where('regions_id',null)->get();
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.stores.index',compact("records","totalPages",'currentPage','regions'));
    }   
    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);    
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
        }
        $records = $request->has_offer?$records->where('has_offer',true):$records; 
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.stores.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    public static function createUpdate(Request $request)
    {
        $rules=[
            "name"     =>"required|min:3",
            "email"    =>"required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:stores,email,".$request->id."|unique:drivers,email,".$request->id."|unique:users,email,".$request->id."|unique:admins,email,".$request->id,
            "phone"    =>"bail|required_if:email,|".$request->phone?"":"numeric"."|between:10000000,99999999999999999999|unique:stores,phone,id|unique:drivers,phone|unique:users,phone",
            "password" =>"bail|required_if:id,|nullable|min:6",
            "image"    =>"required_if:id,",
            // "longitude"=>"required",
            // "latitude"=>"required",
            "mapUrl"=>"required_if:id,",
            "address"=>"required_if:id,",
            // "categories_id"=>"required",
        ];
        if($request->isDiscounted){
            
            $rules=[
                "start_at_offer"=>"required",
                "end_at_offer"=>"required",
                "discount"=>"required",
                "discountCode"=>"required|unique:stores,discountCode,{$request->id}|min:5|max:7",
            ];
        }
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",
    
            "email.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.regex"       =>"يجب ادخال البريد الالكتروني بشكل صحيح",
            "email.min"         =>"يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
            "email.unique"      =>"هذا البريد مسجل مسبقا",
    
            "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.numeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "regionId.required" =>"يجب ادخال البلد ",
            "regionId.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",
    
            "password.required_if" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",
    
            "image.required_if" =>"يجب ادخال  الصورة",
    
            "longitude.required" =>"يجب ادخال  خطوط الطول",
            "latitude.required" =>"يجب ادخال خطوط الطول",
            "address.required" =>"يجب ادخال العنوان",
    
            "mapUrl.required_if" =>"يجب ادخال رابط الخريطة",
            
            "categories_id.required"=>"يجب إدخال القسم",
    
            "address.required_if"=>"يجب إدخال العنوان ",
            
            "start_at_offer.required"=>"يجب إدخال تاريخ بداية الخصم",
            "end_at_offer.required"=>"يجب إدخال تاريخ نهاية الخصم",
            "discount.required"=>"يجب إدخال نسبة الخصم",
            "discountCode.required"=>"يجب إدخال الكود ",
            "discountCode.unique" =>"يجب أدخال كود مختلف",
            "discountCode.min" =>"يجب ان يتكون الكود من 5 الي 7 ارقام وحروف",
            "discountCode.max" =>"يجب ان يتكون الكود من 5 الي 7 ارقام وحروف",
        ];
    
        $messagesEn=[
            
        ];
        
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }    
        if(!$request->id && !$request->password)
            return response()->json(['status'=>500,'message'=>"يجب إدخال الرقم السري"]);
            
        if($request->phone){
            // $phone =  Str::startsWith($request->phone,"00968")?$request->phone:"00968".$request->phone;
            $phone =  $request->phone;
        }else{
            $phone = null; 
        }
        // dd($request->all());
        $record= self::$model::createUpdate([
            "id"=>$request->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>Str::replace('+','00',$request->phone),
            'password'=>$request->password,
            'categories_id'=>$request->categories_id,
            'deliveryTime'=>$request->deliveryTime . " " .$request->timeUnit ,
            'discount'=>$request->discount,
            "discountCode"=>$request->discountCode,
            "start_at_offer"=>$request->start_at_offer,
            "end_at_offer"=>$request->end_at_offer,
            'image'=>$request->image,  
            'fees'=>$request->fees??0,  
            'balance'=>$request->balance??0,  
        ]);
        if($request->mapUrl){
            locations::where('stores_id',$record->id)->delete();
            $url=$request->mapUrl;
            $latLong= explode(',',explode('@',$request->mapUrl)[1]);
            $lat = $latLong[0];
            $long =  $latLong[1];
            locations::createUpdate([
                'stores_id'=>$record->id,
                'longitude'=>$long,
                'latitude'=>$lat,
                'address'=>$request->address,
                'mapUrl'=>$request->mapUrl
            ]);
            
        }
        $count=0;
        $regions_names =  explode(',',$request->resultOfFilter);
        stores_has_regions::where('stores_id',$request->id)->delete();
        foreach($regions_names as $regions_name){
            $region = regions::where('nameAr','like', "%{$regions_name}%")->first();
            if($region){
                stores_has_regions::createUpdate([
                    'stores_id'=>$request->id , 
                    'regions_id'=>$region->id , 
                ]);
            }
        } 
        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
    }
    public static function getRecord($id)
    {
        return  self::$model::find($id);
    }
    public static function check($type, $id)
    {
        $record= self::$model::find($id);
        if($record->$type){
            $action="false";
            $record->$type=0;
        }else{
            $action="true";
            $record->$type=1;
        }
        $record->save();
        return response()->json(['status',200,'action'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        $record->delete();
        return response()->json(['status'=>200]);
    }
}