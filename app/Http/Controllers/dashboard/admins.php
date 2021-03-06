<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\admins as model;
use Auth;
use Illuminate\Support\Arr;

class admins extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.admins.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);  
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                if( stripos($item['name'],$search) !== false  || stripos($item['email'],$search) !== false )
                    return true;
                return false;
            });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.admins.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){

        $rules=[
            "name"     =>"required|min:3",
            "email"    =>"required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:admins,email,".$request->id."|unique:stores,email,".$request->id,
            "password" =>"nullable|required_if:id,|min:6|confirmed",
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

            "password.required_if" =>"?????? ?????????? ?????????? ??????????",
            "password.confirmed" =>"?????????? ?????????? ?????? ????????????",
            "password.min"      =>"?????? ???? ???? ?????? ?????????? ?????????? ???? 6 ?????????? ???? ????????",

        ];

        $messagesEn=[
            
        ];

        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }  
        $configPermissions =  config('helperDashboard.permission');
        $permission=[];
        foreach($configPermissions as $key => $value){
            $permission[$key] = [
                "view" => $request->has($key."_view")?1:0,
                "add" => $request->has($key."_add")?1:0,
                "edit" => $request->has($key."_edit")?1:0,
                "delete" => $request->has($key."_delete")?1:0,
            ];
        }
        $record= self::$model::updateOrCreate(['id'=>$request->id],[
            'name'=>$request->name,
            'isSuperAdmin'=>$request->isSuperAdmin?1:0,
            'email'=>$request->email,
            'password'=>$request->password,
            'permissions'=>json_encode($permission),
            'createdAt'=>now(),
            'updatedAt'=>now(),
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
            if(!$record->permissions){
                $record->permissions='{"statistics":{"view":1,"add":0,"edit":0,"delete":0},"users":{"view":1,"add":1,"edit":1,"delete":1},"notifications":{"view":1,"add":1,"edit":1,"delete":1},"contacts":{"view":1,"add":0,"edit":0,"delete":1},"price_list":{"view":1,"add":1,"edit":1,"delete":1},"categories":{"view":1,"add":1,"edit":1,"delete":1},"stores":{"view":1,"add":1,"edit":1,"delete":1},"regions":{"view":1,"add":1,"edit":1,"delete":1},"ads":{"view":1,"add":1,"edit":1,"delete":1},"codes":{"view":1,"add":1,"edit":1,"delete":1},"recharges":{"view":1,"add":1,"edit":1,"delete":1},"send_to_my_emails":{"view":1,"add":1,"edit":1,"delete":1},"withdraw_requests":{"view":1,"add":1,"edit":1,"delete":1},"bank_accounts":{"view":1,"add":1,"edit":1,"delete":1},"orders":{"view":1,"add":1,"edit":1,"delete":1},"vehicles":{"view":1,"add":1,"edit":1,"delete":1},"admins":{"view":0,"add":0,"edit":0,"delete":0},"appInfo":{"view":1,"add":0,"edit":1,"delete":0}}';
            }
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
    static function image($image, $id=null)
    {
        if($image)
            return helper::base64_image_dash( $image,'categories');
        elseif($id){
            $category= model::find($id);
            return $category->image;
        }
    }
}

