<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Livewire\WithPagination;

class TeacherSearch extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search']; // optional: keeps search in URL

    public function updatingSearch()
    {
        $this->resetPage(); // reset pagination on new search
    }

    private function searchTeachers()
    {
        if (strlen($this->search) < 1) {
            return collect(); // return empty collection if search too short
        }

        $results = User::searchUsers($this->search, 1)
            ->whereHas('currentService', function ($query) {
                $query->where('serviceId', 1); // only current principal service
            })
            ->paginate(8);

        $results->getCollection()->transform(function ($item) {
            $item->usId = Crypt::encryptString($item->id);
            return $item;
        });

        return $results;
    }

    public function render()
    {
        return view('livewire.teacher-search', [
            'searchResults' => $this->searchTeachers(),
        ]);
    }
}
