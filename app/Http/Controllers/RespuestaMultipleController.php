<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\RespuestaMultiple;
use App\Respuesta;


class RespuestaMultipleController extends Controller
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
        
        $respuestas = json_decode($request->input('datos'), true);

        //dd($respuestas);
        $encuestado_id = 0;

        $encuestado_id = $respuestas[0]['encuestado'];

        $contestadas = RespuestaMultiple::where('encuestado_id',$encuestado_id)->get();

        $pregunta_id = 54;
        $respCargada = Respuesta::where('encuestado_id',$encuestado_id)
                           ->where('item_id',$pregunta_id)->first();

        if ($respCargada <> null) {
            $idr = $respCargada->id;
            $resp = Respuesta::find($idr);
            $resp->delete();
        }

        if($contestadas <> null){
           foreach ($contestadas as $resp) {
            $id = $resp['id'];
            $respuest = RespuestaMultiple::find($id);
            $respuest->delete();
            }

        }else{
            dd("es null");
        }

        foreach ($respuestas as $respuesta) {
            //dd($respuesta['encuestado']);
            $respuestamultiple = new RespuestaMultiple();

            $respuestamultiple->encuestado_id = $respuesta['encuestado'];
            $respuestamultiple->item_id = $respuesta['pregunta'];
            $respuestamultiple->opcion_id = $respuesta['opcion'];
            $respuestamultiple->save();
            
        }

        //grabo una nueva respuesta
        $resp1 = new Respuesta();
        $resp1->encuestado_id = $respuesta['encuestado'];
        $resp1->item_id = $respuesta['pregunta'];
        $resp1->opcion_id = $respuesta['opcion'];        
        $resp1->save();

        //dd($contestadas);

        //falta grabar una respuesta simple, para controlar que estan todas las respuestas contestadas

        dd("grabado");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
