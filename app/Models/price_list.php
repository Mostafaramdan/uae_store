<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class price_list extends GeneralModel
{
    protected $table = 'price_list',$guarded=[];
    public $timestamps=false;

    // public static function createUpdate($params){

    //     $record= isset($params["id"])? self::find($params["id"]) :new self();
    //     $record->startKm = isset($params["startKm"])? $params["startKm"]: $record->startKm;
    //     $record->endKm = isset($params["endKm"])? $params["endKm"]: $record->endKm;
    //     $record->minPrice = isset($params["minPrice"])? $params["minPrice"]: $record->minPrice;
    //     $record->maxPrice = isset($params["maxPrice"])? $params["maxPrice"]: $record->maxPrice;
    //     $record->vehicles_id = isset($params["vehicles_id"])? $params["vehicles_id"]: $record->vehicles_id;
    //     $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
    //     isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
    //     $record->save();
    //     return $record;
    // }
    // public function vehicle(){
    //     return $this->belongsTo(vehicles::class,"vehicles_id");
    // }
}