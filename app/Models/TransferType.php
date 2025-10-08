<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferType extends Model
{
    use HasFactory;

    protected $table = 'transfer_types';

    protected $fillable = ['name'];

    public function teacherTransfers(): HasMany
    {
        return $this->hasMany(TeacherTransfer::class, 'typeId');
    }
}
