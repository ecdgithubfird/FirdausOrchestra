<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use app\Mail\BulkEmail;
use Modules\Mail\Models\Mail;
use Modules\Subscriber\Models\Subscriber;

class SendBulkEmail implements ShouldQueue
{
    protected $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }
    public function handle()
    {
        $mailGroup = Mail::select('mail_group')->where('id',$this->requestId)->first();
        if ($mailGroup->mail_group == 0) {

            $toEmail = Mail::select('to')->where('id',$this->requestId)->first();
            $recipients = [$toEmail->to];
        }else{
            $recipients = Subscriber::pluck('email')->toArray();
        }

        foreach ($recipients as $recipient) {
            \Mail::to($recipient)->send(new \App\Mail\BulkEmail($this->requestId));
        }
    }
}
