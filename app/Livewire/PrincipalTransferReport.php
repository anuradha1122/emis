<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PrincipalTransfer;
use App\Models\Province;
use App\Models\District;
use App\Models\SchoolAuthority;
use App\Models\SchoolEthnicity;
use App\Models\SchoolClass;
use App\Models\SchoolDensity;
use App\Models\SchoolFacility;
use App\Models\SchoolGender;
use App\Models\SchoolLanguage;
use App\Models\Office;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use App\Exports\PrincipalTransferReportExport;

class PrincipalTransferReport extends Component
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
        $query = PrincipalTransfer::query()
            ->with([
                'userService.user.personalInfo',
                'userService.currentAppointment.workPlace.school',
            ])
            ->where('active', 1)
            ->whereHas('userService'); // only transfers with a service

        // 🏫 Location-based filters
        $query->when($this->selectedSchool, function($q) {
            $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) {
                $q2->where('id', $this->selectedSchool);
            });
        });

        $query->when($this->selectedDivision, function($q) {
            $division = Office::with('schools')->find($this->selectedDivision);
            $schoolIds = $division ? $division->schools->pluck('id')->toArray() : [];
            if ($schoolIds) {
                $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) use ($schoolIds) {
                    $q2->whereIn('id', $schoolIds);
                });
            }
        });

        $query->when($this->selectedZone, function($q) {
            $zone = Office::with('subOffices.schools')->find($this->selectedZone);
            $schoolIds = $zone ? $zone->subOffices->flatMap(fn($d) => $d->schools)->pluck('id')->toArray() : [];
            if ($schoolIds) {
                $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) use ($schoolIds) {
                    $q2->whereIn('id', $schoolIds);
                });
            }
        });

        $query->when($this->selectedDistrict, function($q) {
            $district = District::with('zones.subOffices.schools')->find($this->selectedDistrict);
            $schoolIds = $district
                ? $district->zones->flatMap(fn($zone) => $zone->subOffices->flatMap(fn($d) => $d->schools))->pluck('id')->toArray()
                : [];
            if ($schoolIds) {
                $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) use ($schoolIds) {
                    $q2->whereIn('id', $schoolIds);
                });
            }
        });

        $query->when($this->selectedProvince, function($q) {
            $province = Province::with('districts.zones.subOffices.schools')->find($this->selectedProvince);
            $schoolIds = $province
                ? $province->districts
                    ->flatMap(fn($district) => $district->zones
                        ->flatMap(fn($zone) => $zone->subOffices
                            ->flatMap(fn($d) => $d->schools)))
                    ->pluck('id')->toArray()
                : [];
            if ($schoolIds) {
                $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) use ($schoolIds) {
                    $q2->whereIn('id', $schoolIds);
                });
            }
        });

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
            $query->when($this->$property, function($q) use ($property, $column) {
                $q->whereHas('userService.currentAppointment.workPlace.school', function($q2) use ($column, $property) {
                    $q2->where($column, $this->$property);
                });
            });
        }

        return $query;
    }

    public function exportExcel()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $query = $this->getQuery();

        // Get all transfer IDs instead of user IDs
        $transferIds = $query->pluck('id')->toArray();

        // Pass transfer IDs to your export class
        return Excel::download(new PrincipalTransferReportExport($transferIds), 'principal_transfer_report.xlsx');
    }

    public function render()
    {
        if ($this->reportAction === 'web') {
            $query = $this->getQuery();
            $results = $query->paginate(10);
            //$names = $results->map(fn($transfer) => $transfer->userService->user->name);
        } else {
            $results = collect();
        }

        return view('livewire.principal-transfer-report', [
            'results' => $results
        ]);
    }
}
