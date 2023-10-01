<?php

namespace App\Http\Livewire\Initialization;

use App\Constant\Gender;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\Room;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ConstantService;
use App\Services\UtilService;
use DB;
use Hash;
use App\Http\Livewire\BaseComponent;

class Userinit extends BaseComponent
{
    public $isProfileOpen = true;

    public $isMoreActionOpen = false;

    public $isTeacher;

    public $email;

    public $password;

    public $username;

    public $status;

    public $gender;

    public $address;

    public $phoneNumber;

    public $dateOfDate;

    public $selectedGrades;

    public $selectedGradeNames = [];

    public $selectedSubjects;

    public $selectedSubjectNames = [];

    public $selectedRoom;

    public $grades;

    public $subjects;

    public $rooms;

    public $statuses;

    public $genders;

    protected $constantService;

    protected $utilService;

    public function mount()
    {
        $this->profileFormGenerate();
        $this->moreactionFormGenerate();
        $this->isTeacher = false;
        $this->accountFormGenerate();
        $this->getStatuses();
        $this->getGenders();
        $this->getGrades();
    }

    public function boot(ConstantService $constantService, UtilService $utilService)
    {
        $this->constantService = $constantService;
        $this->utilService = $utilService;
    }

    public function render()
    {
        return view('livewire.initialization.userinit');
    }

    public function changeProfileState()
    {
        $this->isProfileOpen = ! $this->isProfileOpen;
    }

    public function changeMoreActionState()
    {
        $this->isMoreActionOpen = ! $this->isMoreActionOpen;
    }

    public function profileFormGenerate()
    {
        $this->gender = Gender::MALE;
        $this->address = '';
        $this->phoneNumber = '';
        $this->dateOfDate = now();
    }

    public function moreactionFormGenerate()
    {
        $this->selectedGrades = [];
        $this->selectedGradeNames = [];
        $this->selectedSubjects = [];
        $this->selectedSubjectNames = [];
        $this->selectedRooms = null;
    }

    public function selectGrade($value)
    {
        if ($this->isTeacher) {
            $key = array_search($value, $this->selectedGrades);
            if ($key === false) {
                $this->selectedGrades[] = $value;
            } else {
                unset($this->selectedGrades[$key]);
            }

            $this->getSubject();
            $this->removeItem($this->selectedSubjects, $this->subjects);
            $this->resetSelectedSubjectNames();
        } else {
            if (! empty($this->selectedGrades)) {
                if ($value != $this->selectedGrades[0]) {
                    $this->selectedRoom = null;
                }
            }

            $this->selectedGrades = [$value];
            $this->getRooms();
        }

        $this->selectedGradeNames = [];

        foreach ($this->grades as $grade) {
            if (in_array($grade['id'], $this->selectedGrades)) {
                $this->selectedGradeNames[] = $grade['name'];
            }
        }
    }

    private function removeItem(&$selected, $source)
    {
        $temp = [];
        foreach ($selected as $item) {
            foreach ($source as $element) {
                if ($item == $element['id']) {
                    $temp[] = $item;
                }
            }
        }
        $selected = $temp;
    }

    public function selectSubject($value)
    {
        $key = array_search($value, $this->selectedSubjects);
        if ($key === false) {
            $this->selectedSubjects[] = $value;
        } else {
            unset($this->selectedSubjects[$key]);
        }

        $this->resetSelectedSubjectNames();
    }

    private function resetSelectedSubjectNames()
    {
        $this->selectedSubjectNames = [];

        foreach ($this->subjects as $subject) {
            if (in_array($subject['id'], $this->selectedSubjects)) {
                $this->selectedSubjectNames[] = $subject['name'];
            }
        }
    }

    public function selectRoom($value)
    {
        $this->selectedRoom = $value;
    }

    public function changeRole($value)
    {
        $this->isTeacher = $value == UserRole::TEACHER;
        $this->moreactionFormGenerate();
    }

    private function getGrades()
    {
        $result = Grade::selectColumns(['id', 'name'])->get();
        $this->grades = $this->mappingData($result);
    }

    private function getSubject()
    {
        $result = Subject::select(
            'subjects.id',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as name'),
        )
            ->join('grades', 'subjects.grade_id', '=', 'grades.id')->whereIn('grades.id', $this->selectedGrades)->get();
        $this->subjects = $this->mappingData($result);
    }

