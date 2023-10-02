<?php

namespace App\Http\Livewire\Detail;

use App\Http\Livewire\BaseComponent;
use App\Models\SchoolYear;
use DateTime;

class Schoolyeardetail extends BaseComponent
{
    public $itemId;

    public $name;

    public $startAt;

    public $endAt;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $result = SchoolYear::selectColumns(['name', 'start_at', 'end_at'])
            ->where('id', $this->itemId)
            ->first();

        $this->name = $result->name;

        $startAt = new DateTime($result->start_at);
        $this->startAt = $startAt->format('Y-m-d');

        $endAt = new DateTime($result->end_at);
        $this->endAt = $endAt->format('Y-m-d');
    }

    public function save()
    {
        $schoolYear = [
            'name' => trim($this->name),
            'start_at' => $this->startAt,
            'end_at' => $this->endAt,
        ];

        $result = $this->isValidData($schoolYear);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $result = SchoolYear::where('id', $this->itemId)->update($schoolYear);

        if ($result) {
            $this->notify('success', 'update school year successfully');
        } else {
            $this->notify('error', 'update school year fail');
        }
    }

    private function isValidData($data)
    {
        if ($data['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        if ($data['start_at'] >= $data['end_at']) {
            return ['isValid' => false, 'message' => 'End time can not be equal or smaller start time'];
        }

        $nameExists = SchoolYear::where('id', '<>', $this->itemId)
            ->where('name', $data['name'])
            ->exists();

        if ($nameExists) {
            return ['isValid' => false, 'message' => 'This name has been exist'];
        }

        return ['isValid' => true];
    }

    public function render()
    {
        return view('livewire.detail.schoolyeardetail');
    }
}
