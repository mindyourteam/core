<?php

namespace Mindyourteam\Core\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Mindyourteam\Core\Models\Question;
use Mindyourteam\Core\Models\Answer;
use Illuminate\Http\Request;
use Mindyourteam\Core\Models\Team;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function withtoken(Question $question, Request $request)
    {
        $team = Team::find(env('APP_TEAM_ID'));
        if ($question->user_id != $team->lead_id) {
            abort(403, 'Du darfst diese Frage nicht beantworten.');
        }

        $user = User::where('remember_token', $request->token)->firstOrFail();
        Auth::login($user, true);

        return view('mindyourteam::answer.index', ['question' => $question]);
    }

    public function index(Question $question, Request $request)
    {
        $team = Team::find(env('APP_TEAM_ID'));
        if ($question->user_id != $team->lead_id) {
            abort(403, 'Du darfst diese Frage nicht beantworten.');
        }

        $my_answer = $question->answers()->where('user_id', $request->user()->id)->first();

        return view('mindyourteam::answer.index', [
            'question' => $question,
            'my_answer' => $my_answer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::find(env('APP_TEAM_ID'));
        $question = Question::findOrFail($request->question_id);
        if ($question->user_id != $team->lead_id) {
            abort(403, 'Du darfst diese Frage nicht beantworten.');
        }

        if ($question->type == 'yesno') {
            $defaults = [ 'yesno_answer' => false ];
        }
        else {
            $defaults = [];
        }
        $input = $request->all() + $defaults;

        $answer = Answer::updateOrCreate([
            'user_id' => $request->user()->id,
            'question_id' => $question->id,
        ], $input);
        return redirect()->route('culture.show', [$question])->with('success', 'Antwort gespeichert.'); 
    }
}
