<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Mail\SendToParent;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notifyId;

    private $isSendToParent;

    public function __construct($notifyId, $isSendToParent=false)
    {
        $this->notifyId = $notifyId;
        $this->isSendToParent = $isSendToParent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->isSendToParent) {
            $notify = Notification::selectColumns([
                'users.username as name',
                'from_users.username as from_name',
                'parent_students.email',
                'content',
                'link',
            ])
                ->join('users as from_users', 'from_users.id', '=', 'notifications.from_user_id')
                ->join('users', 'users.id', '=', 'notifications.user_id')
                ->join('parent_students', 'parent_students.user_id', '=', 'users.id')
                ->where('notifications.id', $this->notifyId)
                ->first();

            $mail = new SendToParent($notify);
        } else {
            $notify = Notification::selectColumns([
                'users.username as name',
                'from_users.username as from_name',
                'users.email',
                'content',
                'link',
            ])
                ->join('users as from_users', 'from_users.id', '=', 'notifications.from_user_id')
                ->join('users', 'users.id', '=', 'notifications.user_id')
                ->where('notifications.id', $this->notifyId)
                ->first();
                
            $mail = new SendMail($notify);
        }
        Mail::to($notify->email)->send($mail);
    }
}
