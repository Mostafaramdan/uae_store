<?php

namespace App\Observers;

use App\Models\categories;
use App\Models\products;

class categoriesObserver
{
    public $afterCommit = true;

    public function created(categories $categories)
    {
        //
    }

    public function updated(categories $categories)
    {
        if($categories->isDirty('isActive'))
            products::where('categories_id',$categories->id)
                    ->update(['isActive'=>$categories->isActive]);
    }

    public function deleted(categories $categories)
    {
        //
    }

    public function restored(categories $categories)
    {
        //
    }

    public function forceDeleted(categories $categories)
    {
        //
    }
}
