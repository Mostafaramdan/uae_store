<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\price_list as model;

class price_list extends Controller
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
        return view('dashboard.price_list.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    return stripos($item['startKm'],$search) !== false;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage??1;
        $records=$records->forpage($currentPage??1,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.price_list.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){
        $lastRecord= self::$model::orderBy('id','DESC')->first();
        $startKm= $lastRecord->startKm??0;
        $endKm= $lastRecord->endKm??0;
        $rules=[
            "startKm"     =>"required|integer|gt:".$endKm,
            "endKm"     =>"required|integer|gt:".$request->startKm,
            "price"     =>"required",
        ];

        $messages=[
        ];

        $messagesAr=[
            "startKm.required"     =>"يجب ادخال بداية المسافة",
            "startKm.gt"     =>"يجب ادخال بداية المسافة اكبر من  {$endKm}.",

            "endKm.required"     =>"يجب ادخال نهاية المسافة",
            "endKm.gt"     =>"يجب ادخال نهاية المسافة اكبر من  مسافة البداية",

            "price.required"     =>"يجب ادخال السعر ",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }  
        $record= self::$model::updateOrCreate(['id'=>$request->id],[
            'startKm'=>$request->startKm,
            'endKm'=>$request->endKm,
            'price'=>$request->price,
            'createdAt'=>date('Y-m-d H:i:s')
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