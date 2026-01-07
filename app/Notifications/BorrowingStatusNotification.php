<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowingStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Borrowing $borrowing) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'book_title' => $this->borrowing->book->title,
            'status'     => $this->borrowing->status,
            'library'   => $this->borrowing->library->name,
            'borrowing_id' => $this->borrowing->id,
        ];
    }
}
