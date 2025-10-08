<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class RoleNic extends Component
{
    public $nic;
    public $gender;
    public $genderValue;
    public $nicExists = false; // To track if NIC already exists
    public $nicMessage = '';   // To show message

    public function updatedNic()
    {
        // Reset values
        $this->gender = null;
        $this->genderValue = null;
        $this->nicExists = false;
        $this->nicMessage = '';

        // Basic format validation
        if (!preg_match('/^([0-9]{9}[VvXx]|[0-9]{12})$/', $this->nic)) {
            $this->nicMessage = 'Invalid NIC format';
            return;
        }

        // Check if NIC exists
        if (User::where('nic', $this->nic)->exists()) {
            $this->nicExists = true;
            $this->nicMessage = 'NIC verified';
        }

    }

    public function render()
    {
        return view('livewire.role-nic', [
            'nic' => $this->nic,
            'nicExists' => $this->nicExists,
            'nicMessage' => $this->nicMessage,
        ]);
    }
}
