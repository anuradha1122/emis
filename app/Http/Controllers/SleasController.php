<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Subject;
use App\Models\AppointmentMedium;
use App\Models\AppointmentCategory;
use App\Models\Rank;
use App\Models\User;
use App\Models\UserInService;
use App\Models\Service;
use App\Models\UserServiceInRank;
use App\Models\UserServiceAppointment;
use App\Models\UserServiceAppointmentPosition;
use App\Models\TeacherService;
use App\Models\ContactInfo;
use App\Models\PersonalInfo;
use App\Models\LocationInfo;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\EducationQualification;
use App\Models\ProfessionalQualification;
use App\Models\FamilyMemberType;
use App\Models\FamilyInfo;
use App\Models\EducationQualificationInfo;
use App\Models\ProfessionalQualificationInfo;
use App\Models\WorkPlace;
use App\Models\Office;
use App\Models\District;
use App\Models\SchoolAuthority;
use App\Models\SchoolEthnicity;
use App\Models\SchoolClass;
use App\Models\SchoolDensity;
use App\Models\SchoolFacility;
use App\Models\SchoolGender;
use App\Models\SchoolLanguage;
use App\Models\AppointmentTermination;
use Carbon\Carbon;
use App\Services\UserDashboardService;
use Mpdf\Mpdf;

class SleasController extends Controller
{
    //
}
