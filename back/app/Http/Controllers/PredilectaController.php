<?php

namespace App\Http\Controllers;

use App\Models\Predilecta;
use App\Http\Requests\StorePredilectaRequest;
use App\Http\Requests\UpdatePredilectaRequest;

class PredilectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorePredilectaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePredilectaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Predilecta  $predilecta
     * @return \Illuminate\Http\Response
     */
    public function show(Predilecta $predilecta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Predilecta  $predilecta
     * @return \Illuminate\Http\Response
     */
    public function edit(Predilecta $predilecta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePredilectaRequest  $request
     * @param  \App\Models\Predilecta  $predilecta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePredilectaRequest $request, Predilecta $predilecta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Predilecta  $predilecta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Predilecta $predilecta)
    {
        //
    }
}
