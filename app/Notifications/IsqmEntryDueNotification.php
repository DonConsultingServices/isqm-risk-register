<?php

namespace App\Notifications;

use App\Models\IsqmEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IsqmEntryDueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public IsqmEntry $entry)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('ISQM entry due: '.$this->entry->id)
            ->greeting('Hello')
            ->line('An ISQM entry is due soon or overdue:')
            ->line($this->entry->quality_objective)
            ->action('Open ISQM Register', url('/isqm'))
            ->line('Status: '.$this->entry->status)
            ->line('Due: '.optional($this->entry->due_date)->format('Y-m-d'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'entry_id' => $this->entry->id,
            'area' => $this->entry->area,
            'status' => $this->entry->status,
            'due_date' => optional($this->entry->due_date)->toDateString(),
            'quality_objective' => $this->entry->quality_objective,
        ];
    }
}


