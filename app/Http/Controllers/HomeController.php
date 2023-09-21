<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\RoomService;
use Auth;

class HomeController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index()
    {
        switch (auth()->user()->role) {
            case UserRole::ADMIN:
                return redirect('/insistences');
            case UserRole::TEACHER:
                return redirect('/teachers/' . str(Auth()->user()->id));
            default:
                $url = $this->roomService->getUrlForStudent();
                return redirect($url);
        }
    }

    public function homeroom($id) {
        return $this->roomService->getHomeroomPage($id);
    }

    public function studentRoom($userId, $roomId) {
        return $this->roomService->getStudentRoom($userId, $roomId);
    }

    public function teacherRoom($roomTeacherId) {
        return $this->roomService->getTeacherRoom($roomTeacherId);
    }
}
