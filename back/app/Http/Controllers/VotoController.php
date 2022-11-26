<?php

namespace App\Http\Controllers;

use App\Models\Predilecta;
use App\Models\User;
use App\Models\Voto;
use App\Http\Requests\StoreVotoRequest;
use App\Http\Requests\UpdateVotoRequest;
use Illuminate\Http\Request;

class VotoController extends Controller{
    public function resultados(){
        $predilectas = Predilecta::all();
        $usuarios = User::where('tipo','jurado')->get();

        foreach ($predilectas as $predilecta) {
            $total=0;
            $con=0;
            foreach ($usuarios as $usuario) {
                $con++;
                $bano = Voto::where('user_id', $usuario->id)->where('predilecta_id', $predilecta->id)->where('tipo','TRAJE DE BAÑO')->first();
                $gala = Voto::where('user_id', $usuario->id)->where('predilecta_id', $predilecta->id)->where('tipo','TRAJE DE GALA')->first();
                $fol = Voto::where('user_id', $usuario->id)->where('predilecta_id', $predilecta->id)->where('tipo','TRAJE DE FOLKLORICO')->first();
                $pre = Voto::where('user_id', $usuario->id)->where('predilecta_id', $predilecta->id)->where('tipo','PREGUNTAS')->first();
//                return $bano;
//                $predilecta['j'.$con]=$usuario->name;
                $predilecta['bano'.$con]=$bano==null||$bano->puntaje==''?0:$bano->puntaje;
                $predilecta['gala'.$con]=$gala==null||$gala->puntaje==''?0:$gala->puntaje;
                $predilecta['fol'.$con]=$fol==null||$fol->puntaje==''?0:$fol->puntaje;
                $predilecta['pre'.$con]=$pre==null||$pre->puntaje==''?0:$pre->puntaje;
                $total+=$bano==null||$bano->puntaje==''?0:$bano->puntaje;
                $total+=$gala==null||$gala->puntaje==''?0:$gala->puntaje;
                $total+=$fol==null||$fol->puntaje==''?0:$fol->puntaje;
                $total+=$pre==null||$pre->puntaje==''?0:$pre->puntaje;
            }
            $asi = Voto::where('user_id', 2)->where('predilecta_id', $predilecta->id)->where('tipo','ASISTENCIA')->first();
            $predilecta['asistencia']=$asi==null?0:$asi->puntaje;
            $total+=$asi==null||$asi->puntaje==''?0:$asi->puntaje;
            $predilecta['total']=$total;
        }
        return $predilectas;
    }
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
