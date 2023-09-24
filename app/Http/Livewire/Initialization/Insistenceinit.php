<?php

namespace App\Http\Livewire\Initialization;

use App\Models\Insistence;
use Livewire\Component;

class Insistenceinit extends Component
{
    public $userId;

    public $content;

    public function mount($userId) {
        $this->userId = $userId;
    }

    public function formGenerate() {
        $this->content = '';
    }

    public function create() {
        $this->content = trim($this->content);
        if($this->content == '') {
            $this->notify('error', 'Your content is empty');
            return;
        }

        $newInsistence = Insistence::create([
            'user_id' => $this->userId,
            'status' => \App\Constant\Insistence::PENDING,
            'content' => $this->content
        ]);

        if($newInsistence) {
            $this->notify('success', 'Your insistence has been sent');
        } else {
            $this->notify('error', 'Create fail');
        }
    }

    public function addAndNext() {
        $this->create();
        $this->formGenerate();
    }


    public function render()
    {
        return view('livewire.initialization.insistenceinit');
    }
}
