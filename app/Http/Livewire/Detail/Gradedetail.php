<?php

namespace App\Http\Livewire\Detail;

use App\Cache\GradeCache;
use App\Http\Livewire\BaseComponent;
use App\Models\Grade;
use Illuminate\Support\Facades\Redis;

class Gradedetail extends BaseComponent
{
    public $itemId;

    public $name;

    private $gradeCache;

    public function boot(GradeCache $gradeCache) {
        $this->gradeCache = $gradeCache;
    }

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $result = $this->gradeCache->getById($this->itemId);
        $this->name = $result ? $result->name : '';
    }

    public function save()
    {
        $grade = [
            'name' => trim($this->name),
        ];

        $result = $this->isValidData($grade);

        if (! $result['isValid']) {
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
