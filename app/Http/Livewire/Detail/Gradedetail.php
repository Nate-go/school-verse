<?php

namespace App\Http\Livewire\Detail;

use App\Models\Grade;
use Livewire\Component;

class Gradedetail extends Component
{
    public $itemId;

    public $name;

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->formGenerate();
    }

    public function formGenerate() {
        $result = Grade::selectColumns(['name'])
                        ->where('id', $this->itemId)->first();

        $this->name = $result->name;
    }

    public function save() {
        $grade = [
            'name' => trim($this->name)
        ];

        $result = $this->isValidData($grade);

        if (!$result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $result = Grade::where('id', $this->itemId)->update($grade);

        if ($result) {
            $this->notify('success', 'update grade successfully');
        } else {
            $this->notify('error', 'update grade fail');
        }
    }

    private function isValidData($data)
    {
        if ($data['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        $nameExists = Grade::where('id', '<>', $this->itemId)
            ->where('name', $data['name'])
            ->exists();

        if ($nameExists) {
            return ['isValid' => false, 'message' => 'This name has been exist'];
        }

        return ['isValid' => true];
    }

    public function render()
    {
        return view('livewire.detail.gradedetail');
    }
}
