<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['wordcloud_id', 'user_id', 'word'];
    
    public function wordcloud()
    {
        return $this->belongsTo(Wordcloud::class);
    }
}
