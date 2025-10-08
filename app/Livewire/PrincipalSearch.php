<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\UserInService;
use Illuminate\Support\Facades\Crypt;
use Livewire\WithPagination;

class PrincipalSearch extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search']; // optional: keeps search in URL

    public function updatingSearch()
    {
        $this->resetPage(); // reset pagination on new search
    }

    private function searchPrincipals()
    {
        if (strlen($this->search) < 1) {
            return collect(); // return empty collection if search too short
        }

        $results = User::searchUsers($this->search, 1, 3) // 3 = principal serviceId
            ->paginate(8);

        $results->getCollection()->transform(function ($item) {
            $item->usId = Crypt::encryptString($item->id);
            return $item;
        });

        return $results;
    }


    public function render()
    {
        return view('livewire.principal-search', [
            'searchResults' => $this->searchPrincipals(),
        ]);
    }
}
