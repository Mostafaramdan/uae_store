<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users as user;
use App\Models\roles ;
use App\Models\logs ;
use Auth;
use Illuminate\Support\Str;

class users extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=user::class;
    }

    public static function index()
    {
        $records=  self::$model::orderBy('id','DESC');
        $only = ['id','name','phone','email','createdAt','isActive'] ;
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get($only);
        return view('dashboard.users.index',compact('records','totalPages','currentPage'));
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
        $tableInfo= (string) view('dashboard.users.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){
        
        $rules=[
            "name"      =>"required|min:3",
            "email"     =>"nullable|required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email,".$request->id,
            "phone"     =>"nullable|bail|required_if:email,|numeric|between:1000000000,99999999999999999999|unique:users,phone,".$request->id,
            // 'vehicleId' =>"required|exists:vehicles,id|",
            "password"  =>"required_if:id,|nullable|min:6",
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"?????? ?????????? ??????????",
            "name.min"          =>"?????? ???? ???? ?????? ?????????? ???? 3 ???????? ",

            "email.required_if" =>"?????? ?????????? ?????? ???????????????? ???? ???????????? ??????????????????",
            "email.regex"       =>"?????? ?????????? ???????????? ???????????????????? ???????? ????????",
            "email.min"         =>"?????? ???? ???? ?????? ???????????? ???????????????????? ???? 5 ???????? ",
            "email.unique"      =>"?????? ???????????? ???????? ??????????",

            "phone.required_if" =>"?????? ?????????? ?????? ???????????????? ???? ???????????? ????????????????????",
            "phone.nemeric"     =>"?????? ?????????? ?????? ???????????????? ???????? ???????? ",
            "phone.between"     =>"?????? ???? ???? ?????? ?????? ???????????????? ???? 11 ?????????? ?????? ???????? ???? 15 ?????? ",
            "phone.unique"      =>"?????? ???????????? ???????? ??????????",
            
            "vehicleId.required"=>"?????? ?????????? ?????????? ",
            "vehicleId.exists" =>"?????? ?????????? ?????? ???????? ???? ?????????? ????????????????",

            "password.required_if" =>"?????? ?????????? ?????????? ??????????",
            "password.min"      =>"?????? ???? ???? ?????? ?????????? ?????????? ???? 6 ?????????? ???? ????????",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }   
        if($request->has('img') && $request->id){
            helper::deleteFile(self::$model::find($request->id)->image);
        }
        if($request->id){
            $oldBalance= self::$model::find($request->id)->balance;
            if($request->balance){
                logs::createUpdate([
                    "users_id"  => $request->id,
                    "balance"=>$request->balance,
                    "admins_id"=>Auth::guard('dashboard')->user()->id
                ]);
            }
        }
        $data=[
            'id'=>$request->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'cashback'=>$request->cashback,
            'phone'=>Str::replace('+','00',$request->phone),
            'password'=>bcrypt($request->password)??null,
            "language"=>"Ar",
            'createdAt'=>now()
        ];
        !$request->imag?:$data['image']=helper::base64_image_dash($request->imag,'users');
        $record= self::$model::updateOrCreate(['id'=>$request->id],$data);

        $record->increment('balance',$request->balance??0   );
        $message=$request->id?"???? ?????????????? ??????????":'???? ?????????? ??????????';
        
        return response()->json(['status'=>200,'message'=>$message]);
    }

    public static function getRecord($id)
    {
       return  self::$model::find($id);
    }
    public static function check($type,$id)
    {
        $record= self::$model::find($id);
        if($record->$type){
            $action="true";
            $record->$type=0;
        }else{
            $action="false";
            $record->$type=1;
        }
        $record->save();
        return response()->json(['status',200,'action'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        helper::deleteFile($record->image);
        $record->delete();
        return response()->json(['status'=>200]);
    }
    public static function getLogs($id)
    {
        $records = logs::where('users_id',$id)->orderBy("id",'DESC')->get();
        $currentBalance= self::$model::find($id)->balance;
        return view('dashboard.users.balanceTableInfo',compact('records','currentBalance'));
    }
}
