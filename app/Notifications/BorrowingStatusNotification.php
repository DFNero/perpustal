<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class BorrowingStatusNotification extends Notification
{
    use Queueable;

    protected string $status;
    protected string $bookTitle;

    public function __construct(string $status, string $bookTitle)
    {
        $this->status = $status;
        $this->bookTitle = $bookTitle;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'status' => $this->status, // approved | rejected
            'book_title' => $this->bookTitle,
        ];
    }
}
