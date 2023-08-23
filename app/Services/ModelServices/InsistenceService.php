<?php

namespace App\Services\ModelServices;
use App\Models\Insistence;
use App\Services\ConstantService;

class InsistenceService extends BaseService{
    public function getModel()
    {
        return Insistence::class;
    }

    public function getTable($filterData)
    {
        $filterElements = $filterData['filterElements'];
        $rooms = $filterElements['room'];
        $statuses = $filterElements['status'];
        $sort = $filterData['sort'];
        $search = $filterData['search'];

        $insistences = $this->model->selectColumns(['id', 'username', 'status', 'room', 'content', 'insistences.create_at', 'image_url'])
            ->status($statuses)
            ->join('profiles', 'insistences.user_id', 'profiles.user_id')
            ->join('rooms', 'insistences.room_id', 'rooms.id')
            ->whereIn('rooms.id', $rooms)
            ->search($search)
            ->orderBy($sort['columnName'], $sort['type'])
            ->paginate($filterData['perPage']);

        $insistences = ConstantService::mappingConstant(\App\Constant\Insistence::class, 'status', $insistences);

        return $insistences;
    }
}