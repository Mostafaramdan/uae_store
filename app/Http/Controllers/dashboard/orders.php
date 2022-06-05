<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\orders as model;
use  App\Http\Controllers\Apis\Controllers\index ;
use Auth;

class orders extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        index::$request=new Request();
        index::$lang="ar";
        self::$model=model::class;
    }
    public static function index()
    {
        $records= model::query();
        if(Auth::guard('stores')->check()){
            $records= $records->where('stores_id',Auth::guard('stores')->user()->id);
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get();
        $currentPage=1;
        return view('dashboard.orders.index',compact("records","totalPages",'currentPage'));
    }

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $currentPage= (int)$request->currentPage;
        
        $records= self::$model::orderBy($request->sortBy??"id",$request->sortType?'ASC':'DESC')
                    ->when($request->sortByStatus,function($q) use ($request){
                            return $q->where('status',$request->sortByStatus);
                    })
                    // ->when($request->search,function($q) use ($request){
                    //     return $q->where(function($q) use ($request){
                    //         return $q->where('name','like',"%{$request->search}%");
                    //     });
                    // })
                    ->when(Auth::guard('stores')->check(),function($q){
                        return $q->where('stores_id',Auth::guard('stores')->user()->id);
                    });
        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;
        $records=$records->forpage($currentPage,$itemPerPage)->get();
            
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.orders.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
    
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'status'=>$request->status,
            'extraDescription'=>$request->extraDescription,
            'deliveryTime'=>$request->deliveryTime,
        ]);
    
        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
}
    public static function getRecord($id)
    {
        return  self::$model::find($id);
}
    public static function getRecordInfo($id)
    {
        $records =  self::$model::find($id)->carts;
        return view("dashboard.orders.orderTableInfo",compact('records'));
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
    public static function deleteAllRecords()
    {
        // self::$model::where("id",">",0)->delete();
        return response()->json(['status'=>200]);

    }

    public static function delete($id)
    {
    $record= self::$model::find($id);
    $record->delete();
    return response()->json(['status'=>200]);
}
}