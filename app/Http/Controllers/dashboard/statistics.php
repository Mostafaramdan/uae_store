<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use DB;
use App\Models\users;
use App\Models\drivers;
use App\Models\orders;
use App\Models\stores;
use App\Models\admins;
use Carbon\Carbon;

class statistics extends Controller
{
public static $model;
    function __construct(Request $request)
    {
        // self::$model=model::class;
    }
    public static function index()
    {
        // return admins::all();
        $users = json_encode(self::Query('users'));
        $drivers = json_encode(self::Query('drivers'));
        $orders = json_encode(self::Query('orders'));
        $stores = json_encode(self::Query('stores'));
        $usersCount=users::count();
        $driversCount=drivers::count();
        $ordersCount=orders::count();
        $storesCount=stores::count();
        return view('dashboard.statistics.index', compact('users','drivers','stores','orders','usersCount','driversCount','ordersCount','storesCount'));
    }   

    public static function getByDateRange(Request $request)
    {
        return response()->json([
            'usersCount'=>users::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
            'driversCount'=>drivers::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
            'storesCount'=>stores::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
            'ordersCount'=>orders::where('createdAt','>=',$request->from??'2000-01-01' )->where('createdAt','<=',$request->to??date("Y-m-d") )->count(),
        ]);
    }

    private  static function Query($tableNAme)
    {
        return DB::table($tableNAme)
            ->select(
                DB::raw('COUNT(id) as `value`'),
                DB::raw("MONTH(createdAt) as `month`")
            )
            ->where(DB::raw("YEAR(createdAt)"), '=', date('Y'))
            ->groupBy('month')
            ->get();
    }
   
}