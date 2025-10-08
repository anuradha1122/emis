<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualificationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'eduQualiId',
        'effectiveDate',
        'description',
        'active',
    ];

    public function educationQualification()
    {
        return $this->belongsTo(EducationQualification::class, 'eduQualiId')
                    ->where('active', 1);
    }




}
