<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\products as model;
use App\Models\images ;
use App\Models\categories ;
use App\Models\sections ;
use App\Models\features ;
use App\Models\points ;
use App\Models\brands ;
use App\Models\prices ;
use Auth;
use  App\Http\Controllers\Apis\Controllers\index ;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Jobs\importProducts;
use Illuminate\Support\Facades\Bus;
use Intervention\Image\ImageManagerStatic;


class products extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        index::$request=new Request();
        index::$lang="ar";
        self::$model=model::class;
    }
    function export(Request $request)
    {
        $only= ['brands_id','ID_','nameAr','nameEn','old_price','price','descriptionAr','product_type','isActive','createdAt','categories_id'];
        $products= self::$model::when((int)$request->categories_id,function($q) use ($request){
                                return $q->where('categories_id',$request->categories_id);
                        })
                        ->forPage(1,1500)
                        ->get($only);
        (new FastExcel($products))->export('المنتجات.xlsx',function($product){
            return [
                'ID_' => $product->ID_,
                'الاسم ' => $product->nameAr,
                'Name en' => $product->nameEn,
                'Old Price' => $product->old_price,
                'Price' => $product->price,
                'quantity' => $product->quantity,
                'Brand' => $product->brand->nameAr??'',
                'Content' => $product->descriptionAr,
                'Section' => $product->section->nameAr??'',
                'Category' => $product->category->category->nameAr??'',
                'Sub category' => $product->category->nameAr??'',
                'Product type'=>$product->product_type,
                'مفعل' => $product->isActive? 'ON' :'OFF',
                'تاريخ الانشاء' => $product->createdAt
            ];
        });
        return redirect('/المنتجات.xlsx');
    }
    function import(Request $request)
    {
        $collections =(new FastExcel)->import($request->file);
        $chunks= array_chunk($collections->toArray(),100);
        $batch  = Bus::batch([])->dispatch();

        foreach($chunks as $k=>$v){
            $batch->add(new importProducts($v));
        };    
        // return $batch;

        return back();
    }
    public static function index()
    {
        $categories= categories::where('isActive',1)->get(['id','nameAr','nameEn']);
        $records= self::$model::orderBy('id','desc')
                      ->with('category')
                      ->when(Auth::guard('stores')->check(),function($q) use ($categories){
                            $categories= $categories->whereIn('stores_id',Auth::guard('stores')->user()->id);
                            return $q->whereIn('categories_id',$categories->pluck('id'));
                      });

        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'))->get();
        return view('dashboard.products.index',compact('categories',"records","totalPages",'currentPage','categories'));
    }   
    
    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType=='sortBy'?'asc':'desc';
        $records= self::$model::orderBy($request->sortBy??"id",$sort)
                ->when($request->search,function($q) use ($request){
                    $search = $request->search;
                    $search = is_numeric($search)? (double)$search: $search;
                    return $q->where(function($q) use ($request){
                            return $q->where('nameAr','LIKE', '%'.$request->search.'%')
                        ->orWhere('nameEn','LIKE', '%'.$request->search.'%')
                        ->orWhere('ID_','LIKE', $request->search.'%')
                        ->orWhere(function($q) use ($request){
                            return $q->whereHas('category',function($q) use ($request){
                                return $q->where('nameAr','LIKE', '%'.$request->search.'%')
                                ->orWhere('nameEn','LIKE', '%'.$request->search.'%');
                            });
                        });
                    });
                })                
                ->when($request->isFreeDelivered,function($q){
                    return $q->where("isFreeDelivered",1);
                })
                ->when($request->categories_id,function($q) use ($request){
                    return $q->where("categories_id",$request->categories_id);
                })
                ->when(Auth::guard('stores')->check(),function($q){
                    $categories= categories::where('isActive',1)->whereIn('stores_id',Auth::guard('stores')->user()->id);
                    return $q->whereIn('categories_id',$categories->pluck('id'));
                });

        
        $itemPerPage= $request->pages ??config('helperDashboard.itemPerPage');
        $totalPages= ceil($records->count()/$itemPerPage);
        $currentPage= $request->currentPage;
        
        $records=$records->forpage($currentPage,$itemPerPage)->get();
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.products.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    
    public static function createUpdate(Request $request)
    {
        $rules=[
            "ID_"        =>"required|unique:products,ID_,".$request->id,
            "nameAr"        =>"required|min:3",
            "nameEn"        =>"required|min:3",
            "descriptionAr" =>"required|min:3",
            "descriptionEn" =>"required|min:3",
            "price"         =>"required|numeric|min:.1",
            "quantity"      =>"required|numeric|min:1",
            "image"        =>"required_if:id,|array|min:1|max:15",
            "categories_id" =>"required",    
        ];
        if(is_array($request->nameArFeat) && $request->haveFeatures=="on")
        {
            $rules=[
                "nameArFeat.*"  =>"required",
                "nameEnFeat.*"  =>"required",
                "priceFeat.*"  =>"required",
                "priceFeat.*"  =>"numeric",
                'imageFeat.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
        }
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "ID_.required"       =>"يجب ادخال الباركود",
            "ID_.unique"       =>"يجب ادخال باركود مختلف",

            "nameAr.required"       =>"يجب ادخال الاسم بالعربي",
            "nameAr.min"            =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",
    
            "nameEn.required"       =>"يجب ادخال الاسم بالانجليزي",
            "nameEn.min"            =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",
    
            "descriptionAr.required"     =>"يجب ادخال الوصف بالعربي",
            "descriptionAr.min"          =>"يجب ان لا يقل الوصف بالعربي عن 3 حروف ",
    
            "descriptionEn.required"     =>"يجب ادخال الوصف بالانجليزي",
            "descriptionEn.min"          =>"يجب ان لا يقل الوصف بالعربي عن 3 حروف ",
    
            "price.required"            =>"يجب ادخال السعر",
            "price.nemeric"             =>"يجب ادخال السعر بشكل صحيح ",
    
            "quantity.required"         =>"يجب ادخال الكمية ",
            "quantity.nemeric"          =>"يجب ادخال الكمية بشكل صحيح ",
        
            "image.required_if"           =>"يجب إدخال الصور",
            "image.min"                =>"يجب إدخال صورة علي الاقل",
            "image.max"                =>"يجب إدخال 15 صورة علي الاكثر  ",
            
            "categories_id.required"         =>"يجب ادخال القسم ",
            
            "nameArFeat.*required"  =>"يجب إدخال اسماء جميع الميزات بالعربي",
            "nameEnFeat.*required"  =>"يجب إدخال اسماء جميع الميزات بالانجليزي",
            "priceFeat.*required"  =>"يجب إدخال اسعار جميع الميزات",
            "priceFeat.*numeric"  =>"يجب إدخال اسعار جميع الميزات بشكل صحيح",
            'imageFeat.*.required' => 'يجب إدخال جميع صور المميزات',
            'imageFeat.*.image' => 'يجب إدخال جميع الصور ان تكون حقيقية',
            'imageFeat.*.mimes' => 'يjpeg,png,jpg,gif,svg جب ادخال جميع الصور من نوع ',
            'imageFeat.*.max' => 'يجب ان لا تتعدي حجم الصور عن 1 ميجا ',
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            "id"=>$request->id,
            "ID_"=>$request->ID_,
            'nameAr'=>$request->nameAr,
            'nameEn'=>$request->nameEn,
            'descriptionAr'=>$request->descriptionAr,
            'descriptionEn'=>$request->descriptionEn,
            'price'=>$request->price,  
            'product_price'=>$request->product_price,  
            'quantity'=>$request->quantity,  
            "categories_id"=>$request->categories_id,
            "discount"=>$request->discount,
            "start_at_offer"=>$request->start_at_offer,
            "end_at_offer"=>$request->end_at_offer,
            "isFreeDelivered"=>$request->isFreeDelivered==="0"?1:0,
            "points"=>$request->points??0
        ]);
        if($request->has('image')){
            images::where("products_id",$record->id)->delete();
            foreach ($request->image as $image){
                images::createUpdate([
                    "products_id"=>$record->id,
                    "image"     =>$image
                 ]);
            }
        }

        if($request->has('prices')){
            prices::where("products_id",$record->id)->delete();
            for ($i=0;$i<count($request->prices) ;$i++){
                if($request->prices[$i]??false && $request->quantities[$i]){
                    prices::create([
                        "products_id"=>$record->id,
                        "price"     =>$request->prices[$i],
                        "quantity"     =>$request->quantities[$i],
                        "image"     =>helper::uploadPhoto($request->images_prices[$i],'prices')
                    ]);
                }
            }
        }
        if(is_array($request->nameArFeat) && $request->haveFeatures=="on"){
            // features::where('products_id',$record->id)->delete();
            for ($i = 0 ; $i < count($request->nameArFeat) ;$i++  ){
                features::createUpdate([
                    "id"   =>$request->FeatId[$i],
                    "nameAr"=>$request->nameArFeat[$i],
                    "nameEn"=>$request->nameEnFeat[$i],
                    "price"=>$request->priceFeat[$i]??0,
                    "products_id"=>$record->id,
                    "image"=>$request->imageFeat[$i]??null,
                    ]);
            }
        }elseif($request->haveFeatures!="on"){
            features::where('products_id',$record->id)->delete();
        }
        $message=$request->id?"edited successfully":'added successfully';
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
    }
    
    public static function points (Request $request)
    {
        $rules=[
            "descriptionAr"  =>"required|min:3",
            "descriptionEn"  =>"required|min:3",
            "numberOfPoints" =>"required|numeric|min:1",
            // "image"          =>"required_if:id,",
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "descriptionAr.required"     =>"يجب ادخال الوصف بالعربي",
            "descriptionAr.min"          =>"يجب ان لا يقل الوصف بالعربي عن 3 حروف ",
    
            "descriptionEn.required"     =>"يجب ادخال الوصف بالانجليزي",
            "descriptionEn.min"          =>"يجب ان لا يقل الوصف بالعربي عن 3 حروف ",
    
            "numberOfPoints.required"            =>"يجب ادخال عدد النقاط",
            "numberOfPoints.nemeric"             =>"يجب ادخال عدد النقاط بشكل صحيح ",
    
            "image.required_if"           =>"يجب إدخال الصور",
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= points::createUpdate([
            "id"=>$request->id,
            'products_id'=>$request->products_id,
            'descriptionAr'=>$request->descriptionAr,
            'descriptionEn'=>$request->descriptionEn,
            'numberOfPoints'=>$request->numberOfPoints,  
            // "image"=>$request->image
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
    public static function deleteFeature($id)
    {
        $record= features::find($id);
        $record->delete();
        return response()->json(['status'=>200]);
    }
    static function uploadImages(Request $request)
    {
        $file= $request->image;
        $imageInfo= [
            'path' => $file->getRealPath(),
            'name' => $file->getClientOriginalName(),
        ];
        ImageManagerStatic::make($imageInfo['path'])->save(public_path('uploads/products/').$imageInfo['name']);

        return response(200);
    }
}

