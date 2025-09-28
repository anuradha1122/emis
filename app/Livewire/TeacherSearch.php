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
        if (strlen($this->search) < 2) {
            return collect(); // return empty collection if search too short
        }
        return User::searchUsers($this->search, 1)->paginate(8);
    }

    public function render()
    {
        return view('livewire.teacher-search', [
            'searchResults' => $this->searchTeachers(),
        ]);
    }
}
