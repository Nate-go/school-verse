<?php

namespace App\Http\Livewire\Initialization;

use App\Http\Livewire\BaseComponent;
use App\Models\Grade;
use App\Models\Subject;
use App\Services\ConstantService;
use App\Services\UtilService;
use Livewire\WithFileUploads;

class Subjectinit extends BaseComponent
{
    use WithFileUploads;

    public $name;

    public $image;

    public $coefficient;

    public $numberOfLesson;

    public $selectedGrade;

    public $grades;

    protected $constantService;

    protected $utilService;

    public function mount()
    {
        $this->formGenerate();
        $this->getGrades();
    }

    public function formGenerate()
    {
        $this->name = '';
        $this->coefficient = 1;
        $this->numberOfLesson = 75;
        $this->image = null;
        $this->selectedGrade = null;
    }

    public function boot(ConstantService $constantService, UtilService $utilService)
    {
        $this->constantService = $constantService;
        $this->utilService = $utilService;
    }

    private function getGrades()
    {
        $result = Grade::selectColumns(['id', 'name'])->get();
        $this->grades = $this->mappingData($result);
    }

    private function mappingData($data)
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = ['name' => $item->name, 'id' => $item->id];
        }

        return $result;
    }

    public function create()
    {
        $subject = [
            'grade_id' => $this->selectedGrade,
            'name' => trim($this->name),
            'coefficient' => $this->coefficient,
            'number_lesson' => $this->numberOfLesson,
        ];

        $result = $this->isValidData($subject);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $subject['image_url'] = $this->saveImage();

        $newSubject = Subject::create($subject);

        if ($newSubject) {
            $this->notify('success', 'Create subject successful');
        } else {
            $this->notify('error', 'Create subject fail');
        }
    }

    private function isValidData($subject)
    {
        if ($subject['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        if (! $subject['grade_id']) {
            return ['isValid' => false, 'message' => 'Grade have not been selected'];
        }

        $subjectExists = Subject::where('grade_id', $subject['grade_id'])
            ->where('name', $subject['name'])
            ->exists();

        if ($subjectExists) {
            return ['isValid' => false, 'message' => 'This subject has been exist'];
        }

        return ['isValid' => true];
    }

    public function saveImage()
    {
        if ($this->image) {
            $imageName = time().'.'.$this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/'.$imageName);

            return $url;
        } else {
            return asset('storage/images/default-image.png');
        }
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }

    public function render()
    {
        return view('livewire.initialization.subjectinit');
    }
}
