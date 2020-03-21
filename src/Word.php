<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['wordcloud_id', 'name'];
    
    public function wordcloud()
    {
        return $this->belongsTo(Wordcloud::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(UserWord::class);
    }
}
