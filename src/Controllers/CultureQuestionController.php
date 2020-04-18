<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller;
use Mindyourteam\Core\Models\Question;
use Illuminate\Http\Request;

class CultureQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::with('answers')
            ->leftJoin(
                'blueprints', 'questions.blueprint_id', '=', 'blueprints.id')
            ->where('user_id', $request->user()->id)
            ->where('blueprints.category', 'culture')
            ->whereRaw('planned_at < NOW()')
            ->orderBy('planned_at', 'desc')
            ->paginate();

            $next_question = Question::leftJoin(
                    'blueprints', 'questions.blueprint_id', '=', 'blueprints.id')
                ->where('user_id', $request->user()->id)
                ->where('blueprints.category', 'culture')
                ->whereRaw('planned_at > NOW()')
                ->orderBy('planned_at', 'asc')
                ->first();
        return view('mindyourteam::culture.index', [
            'questions' => $questions,
            'next_question' => $next_question,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(CultureQuestion $cultureQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(CultureQuestion $cultureQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CultureQuestion $cultureQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CultureQuestion $cultureQuestion)
    {
        //
    }
}
