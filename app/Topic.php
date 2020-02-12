<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'name',
        'product_id',
        'description',
        'roadmap',
        'effort',
        'important',
        'urgent',
    ];
}
