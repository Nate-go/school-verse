<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class RoomService extends BaseService
{
    protected $schoolYearService;

    public function __construct(SchoolYearService $schoolYearService)
    {
        parent::__construct();
        $this->schoolYearService = $schoolYearService;
    }

    public function getModel()
    {
        return Room::class;
    }

    public function getUrlForStudent()
    {
        $currentSchoolYearId = $this->schoolYearService->getCurrentSchoolYear();

        $room = $this->model->selectColumns(['room_id'])->where('user_id', Auth::user()->id)->where('school_year_id', $currentSchoolYearId)->first();

        return '/rooms/'.str($room->id);
    }

    public function getPageForAdmin()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getPageForTeacher()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getPageForStudent()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/room/rooms-initialization');
    }
}
