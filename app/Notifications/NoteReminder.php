<?php

namespace App\Notifications;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NoteReminder extends Notification
{
    use Queueable;

    public function __construct(public Note $note)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Recordatorio: tenés una nota sin actualizar')
            ->greeting('¡Hola '.$notifiable->name.'!')
            ->line('Tu nota "'.$this->note->title.'" no la actualizás hace un tiempo.')
            ->line('Resumen: '.$this->note->summary)
            ->action('Ver nota', url('/notes'))
            ->line('¡Que tengas un lindo día!');
    }
}