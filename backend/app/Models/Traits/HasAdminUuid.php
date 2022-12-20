<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasAdminUuid
{
  protected static function bootHasAdminUuid()
  {
    static::creating(function ($model) {
      if (empty($model->admin_id)) {
        $model->admin_id = Str::uuid();
      }
    });
  }
}
