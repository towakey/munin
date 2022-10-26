<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'contents',
        'type',
        'user_id',
    ];
    protected $hidden = [
    ];

    protected static function boot()
    {
        parent::boot();
        self::saving(function($note){
            $note->id=(string)Str::orderedUuid();
        });
    }
}
