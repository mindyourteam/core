<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserWord extends Pivot
{
    public $incrementing = true;
    protected $fillable = ['user_id', 'word_id'];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
