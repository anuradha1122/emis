<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Province;
use App\Models\District;
use App\Models\Office;
use App\Models\School;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FormUserAreaSchoolList extends Component
{
    public $provinceList = [];
    public $districtList = [];
    public $zoneList = [];
    public $divisionList = [];
    public $schoolList = [];

    public $selectedProvince;
    public $selectedDistrict;
    public $selectedZone;
    public $selectedDivision;
    public $selectedSchool;

    public function mount()
    {
        // Empty collections
        $this->provinceList = collect();
        $this->districtList = collect();
        $this->zoneList = collect();
        $this->divisionList = collect();
        $this->schoolList = collect();

        $this->loadUserBasedDropdowns();
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
    }

    public function updatedSelectedDistrict($districtId)
    {
        $district = District::with('zones.workPlace')->find($districtId);
        $this->zoneList = $district
            ? $district->zones->map(fn($z) => (object)['id' => $z->id, 'name' => $z->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['zone','division','school']);
    }

    public function updatedSelectedZone($zoneId)
    {
        $zone = Office::with('divisions.workPlace')->find($zoneId);
        $this->divisionList = $zone
            ? $zone->divisions->map(fn($d) => (object)['id' => $d->id, 'name' => $d->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['division','school']);
    }

    public function updatedSelectedDivision($divisionId)
    {
        $division = Office::with('schools.workPlace')->find($divisionId);
        $this->schoolList = $division
            ? $division->schools->map(fn($s) => (object)['id' => $s->id, 'name' => $s->workPlace?->name ?? 'N/A'])
            : collect();
        $this->resetDependentDropdowns(['school']);
    }

    private function resetDependentDropdowns(array $fields)
    {
        foreach ($fields as $field) {
            $property = "selected" . ucfirst($field);
            $this->$property = null;
        }
    }

    public function render()
    {
        return view('livewire.form-user-area-school-list');
    }
}
