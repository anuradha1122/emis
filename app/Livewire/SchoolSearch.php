<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkPlace;
use App\Models\School;
use Illuminate\Support\Facades\Crypt;
use Livewire\WithPagination;

class SchoolSearch extends Component
{

    use WithPagination;

    public $search = '';

    protected $queryString = ['search']; // optional: keeps search in URL

    public function updatingSearch()
    {
        $this->resetPage(); // reset pagination on new search
    }

    private function searchSchools()
    {
        if (strlen($this->search) < 1) {
            return collect(); // return empty collection if search too short
        }

        $results = WorkPlace::search($this->search)
        ->where('catagoryId', 1)
        ->paginate(8);


        $results->getCollection()->transform(function ($item) {
            $item->usId = Crypt::encryptString($item->id);
            return $item;
        });

        return $results;
    }

    public function render()
    {
        return view('livewire.school-search', [
            'searchResults' => $this->searchSchools(),
        ]);
    }
}
