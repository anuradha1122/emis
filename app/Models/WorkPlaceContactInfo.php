<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkPlaceContactInfo extends Model
{
    protected $fillable = ['workPlaceId', 'addressLine1', 'addressLine2', 'addressLine3', 'mobile1', 'mobile2'];

    public function workPlace()
    {
        return $this->belongsTo(WorkPlace::class, 'workPlaceId');
    }
}
