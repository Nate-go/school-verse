<?php

namespace App\Http\Livewire\Detail;

use App\Models\Subject;
use App\Services\ConstantService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Subjectdetail extends Component
{
    use WithFileUploads;

    public $name;

    public $image;

    public $imageUrl;

    public $coefficient;

    public $numberOfLesson;

    public $grade;

    protected $constantService;

    public $itemId;

    public $gradeId;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $result = Subject::selectColumns([
            'subjects.name', 
            'number_lesson', 
            'coefficient', 
            'image_url', 
            'grades.name as grade_name', 
            'grade_id'
            ])
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('subjects.id', $this->itemId)
            ->first();

        $this->name = $result->name;
        $this->coefficient = $result->coefficient;
        $this->numberOfLesson = $result->number_lesson;
        $this->image = null;
        $this->imageUrl = $result->image_url;
        $this->grade = $result->grade_name;
        $this->gradeId = $result->grade_id;
    }

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function save()
    {
        $subject = [
            'name' => trim($this->name),
            'coefficient' => $this->coefficient,
            'number_lesson' => $this->numberOfLesson,
        ];

        $result = $this->isValidData($subject);

        if (!$result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $subject['image_url'] = $this->saveImage();

        $result = Subject::where('id', $this->itemId)->update($subject);

        if ($result) {
            $this->notify('success', 'Update subject successful');
        } else {
            $this->notify('error', 'Update subject fail');
        }
    }

    private function isValidData($subject)
    {
        if ($subject['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        if ($subject['coefficient'] <= 0) {
            return ['isValid' => false, 'message' => 'Coefficient is invalid'];
        }

        if ($subject['number_lesson'] <= 0) {
            return ['isValid' => false, 'message' => 'Number_lesson is invalid'];
        }

        $nameExists = Subject::where('id', '<>',$this->itemId)
            ->where('name', $subject['name'])
            ->where('grade_id', $this->gradeId)
            ->exists();

        if ($nameExists) {
            return ['isValid' => false, 'message' => 'This subject name has been exist in this gradess'];
        }

        return ['isValid' => true];
    }

    public function saveImage()
    {
        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/' . $imageName);

            return $url;
        } else {
            return $this->imageUrl;
        }
    }
    
    public function render()
    {
        return view('livewire.detail.subjectdetail');
    }
}
