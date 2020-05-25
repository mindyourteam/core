<?php

namespace Mindyourteam\Core\Controllers;

use App\Http\Controllers\Controller as AppController;
use Mindyourteam\Core\Models\Product;
use Mindyourteam\Core\Models\Epic;
use Illuminate\Http\Request;

class EpicController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $epics = Epic::where('product_id', $product->id)
            ->orderBy('name')
            ->paginate();
        return view('mindyourteam::epic.index', [
            'epics' => $epics,
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
        $epic = Epic::create($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Thema gespeichert',
            'epic' => $epic,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Epic  $epic
     * @return \Illuminate\Http\Response
     */
    public function show(Epic $epic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Epic  $epic
     * @return \Illuminate\Http\Response
     */
    public function edit(Epic $epic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Epic  $epic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Epic $epic)
    {
        $data = $request->json()->all();
        $data["urgent"] = preg_match('/^d1w\d$/', $data["eisenhower"]) ? "yes" : "no";
        $data["important"] = preg_match('/^d\dw1$/', $data["eisenhower"]) ? "yes" : "no";
        $epic->update($data);
        return response()->json([
            'status' => 'ok', 
            'message' => 'Thema gespeichert',
            'epic' => $epic,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Epic  $epic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Epic $epic)
    {
        //
    }
}
