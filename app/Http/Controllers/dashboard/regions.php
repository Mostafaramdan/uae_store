<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\regions as model;

class regions extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::query();
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get();
        return view('dashboard.regions.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType=='sortBy'?'asc':'desc';
        $records= self::$model::orderBy($request->sortBy??"id",$sort)
                ->when($request->search,function($q) use ($request){
                    return $q->where('nameAr','LIKE', '%'.$request->search.'%');
                })
                ->when($request->isFreeDelivered,function($q){
                    return $q->where("isFreeDelivered",1);
                });

        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;
        
        $records=$records->forpage($currentPage,$itemPerPage)->get();
        
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.regions.tableInfo',compact('records'));
        
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "nameAr"     =>"required|min:3",
            "nameEn"     =>"required|min:3",
            // 'regions_id' =>"required_if:check,|not_in:".$request->id,
        ];

        $messages=[
        ];

        $messagesAr=[

            "nameAr.required"     =>"يجب ادخال الاسم",
            "nameAr.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "nameEn.required"     =>"يجب ادخال الاسم",
            "nameEn.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "regions_id.required_if" =>"يجب ادخال البلد ",
            "regions_id.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",
            "regions_id.not_in"   =>"لا يمكن اختيار البلد مع نفس المدينة",

        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'nameAr'=>$request->nameAr,
            'nameEn'=>$request->nameEn,
            'type'=>$request->type,
            'regions_id'=>$request->regions_id,
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
}

