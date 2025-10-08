<?php

namespace App\Livewire;

use Livewire\Component;

class FormUserNic extends Component
{

    public $nic;
    public $gender;
    public $genderValue;

    public function rules()
    {
        return [
            'nic' => [
                'required',
                'unique:users,nic',
                'regex:/^([0-9]{9}[VvXx]|[0-9]{12})$/', // Matches either 9 digits followed by V/v or 12 digits
            ],
        ];
    }

    public function updatedNic()
    {
        // Attempt validation
        try {
            $this->validate();
            if(strlen($this->nic)==10){
                $firstTwoCharacters = substr($this->nic, 0, 2);
                $year = (int)"19".$firstTwoCharacters;
                $nextThreeCharacters = (int)substr($this->nic, 2, 3);
                if($nextThreeCharacters>500){
                    $this->gender = "FeMale";
                    $this->genderValue = 2;
                }else{
                    $this->gender = "Male";
                    $this->genderValue = 1;
                }
            }
            if(strlen($this->nic)==12){
                $firstTwoCharacters = substr($this->nic, 0, 4);
                $year = (int)$firstTwoCharacters;
                $nextThreeCharacters = (int)substr($this->nic, 4, 3);
                if($nextThreeCharacters>500){
                    $this->gender = "FeMale";
                    $this->genderValue = 2;
                }else{
                    $this->gender = "Male";
                    $this->genderValue = 1;
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.form-user-nic',[
            'nic' => $this->nic,
            'gender' => $this->gender,
            'genderValue' => $this->genderValue,
        ]);
    }
}
