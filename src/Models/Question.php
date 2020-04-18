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

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function blueprint()
    {
        return $this->belongsTo(Blueprint::class);
    }
}
