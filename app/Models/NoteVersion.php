<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteVersion extends Model
{
    protected $fillable = ['note_id', 'title', 'content'];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}