<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\offers as model;
use App\Models\categories;
use App\Models\products;
use App\Models\regions;
use App\Models\stores;
use Carbon\Carbon;

class offers extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        
        $products   = products::where('isActive',1)->get()->forPage(1,25);
        $regions     = regions::where('isActive',1)->get()->forPage(1,25);
        $categories = categories::where('isActive',1)->get()->forPage(1,25);

        $totalPages = ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.offers.index',compact("records","totalPages",'currentPage','products','regions','categories'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);    
        if($request->search){
            $search= $request->search;
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage??1,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.offers.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "discount"     =>"required|numeric",
            "action"    =>"required",
            "stores_id"    =>"required_if:action,region",
            "categories_id"    =>"required_if:action,category",
            "products_id"    =>"required_if:action,product",
            'startAt' =>"required|after:".Carbon::parse("now")->subDay(1)->format("Y-m-d"),
            'endAt' =>"required|after:startAt",
        ];

        $messages=[
        ];

        $messagesAr=[

            "discount.required"     =>"يجب ادخال الخصم ",
            
            "startAt.required" =>"يجب ادخال تاريخ بداية الاعلان ",
            "startAt.after" =>"يجب أن يكون تاريخ بداية الاعلان اكبر من تاريخ اليوم ",

            "endAt.required" =>"يجب ادخال تاريخ إنتهاء الاعلان ",
            "endAt.after" =>"يجب أن يكون تاريخ انتهاء الاعلان اكبر من تاريخ البداية ",

            "regions_id.required_if" =>"يجب ادخال المنطقة",

            "categories_id.required_if" =>"يجب ادخال القسم ",

            "products_id.required_if" =>"يجب ادخال المنتج",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    } 
        $record= self::$model::updateOrCreate(['id'=>$request->id],[
            'discount'=>$request->discount,
            $request->action.'_id'=>$request->{$request->action.'_id'},
            'startAt'=>$request->startAt,  
            'endAt'=>$request->endAt,  
            'created_at'=>now(),  
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