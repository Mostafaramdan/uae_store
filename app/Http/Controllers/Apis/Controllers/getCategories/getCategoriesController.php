<?php

namespace App\Http\Controllers\Apis\Controllers\getCategories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\categories;

class getCategoriesController extends index
{
    public static function api()
    {
       
        $records=  categories::where('isActive',1)
                            ->orderBy('orderNum','asc')
                             ->when(self::$request->categoryId,function($q){
                                 return $q->where('categories_id',self::$request->categoryId);
                             })
                             ->when(self::$request->type,function($q){
                                $funName= self::$request->type=='mainCategory'?'whereNull':'whereNotNull';
                                return $q->$funName('categories_id');
                            });
        
        $total=$records->count();
        $records=$records->forPage(self::$request->page+1,self::$itemPerPage)->get();
        return [
            "status"=>$records->count()?200:204,
            "totalPages"=>ceil($total/self::$itemPerPage),
            "categories"=>objects::ArrayOfObjects($records,"category"),
        ];
    }
}