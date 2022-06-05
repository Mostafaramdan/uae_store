<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\ads as model;
use App\Models\categories;
use App\Models\products;
use App\Models\stores;
use Carbon\Carbon;

class ads extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        
        $products   = products::where('isActive',1)->forPage(1,25)->get();
        $stores     = stores::where('isActive',1)->forPage(1,25)->get();
        $categories = categories::where('isActive',1)->forPage(1,25)->get();

        $totalPages = ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.ads.index',compact("records","totalPages",'currentPage','products','stores','categories'));
    }   

    public static function indexPageing(Request $request)
    {
        // $request->sortType
        $records= self::$model::when($request->search,function($q) use ($request){
                return $q->where(function($q) use ($request){
                    $search= '%'.$request->search.'%';
                    return $q
                        ->where("descriptionAr","like",$search)
                        ->orWhere("descriptionEn","like",$search)
                        ->orWhere("titleAr","like",$search)
                        ->orWhere("titleEn","like",$search)
                        ->orWhere("link","like",$search)
                        ->orWhere("startAt","like",$search)
                        ->orWhere("endAt","like",$search);
                });
        })
        ->orderBy($request->sortBy??'id',$request->sortType??'desc');
        
        $itemPerPage= $request->pages?? config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/ $itemPerPage);
        $currentPage= $request->currentPage;

        $records=$records->forpage($request->currentPage??1,$itemPerPage)->get();
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.ads.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "titleAr"     =>"required|min:3",
            "titleEn"     =>"required|min:3",
            "link"    =>"required_if:action,link|nullable|active_url",
            "categories_id"=>"required_if:screen,categories",
            "stores_id"=>"required_if:screen,stores",
            "action"    =>"required",
            "action_stores_id"    =>"required_if:action,stores",
            "action_categories_id"    =>"required_if:action,categories",
            "action_products_id"    =>"required_if:action,categories",
            'startAt' =>"required|after:".Carbon::parse("now")->subDay(1)->format("Y-m-d"),
            'endAt' =>"required|after:startAt",
            "image"    =>"required_without:id,",
        ];

        $messages=[
        ];

        $messagesAr=[

            "titleAr.required"     =>"يجب ادخال العنوان بالعربي",
            "titleAr.min"          =>"يجب ان لا العنوان بالعربي عن 3 حروف ",

            "titleEn.required"     =>"يجب ادخال العنوان بالانجليزي",
            "titleEn.min"          =>"يجب ان لا العنوان بالانجليزي عن 3 حروف ",

            "link.required" =>"يجب ادخال الرابط",
            "link.active_url"     =>"  يجب ادخال الرابط بشكل صحيح",
            
            "startAt.required" =>"يجب ادخال تاريخ بداية الاعلان ",
            "startAt.after" =>"يجب أن يكون تاريخ بداية الاعلان اكبر من تاريخ اليوم ",

            "endAt.required" =>"يجب ادخال تاريخ إنتهاء الاعلان ",
            "endAt.after" =>"يجب أن يكون تاريخ انتهاء الاعلان اكبر من تاريخ البداية ",

            "image.required_without" =>"يجب ادخال صورة الإعلان",

            "categories_id.required_if" =>"يجب ادخال القسم ",

            "action_stores_id.required_if" =>"يجب ادخال المتجر",

            "action_categories_id.required_if" =>"يجب ادخال القسم ",

            "action_products_id.required_if" =>"يجب ادخال المتجر",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'titleAr'=>$request->titleAr,
            'titleEn'=>$request->titleEn,
            'products_id'=>$request->products_id,
            'offers_id'=>$request->offers_id,
            'categories_id'=>$request->categories_id,
            'stores_id'=>$request->stores_id,
            'screen'=>$request->screen,
            'image'=>$request->image,  
            'startAt'=>$request->startAt,  
            'endAt'=>$request->endAt,  
            'action'=>$request->action,  
            'link'=>$request->link,  
            'action_stores_id'=>$request->action_stores_id,  
            'action_products_id'=>$request->action_products_id,  
            'action_categories_id'=>$request->action_categories_id,  
            'is_active'=>1, 
            'viewers'=>0, 
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