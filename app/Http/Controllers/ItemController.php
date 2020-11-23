<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Encuestado;
use App\Respuesta;
use App\Item;
use App\Opcion;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('encuesta.respuesta.encuestafin');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $encuestado_id = $_GET['encuestado'];
        $pregunta_id = $_GET['pregunta'];
        $status = $_GET['status'];
        $opcion_id = $_GET['opcion'];

        $encuestado = Encuestado::find($encuestado_id);

        $opciones = Opcion::all();
        $items = Item::where('encuesta_id',$encuestado->encuesta_id)->get();
        //cantidad de preguntas para controlar si estan todas contestadas 20.11.2020
        $CantItems = Item::where('encuesta_id',$encuestado->encuesta_id)->count();
        //cantidad de preguntas multiples que tienen la encuesta, para habilitar o no habilitar el control de todas las opciones multiples finalizadas.
        $CantMulti = Item::where('tipo_id',$encuestado->encuesta_id)->count();

        $PregOpc = 0;
        $contestadas = 0;

        //dd($cantidad);

        //controlo si ya existe la respuesta y la actualizo
        $resp = Respuesta::where('encuestado_id',$encuestado_id)
                           ->where('item_id',$pregunta_id)->first();
        
        //controlo que resp no este vacio
        if($resp <> null){
            //cambio el status a 5 para que actualise la respuesta
            //que opcion sea igual a cero implica que fue elegida la pregunta desde un icono
            if ($opcion_id <> 0) {
                //respuesta igual a 
                $status = 5;
            }else{
                //que solo muestre la pregunta con el campo que fue contestado
                $status = 6;

            }
        }
        
        /*
        status
            - 1 sumar +1 $id
            - 2 restar -1 $id
            - 3 tomar el id que llega
            - 4 viene con la respuesta de esa pregunta
                debe guardar la respuesta y devolver la 
                siguiente pregunta
            - 5 actualiza la respuesta
            - 6 devuelve la pregunta con su respuesta (sin actualizar ni insertar nada)
        */

        switch ($status) {
            case '1':
                //mostrar la siguiente pregunta
                $id = $id + 1;
                $item = Item::find($id);

                break;
            case '2':
                //mostrar la pregunta anterior
                $id = $id - 1;
                $item = Item::find($id);
                break;
            case '3':
                //mostrar la pregunta del id que llego
                $item = Item::find($id);
                break;
            case '4':
                //grabar la respuesta
                $respuesta = new Respuesta();
                $respuesta->encuestado_id = $encuestado_id;
                $respuesta->item_id = $id;
                $respuesta->opcion_id = $opcion_id;
                $respuesta->save();

                //carga la siguiente pregunta
                $id = $id + 1;
                $item = Item::find($id);
                break;
            case '5':
                //Actualiza la respuesta
                $idresp = $resp->id;
                $respuesta = Respuesta::find($idresp);
                $respuesta->encuestado_id = $encuestado_id;
                $respuesta->item_id = $id;
                $respuesta->opcion_id = $opcion_id;
                $respuesta->save();

                //carga la siguiente pregunta
                $id = $id + 1;
                $item = Item::find($id);
                break;
            case '6':
                //Muestra la pregunta seleccionada
                $idresp = $resp->id;
                //recupera la respuesta
                $respuesta = Respuesta::find($idresp);
                //obtengo la opcion seleccionada para enviarla
                $PregOpc = $respuesta->opcion_id;
                //cargo la pregunta seleccionada
                $item = Item::find($id);
                break;
        }

        //recuperar en caso de existir, la respuesta del item

        $resp = Respuesta::where('encuestado_id',$encuestado_id)
                           ->where('item_id',$id)->first();

        if($resp <> null){
            $PregOpc = $resp->opcion_id;
        }

        $contestadas = Respuesta::where('encuestado_id',$encuestado_id)->count();
        
        //$encuestado->load('area','antiguedad','rangoedad','estudio','sede','sector','genero','contrato','puesto', 'respuestas', 'respuestasmultiples');
        $encuestado->load('respuestas', 'respuestasmultiples');

        $html = view('encuesta.respuesta.pregunta')
            ->with('encuestado',$encuestado)
            ->with('item',$item)
            ->with('PregOpc',$PregOpc)
            ->with('items',$items)
            //agregado 23.11.2020
            ->with('CantItems',$CantItems)
            ->with('CantMulti',$CantMulti)
            //agregado 23.11.2020
            ->with('contestadas',$contestadas)
            ->with('opciones',$opciones);

        return $html;
        
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
