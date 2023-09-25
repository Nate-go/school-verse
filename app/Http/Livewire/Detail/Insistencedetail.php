<?php

namespace App\Http\Livewire\Detail;

use App\Constant\Insistence;
use App\Constant\UserRole;
use App\Services\ConstantService;
use Auth;
use Livewire\Component;

class Insistencedetail extends Component
{
    public $itemId;

    public $imageUrl;

    public $username;

    public $role;

    public $statuses;

    public $selectedStatus;

    public $content;

    public $feedback;

    public $time;

    protected $constantService;

    public $isAdmin;

    const PENDDING = Insistence::PENDING;

    public function boot(ConstantService $constantService) {
        $this->constantService = $constantService;
    }

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->formGenerate();
        $this->setStatus();
        $this->isAdmin = Auth::user()->role == UserRole::ADMIN;
    }

    private function setStatus() {
        $this->statuses = $this->constantService->getConstantsJson(Insistence::class);
    }

    public function formGenerate() {
        $data = \App\Models\Insistence::selectColumns(['username', 'image_url', 'role', 
                'insistences.status', 'content', 'feedback', 'insistences.created_at'])
                ->join('users', 'users.id', '=', 'insistences.user_id')
                ->where('insistences.id', $this->itemId)
                ->first();
        
        $this->username = $data->username;
        $this->imageUrl = $data->image_url;
        $this->role = $this->constantService->getNameConstant(UserRole::class, $data->role) ;
        $this->selectedStatus = $data->status;
        $this->content = $data->content;
        $this->time = $data->created_at;
        $this->feedback = $data->feedback;        
    }

    public function save() {
        if($this->isAdmin) {
            $result = \App\Models\Insistence::where('id', $this->itemId)->update([
                'status' => $this->selectedStatus,
                'feedback' => $this->feedback
            ]);
        } else {
            if($this->selectedStatus != Insistence::PENDING) {
                $this->notify('error', 'Your insistence is not pending anymore for change');
                $this->formGenerate();
                return;
            }
            $result = \App\Models\Insistence::where('id', $this->itemId)->update([
                'content' => $this->content
            ]);
        }
        

        if($result) {
            $this->notify('success', 'Insistence update successfull');
        } else {
            $this->notify('error', 'Insistence update fail');
        }

        $this->formGenerate();
    }

    public function delete() {
        if($this->selectedStatus != Insistence::PENDING) {
            $this->notify('error', 'Your insistence is not pending anymore to delete');
            return;
        }

        $success = \App\Models\Insistence::where('id', $this->itemId)
                                ->delete();

        if ($success) {
            $this->notify('success', 'Insistence delete successfull');
            return redirect('/insistences');
        } else {
            $this->notify('error', 'Insistence delete fail');
        }
    }

    public function render()
    {
        return view('livewire.detail.insistencedetail');
    }
}
