<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\SchoolAuthority;
use App\Models\SchoolEthnicity;
use App\Models\SchoolClass;
use App\Models\SchoolDensity;
use App\Models\SchoolFacility;
use App\Models\SchoolGender;
use App\Models\SchoolLanguage;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Office;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use App\Exports\TeacherFullReportExport;


class TeacherFullReport extends Component
{
    use WithPagination;

    protected $queryString = [
        'reportAction' => ['except' => ''],
        'selectedProvince',
        'selectedDistrict',
        'selectedZone',
        'selectedDivision',
        'selectedSchool',
        'schoolAuthority',
        'schoolEthnicity',
        'schoolClass',
        'schoolDensity',
        'schoolFacility',
        'schoolGender',
        'schoolLanguage',
        'race',
        'religion',
        'civilStatus',
        'gender',
        'birthDayStart',
        'birthDayEnd',
        'serviceStart',
        'serviceEnd',
        'schoolAppointStart',
        'schoolAppointEnd'
    ];
    // Dropdown data
    public $provinceList = [];
    public $districtList = [];
    public $zoneList = [];
    public $divisionList = [];
    public $schoolList = [];
    public $schoolAuthorityList = [];
    public $schoolEthnicityList = [];
    public $schoolClassList = [];
    public $schoolDensityList = [];
    public $schoolFacilityList = [];
    public $schoolGenderList = [];
    public $schoolLanguageList = [];
    public $raceList = [];
    public $religionList = [];
    public $civilStatusList = [];
    public $genderList = [];

    // Selected filters
    public $selectedProvince;
    public $selectedDistrict;
    public $selectedZone;
    public $selectedDivision;
    public $selectedSchool;
    public $schoolAuthority;
    public $schoolEthnicity;
    public $schoolClass;
    public $schoolDensity;
    public $schoolFacility;
    public $schoolGender;
    public $schoolLanguage;
    public $race;
    public $religion;
    public $civilStatus;
    public $gender;
    public $birthDayStart;
    public $birthDayEnd;
    public $serviceStart;
    public $serviceEnd;
    public $schoolAppointStart;
    public $schoolAppointEnd;

    public $reportAction = null;

    public function mount()
    {
        // Empty collections
        $this->provinceList = collect();
        $this->districtList = collect();
        $this->zoneList = collect();
        $this->divisionList = collect();
        $this->schoolList = collect();

        $this->loadStaticReferenceLists();
        $this->loadUserBasedDropdowns();
    }

    private function loadStaticReferenceLists()
    {
        $this->schoolAuthorityList = SchoolAuthority::select('id','name')->get();
        $this->schoolEthnicityList = SchoolEthnicity::select('id','name')->get();
        $this->schoolClassList = SchoolClass::select('id','name')->get();
        $this->schoolDensityList = SchoolDensity::select('id','name')->get();
        $this->schoolFacilityList = SchoolFacility::select('id','name')->get();
        $this->schoolGenderList = SchoolGender::select('id','name')->get();
        $this->schoolLanguageList = SchoolLanguage::select('id','name')->get();
        $this->raceList = Race::select('id','name')->get();
        $this->religionList = Religion::select('id','name')->get();
        $this->civilStatusList = CivilStatus::select('id','name')->get();

        $this->genderList = collect([
            (object)['id' => 1, 'name' => 'Male'],
            (object)['id' => 2, 'name' => 'Female'],
        ]);
    }

    private function loadUserBasedDropdowns()
    {
        $userType = auth()->user()->workPlaceType();

        match ($userType) {
            'ministry' => $this->provinceList = Province::select('id','name')->get(),
            'provincial_department' => $this->loadProvinceBasedDistricts(),
            'zone' => $this->loadZoneBasedDivisions(),
            'division' => $this->loadDivisionBasedSchools(),
            default => null,
        };

    }

    private function loadProvinceBasedDistricts()
    {
        $province = auth()->user()->currentService->currentAppointment->workPlace->office->province;
        $this->districtList = $province
            ? $province->districts->map(fn($d) => (object)['id' => $d->id, 'name' => $d->name])
            : collect();
    }

    private function loadZoneBasedDivisions()
    {
        $zone = auth()->user()->currentService->currentAppointment->workPlace->office;
        $this->divisionList = $zone
            ? $zone->subOffices()->with('workPlace')->get()
                ->map(fn($d) => (object)['id' => $d->id, 'name' => $d->workPlace?->name ?? 'N/A'])
            : collect();
    }

    private function loadDivisionBasedSchools()
    {
        $division = auth()->user()->currentService->currentAppointment->workPlace->office;
        $this->schoolList = $division
            ? $division->schools()->with('workPlace')->get()
                ->map(fn($s) => (object)['id' => $s->id, 'name' => $s->workPlace?->name ?? 'N/A'])
            : collect();
    }

    public function updatedSelectedProvince($provinceId)
    {
        $province = Province::with('districts')->find($provinceId);
        $this->districtList = $province
            ? $province->districts->map(fn($d) => (object)['id' => $d->id, 'name' => $d->name])
            : collect();
        $this->resetDependentDropdowns(['district','zone','division','school']);
        $this->reportAction = null;
    }

