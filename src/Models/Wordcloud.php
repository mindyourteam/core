<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Wordcloud extends Model
{
    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
