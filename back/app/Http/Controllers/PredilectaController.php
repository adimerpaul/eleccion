<?php

namespace App\Http\Controllers;

use App\Models\Predilecta;
use App\Http\Requests\StorePredilectaRequest;
use App\Http\Requests\UpdatePredilectaRequest;

class PredilectaController extends Controller{
    public function index(){ return Predilecta::all();}
    public function store(StorePredilectaRequest $request){ return Predilecta::create($request->all());}
    public function show($id){ return Predilecta::find($id);}
    public function update(UpdatePredilectaRequest $request, $id){
        $predilecta = Predilecta::find($id);
        $predilecta->update($request->all());
        return $predilecta;
    }
    public function destroy($id){
        $predilecta = Predilecta::find($id);
        $predilecta->delete();
        return $predilecta;
    }
}
