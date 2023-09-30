<?php

namespace App\Http\Livewire;
use App\Events\NotifyEvent;
use App\Jobs\SendEmailQueue;
use App\Mail\SendMail;
use App\Models\Notification;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BaseComponent extends ModalComponent {

    use LivewireAlert;

    public function displayModal($name, $params) {
        $this->emit('openModal', $name, $params);
    }

    public function notify($type, $message) {
        $this->alert($type, $message, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function realTimeNotify($notify) {
        $newNotify = Notification::create($notify);
        event(new NotifyEvent($newNotify->id));
        SendEmailQueue::dispatch($newNotify->id);
    }

    public function confirmBox($message, $action, $params) {
        $this->alert('question', 'Are you sure to ' . $message . ' ?', [
            'position' => 'top-end',
            'timer' => 10000,
            'toast' => true,
            'showCancelButton' => true,
            'onDismissed' => '',
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmAction',
            'inputAttributes' => ['action' => $action, 'params' => $params],
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Yes',
            'timerProgressBar' => true,
        ]);
    }

    public function getListeners()
    {
        return [
            'confirmAction',
        ];
    }

    public function confirmAction($input)
    {
        $data = $input['data']['inputAttributes'];
        $action = $data['action'];
        $params = $data['params'];
        $this->$action(...$params);
    }
}