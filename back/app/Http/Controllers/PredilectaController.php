<?php

namespace App\Http\Controllers;

use App\Models\Predilecta;
use App\Http\Requests\StorePredilectaRequest;
use App\Http\Requests\UpdatePredilectaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredilectaController extends Controller{
    public function index(){ return Predilecta::all();}
    public function predilectaVotos(Request $request){
        $id= $request->user()->id;
        return DB::select("
        SELECT *
,(
	CASE
    	WHEN (SELECT COUNT(*) FROM votos WHERE user_id=$id AND tipo='TRAJE DE BAÑO' AND votos.predilecta_id=predilectas.id)=0 THEN ''
    	else (SELECT puntaje FROM votos WHERE user_id=$id AND tipo='TRAJE DE BAÑO' AND votos.predilecta_id=predilectas.id)
    end
) bano,
(
	CASE
    	WHEN (SELECT COUNT(*) FROM votos WHERE user_id=$id AND tipo='TRAJE DE GALA' AND votos.predilecta_id=predilectas.id)=0 THEN ''
    	else (SELECT puntaje FROM votos WHERE user_id=$id AND tipo='TRAJE DE GALA' AND votos.predilecta_id=predilectas.id)
    end
) gala,
(
	CASE
    	WHEN (SELECT COUNT(*) FROM votos WHERE user_id=$id AND tipo='TRAJE DE FOLKLORICO' AND votos.predilecta_id=predilectas.id)=0 THEN ''
    	else (SELECT puntaje FROM votos WHERE user_id=$id AND tipo='TRAJE DE FOLKLORICO' AND votos.predilecta_id=predilectas.id)
    end
) fol,
(
	CASE
    	WHEN (SELECT COUNT(*) FROM votos WHERE user_id=$id AND tipo='PREGUNTAS' AND votos.predilecta_id=predilectas.id)=0 THEN ''
    	else (SELECT puntaje FROM votos WHERE user_id=$id AND tipo='PREGUNTAS' AND votos.predilecta_id=predilectas.id)
    end
) pre
FROM predilectas;
        ");

    }
    public function store(Request $request){
        $predilecta= Predilecta::create($request->all());
        $predilecta->nroBano=$predilecta->id;
        $predilecta->nroGala=$predilecta->id;
        $predilecta->nroFol=$predilecta->id;
        $predilecta->nroPre=$predilecta->id;
        $predilecta->save();
        return $predilecta;
    }
    public function show($id){ return Predilecta::find($id);}
    public function update(Request $request, $id){
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
