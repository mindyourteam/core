<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'name',
        'description',
        'roadmap',
        'effort',
        'important',
        'urgent',
    ];
}
