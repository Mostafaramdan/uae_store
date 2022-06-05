<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\drivers as model;
use App\Models\logs;
use Illuminate\Support\Str;

class drivers extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::orderBy($request->sortBy??'id',$request->sortType??'desc');
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get();
        $currentPage=1;
        return view('dashboard.drivers.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $records= self::$model::when($request->search,function($q) use ($request){
                return $q->where(function($q) use ($request){
                    $search= '%'.$request->search.'%';
                    return $q
                        ->where("name","like",$search)
                        ->orWhere("email","like",$search)
                        ->orWhere("phone","like",$search);
                });
            })
            ->orderBy($request->sortBy??'id',$request->sortType??'desc');
        $only = ['id','name','phone','email','createdAt','isActive'] ;

       
        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;

        $records=$records->forpage($currentPage,$itemPerPage)->get($only);
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.drivers.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        // return $request;
        $rules=[
            "name"      =>"required|min:3",
            "email"    =>"required_if:phone,|nullable|email|unique:stores,email,".$request->id."|unique:drivers,email,".$request->id."|unique:users,email,".$request->id,
            "phone"    =>"bail|required_if:email,|".$request->phone?"":"numeric"."|between:10000000,99999999999999999999|unique:stores,phone,".$request->id."|unique:drivers,phone,id,".$request->id."|unique:users,phone".$request->id,
            'vehicles_id' =>"required|exists:vehicles,id|",
            "password"  =>"required_if:id,|nullable|min:6",
            "model"     =>"required_if:id,",
            "licenseNumber"     =>"required_if:id,",
            "delivery_methods_id"     =>"required",
            "image"     =>"required_if:id,",
            "IdPhoto"     =>"required_if:id,",
            "carImage"     =>"required_if:id,",
            "driverLicenseImage"     =>"required_if:id,",
            "carLicenseImage"     =>"required_if:id,",
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "email.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.email"       =>"يجب ادخال البريد الالكتروني بشكل صحيح",
            "email.min"         =>"يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
            "email.unique"      =>"هذا البريد مسجل مسبقا",

            "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "vehicles_id.required"=>"يجب ادخال الشاحنة ",
            "vehicles_id.exists" =>"هذا الرقم غير مسجل في قاعدة البيانات",

            "password.required_if" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",
        
            "model.required"     =>"يجب إدخال طراز السيارة",
            "licenseNumber.required_if"     =>"يجب ادخال رقم الرخصة",
            "delivery_methods_id.required"     =>"يجب إدخال نوع التوصيل",
            "image.required_if"     =>"يجب إدخال الصورة الخاصة بالسائق",
            "IdPhoto.required_if"     =>"يجب إدخال صورة البطاقة الشصخية ",
            "carImage.required_if"     =>"يجب إدخال صورة السيارة",
            "driverLicenseImage.required_if"     =>"يجب إدخال صورة رخصة السائق",
            "carLicenseImage.required_if"     =>"يجب إدخال صورة رخصة السيارة",

        ];

        $messagesEn=[
            
        ];

        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }  
        if($request->id){
            if($request->balance){
                logs::createUpdate([
                    "drivers_id" => $request->id,
                    "balance"=>$request->balance,
                    "admins_id"=>\Auth::guard('dashboard')->user()->id
                ]);
            }
        }  
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'name'=>$request->name,
            'vehicles_id'=>$request->vehicles_id,
            'email'=>$request->email,
            'balance'=>$request->balance,
            'cashback'=>$request->cashback,
            'fees'=>$request->fees,
            'phone'=>Str::replace('+','00',$request->phone),
            'model'=>$request->model,
            'password'=>$request->password,
            'licenseNumber'=>$request->licenseNumber,  
            'delivery_methods_id'=>$request->delivery_methods_id,  
            'imageDash'=>$request->image,  
            'IdPhotoDash'=>$request->IdPhoto,  
            'carImageDash'=>$request->carImage,  
            'driverLicenseImageDash'=>$request->driverLicenseImage,  
            'carLicenseImageDash'=>$request->carLicenseImage,  
            'isOnline'=>0, 
            'language'=>"Ar", 
        ]);
    
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
    public static function getLogs($id)
    {
        $records = logs::where('drivers_id',$id)->orderBy("id",'DESC')->get();
        $currentBalance= self::$model::find($id)->balance;
        return view('dashboard.drivers.balanceTableInfo',compact('records','currentBalance'));
    }
}

