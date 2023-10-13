<?php

namespace App\Http\Livewire\Ulti;

use App\Constant\ExamTypeCoefficient;
use App\Constant\Ranking;
use App\Http\Livewire\BaseComponent;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Room;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\Subject;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;
use Database\Seeders\RoomTeacherSeeder;
use Livewire\Component;

class Dashboard extends BaseComponent
{
    const MAXNUMBERLENGTH = 0;

    const ALL = -1;

    public $types = ['Giỏi', 'Khá', 'Trung bình', 'Yếu'];

    public $colors = [
        'Giỏi' => '#1be014',
        'Khá' => '#e0da1b',
        'Trung bình' => '#ed9f02',
        'Yếu' => '#de1212',
    ];

    public $subjects;

    public $firstRun = true;

    public $showDataLabels = false;

    public $selectedSchoolYear;

    public $schoolYears;

    public $selectedGrade;

    public $grades;

    public $selectedRoom;

    public $rooms;

    public $students;

    public $selectedRank;

    public $selectedRoomCompare;

    public $displayStudent = false;

    public $last = null;

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
        'onBlockClick' => 'handleOnBlockClick',
    ];

    public function handleOnPointClick($point)
    {
    }

    public function handleOnSliceClick($slice)
    {
        if($this->last == null or $this->last == 'column') {
            $this->selectedRank = self::ALL;
        }
        $this->last = 'pie';
        $this->displayStudent = false;
        $this->displayStudent();
        $this->selectedRank = $this->selectedRank == $slice['title'] ? self::ALL : $slice['title']; 
    }

    public function handleOnColumnClick($column)
    {
        if ($this->last == null or $this->last == 'pie') {
            $this->selectedRank = self::ALL;
            $this->selectedRoomCompare = self::ALL;
        }
        $this->last = 'column';
        $this->displayStudent = false;
        $this->displayStudent();
        if(isset($column['seriesName'])) {
            if($this->selectedRank == $column['seriesName'] and $this->selectedRoomCompare == $column['title'] ) {
                $this->selectedRank = self::ALL;
                $this->selectedRoomCompare = self::ALL;
            } else {
                $this->selectedRank = $column['seriesName'];
                $this->selectedRoomCompare = $column['title'];
            }
        } else {
            $this->selectedRank = $this->selectedRank == $column['title'] ? self::ALL : $column['title'];
        }
        
    }

    public function handleOnBlockClick($block)
    {
    }

    public function changeLabelDisplay() {
        $this->showDataLabels = ! $this->showDataLabels;
    }

    public function mount() {
        $this->subjects = $this->getSubjects();
        $this->selectedGrade = self::ALL;
        $this->selectedRoom = self::ALL;
        $this->selectedSchoolYear = self::ALL;
        $this->setSchoolYear();
        $this->selectedRank = self::ALL;
        $this->selectedRoomCompare = self::ALL;
    }

    public function setSchoolYear() {
        $result = SchoolYear::all();
        
        $this->schoolYears = [];

        foreach($result as $item) {
            $this->schoolYears[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
    }

    public function setGrade()
    {
        $result = Grade::all();

        $this->grades = [];

        foreach ($result as $item) {
            $this->grades[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
    }

    public function setRoom()
    {
        $result = Room::selectColumns([
            'rooms.id',
            'rooms.name',
            'grades.name as grade_name'
        ])
        ->join('grades', 'grades.id', '=', 'rooms.grade_id')
        ->where('grade_id', $this->selectedGrade)
        ->where('school_year_id', $this->selectedSchoolYear)
        ->get();

        $this->rooms = [];

        foreach ($result as $item) {
            $this->rooms[] = [
                'id' => $item->id,
                'name' => $item->grade_name . $item->name
            ];
        }
    }

    public function displayStudent() {
        $this->displayStudent = ! $this->displayStudent;
        if($this->students == null) {
            $this->setStudent();
        }
    }

    public function setStudent() {
        $students = Student::selectColumns([
            'users.image_url',
            'users.username',
            'school_years.name as school_year_name',
            'grades.name as grade_name',
            'rooms.name as room_name',
            'scores'
        ])
        ->join('users', 'users.id', '=', 'students.user_id')
        ->join('grades', 'grades.id', '=', 'students.grade_id')
        ->join('school_years', 'school_years.id', '=', 'students.school_year_id')
        ->join('rooms', 'rooms.id', '=', 'students.room_id')
        ->whereOrAll(['students.school_year_id', 'students.grade_id', 'students.room_id'], [$this->selectedSchoolYear, $this->selectedGrade, $this->selectedRoom])
        ->get();

        $this->students = [];

        foreach ($students as $student) {
            $scores = json_decode($student->scores);
            $totalScore = 0;
            $totalCoeff = 0;
            foreach ($scores as $score) {
                $coeff = $this->subjects[$score->subject_id];
                $totalScore += $score->value * $coeff;
                $totalCoeff += $coeff;
            }

            $totalScore = $totalCoeff > 0 ? round($totalScore / $totalCoeff, self::MAXNUMBERLENGTH) : 0;

            $rank = $this->rank($totalScore);
            $this->students[] = [
                'username' => $student->username,
                'imageUrl' => $student->image_url,
                'schoolYearName' => $student->school_year_name,
                'roomName'=> $student->grade_name . $student->room_name,
                'score' => $totalScore,
                'rank' => $rank
            ];
        }
    }

    public function getData() {
        $students = Student::whereOrAll(['school_year_id', 'grade_id', 'room_id'], [$this->selectedSchoolYear, $this->selectedGrade, $this->selectedRoom])
                    ->get();
        $data = [];
        foreach($students as $student) {
            $scores = json_decode($student->scores);
            $totalScore = 0;
            $totalCoeff = 0;
            foreach($scores as $score) {
                $coeff = $this->subjects[$score->subject_id];
                $totalScore += $score->value*$coeff;
                $totalCoeff += $coeff;
            }

            $totalScore = $totalCoeff > 0 ? round($totalScore / $totalCoeff, self::MAXNUMBERLENGTH) : 0;
            
            $rank = $this->rank($totalScore);
            if (array_key_exists($rank, $data)) {
                $data[$rank] += 1;
            } else {
                $data[$rank] = 1;
            }
        }
        return $data;
    }

    public function getSubjects() {
        $subjects = Subject::all();

        $data = [];

        foreach($subjects as $subject) {
            $data[$subject->id] = $subject->coefficient;
        }

        return $data;
    }

    private function rank($score)
    {
        foreach (Ranking::RANKS as $rank) {
            if ($score >= $rank['value']) {
                return $rank['name'];
            }
        }
        return null;
    }

    public function updatedSelectedSchoolYear($value) {
        $this->selectedGrade = self::ALL;
        $this->selectedRoom = self::ALL;
        if($this->grades == null) {
            $this->setGrade();
        }
        $this->resetData();
    }

    public function updatedSelectedGrade($value)
    {
        $this->selectedRoom = self::ALL;
        $this->setRoom();
        $this->resetData();
    }

    public function updatedSelectedRoom($value) {
        $this->resetData();
    }

    public function resetData() {
        $this->displayStudent = false;
        $this->students = null;
        $this->selectedRank = self::ALL;
        $this->selectedRoomCompare = self::ALL;
    }

    public function render()
    {
        $data = $this->getData();

        $pieChartModel = LivewireCharts::pieChartModel()
            ->setTitle('Percent')
            ->setAnimated($this->firstRun)
            ->setType('donut')
            ->withOnSliceClickEvent('onSliceClick')
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled($this->showDataLabels);

        foreach ($data as $type => $value) {
            $pieChartModel->addSlice($type, $value, $this->colors[$type]);
        }

        if($this->selectedGrade != self::ALL and $this->selectedRoom == self::ALL) {
            $multilColumnChartModel = LivewireCharts::multiColumnChartModel()->setTitle('Number of students')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->setLegendVisibility(false)
                ->setDataLabelsEnabled($this->showDataLabels)
                ->setColumnWidth(30)
                ->multiColumn()
                ->withGrid();

            $this->setStudent();
            $data = $this->students;
            $muilColumns = [];

            foreach($data as $item) {
                if(isset($multiColumns[$item['roomName']][$item['rank']])) {
                    $multiColumns[$item['roomName']][$item['rank']] += 1;
                } else {
                    $multiColumns[$item['roomName']][$item['rank']] = 1;
                }
            }

            foreach($multiColumns as $roomName => $room) {
                foreach($room as $rank => $value) {
                    $multilColumnChartModel->addSeriesColumn($rank, $roomName, $value);
                }
            }

            $columnChartModel = $multilColumnChartModel;
        } else {
            $columnChartModel = LivewireCharts::columnChartModel()
                ->setTitle('Number of students')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->setLegendVisibility(false)
                ->setDataLabelsEnabled($this->showDataLabels)
                ->setColumnWidth(20)
                ->withGrid();

            foreach ($data as $type => $value) {
                $columnChartModel->addColumn($type, $value, $this->colors[$type]);
            }
        }

        $this->firstRun = false;

        return view('livewire.ulti.dashboard')
            ->with([
                'columnChartModel' => $columnChartModel,
                'pieChartModel' => $pieChartModel,
            ]);
    }
}
