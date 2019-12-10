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
use App\Indice;
use App\Dimension;
use App\Factor;


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

          case 'Area':
                $join = 'inner join area sd on sd.id = en.area_id ';
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
        'Area' => 'Area',
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
        'Area' => 'Area',
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

    public function favorabilidaddemografico()
    {

        $titulo = 'Sede';
       
        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)


      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad';
      $from = ' from (select sd.descripcion as descripcion, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id';
      $join = ' inner join sede sd on sd.id = en.sede_id';
      $where = ' where not r.item_id = 54';
      $group =' group By sd.descripcion, opc.puntaje ) fav group by fav.descripcion, fav.favorabilidad';
      $order = ' order by fav.id ';


      $consulta = $select . $from . $join . $where . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      $demograficos = Sede::all();

      //dd($demograficos);
      
      //dd($consultadb);

      $demos= array();

      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($datosO1 as $dato) {
            if ($dato->id == $demografico->id) {
                $total += $dato->cantidad;
            }
        }

        array_push($demos,$total);
          
      }

      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);

      //dd($datos);

      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

            return view('encuesta.estadistica.favorabilidaddemografica')
                    ->with('demograficos',$demograficos)
                    ->with('titulo',$titulo)
                    ->with('datosO1',$datosO1)
                    ->with('demos',$demos)
                    ->with('demosO1',$demosO1)                    
                    ->with('datos',$datos);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function injeccionfavorabilidaddemo()
    {
        $variableDemog = 0;
        $titulo = 'Sede';

        if (isset($_GET['demografico'])) {
            $variableDemog = $_GET['demografico'];
            $titulo = $variableDemog;
        }

        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)


      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = ' from (';
      $select2 = 'select sd.descripcion as descripcion ,';
      $from2 = 'opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id ';
      $join = ' inner join sede sd on sd.id = en.sede_id';
      $where = ' where not r.item_id = 54';
      $group =' group By sd.descripcion,';
      $group2 = ' opc.puntaje ) fav group by fav.descripcion ,fav.favorabilidad';
      $order = ' order by fav.id ';


      switch ($titulo) {
          case 'Sede':
                $join = 'inner join sede sd on sd.id = en.sede_id ';
                $demograficos = Sede::all();
              break;

          case 'Antiguedad':
                $select2 = 'select sd.rango as descripcion ,';
                $join = 'inner join antiguedad sd on sd.id = en.antiguedad_id ';
                $group = 'group by sd.rango, ';
                      $demograficos = Antiguedad::all();
              break;

          case 'Area':
                $join = 'inner join area sd on sd.id = en.area_id ';
                $demograficos = Area::all();
              break;

          case 'Contrato':
                $join = 'inner join contrato sd on sd.id = en.contrato_id ';
                $demograficos = Contrato::all();
              break;

          case 'Estudio':
                $select2 = 'select sd.nivel as descripcion ,';
                $join = 'inner join estudio sd on sd.id = en.estudio_id ';
                $group = 'group by sd.nivel, ';
                $demograficos = Estudio::all();
              break;

          case 'Genero':
                $join = 'inner join genero sd on sd.id = en.genero_id ';
                $demograficos = Genero::all();
              break;

          case 'Puesto':
                $join = 'inner join puesto sd on sd.id = en.puesto_id ';
                $demograficos = Puesto::all();
              break;

          case 'Edad':
                $join = 'inner join rangoedad sd on sd.id = en.rangoedad_id ';
                $demograficos = RangoEdad::all();
              break;
          case 'Sector':
                $join = 'inner join sector sd on sd.id = en.sector_id ';
                $demograficos = Sector::all();
              break;

          default:
              
              break;
      }


      $consulta = $select . $from . $select2 . $from2 . $join . $group . $group2 . $order;

    //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;


      //dd($demograficos);

      //dd($consulta);
      
      //dd($consultadb);

      $demos= array();

      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($datosO1 as $dato) {
            if ($dato->id == $demografico->id) {
                $total += $dato->cantidad;
            }
        }

        array_push($demos,$total);
          
      }

      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);

