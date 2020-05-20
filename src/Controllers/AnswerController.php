<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller;
use Mindyourteam\Core\Models\Question;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
