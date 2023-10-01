<?php

namespace App\Http\Livewire\Initialization;

use App\Constant\InsistenceTypes;
use App\Constant\NotificationStatus;
use App\Constant\UserRole;
use App\Models\Insistence;
use App\Http\Livewire\BaseComponent;
use App\Models\User;
use Auth;

class Insistenceinit extends BaseComponent
{
    public $userId;

    public $content;

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function formGenerate()
    {
        $this->content = '';
    }

    public function create()
    {
        $this->content = trim($this->content);
        if ($this->content == '') {
            $this->notify('error', 'Your content is empty');

            return;
        }

        $newInsistence = Insistence::create([
            'user_id' => $this->userId,
            'status' => \App\Constant\Insistence::PENDING,
            'content' => $this->content,
            'type' => InsistenceTypes::NORMAL,
        ]);

        if ($newInsistence) {
            $this->notify('success', 'Your insistence has been sent');

            $admin = User::where('role', UserRole::ADMIN)->first();
            $newNotify = [
                'content' => 'You have new insistence',
                'from_user_id' => Auth::user()->id,
                'user_id' => $admin->id,
                'status' => NotificationStatus::UNSEEN,
                'link' => '/insistences/' . str($newInsistence->id),
            ];

            $this->realTimeNotify($newNotify);
        } else {
            $this->notify('error', 'Create fail');
        }
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }

    public function render()
    {
        return view('livewire.initialization.insistenceinit');
    }
}
