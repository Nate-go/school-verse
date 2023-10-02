<?php

namespace App\Http\Livewire\Fregment;

use App\Constant\NotificationStatus;
use App\Constant\SortTypes;
use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use Auth;

class Notifytable extends BaseComponent
{
    const UNSEEN = NotificationStatus::UNSEEN;

    public $notifyIsOpen = false;

    public $notifies;

    public $numberOfUnread;

    protected $listeners = [
        'closeAll' => 'closeNotify',
        'setNotify',
    ];

    public function mount()
    {
        $this->setNotify();
    }

    public function closeNotify()
    {
        $this->notifyIsOpen = false;
    }

    public function render()
    {
        return view('livewire.fregment.notifytable');
    }

    public function changeNotify()
    {
        $this->notifyIsOpen = ! $this->notifyIsOpen;
    }

    public function changeStatus($notifyId, $currentStatus = null)
    {
        if ($currentStatus == null or $currentStatus == NotificationStatus::UNSEEN) {
            $currentStatus = NotificationStatus::SEEN;
        } else {
            $currentStatus = NotificationStatus::UNSEEN;
        }

        Notification::where('id', $notifyId)
            ->update([
                'status' => $currentStatus,
            ]);

        $this->setNotify();
    }

    public function readNotify($notifyId, $link)
    {
        $this->changeStatus($notifyId);

        return redirect($link);
    }

    public function setNotify()
    {
        $this->notifies = [];

        $data = Notification::selectColumns([
            'users.image_url as image',
            'notifications.status',
            'users.username as fromName',
            'content',
            'notifications.created_at',
            'link',
            'notifications.id as notify_id',
        ])
            ->join('users', 'users.id', '=', 'notifications.from_user_id')
            ->where('notifications.user_id', Auth::user()->id)
            ->sort(['columnName' => 'created_at', 'type' => SortTypes::DECREASE_SORT])
            ->get();

        $this->numberOfUnread = 0;

        foreach ($data as $item) {
            $this->notifies[] = [
                'image' => $item->image,
                'status' => $item->status,
                'fromName' => $item->fromName,
                'content' => $item->content,
                'created_at' => $item->created_at,
                'link' => $item->link,
                'id' => $item->notify_id,
            ];

            if ($item->status == self::UNSEEN) {
                $this->numberOfUnread += 1;
            }
        }
    }
}
