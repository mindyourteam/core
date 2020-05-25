<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Epic extends Model
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
