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

    function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->user->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=40&d=retro";    
    }

    function getAnswerAttribute()
    {
        $question = $this->question;
        $typed_answer = $question->type . '_answer';
        $answer = $this->$typed_answer;
        if ($question->type == 'yesno') {
            $answer = $answer ? 'ja' : 'nein';
        }
        return $answer;
    }
}
