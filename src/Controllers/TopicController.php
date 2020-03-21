<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller as AppController;
use Mindyourteam\Core\Models\Product;
use Mindyourteam\Core\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $topics = Topic::where('product_id', $product->id)
            ->orderBy('name')
            ->paginate();
        return view('mindyourteam::topic.index', [
            'topics' => $topics,
            'product' => $product,
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
    public function store(Request $request, Product $product)
    {
        $data = $request->json()->all();
        $data["urgent"] = preg_match('/^d1w\d$/', $data["eisenhower"]) ? "yes" : "no";
        $data["important"] = preg_match('/^d\dw1$/', $data["eisenhower"]) ? "yes" : "no";
        $data["product_id"] = $product->id;
        $topic = Topic::create($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Thema gespeichert',
            'topic' => $topic,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $data = $request->json()->all();
        $data["urgent"] = preg_match('/^d1w\d$/', $data["eisenhower"]) ? "yes" : "no";
        $data["important"] = preg_match('/^d\dw1$/', $data["eisenhower"]) ? "yes" : "no";
        $topic->update($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Thema gespeichert',
            'topic' => $topic,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
