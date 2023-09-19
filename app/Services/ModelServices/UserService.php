<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Profile;
use App\Models\User;

class UserService extends BaseService
{
    protected $profileModel;

    public function __construct(Profile $profileModel)
    {
        parent::__construct();
        $this->profileModel = $profileModel;
    }

    protected function getModel()
    {
        return User::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::USERS;
        $this->tableService->setTableForm($data);

        return view('admin/user/users', ['userSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/user/users-initialization');
    }

    public function getDetailPage($id)
    {
        return view('user/users-detail', ['id' => $id]);
    }
}
