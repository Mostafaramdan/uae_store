<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\points as model;

class points extends Controller
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
    return view('dashboard.points.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
  $sort=$request->sortType??'sortBy';
  $records= self::$model::all()->$sort($request->sortBy??"id",);    if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                if( stripos($item['numberOfPoints'],$search) !== false || stripos($item['balance'],$search) !== false)
                    return true;
                return false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.points.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "numberOfPoints"     =>"required",
        "descriptionAr"     =>"required|min:3|max:100",
        "descriptionEn"     =>"required|min:3|max:100",
        "image"     =>"required_if:id,",
    ];

    $messages=[
    ];

    $messagesAr=[

        "numberOfPoints.required"     =>"يجب ادخال عدد النقاط",
        "image.required_if"     =>"يجب ادخال الصورة",

        "descriptionAr.required"     =>"يجب ادخال الوصف بالعربي",
        "descriptionAr.min"     =>"يجب ان لا يقل الوصف بالعربي بالعربي عن 3 حروف  ",
        "descriptionAr.max"     =>"يجب ان لا يزيد الوصف بالعربي بالعربي  عن 100 حرف  ",

        "descriptionEn.required"     =>"يجب ادخال الوصف بالانجليزية",
        "descriptionEn.min"     =>"يجب ان لا يقل الوصف  بالانجليزية عن 3 حروف  ",
        "descriptionEn.max"     =>"يجب ان لا يزيد الوصف بالانجليزية  عن 100 حرف  ",

    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'numberOfPoints'=>$request->numberOfPoints,
        'image'=>$request->image,
        'descriptionAr'=>$request->descriptionAr,
        'descriptionEn'=>$request->descriptionEn,
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

