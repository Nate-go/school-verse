<?php

namespace App\Http\Livewire\Initialization;

use App\Models\Grade;
use App\Http\Livewire\BaseComponent;

class Gradeinit extends BaseComponent
{
    public $name;

    public function mount()
    {
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $this->name = '';
    }

    public function create()
    {
        $grade = [
            'name' => trim($this->name),
        ];

        $result = $this->isValid($grade);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $newGrade = Grade::create($grade);

        if ($newGrade) {
            $this->notify('success', 'Create grade successfull');
        } else {
            $this->notify('success', 'Create grade fail');
        }
    }

    public function isValid($grade)
    {
        if ($grade['name'] == '') {
            return ['isValid' => false, 'message' => 'The name is empty'];
        }

        if ($this->isExistName($grade['name'])) {
            return ['isValid' => false, 'message' => 'The name is exist'];
        }

        return ['isValid' => true];
    }

    private function isExistName($name)
    {
        $result = Grade::where('name', $name)->exists();

        return $result;
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }

    public function render()
    {
        return view('livewire.initialization.gradeinit');
    }
}
