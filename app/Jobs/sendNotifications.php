<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\users;
use App\Models\stores;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\drivers;
use App\Models\notify;
use App\Models\notifications;
use App\Models\tutorials;
use Illuminate\Support\Str;

class sendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  $record, $checkType, $users_type,  $timeout = 9999999;

    public function __construct($record, $checkType,$users_type)
    {
        $this->record= $record;
        $this->checkType= $checkType;
        $this->users_type= $users_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $models=['users','drivers','stores'];
        $models = $this->checkType?$models:[$this->users_type];
        foreach($models as $model){
            $modelClass= "\App\Models\\".$model;
            $modelClass::where('isActive',1)->chunk(100,function($records) use($model){
                foreach($records as $record){
                    $notify = notify::createUpdate([
                        "notifications_id"=>$this->record->id,
                        "isSeen"=>0,
                        $model."_id"=>$record->id
                    ]);
                    helper::sendFCM($notify,Str::singular($model));

                } 
            });
        }
    }

}
