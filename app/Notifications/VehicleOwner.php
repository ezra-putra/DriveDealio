<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleOwner extends Notification
{
    use Queueable;

    protected $message;
    protected $title;
    public function __construct($title, $message)
    {
        $this->message = $message;
        $this->title = $title;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'messages' => $this->message,
        ];
    }
}
