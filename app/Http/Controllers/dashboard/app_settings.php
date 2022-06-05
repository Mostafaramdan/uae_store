<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\app_settings as model;

class app_settings extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $record= self::$model::first();
    if(!$record){
        $record =
            self::$model::createUpdate([
                'id'=>$recor->id??null,
                'app_phone'=>0,
                "app_email"=>"@mail.com",
                "about_us"=>" . ",
                "policy_terms"=>" .",
                "number_of_persons_per_room"=>5,
                "time_allowed_to_the_visitor_per_minutes"=>1,
                "number_of_letters"=>100,
                "time_to_be_kicked_per_hours"=>1,
                "time_to_be_blocked_writing_per_hours"=>1,
                "time_to_be_have_background_coloring_per_hours"=>1
            ]);
    }
    return view('dashboard.app_settings.index',compact("record"));
}   

public static function indexPageing(Request $request)
{
    $record= self::$model::first();
    $tableInfo= (string) view('dashboard.app_settings.tableInfo',compact('record'));
    return ['paging'=>0,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){

    $record= self::$model::first();
    self::$model::createUpdate([
        'id'=>$record->id,
        'app_phone'=>$request->app_phone,
        "app_email"=>$request->app_email,
        "about_us"=>$request->about_us,
        "policy_terms"=>$request->policy_terms,
        "number_of_persons_per_room"=>$request->number_of_persons_per_room,
        "time_allowed_to_the_visitor_per_minutes"=>$request->time_allowed_to_the_visitor_per_minutes,
        "number_of_letters"=>$request->number_of_letters,
        "time_to_be_kicked_per_hours"=>$request->time_to_be_kicked_per_hours,
        "time_to_be_blocked_writing_per_hours"=>$request->time_to_be_blocked_writing_per_hours,
        "time_to_be_have_background_coloring_per_hours"=>$request->time_to_be_have_background_coloring_per_hours
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

