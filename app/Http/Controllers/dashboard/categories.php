<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\categories as model;
use App\Http\Controllers\Apis\Controllers\index ;
use Auth;
use App\Jobs\importCategories;
use Illuminate\Support\Facades\Bus;

class categories extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        index::$request=new Request();
        index::$lang="ar";
        self::$model=model::class;
    }
    function export(){
        $categories= self::$model::all();
        (new FastExcel($categories))->export('الاقسام.xlsx',function($category){
            return [
                'id' => $category->id,
                'الاسم بالعربي' => $category->nameAr,
                'الاسم بالانجليزي' => $category->nameEn,
                'النوع' => $category->categories_id?'فرعي':'رئيسي',
                'تابع لقسم' => $category->category->nameAr??'',
                'مفعل' => $category->isActive,
                'تاريخ الانشاء' => $category->createdAt
            ];
        });
        return redirect('/الاقسام.xlsx');
    }
    function import(Request $request){

        $collections =(new FastExcel)->import($request->file);
        $chunks= array_chunk($collections->toArray(),100);
        $batch  = Bus::batch([])->dispatch();

        foreach($chunks as $k=>$v){
            $batch->add(new importCategories($v));
        };    

        return back();
    }
    static function mainCategory($data)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['Category']],[
                'nameEn'=>$data['Category'],
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }
    static function subCategory($data,$mainCategory)
    {
        return 
            categories::firstOrCreate(['nameAr'=>$data['Sub category'],'categories_id'=>$mainCategory->id],[
                'nameEn'=>$data['Category'],
                'isActive'=>1,
                'createdAt'=>now()
            ]);
    }
    public static function index()
    {
        $records= self::$model::query()
                                ->orderBy('id','DESC')
                              ->with('category')
                              ->when(Auth::guard('stores')->check(),function($q){
                                return $q->where('stores_id',Auth::guard('stores')->user()->id);
                            });
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $sub_categories= \App\Models\categories::whereNull('categories_id')->get(['nameAr','id']) ;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get();
        return view('dashboard.categories.index',compact("records","totalPages",'currentPage','sub_categories'));
    }   
    public static function indexPageing(Request $request)
    {
        $records= self::$model::when(Auth::guard('stores')->check(),function($q){
                return $q->where('stores_id',Auth::guard('stores')->user()->id);
            })
            ->when($request->categoryType,function($q) use ($request){
                $type= $request->categoryType=='mainCategory'? 'whereNull':'whereNotNull';
                return $q->$type('categories_id');
            })
            ->when($request->search,function($q) use ($request){
                return $q->where(function($q) use ($request){
                    return $q->where('nameAr' , 'like', '%'.$request->search.'%');
                });
            })
            ->with('category')
            ->orderBy($request->sortBy??'id',$request->sortType??'desc');

        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;
        
        $records=$records->forpage($currentPage,$itemPerPage)->get();
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.categories.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    public static function createUpdate(Request $request)
    {
        $rules=[
            "nameAr"     =>"required|min:3",
            "nameEn"     =>"required|min:3",
            "image"       =>"required_if:id,"    
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "name_ar.required"     =>"يجب ادخال الاسم بالعربي",
            "name_ar.min"          =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",
    
            "name_en.required"     =>"يجب ادخال الاسم بالإنجليزية",
            "name_en.min"          =>"يجب ان لا يقل الاسم بالإنجليزية عن 3 حروف ",
            
            "image.required_if"       =>"يجب إدخال صورة"   
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        if(!$request->store)
            $request->offsetSet('categories_id',null);
        // if(Auth::guard('stores')->check()){
        //     $stores_id = Auth::guard('stores')->user()->id;
        // }else{
        //     $stores_id=null;
        // }
        $record= self::$model::updateOrCreate(['id' =>$request->id],[
            'nameAr'  =>$request->nameAr,
            "orderNum" =>$request->orderNum,
            'categories_id'  =>$request->categories_id,
            'nameEn'  =>$request->nameEn,
            'image'  =>self::image($request->image,$request->id??null),
            'stores_id'=>Auth::guard('stores')->user()->id??null,
            "discount"=>$request->discount,
            "start_at_offer"=>$request->start_at_offer,
            "end_at_offer"=>$request->end_at_offer,

        ]);
        !$request->image?:$record->image= self::image($request->image);

        // if($stores_id == null){
        //     $record->stores_id=null;
        //     $record->save();
        // }
    
        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
    }
    public static function getRecord($id)
    {
        index::$request=new Request();
        index::$lang="ar";
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