    public function updatedSelectedDistrict($districtId)
    {
        $district = District::with('zones.workPlace')->find($districtId);
        $this->zoneList = $district
            ? $district->zones->map(fn($z) => (object)['id' => $z->id, 'name' => $z->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['zone','division','school']);
        $this->reportAction = null;
    }

    public function updatedSelectedZone($zoneId)
    {
        $zone = Office::with('divisions.workPlace')->find($zoneId);
        $this->divisionList = $zone
            ? $zone->divisions->map(fn($d) => (object)['id' => $d->id, 'name' => $d->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['division','school']);
        $this->reportAction = null;
    }

    public function updatedSelectedDivision($divisionId)
    {
        $division = Office::with('schools.workPlace')->find($divisionId);
        $this->schoolList = $division
            ? $division->schools->map(fn($s) => (object)['id' => $s->id, 'name' => $s->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['school']);
        $this->reportAction = null;
    }

    private function resetDependentDropdowns(array $fields)
    {
        foreach ($fields as $field) {
            $property = "selected" . ucfirst($field);
            $this->$property = null;
        }
    }

    private function getQuery()
    {
        $query = User::query()
            ->with([
                'personalInfo',
                'currentTeacherService.currentAppointment.workPlace.school'
            ])
            ->whereHas('currentTeacherService');

        // 🏫 Location-based filters
        if ($this->selectedSchool) {
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->where('id', $this->selectedSchool));
        } elseif ($this->selectedDivision) {
            $division = Office::with('schools')->find($this->selectedDivision);
            $schoolIds = $division?->schools->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($this->selectedZone) {
            $zone = Office::with('subOffices.schools')->find($this->selectedZone);
            $schoolIds = $zone?->subOffices->flatMap(fn($d) => $d->schools)->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($this->selectedDistrict) {
            $district = District::with('zones.subOffices.schools')->find($this->selectedDistrict);
            $schoolIds = $district?->zones
                ->flatMap(fn($zone) => $zone->subOffices
                    ->flatMap(fn($d) => $d->schools))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        } elseif ($this->selectedProvince) {
            $province = Province::with('districts.zones.subOffices.schools')->find($this->selectedProvince);
            $schoolIds = $province?->districts
                ->flatMap(fn($district) => $district->zones
                    ->flatMap(fn($zone) => $zone->subOffices
                        ->flatMap(fn($d) => $d->schools)))
                ->pluck('id')->toArray() ?? [];
            $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                fn($q) => $q->whereIn('id', $schoolIds));
        }

        // 🏫 School attributes
        foreach ([
            'schoolAuthority' => 'authorityId',
            'schoolEthnicity' => 'ethnicityId',
            'schoolClass' => 'classId',
            'schoolDensity' => 'densityId',
            'schoolFacility' => 'facilityId',
            'schoolGender' => 'genderId',
            'schoolLanguage' => 'languageId',
        ] as $property => $column) {
            if ($this->$property) {
                $query->whereHas('currentTeacherService.currentAppointment.workPlace.school',
                    fn($q) => $q->where($column, $this->$property));
                $this->reportAction = null;
            }
        }

        // 👤 Personal Info filters
        if ($this->race) {
            $query->whereHas('personalInfo', fn($q) => $q->where('raceId', $this->race));
            $this->reportAction = null;
        }
        if ($this->religion) {
            $query->whereHas('personalInfo', fn($q) => $q->where('religionId', $this->religion));$this->reportAction = null;
        }
        if ($this->civilStatus) {
            $query->whereHas('personalInfo', fn($q) => $q->where('civilStatusId', $this->civilStatus));
            $this->reportAction = null;
        }
        if ($this->gender) {
            $query->whereHas('personalInfo', fn($q) => $q->where('genderId', $this->gender));
            $this->reportAction = null;
        }
        if ($this->birthDayStart) {
            $query->whereHas('personalInfo', fn($q) => $q->where('birthDay', '>=', $this->birthDayStart));
            $this->reportAction = null;
        }
        if ($this->birthDayEnd) {
            $query->whereHas('personalInfo', fn($q) => $q->where('birthDay', '<=', $this->birthDayEnd));
            $this->reportAction = null;
        }

        // 📅 Service filters
        if ($this->serviceStart) {
            $query->whereHas('currentTeacherService', fn($q) => $q->where('appointedDate', '>=', $this->serviceStart));
            $this->reportAction = null;
        }
        if ($this->serviceEnd) {
            $query->whereHas('currentTeacherService', fn($q) => $q->where('appointedDate', '<=', $this->serviceEnd));
            $this->reportAction = null;
        }
        if ($this->schoolAppointStart) {
            $query->whereHas('currentTeacherService.currentAppointment',
                fn($q) => $q->where('appointedDate', '>=', $this->schoolAppointStart));
            $this->reportAction = null;
        }
        if ($this->schoolAppointEnd) {
            $query->whereHas('currentTeacherService.currentAppointment',
                fn($q) => $q->where('appointedDate', '<=', $this->schoolAppointEnd));
            $this->reportAction = null;
        }

        return $query;
    }

    // Livewire component
    public function exportExcel()
    {

        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $query = $this->getQuery();
        $userIds = $query->pluck('id')->toArray(); // only IDs, no live DB connection

        return Excel::download(new TeacherFullReportExport($userIds), 'teacher_full_report.xlsx');
    }

    public function render()
    {


        if ($this->reportAction === 'web') {
            $query = $this->getQuery();
            $results = $query->paginate(10);
        } else {
            $results = collect();
        }

        return view('livewire.teacher-full-report', compact('results'));
    }
}
