<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Province;
use App\Models\District;
use App\Models\DsDivision;
use App\Models\GnDivision;

class FormLocationGnDivisionList extends Component
{
    public $provinceList = [];
    public $districtList = [];
    public $dsDivisionList = [];
    public $gnDivisionList = [];

    public $selectedProvince = null;
    public $selectedDistrict = null;
    public $selectedDsDivision = null;
    public $selectedGnDivision = null;

    public function mount($selectedGnDivision = null)
    {
        $this->provinceList = Province::select('id', 'name')->get();

        // If editing existing teacher with stored GN Division
        if ($selectedGnDivision) {
            $this->selectedGnDivision = $selectedGnDivision;

            $gn = GnDivision::with('dsDivision.district.province')->find($selectedGnDivision);

            if ($gn) {
                $this->selectedDsDivision = $gn->dsDivision->id;
                $this->selectedDistrict = $gn->dsDivision->district->id;
                $this->selectedProvince = $gn->dsDivision->district->province->id;

                $this->districtList = District::where('provinceId', $this->selectedProvince)->get(['id', 'name']);
                $this->dsDivisionList = DsDivision::where('districtId', $this->selectedDistrict)->get(['id', 'name']);
                $this->gnDivisionList = GnDivision::where('dsId', $this->selectedDsDivision)->get(['id', 'name']);
            }
        }
    }

    public function updatedSelectedProvince($provinceId)
    {
        $this->districtList = $provinceId
            ? District::where('provinceId', $provinceId)->get(['id', 'name'])
            : collect();

        $this->resetDependentDropdowns(['district', 'dsDivision', 'gnDivision']);
    }

    public function updatedSelectedDistrict($districtId)
    {
        $this->dsDivisionList = $districtId
            ? DsDivision::where('districtId', $districtId)->get(['id', 'name'])
            : collect();

        $this->resetDependentDropdowns(['dsDivision', 'gnDivision']);
    }

    public function updatedSelectedDsDivision($dsDivisionId)
    {
        $this->gnDivisionList = $dsDivisionId
            ? GnDivision::where('dsId', $dsDivisionId)->get(['id', 'name'])
            : collect();

        $this->resetDependentDropdowns(['gnDivision']);
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
        return view('livewire.form-location-gn-division-list');
    }
}
