<?php

namespace App\Console\Commands;

use App\Models\Note;
use App\Notifications\NoteReminder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-note-reminders')]
#[Description('Manda un email por cada nota que no se actualizó hace más de 7 días')]
class SendNoteReminders extends Command
{
    public function handle()
    {
        $notes = Note::where('updated_at', '<', now()->subDays(7))->get();

        foreach ($notes as $note) {
            $note->user->notify(new NoteReminder($note));

            $this->info('Recordatorio enviado para: '.$note->title);
        }

        $this->info('Total de recordatorios enviados: '.$notes->count());
    }
}