<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalQualificationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'profQualiId',
        'effectiveDate',
        'description',
        'active',
    ];

    public function professionalQualification()
    {
        return $this->belongsTo(ProfessionalQualification::class, 'profQualiId')
                    ->where('active', 1);
    }


}