//nuevo codigo <-------------------------

      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            $titulo2 = $titulo;
            $datos2 = $datos;
            $demos2 = $demos;
            $datosO2 = $datosO1;
            $demosO2 = $demosO1;



            //dd($datosO2);
            //dd($datosO2);


            $html = view('encuesta.estadistica.injeccionfavorabilidaddemo')
                    ->with('titulo2',$titulo2)
                    ->with('datos2',$datos2)
                    ->with('datosO2',$datosO2)
                    ->with('demos2',$demos2)
                    ->with('demosO2',$demosO2);

            return $html;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function indicedimensionfactor()
    {

        $titulo = 'Indice';
       
        //dd($titulo);

      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = 'from (select sd.descripcion as descripcion, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id ';
      $join = 'inner join indice sd on sd.id = rl.indice_id ';
      $group = 'group by sd.descripcion, opc.puntaje) fav group by fav.descripcion ,fav.favorabilidad order by fav.id';


      $consulta = $select . $from . $join . $group;

      //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      $demograficos = Indice::all();

      //dd($demograficos);
      
      //dd($consultadb);

      $demos= array();

      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($datosO1 as $dato) {
            if ($dato->id == $demografico->id) {
                $total += $dato->cantidad;
            }
        }

        array_push($demos,$total);
          
      }

      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);

      //dd($datos);

      $demograficos = array('Indice' => 'Indice',
        'Dimension' => 'Dimension',
        'Factor' => 'Factor');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

            return view('encuesta.estadistica.indicedimensionfactor')
                    ->with('demograficos',$demograficos)
                    ->with('titulo',$titulo)
                    ->with('datosO1',$datosO1)
                    ->with('demos',$demos)
                    ->with('demosO1',$demosO1)                    
                    ->with('datos',$datos);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function injeccionindicedimensionfactor()
    {
        $variableDemog = 0;
        $titulo = 'Indice';

        if (isset($_GET['demografico'])) {
            $variableDemog = $_GET['demografico'];
            $titulo = $variableDemog;
        }

        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)

      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = 'from (select sd.descripcion as descripcion, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id ';
      $join = 'inner join indice sd on sd.id = rl.indice_id ';
      $group = 'group by sd.descripcion, opc.puntaje) fav group by fav.descripcion ,fav.favorabilidad order by fav.id';


      switch ($titulo) {
          case 'Indice':
                $join = 'inner join indice sd on sd.id = rl.indice_id ';
                $demograficos = Indice::all();
              break;
          case 'Dimension':
                $join = 'inner join dimensions sd on sd.id = rl.dimension_id ';
                $demograficos = Dimension::all();
              break;

          case 'Factor':
                $join = 'inner join factors sd on sd.id = rl.factor_id ';
                $demograficos = Factor::all();
              break;

          default:
              
              break;
      }


      $consulta = $select . $from . $join . $group;

    //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      //dd($demograficos);

      //dd($consulta);
      
      //dd($consultadb);

      $demos= array();

      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($datosO1 as $dato) {
            if ($dato->id == $demografico->id) {
                $total += $dato->cantidad;
            }
        }

        array_push($demos,$total);
          
      }

      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);

      $demograficos = array('Indice' => 'Indice',
        'Dimension' => 'Dimension',
        'Factor' => 'Factor');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            $titulo2 = $titulo;
            $datos2 = $datos;
            $demos2 = $demos;
            $datosO2 = $datosO1;
            $demosO2 = $demosO1;

            //dd($datosO2);
            //dd($datosO2);

            $html = view('encuesta.estadistica.injeccionfavorabilidaddemo')
                    ->with('titulo2',$titulo2)
                    ->with('datos2',$datos2)
                    ->with('datosO2',$datosO2)
                    ->with('demos2',$demos2)
                    ->with('demosO2',$demosO2);

            return $html;

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