    private function getRooms()
    {
        $currentSchoolYearId = $this->utilService->getCurrentSchoolYear();

        $result = Room::select(
            'rooms.id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as name'),
        )
            ->join('grades', 'rooms.grade_id', '=', 'grades.id')
            ->where('rooms.school_year_id', '=', $currentSchoolYearId)->whereIn('grades.id', $this->selectedGrades)->get();
        $this->rooms = $this->mappingData($result);
    }

    private function getStatuses()
    {
        $this->statuses = $this->constantService->getConstantsJson(UserStatus::class);
    }

    private function getGenders()
    {
        $this->genders = $this->constantService->getConstantsJson(Gender::class);
    }

    public function accountFormGenerate()
    {
        $this->email = '';
        $this->password = '';
        $this->username = '';
        $this->status = UserStatus::ACTIVE;
        $this->isTeacher = false;
    }

    private function mappingData($data)
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = ['name' => $item->name, 'id' => $item->id];
        }

        return $result;
    }

    public function createAccount()
    {
        $vars = [
            'email',
            'password',
            'role',
            'username',
            'status',
        ];

        $cleanData = $this->getCleanData([
            $this->password,
            $this->isTeacher ? UserRole::TEACHER : UserRole::STUDENT,
            $this->username,
            $this->status,
        ]);

        array_unshift($cleanData, trim($this->email));

        $user = [];
        for ($i = 0; $i < count($cleanData); $i++) {
            $user[$vars[$i]] = $cleanData[$i];
        }

        $user['role'] = intval($user['role']);
        $user['status'] = intval($user['status']);

        $result = $this->isUserValid($user);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);
        } else {
            $profile = [
                'gender' => $this->gender,
                'address' => $this->address,
                'phoneNumber' => $this->phoneNumber,
                'date_of_birth' => $this->dateOfDate,
            ];

            $object = [
                'moreAction' => $this->isMoreActionOpen,
                'subjectIds' => $this->selectedSubjects,
                'gradeId' => $this->selectedGrades[0] ?? null,
                'roomId' => $this->selectedRoom,
            ];

            $success = DB::transaction(function () use ($user, $profile, $object) {

                $newProfile = Profile::create($profile);

                $fullUrl = url('/');

                $user['image_url'] = $fullUrl.'/img/default-user-'.str(random_int(0, 5)).'.png';
                $user['profile_id'] = $newProfile->id;
                $user['password'] = Hash::make($user['password']);

                $newUser = User::create($user);

                if ($object['moreAction'] and $object['gradeId']) {
                    if ($newUser->role == UserRole::TEACHER) {
                        foreach ($object['subjectIds'] as $subjectId) {
                            Teacher::create(['user_id' => $newUser->id, 'subject_id' => $subjectId]);
                        }
                    } else {
                        Student::create([
                            'user_id' => $newUser->id,
                            'school_year_id' => $this->utilService->getCurrentSchoolYear(),
                            'grade_id' => $object['gradeId'],
                            'room_id' => $object['roomId'],
                        ]);
                    }
                }

                return true;
            });

            if ($success) {
                $this->notify('success', 'create account successfull');
            } else {
                $this->notify('error', 'create account fail');
            }
        }
    }

    public function addAndNext()
    {
        $this->createAccount();
        $this->profileFormGenerate();
        $this->accountFormGenerate();
    }

    private function isUserValid($user)
    {
        if (! filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            return ['isValid' => false, 'message' => 'Invalid email'];
        }

        if ($this->isUserEmailExist($user['email'])) {
            return ['isValid' => false, 'message' => 'Email exist'];
        }

        foreach ($user as $var) {
            if ($var == '') {
                return ['isValid' => false, 'message' => 'Empty data'];
            }
        }

        return ['isValid' => true];
    }

    private function getCleanData($strs)
    {
        $cleanData = [];
        foreach ($strs as $str) {
            $cleanData[] = trim($this->utilService->freshString($str));
        }

        return $cleanData;
    }

    private function isUserEmailExist($email)
    {
        return User::where('email', $email)->exists();
    }
}
