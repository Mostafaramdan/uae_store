<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\faqs as model;

class faqs extends Controller
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
    return view('dashboard.faqs.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
  $sort=$request->sortType??'sortBy';
  $records= self::$model::all()->$sort($request->sortBy??"id",);    if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.faqs.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "questionAr"     =>"required|min:3",
        "questionEn"     =>"required|min:3",
        "answerAr"     =>"required|min:3",
        "answerEn"     =>"required|min:3",
    ];

    $messages=[
    ];

    $messagesAr=[

        "questionAr.required"     =>"يجب ادخال السؤال بالعربي",
        "questionAr.min"          =>"يجب ان لا يقل السؤال بالعربي عن 3 حروف ",

        "questionEn.required"     =>"يجب ادخال السؤال بالإنجليزي",
        "questionEn.min"          =>"يجب ان لا يقل السؤال بالإنجليزي عن 3 حروف ",

        "answerAr.required"     =>"يجب ادخال الجواب بالعربي",
        "answerAr.min"          =>"يجب ان لا يقل الجواب بالعربي عن 3 حروف ",

        "answerEn.required"     =>"يجب ادخال الجواب بالإنجليزي",
        "answerEn.min"          =>"يجب ان لا يقل الجواب بالإنجليزي عن 3 حروف ",

    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'questionAr'=>$request->questionAr,
        'questionEn'=>$request->questionEn,
        'answerAr'=>$request->answerAr,
        'answerEn'=>$request->answerEn,
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

