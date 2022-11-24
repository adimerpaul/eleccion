<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use App\Http\Requests\StoreVotoRequest;
use App\Http\Requests\UpdateVotoRequest;
use Illuminate\Http\Request;

class VotoController extends Controller{
    public function index(){ return Voto::all();}
    public function store(Request $request){
        $count=Voto::where('user_id',$request->user()->id)->where('tipo',$request->tipo)->where('predilecta_id',$request->predilecta_id)->count();
        if($count==0){
            $voto=new Voto();
            $voto->user_id=$request->user()->id;
            $voto->tipo=$request->tipo;
            $voto->predilecta_id=$request->predilecta_id;
            $voto->puntaje=$request->puntaje;
            $voto->save();
        }else{
            $voto=Voto::where('user_id',$request->user()->id)->where('tipo',$request->tipo)->where('predilecta_id',$request->predilecta_id)->first();

            $voto->puntaje=$request->puntaje==null?"":$request->puntaje;

            $voto->save();
            return $request;
        }
    }
    public function show($id){ return Voto::find($id);}
    public function update(Request $request, $id){
        $voto = Voto::find($id);
        $voto->update($request->all());
        return $voto;
    }
    public function destroy($id){
        $voto = Voto::find($id);
        $voto->delete();
        return $voto;
    }
}
