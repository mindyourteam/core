<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Team extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
