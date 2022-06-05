<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\notifications as model;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\notify  ;
use App\Models\users  ;
use App\Models\drivers  ;
use App\Models\stores  ;
use Illuminate\Support\Str;
use App\Jobs\sendNotifications;

class notifications extends Controller
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
        return view('dashboard.notifications.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType=='sortBy'?'asc':'desc';
        $records= self::$model::orderBy($request->sortBy??"id",$sort)
                ->when($request->search,function($q) use ($request){
                return $q->where('titleAr','LIKE', '%'.$request->search.'%')
                        ->orWhere("titleEn",'LIKE', '%'.$request->search.'%')
                        ->orWhere("contentAr",'LIKE', '%'.$request->search.'%')
                        ->orWhere("contentEn",'LIKE', '%'.$request->search.'%');
                });

        
        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;
        
        $records=$records->forpage($currentPage,$itemPerPage)->get();
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.notifications.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }


    public static function createUpdate(Request $request){
        $rules=[
            "titleAr"     =>"required|min:3",
            // "titleEn"     =>"required|min:3",
            "contentAr"     =>"required|min:3",
            // "contentEn"     =>"required|min:3",
        ];

        $messages=[
        ];

        $messagesAr=[

            "titleAr.required"     =>"يجب ادخال العنوان بالعربي",
            "titleAr.min"          =>"يجب ان لا يقل العنوان بالعربي عن 3 حروف ",

            "titleEn.required"     =>"يجب ادخال العنوان بالانجليزي",
            "titleEn.min"          =>"يجب ان لا يقل العنوان بالانجليزي عن 3 حروف ",

            "contentAr.required"     =>"يجب ادخال المحتوي بالعربي",
            "contentAr.min"          =>"يجب ان لا يقل المحتوي بالعربي عن 3 حروف ",

            "contentEn.required"     =>"يجب ادخال المحتوي بالانجليزي",
            "contentEn.min"          =>"يجب ان لا يقل المحتوي بالانجليزي عن 3 حروف ",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }    
        
        //create Notification 
        $record=self::$model::createUpdate([ 
            'id'=>$request->id,
            'titleAr'=>$request->titleAr,
            'titleEn'=>$request->titleEn,
            'contentAr'=>$request->contentAr,
            'contentEn'=>$request->contentEn,
            "image"    =>$request->image,
            ]);
        if($request->id){
            $record= self::$model::find($request->id);
            $record->titleAr=$request->titleAr;
            $record->titleEn=$request->titleEn;
            $record->contentAr=$request->contentAr;
            $record->contentEn=$request->contentEn;
            $record->save();
            notify::where('notifications_id',$record->id)->delete();
        }
        sendNotifications::dispatch($record,$request->checkType,$request->users_type);
        $message=$request->id?"edited successfully":'added successfully';
    
        return response()->json(['status'=>200,'message'=>$message]);
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

