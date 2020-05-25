<?php

namespace Mindyourteam\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    protected $fillable = [
        'blueprint_id', 
        'user_id', 
        'lang', 
        'type', 
        'min', 
        'max', 
        'epic', 
        'body', 
        'rationale', 
        'planned_at'
    ];

    function getPrintableTypeAttribute($value)
    {
        $printable_type = [
            'yesno' => 'Ja/Nein-Frage',
            '1to5' => 'Wertung (1..5)',
            '1to10' => 'Punkte (1..10)',
            'text' => 'Freitext',
        ];
        return $printable_type[$this->type];
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function blueprint()
    {
        return $this->belongsTo(Blueprint::class);
    }

    function answers()
    {
        return $this->hasMany(Answer::class);
    }

    function stats()
    {
        $typed_answer = $this->type . '_answer';
              
        // Don't use the answers() relation here as the aggregated rows are not answers at all
        $stats = DB::table('answers')
            ->selectRaw("COUNT(*) as count, {$typed_answer} as answer")
            ->where('question_id', $this->id)
            ->groupBy($typed_answer)
            ->orderBy($typed_answer)
            ->get();
        foreach ($stats as $row) {
            $row->answers = $this->answers->where($typed_answer, $row->answer);
            if ($this->type == 'yesno') {
                $row->answer = $row->answer ? 'ja' : 'nein';
            }
        }
        return $stats;
    }

    function getHumanPlannedAtAttribute()
    {
        return (new Carbon($this->planned_at))
            ->locale('de')
            ->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]);
    }
}
