<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Encuestado;
use App\Respuesta;
use App\Item;
use App\Opcion;



class RespuestaController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $encuestado = Encuestado::find($id);
        $encuestado->load('area','antiguedad','rangoedad','estudio','sede','sector','genero','contrato','puesto');
        //$item = Item::find(1);
        $item = Item::where('encuesta_id',$encuestado->encuesta_id)->first();
        $opciones = Opcion::all();

//        dd($encuestado);

        return view('encuesta.respuesta.respuesta')
            ->with('encuestado',$encuestado)
            ->with('items',$items)
            ->with('opciones',$opciones);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encuestado = Encuestado::find($id);
        $encuestado->load('area','antiguedad','rangoedad','estudio','sede','sector','genero','contrato','puesto');
        //$items = Item::find(1);
        $items = Item::where('encuesta_id',$encuestado->encuesta_id)->first();
        $opciones = Opcion::all();

//        dd($encuestado);

        return view('encuesta.respuesta.respuesta')
            ->with('encuestado',$encuestado)
            ->with('items',$items)
            ->with('opciones',$opciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function respuesta($id,$id2)
    {
        // $id es de el encuestado
        // $id2 respuesta para saber en que pregunta quedo
      
        $encuestado = Encuestado::find($id);
        $encuestado->load('respuestas', 'respuestasmultiples');

        //$respuestasmultiples = RespuestaMultiple::where('encuestado_id',$id)->where('item_id',$id2)->get();

        $item = Item::find($id2);
        //$items = Item::all();
        $items = Item::where('encuesta_id',$encuestado->encuesta_id);
        //cantidad de preguntas para controlar si estan todas contestadas 20.11.2020
        $CantItems = Item::where('encuesta_id',$id)->count();
        $opt = $item->tipo_id;

        $opciones = Opcion::all();

        $PregOpc = 0;
        $cantidad = 0;

        //controlo si ya existe la respuesta y la actualizo
        $resp = Respuesta::where('encuestado_id',$id)
                           ->where('item_id',$id2)->first();
        $contestadas = Respuesta::where('encuestado_id',$id)->count();

        //dd($cantidad);
        
        //controlo que resp no este vacio
        if($resp <> null){
            //le asigno la opcion que se selecciono como respuesta
            //dd($resp->opcion_id);
            $PregOpc = $resp->opcion_id;

        }
        $encuestado1 = json_encode($encuestado);
        return view('encuesta.respuesta.respuesta')
            ->with('encuestado',$encuestado)
            ->with('encuestado1',$encuestado1)
            ->with('item',$item)
            ->with('PregOpc',$PregOpc)
            ->with('items',$items)
            ->with('CantItems',$CantItems)
            ->with('contestadas',$contestadas)
            ->with('opciones',$opciones);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
