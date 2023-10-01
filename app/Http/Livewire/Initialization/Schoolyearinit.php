<?php

namespace App\Http\Livewire\Initialization;

use App\Models\SchoolYear;
use App\Http\Livewire\BaseComponent;

class Schoolyearinit extends BaseComponent
{
    public $name;

    public $startAt;

    public $endAt;

    public function mount()
    {
        $this->formGenerate();
    }

    public function render()
    {
        return view('livewire.initialization.schoolyearinit');
    }

    public function formGenerate()
    {
        $this->name = '';
        $this->startAt = now()->format('Y-m-d');
        $this->endAt = now()->format('Y-m-d');
    }

    public function create()
    {
        $schoolYear = [
            'name' => trim($this->name),
            'start_at' => $this->startAt,
            'end_at' => $this->endAt,
        ];

        $result = $this->isValid($schoolYear);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $newSchoolYear = SchoolYear::create($schoolYear);

        if ($newSchoolYear) {
            $this->notify('success', 'Create school year successfull');
        } else {
            $this->notify('success', 'Create school year fail');
        }
    }

    public function isValid($schoolYear)
    {
        if ($schoolYear['name'] == '') {
            return ['isValid' => false, 'message' => 'The name is empty'];
        }

        if ($schoolYear['start_at'] >= $schoolYear['end_at']) {
            return ['isValid' => false, 'message' => 'End time is smaller or equal the start time'];
        }

        if ($this->isExistName($schoolYear['name'])) {
            return ['isValid' => false, 'message' => 'The name is exist'];
        }

        if ($this->isInAnotherRange($schoolYear['start_at'])) {
            return ['isValid' => false, 'message' => 'Start time is in another school year range'];
        }

        return ['isValid' => true];
    }

    private function isExistName($name)
    {
        $result = SchoolYear::where('name', $name)->exists();

        return $result;
    }

    private function isInAnotherRange($time)
    {
        $result = SchoolYear::where('end_at', '>=', $time)->exists();

        return $result;
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }
}
