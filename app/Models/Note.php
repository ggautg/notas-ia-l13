<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'embedding',
        'summary', 'user_id', 'image', 'share_token'];

    protected $casts = [
        'embedding' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function versions()
    {
        return $this->hasMany(NoteVersion::class)->latest();
    }
}
