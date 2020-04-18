<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
    protected $fillable = ['category', 'lang', 'type', 'min', 'max', 'topic', 'body', 'rationale', 'source'];
}
