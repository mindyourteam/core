<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Question extends Model
{
    protected $fillable = [
        'blueprint_id', 
        'user_id', 
        'lang', 
        'type', 
        'min', 
        'max', 
        'topic', 
        'body', 
        'rationale', 
        'planned_at'
    ];

    function getPrintableTypeAttribute($value)
    {
        $printable_type = [
            'yesno' => 'Ja/Nein-Frage',
            '1to5' => 'Wertung (1..5)',
            '1to10' => 'Punkte (1..10)',
            'text' => 'Freitext',
        ];
        return $printable_type[$this->type];
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function blueprint()
    {
        return $this->belongsTo(Blueprint::class);
    }

    function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
