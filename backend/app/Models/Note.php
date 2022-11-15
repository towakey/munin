<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    use HasFactory;
    protected $fillable = [
        'title',
        'contents',
        'type',
        'secret',
        'user_id',
        'node_from',
        'node_to',
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
