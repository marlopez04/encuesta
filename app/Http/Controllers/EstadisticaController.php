<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Encuestado;
use App\Encuesta;
use App\Area;
use App\Antiguedad;
use App\RangoEdad;
use App\Estudio;
use App\Sede;
use App\Sector;
use App\Genero;
use App\Contrato;
use App\Puesto;
use App\Item;

use App\Http\Requests;

class EstadisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $respuestas = DB::table('respuesta')
            ->select('respuesta.item_id', 'opcion.puntaje', DB::raw('count(respuesta.id)'))
            ->join('encuestado', 'encuestado.id', '=', 'respuesta.encuestado_id')
            ->join('opcion', 'opcion.id', '=', 'respuesta.opcion_id')
            ->groupBy('respuesta.item_id', 'opcion.puntaje')
            ->get();


        //cemaforo!!!!
        $favorabilidad = DB::select('select fav.item_id, fav.favorabilidad, sum(fav.cantidad) from (select r.item_id, opc.puntaje, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable"      when (opc.puntaje = 3) then "Neutro"      when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id where not r.item_id = 54 group By r.item_id, opc.puntaje ) fav group by fav.item_id, fav.favorabilidad');


        $sedefavorb = DB::select('select fav.sed, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 group By sd.descripcion, opc.puntaje ) fav group by fav.sed, fav.favorabilidad');

        $general = DB::select('select fav.favorabilidad, sum(fav.cantidad) from ( select sd.descripcion as sed, opc.puntaje, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 group By sd.descripcion, opc.puntaje ) fav group by fav.favorabilidad');

        $sedefavorbs = json_encode($sedefavorb);

        //en base a lo que se mande desde el front
        //armar una consulta concatenando el select, el where, y el group by

        //dd($favorabilidad);
        
        //dd($sedefavorbs);

        $encuestas = Encuesta::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $areas = Area::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $antiguedades = Antiguedad::orderBy('id', 'ASC')->lists('rango', 'id');
        $rangoedades = RangoEdad::orderBy('id', 'ASC')->lists('descripcion', 'id');
        $estudios = Estudio::orderBy('id', 'ASC')->lists('nivel', 'id');
        $sedes = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $sectores = Sector::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $generos = Genero::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $contratos = Contrato::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        $puestos = Puesto::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
        
        return view('encuesta.estadistica.index')
            ->with('encuestas',$encuestas)
            ->with('areas',$areas)
            ->with('antiguedades',$antiguedades)
            ->with('rangoedades',$rangoedades)
            ->with('estudios',$estudios)
            ->with('sedes',$sedes)
            ->with('sectores',$sectores)
            ->with('generos',$generos)
            ->with('puestos',$puestos)
            ->with('sedefavorbs',$sedefavorbs)
            ->with('contratos',$contratos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("hola");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sede()
    {

//todas las sedes separadas
        $sedefavorb = DB::select('select fav.sed, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 group By sd.descripcion, opc.puntaje ) fav group by fav.sed, fav.favorabilidad');

//total de todas las sedes
        $general = DB::select('select fav.favorabilidad as favorabilidad, case when (fav.favorabilidad ="Desfavorable") then 1 when (fav.favorabilidad ="Neutro") then 2 when (fav.favorabilidad ="Favorable") then 3 end as orden, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 group By sd.descripcion, opc.puntaje ) fav group by fav.favorabilidad order by orden');

        $sedetucumandb = DB::select('select fav.sed, fav.favorabilidad, case when (fav.favorabilidad ="Desfavorable") then 1 when (fav.favorabilidad ="Neutro") then 2 when (fav.favorabilidad ="Favorable") then 3 end as orden, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 and sd.id = 1 group By sd.descripcion, opc.puntaje ) fav group by fav.sed, fav.favorabilidad order by orden');

        //dd($sedetucumandb);

        $sedesaltadb = DB::select('select fav.sed, fav.favorabilidad, case when (fav.favorabilidad ="Desfavorable") then 1 when (fav.favorabilidad ="Neutro") then 2 when (fav.favorabilidad ="Favorable") then 3 end as orden, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 and sd.id = 2 group By sd.descripcion, opc.puntaje ) fav group by fav.sed, fav.favorabilidad order by orden');

        //dd($sedesaltadb);

        $sedechacodb = DB::select('select fav.sed, fav.favorabilidad, case when (fav.favorabilidad ="Desfavorable") then 1 when (fav.favorabilidad ="Neutro") then 2 when (fav.favorabilidad ="Favorable") then 3 end as orden, sum(fav.cantidad) as cantidad from ( select sd.descripcion as sed, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join sede sd on sd.id = en.sede_id where not r.item_id = 54 and sd.id = 3 group By sd.descripcion, opc.puntaje ) fav group by fav.sed, fav.favorabilidad order by orden');

        //dd($sedechacodb);


        $sedetotal = json_encode($general);
        $sedetucuman = json_encode($sedetucumandb);
        $sedesalta = json_encode($sedesaltadb);
        $sedechaco = json_encode($sedechacodb);

        $sedefavorbs = json_encode($sedefavorb);

        //en base a lo que se mande desde el front
        //armar una consulta concatenando el select, el where, y el group by

        //dd($favorabilidad);
        
        //dd($sedefavorbs);
       
        return view('encuesta.estadistica.sede')
            ->with('sedetotal',$sedetotal)
            ->with('sedetucuman',$sedetucuman)
            ->with('sedesalta',$sedesalta)
            ->with('sedechaco',$sedechaco)
            ->with('sedefavorbs',$sedefavorbs);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function torta()
    {
        return view('graftorta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function injecciondemo()
    {
        $variableDemog = 0;
        $titulo = 'Sede';

        if (isset($_GET['demografico'])) {
            $variableDemog = $_GET['demografico'];
            $titulo = $variableDemog;
        }

        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)


      $select = 'select sd.descripcion as descripcion, count(en.id) as cantidad ';
      $from = 'from encuestado en ';
      $join = 'inner join sede sd on sd.id = en.sede_id ';
      $group = 'group by sd.descripcion ';
      $order = 'order by sd.descripcion ';

      switch ($titulo) {
          case 'Sede':
                $join = 'inner join sede sd on sd.id = en.sede_id ';
              break;

          case 'Antiguedad':
                $select = 'select sd.rango as descripcion, count(en.id) as cantidad ';
                $join = 'inner join antiguedad sd on sd.id = en.antiguedad_id ';
                $group = 'group by sd.rango ';
                $order = 'order by sd.rango ';
              break;

          case 'Contrato':
                $join = 'inner join contrato sd on sd.id = en.contrato_id ';
              break;

          case 'Estudio':
                $select = 'select sd.nivel as descripcion, count(en.id) as cantidad ';
                $join = 'inner join estudio sd on sd.id = en.estudio_id ';
                $group = 'group by sd.nivel ';
                $order = 'order by sd.nivel ';
              break;

          case 'Genero':
                $join = 'inner join genero sd on sd.id = en.genero_id ';
              break;

          case 'Puesto':
                $join = 'inner join puesto sd on sd.id = en.puesto_id ';
              break;

          case 'Edad':
                $join = 'inner join rangoedad sd on sd.id = en.rangoedad_id ';
              break;
          case 'Sector':
                $join = 'inner join sector sd on sd.id = en.sector_id ';
              break;

          default:
              
              break;
      }


      $consulta = $select . $from . $join . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);
      
      //dd($consultadb);

      $datosO = $consultadb;

      $datos = json_encode($consultadb);

      //dd($datos);


      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);


      
            $titulo2 = $titulo;
            $datos2 = $datos;
            $datosO2 = $datosO;

            //dd($datos2);

            $html = view('encuesta.estadistica.injecciondemografico')
                    ->with('titulo2',$titulo2)
                    ->with('datos2',$datos2)
                    ->with('datosO2',$datosO2);

            return $html;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function demografico()
    {

        $titulo = 'Sede';
       
        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)

      $select = 'select sd.descripcion as descripcion, count(en.id) as cantidad ';
      $from = 'from encuestado en ';
      $join = 'inner join sede sd on sd.id = en.sede_id ';
      $group = 'group by sd.descripcion ';
      $order = 'order by sd.descripcion ';

      $consulta = $select . $from . $join . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;
      
      //dd($consultadb);

      $datos = json_encode($consultadb);

      //dd($datos);

      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

            return view('encuesta.estadistica.demografico')
                    ->with('demograficos',$demograficos)
                    ->with('titulo',$titulo)
                    ->with('datosO1',$datosO1)
                    ->with('datos',$datos);
        
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
