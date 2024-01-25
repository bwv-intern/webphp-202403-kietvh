<?php

namespace App\Observers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    /**
     * Handle the model "created" event.
     */
    public function creating(Model $model): void
    {
        $model->created_by = auth()->id();
        $model->created_at = Carbon::now();
        $model->updated_by = auth()->id();
        $model->updated_at = Carbon::now();
        $model->deleted_by = null;
        $model->deleted_at = null;
    }

    /**
     * Handle the model "updated" and "deleted" event.
     */
    public function updating(Model $model): void
    {
        if ($model->isDirty('del_flg') && $model->del_flg == 1){
            $model->deleted_by = auth()->id();
            $model->deleted_at = Carbon::now();
        } else {
            $model->updated_by = auth()->id();
            $model->updated_at = Carbon::now();
        }
    }
}
