<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\AppointmentMedium;
use App\Models\AppointmentCategory;
use App\Models\UserInService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class TeacherService extends Model
{
    use HasFactory;

    protected $fillable = [
        'userServiceId',
        'appointmentSubjectId',
        'mainSubjectId',
        'appointmentMediumId',
        'appointmentCategoryId',
        'active',
    ];

    protected $table = 'teacher_services';

    public function appointmentSubject()
    {
        return $this->belongsTo(Subject::class, 'appointmentSubjectId');
    }

    public function mainSubject()
    {
        return $this->belongsTo(Subject::class, 'mainSubjectId');
    }

    public function appointmentMedium()
    {
        return $this->belongsTo(AppointmentMedium::class, 'appointmentMediumId');
    }

    public function appointmentCategory()
    {
        return $this->belongsTo(AppointmentCategory::class, 'appointmentCategoryId');
    }

    public function userService()
    {
        return $this->belongsTo(UserInService::class, 'userServiceId');
    }
}
