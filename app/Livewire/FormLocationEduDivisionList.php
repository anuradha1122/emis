<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Province;
use App\Models\District;
use App\Models\Office;

class FormLocationEduDivisionList extends Component
{
    public $provinceList = [];
    public $districtList = [];
    public $zoneList = [];
    public $divisionList = [];

    public $selectedProvince;
    public $selectedDistrict;
    public $selectedZone;

    public function mount()
    {
        // Load all provinces initially
        $this->provinceList = Province::select('id', 'name')->get();
        $this->districtList = collect();
        $this->zoneList = collect();
        $this->divisionList = collect();
    }

    public function updatedSelectedProvince($provinceId)
    {
        // Load districts in the selected province
        $province = Province::with('districts')->find($provinceId);

        $this->districtList = $province
            ? $province->districts->map(fn($d) => (object)[
                'id' => $d->id,
                'name' => $d->name,
            ])
            : collect();

        $this->resetDependentDropdowns(['district', 'zone', 'division']);
    }

    public function updatedSelectedDistrict($districtId)
    {
        // Load zones under the selected district
        $district = District::with('zones.workPlace')->find($districtId);

        $this->zoneList = $district
            ? $district->zones->map(fn($z) => (object)[
                'id' => $z->id,
                'name' => $z->workPlace?->name ?? 'N/A',
            ])
            : collect();

        $this->resetDependentDropdowns(['zone', 'division']);
    }

    public function updatedSelectedZone($zoneId)
    {
        // Load divisions under the selected zone
        $zone = Office::with('divisions.workPlace')->find($zoneId);

        $this->divisionList = $zone
            ? $zone->divisions->map(fn($d) => (object)[
                'id' => $d->id,
                'name' => $d->workPlace?->name ?? 'N/A',
            ])
            : collect();

        $this->resetDependentDropdowns(['division']);
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
        return view('livewire.form-location-edu-division-list');
    }
}
