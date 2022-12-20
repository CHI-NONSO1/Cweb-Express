<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
  protected static function bootHasUuid()
  {
    static::creating(function ($model) {
      if (empty($model->biz_id)) {
        $model->biz_id = Str::uuid();
      }
    });
  }
}
