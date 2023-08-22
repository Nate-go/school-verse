<?php

namespace App\Services\ModelServices;
use App\Models\Room;
use App\Models\Semester;
use Carbon\Carbon;

class RoomService extends BaseService{
    public function getModel()
    {
        return Room::class;
    }

    public function getRoomJson() {
        dd(Carbon::now());
        $currentSemester = Semester::where('start_from', '<=', Carbon::now())
            ->where('end_at', '>=', Carbon::now())
            ->first();
        dd($currentSemester);
        $rooms = $this->model->selectColumns(['name', 'id as value'])->whereHas('semester', function ($query) {
            $query->where('start_from', '<=', Carbon::now())
                ->where('end_at', '>=', Carbon::now());
        })
        ->get();

        dd($rooms);

        return $rooms;
    }
}