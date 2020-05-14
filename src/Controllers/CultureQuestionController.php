<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller;
use Mindyourteam\Core\Models\Question;
use Mindyourteam\Core\Resources\QuestionResource;
use Illuminate\Http\Request;

use Carbon\Carbon;

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
            ->whereRaw('planned_at <= NOW()')
            ->orderBy('planned_at', 'desc')
            ->paginate(5);

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

    public function upcoming(Request $request)
    {
        $questions = Question::with('answers')
            ->select('questions.*')
            ->leftJoin(
                'blueprints', 'questions.blueprint_id', '=', 'blueprints.id')
            ->where('user_id', $request->user()->id)
            ->where('blueprints.category', 'culture')
            ->whereRaw('planned_at > NOW()')
            ->orderBy('planned_at', 'asc')
            ->paginate(5);

        return view('mindyourteam::culture.upcoming', [
            'questions' => $questions,
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
        $data = $request->json()->all();
        $question = Question::create($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Frage gespeichert',
            'question' => new QuestionResource($question),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Move the question to be the next one asked.
     *
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function next(Request $request, Question $question)
    {
        $questions = Question::select('questions.*')
            ->leftJoin(
                'blueprints', 'questions.blueprint_id', '=', 'blueprints.id')
            ->where('user_id', $request->user()->id)
            ->where('blueprints.category', 'culture')
            ->whereRaw('planned_at > NOW()')
            ->orderBy('planned_at', 'asc')
            ->get();
        
        $planned_at = Carbon::parse('next wednesday');
        $planned_at->tz = 'Europe/Berlin';
        $planned_at->hour = 8;
        $planned_at->minute = 30;

        $question->update([
            'planned_at' => $planned_at->toDateTimeString(),
        ]);

        foreach ($questions as $i => $q) {
            if ($q->id == $question->id) {
                continue;
            }

            $planned_at->addWeek();
            $q->update([
                'planned_at' => $planned_at->toDateTimeString(),
            ]);
        }

        return response()->json([
            'status' => 'ok', 
            'message' => 'Fragen neu sortiert',
        ]);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->json()->all();
        $question->update($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Frage gespeichert',
            'question' => new QuestionResource($question),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CultureQuestion  $cultureQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $cultureQuestion)
    {
        //
    }
}
