<?php

namespace App\Http\Controllers;

use App\Constant\UserRole;
use App\Services\ModelServices\RoomService;

class HomeController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService) {
        $this->roomService = $roomService;
    }

    public function index() {
        if(auth()->check()) {
            switch(auth()->user()->role) {
                case UserRole::ADMIN:
                    return route('insistences');
                case UserRole::TEACHER:
                    return route('rooms');
                default:
                    $url = $this->roomService->getUrlForStudent();
                    return redirect($url);
            }
        }
        return route('home');
    }
}
