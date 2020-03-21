<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wordcloud extends Model
{
    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
