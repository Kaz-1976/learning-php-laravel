<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    public function creating(Model $model)
    {
        // 作成者IDを更新
        $model->created_by = Auth::user()->id;
    }

    public function updating(Model $model)
    {
        // 変更があれば
        if($model->isDirty())
        {
            // 更新者IDを更新
            $model->updated_by = Auth::user()->id;
        }
    }
}
