<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller;
use Mindyourteam\Core\Models\Question;
use Mindyourteam\Core\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function withtoken(Question $question, Request $request)
    {
        $user = User::where('remember_token', $request->token)->firstOrFail();
        Auth::login($user, true);

        return view('mindyourteam::answer.index', ['question' => $question]);
    }

    public function index(Question $question)
    {
        return view('mindyourteam::answer.index', ['question' => $question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $answer = Answer::firstOrCreate([
            'user_id' => $request->user()->id,
            'question_id' => $request->question_id,
        ] + $input);
        return redirect('culture')->with('success', 'Antwort gespeichert.'); 
    }
}
