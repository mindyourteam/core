<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Answer extends Model
{
    protected $fillable = ['user_id', 'question_id', 'yesno_answer', 'number_answer', 'text_answer'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function question()
    {
        return $this->belongsTo(Question::class);
    }
}
