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
use App\Opcion;
use App\ObjetoOrden;
use App\ObjetoOrdenDos;

//TODO: agregar filtro de 

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

      return redirect()->route('estadistica.sede');

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
    public function sede($id)
    {
        //variable para definir que boton del menu esta
        //seleccionado
        $menuitem = 0;

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

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin
       
        return view('encuesta.estadistica.sede')
            //agregado 20201005 inicio
            ->with('encuestas',$encuestas)
            //agregado 20201005 fin
            ->with('menuitem',$menuitem)
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


      $select = 'select sd.id as id, sd.descripcion as descripcion, count(en.id) as cantidad ';
      $from = 'from encuestado en ';
      $join = 'inner join sede sd on sd.id = en.sede_id ';
      $group = 'group by sd.descripcion ';
      $order = 'order by sd.id ';

      switch ($titulo) {
          case 'Sede':
                $join = 'inner join sede sd on sd.id = en.sede_id ';
                $demograficos = Sede::all();
              break;

          case 'Antiguedad':
                $select = 'select sd.rango as descripcion, count(en.id) as cantidad ';
                $join = 'inner join antiguedad sd on sd.id = en.antiguedad_id ';
                $group = 'group by sd.rango ';
                $demograficos = Antiguedad::all();
                
              break;

          case 'Contrato':
                $join = 'inner join contrato sd on sd.id = en.contrato_id ';
                $demograficos = Contrato::all();
              break;

          case 'Area':
                $join = 'inner join area sd on sd.id = en.area_id ';
                $demograficos = Area::all();
              break;

          case 'Estudio':
                $select = 'select sd.nivel as descripcion, count(en.id) as cantidad ';
                $join = 'inner join estudio sd on sd.id = en.estudio_id ';
                $group = 'group by sd.nivel ';
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


      $consulta = $select . $from . $join . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);
      
      //dd($consultadb);

      $dats = $consultadb;

      $datosO = $consultadb;

      //dd($datosO);

      //AQUI

      $datos = json_encode($consultadb);


      //dd($datos);

//<---------- agregado para orden por % INICIO ------>


    if ($titulo == 'Edad' || $titulo == 'Antiguedad' || $titulo == 'Estudio' ) {

          $ArrayOrdenID = collect($dats)->sortBy('id')->all();
        
      }else{

          $ArrayOrdenID = collect($dats)->sortByDesc('cantidad')->all();

      }

      //dd($ArrayOrdenID);

      //$datosO = $ArrayOrdenID;

      //$datos00 = $ArrayOrdenID->toJson();

      //$datos = json_encode($ArrayOrdenID);

      //dd($datos);

      //$datos000 = (array) $ArrayOrdenID;

      //$datos000 = json_decode(json_encode($ArrayOrdenID), true);

      //$datos001 = json_encode($datos000);


      //dd($datos001);

      //$datos001 = str_replace ( '[' , '{', $datos000);

      //$datos001 = substr($datos000,0,-1)."o";
      //$datos001 = substr($datos000,1);
      //dd($datos001);

      //$datos ='[' . substr($datos001,0,-1) . ']';

      //dd($datos);

//      $datos = str_replace ( ']' , '}', $datos001);

//      $datos001 = substr($datos000,0,-1)."o";

      //dd($datos);

//<---------- agregado para orden por % FIN ------>


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
    public function demografico($id)
    {

        $menuitem = 1;
        
        $titulo = 'Sede';
       
        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)

      $select = 'select sd.descripcion as descripcion, count(en.id) as cantidad ';
      $from = 'from encuestado en ';
      $join = 'inner join sede sd on sd.id = en.sede_id ';
      $group = 'group by sd.descripcion ';
      $order = 'order by sd.id ';

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

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin

            return view('encuesta.estadistica.demografico')
                //agregado 20201005 inicio
                    ->with('encuestas',$encuestas)
                //agregado 20201005 fin
                    ->with('menuitem',$menuitem)
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

    public function favorabilidaddemografico($id)
    {

        $menuitem = 2;

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

      //dd($datosO1);

      $demograficos = Sede::all();

      //dd($demograficos);
      
      //dd($consultadb);

      $demos= array();

      //foreach ($demograficos as $demografico) {
      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($datosO1 as $dato) {
            if ($dato->id == $demografico->id) {
                $total += $dato->cantidad;
            }
        }

        array_push($demos,$total);
          
      }

//<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % INICIO

      //ordenado de datos prueba 2 ordenar el objeto

      //objeto temporar para array
      
      //array de objetos con porcentajes 
      $porcentualOrdenado = array();

      $item = 0;

      foreach ($demograficos as $demografico) {

        foreach ($datosO1 as $dato){

          if ($dato->id == $demografico->id) {

            $datosOrdenados = new ObjetoOrden();

            //calculo el porcentaje de cada uno
            
            $porcentage = round(($dato->cantidad * 100) / $demos[$item],1);

            $datosOrdenados->id = $dato->id;
            $datosOrdenados->descripcion = $dato->descripcion;
            $datosOrdenados->favorabilidad = $dato->favorabilidad;
            $datosOrdenados->cantidad = $dato->cantidad;
            $datosOrdenados->porcentage = $porcentage;

            //lo guardo en un objeto y le hago un push al array de objeto

            array_push($porcentualOrdenado,$datosOrdenados);

          }

        }
        $item++;
      }

      //dd($porcentualOrdenado);

      //ahora debo extraer todos los datos favorables, y de no teneer, debo insertar un registro con el id y favorabilidad = 0

      //$variableDOrden = new ObjetoOrden();

      //array de objetos con porcentajes 

      $IdOrdenados = array();

      //recorro demografico y porcentajeOrdenado para armar un arreglo solo de favorables por cada demografico para poder ordenarlo a posterior
      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($porcentualOrdenado as $orden) {
            
            if ($demografico->id == $orden->id) {
              $variableDOrden = new ObjetoOrden();
              $variableDemog = $orden;

              if ($orden->favorabilidad == "Favorable" && $total == 0) {
                $total = $orden->porcentage;

              }
            }

        }

        if ($total == 0) {

          $variableDemog->porcentage = 0;
          $variableDemog->favorabilidad = "Favorable";

          array_push($IdOrdenados,$variableDemog);
        }else{

          $variableDemog->porcentage = $total;
          $variableDemog->favorabilidad = "Favorable";

          array_push($IdOrdenados,$variableDemog);
        }
      }
       
      //dd($IdOrdenados);

      //$IdOrdenados->asort();
      
      //de los favorables con porcentaje ordeno por % de mayor a menor

      $ArrayOrdenID = collect($IdOrdenados)->sortByDesc('porcentage')->all();

      //dd($ArrayOrdenID);      

//armos estos dos array que son los que van a dar datos al grafico INICIO

      $porcentages00= array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($porcentages00,$orden->porcentage);
      }

      $porcentages = json_encode($porcentages00);

      //dd($porcentages);

      $descripcion00 = array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($descripcion00,$orden->descripcion);
      }

      $descripcion = json_encode($descripcion00);

      //dd($descripcion);

//armos estos dos array que son los que van a dar datos al grafico FIN

//<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % FIN

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

      $demograficos2 = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin

            return view('encuesta.estadistica.favorabilidaddemografica')
                  //agregado 20201005 inicio
                    ->with('encuestas',$encuestas)
                  //agregado 20201005 fin
                    ->with('menuitem',$menuitem)
                    ->with('ArrayOrdenID',$ArrayOrdenID)
                    ->with('demograficos',$demograficos)
                    ->with('demograficos2',$demograficos2)
                    ->with('porcentages',$porcentages)
                    ->with('descripcion',$descripcion)
                    ->with('titulo',$titulo);
                    /*
                    ->with('datosO1',$datosO1)
                    ->with('demos',$demos)
                    ->with('demosO1',$demosO1)
                    ->with('datos',$datos);
                    */
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

        $primario = array();
        $secundario = array();

        if (isset($_GET['demografico1'])) {
            $variableDemog = $_GET['demografico1'];
            $titulo = $variableDemog;

            //traigo los filtros secundarios
            $demog1 = $_GET['demografico1'];
            $demog3 = $_GET['demografico3'];
            $demog4 = $_GET['demografico4'];
            $demog6 = $_GET['demografico6'];

            //los cargo en un arreglo
            if ($demog3 != "todos") {
              array_push($primario,$demog1);
              array_push($secundario,$demog3);
            }
            
            //controlo que los demograficos 1 y 4 sean distintos

            if ($demog1 != $demog4 && $demog6 != "todos"){
              array_push($primario,$demog4);
              array_push($secundario,$demog6);
            }
              
        }

        //$demoss = $demog1 . ' ' . $demog3 . ' ' . $demog4 . ' ' . $demog6;

        //dd($demoss);

        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)


      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = ' from (';
      $select2 = 'select sd.descripcion as descripcion ,';
      $from2 = 'opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id ';
      $join = ' inner join sede sd on sd.id = en.sede_id';
      $where = ' where not r.item_id = 54';
      $group =' group By sd.descripcion,';
      $group2 = ' opc.puntaje ) fav group by fav.descripcion ,fav.favorabilidad ';
      $order = ' order by fav.id ';


      switch ($titulo) {
          case 'Sede':
                $join = 'inner join sede sd on sd.id = en.sede_id ';
                $demograficos = Sede::all();
              break;

          case 'Antiguedad':
                $select2 = 'select sd.rango as descripcion ,';
                $join = 'inner join antiguedad sd on sd.id = en.antiguedad_id ';
                $group = ' group by sd.rango, ';
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
                $group = ' group by sd.nivel, ';
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


$max =sizeof($primario);

$join2 = ' ';
$where2 = ' ';

$countwhere = 0;

for ($i=0; $i < $max; $i++) { 

      // filtro secundario que solo agrega filtros
      switch ($primario[$i]) {
          case 'Sede':
                $join2 = $join2 .' inner join sede filt'.$i.' on filt'.$i.'.id = en.sede_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Antiguedad':
                $join2 = $join2 .' inner join antiguedad filt'.$i.' on filt'.$i.'.id = en.antiguedad_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Area':
                $join2 = $join2 .' inner join area filt'.$i.' on filt'.$i.'.id = en.area_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Contrato':
                $join2 = $join2 .' inner join contrato filt'.$i.' on filt'.$i.'.id = en.contrato_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Estudio':
                $join2 = $join2 .' inner join estudio filt'.$i.' on filt'.$i.'.id = en.estudio_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Genero':
                $join2 = $join2 .' inner join genero filt'.$i.' on filt'.$i.'.id = en.genero_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Puesto':
                $join2 = $join2 .' inner join puesto filt'.$i.' on filt'.$i.'.id = en.puesto_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Edad':
                $join2 = $join2 .' inner join rangoedad filt'.$i.' on filt'.$i.'.id = en.rangoedad_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;
          case 'Sector':
                $join2 = $join2 .' inner join sector filt'.$i.' on filt'.$i.'.id = en.sector_id ';
                if ($countwhere > 0) {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          default:
              
              break;
      }

  
}




      $consulta = $select . $from . $select2 . $from2 . $join . $join2 . $where . $where2 . $group .  $group2 . $order;

    //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      //dd($datosO1);

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

      //dd($demograficos);

      //dd($datosO1);

//nuevo orden INICIO

      $encuestados2 = $this->Encuestados($demog1,$demog3, $demog4, $demog6, $titulo);




      $cantencuest = json_encode($encuestados2);


      $ArrayOrdenID = $this->ordenar($demograficos,$demos, $datosO1, $titulo);

      //dd($ArrayOrdenID);

//armos estos dos array que son los que van a dar datos al grafico INICIO

      $porcentages00= array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($porcentages00,$orden->porcentage);
      }

      $porcentages = json_encode($porcentages00);

      //dd($porcentages);

      $maximo = sizeof($encuestados2);
      $descpn = "NO";

      //dd($maximo);
      $descripcion00 = array();
      foreach ($ArrayOrdenID as $orden) {

        for ($i=0; $i < $maximo ; $i++) { 

          if ($encuestados2[$i]->id == $orden->id) {

            if ($encuestados2[$i]->encuestados > 2) {
                  array_push($descripcion00,$orden->descripcion);
              }else{

                  array_push($descripcion00,$descpn);
              }

          }
          
        }
    
      }
  
/*
      $descripcion00 = array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($descripcion00,$orden->descripcion);
      }
*/

      $descripcion = json_encode($descripcion00);


      //dd($descripcion);
      //dd($encuestados2);
      //dd($porcentages);
      //dd($ArrayOrdenID);

      //correct

//armos estos dos array que son los que van a dar datos al grafico FIN

//nuevo orden FIN

      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);


//correccion de total inicio


      $select2 = 'select count(en.id) as id from encuestado en ';

      //declaro un where4 que no filtra nada, para poder concatenar where2 y where3 sin problemas
      $where4 = ' where not en.id = 0';

      if ($demog3 == 'todos') {
          //no debe filtrar por el primario

        if ($demog6 == 'todos') {
          //no debe ablicar filtros
          $consulta2 = $select2 ;
          
        }else{
          $consulta2 = $select2 . $join2 . $where4 . $where2;

        }
        
      }else{
        $consulta2 = $select2 . $join2 . $where4 . $where2;
      }

      //$consulta2 = $select . $join2 . $join3 . $where4 . $where2 . $where3;

      //dd($consulta2);

      $consultadb2 = DB::select($consulta2);

      //dd("valor que trae: " . $consultadb2[0]->id);

      $encuestados = $consultadb2[0]->id;

//correccion de total fin


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

            $ArrayOrdenID2 = $ArrayOrdenID;
            $porcentages2 = $porcentages;
            $descripcion2 = $descripcion;

            //dd($ArrayOrdenID2);



            //dd($datosO2);
            //dd($datosO2);


            $html = view('encuesta.estadistica.injeccionfavorabilidaddemo')
                    ->with('titulo2',$titulo2)
                    ->with('encuestados',$encuestados)
                    ->with('encuestados2',$encuestados2)
                    ->with('ArrayOrdenID2',$ArrayOrdenID2)
                    ->with('porcentages2',$porcentages2)
                    ->with('descripcion2',$descripcion2)
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

    public function indicedimensionfactor($id)
    {

        $menuitem = 3;
        
        $titulo = 'Indice';
       
        //dd($titulo);

      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = 'from (select sd.descripcion as descripcion, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id ';
      $join = 'inner join indice sd on sd.id = rl.indice_id ';
        //quito la pregunta 54 por que es la pregunta multiple
      $where = ' where not r.item_id = 54';
      $group = ' group by sd.descripcion, opc.puntaje) fav group by fav.descripcion ,fav.favorabilidad order by fav.id';


      $consulta = $select . $from . $join . $where . $group;

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


//nuevo orden INICIO

      $ArrayOrdenID = $this->ordenar($demograficos,$demos, $datosO1, $titulo);

      //dd($ArrayOrdenID);

//armos estos dos array que son los que van a dar datos al grafico INICIO

      $porcentages00= array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($porcentages00,$orden->porcentage);
      }

      $porcentages = json_encode($porcentages00);

      //dd($porcentages);

      $descripcion00 = array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($descripcion00,$orden->descripcion);
      }

      $descripcion = json_encode($descripcion00);

      //dd($descripcion);

//armos estos dos array que son los que van a dar datos al grafico FIN

//nuevo orden FIN


      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);

      //dd($datos);

      $indicadores = array('Indice' => 'Indice',
        'Dimension' => 'Dimension',
        'Factor' => 'Factor');

      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      $demograficos2 = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin

            return view('encuesta.estadistica.indicedimensionfactor')
                //agregado 20201005 inicio
                    ->with('encuestas',$encuestas)
                //agregado 20201005 fin
                    ->with('menuitem',$menuitem)
                    ->with('indicadores',$indicadores)
                    ->with('demograficos',$demograficos)
                    ->with('demograficos2',$demograficos2)
                    ->with('titulo',$titulo)
                    ->with('ArrayOrdenID',$ArrayOrdenID)
                    ->with('porcentages',$porcentages)
                    ->with('descripcion',$descripcion)
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

        $primario = array();
        $secundario = array();

        if (isset($_GET['indicador'])) {
            $variableDemog = $_GET['indicador'];
            $titulo = $variableDemog;
            $indicador = $_GET['indicador'];

            //traigo los filtros secundarios
            $demog1 = $_GET['demografico1'];
            $demog3 = $_GET['demografico3'];
            $demog4 = $_GET['demografico4'];
            $demog6 = $_GET['demografico6'];

            //los cargo en un arreglo
            if ($demog3 != "todos") {

              array_push($primario,$demog1);
              array_push($secundario,$demog3);
            }
            

            //controlo que los demograficos 1 y 4 sean distintos

            if ($demog1 != $demog4 && $demog6 != "todos"){
              array_push($primario,$demog4);
              array_push($secundario,$demog6);
              
            }

        }

        //$demoss = $demog1 . ' ' . $demog3 . ' ' . $demog4 . ' ' . $demog6 . ' '. $indicador;

        //dd($demoss);

        //dd($titulo);
      
      //asignar a variable el tipo de peticion (ajax / ruta comun)

      $select = 'select fav.descripcion, fav.favorabilidad, fav.id, sum(fav.cantidad) as cantidad ';
      $from = 'from (select sd.descripcion as descripcion, opc.puntaje, sd.id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id ';
      $join = 'inner join indice sd on sd.id = rl.indice_id ';
        //quito la pregunta 54 por que es la pregunta multiple
      $where = ' where not r.item_id = 54';
      $group = ' group by sd.descripcion, opc.puntaje) fav group by fav.descripcion ,fav.favorabilidad order by fav.id';


    //Filtro primario que define lo que se muestra
      switch ($titulo) {
          case 'Indice':
                $join = ' inner join indice sd on sd.id = rl.indice_id ';
                $demograficos = Indice::all();
              break;
          case 'Dimension':
                $join = ' inner join dimensions sd on sd.id = rl.dimension_id ';
                $demograficos = Dimension::all();
              break;

          case 'Factor':
                $join = ' inner join factors sd on sd.id = rl.factor_id ';
                $demograficos = Factor::all();
              break;

          default:
              
              break;
      }

$max =sizeof($primario);

$join2 = ' ';
$where2 = ' ';

$countwhere = 0;

for ($i=0; $i < $max; $i++) { 

      // filtro secundario que solo agrega filtros
      switch ($primario[$i]) {
          case 'Sede':
                $join2 = $join2 .' inner join sede filt'.$i.' on filt'.$i.'.id = en.sede_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                
              break;

          case 'Antiguedad':
                $join2 = $join2 .' inner join antiguedad filt'.$i.' on filt'.$i.'.id = en.antiguedad_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Area':
                $join2 = $join2 .' inner join area filt'.$i.' on filt'.$i.'.id = en.area_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Contrato':
                $join2 = $join2 .' inner join contrato filt'.$i.' on filt'.$i.'.id = en.contrato_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Estudio':
                $join2 = $join2 .' inner join estudio filt'.$i.' on filt'.$i.'.id = en.estudio_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Genero':
                $join2 = $join2 .' inner join genero filt'.$i.' on filt'.$i.'.id = en.genero_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Puesto':
                $join2 = $join2 .' inner join puesto filt'.$i.' on filt'.$i.'.id = en.puesto_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          case 'Edad':
                $join2 = $join2 .' inner join rangoedad filt'.$i.' on filt'.$i.'.id = en.rangoedad_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;
          case 'Sector':
                $join2 = $join2 .' inner join sector filt'.$i.' on filt'.$i.'.id = en.sector_id ';

                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];

                $countwhere++;
                
              break;

          default:
              
              break;
      }

}

      $consulta = $select . $from . $join . $join2 . $where2 .  $group ;

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


//nuevo orden INICIO

      $encuestados2 = $this->Encuestados($demog1,$demog3, $demog4, $demog6, $titulo);

      $cantencuest = json_encode($encuestados2);

      //dd($encuestados2);

      $ArrayOrdenID = $this->ordenar($demograficos,$demos, $datosO1, $titulo);

      //dd($ArrayOrdenID);


//armos estos dos array que son los que van a dar datos al grafico INICIO

      $porcentages00= array();
      $maximo = sizeof($encuestados2);

      //dd($maximo);

      foreach ($ArrayOrdenID as $orden) {

            array_push($porcentages00,$orden->porcentage);
    
      }

      $porcentages = json_encode($porcentages00);

      //dd($porcentages);

      $descripcion00 = array();
      foreach ($ArrayOrdenID as $orden) {
        array_push($descripcion00,$orden->descripcion);
      }

      $descripcion = json_encode($descripcion00);

      //dd($descripcion);

//armos estos dos array que son los que van a dar datos al grafico FIN

//nuevo orden FIN



      //dd($demos);

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $demosO1 = json_encode($demos);


//correccion de total inicio


      $select2 = 'select count(en.id) as id from encuestado en ';

      //declaro un where4 que no filtra nada, para poder concatenar where2 y where3 sin problemas
      $where4 = ' where not en.id = 0';

      if ($demog3 == 'todos') {
          //no debe filtrar por el primario

        if ($demog6 == 'todos') {
          //no debe ablicar filtros
          $consulta2 = $select2 ;
          
        }else{
          $consulta2 = $select2 . $join2 . $where4 . $where2;

        }
        
      }else{
        $consulta2 = $select2 . $join2 . $where4 . $where2;
      }

      //$consulta2 = $select . $join2 . $join3 . $where4 . $where2 . $where3;

      //dd($consulta2);

      $consultadb2 = DB::select($consulta2);

      //dd("valor que trae: " . $consultadb2[0]->id);

      $encuestados = $consultadb2[0]->id;

      //correccion de total fin



      $demograficos = array('Indice' => 'Indice',
        'Dimension' => 'Dimension',
        'Factor' => 'Factor');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            $titulo2 = $titulo;
            $datos2 = $datos;
            $demos2 = $demos;
            $datosO2 = $datosO1;
            $demosO2 = $demosO1;

            $ArrayOrdenID2 = $ArrayOrdenID;
            $porcentages2 = $porcentages;
            $descripcion2 = $descripcion;

            //dd($datosO2);
            //dd($datosO2);

            $html = view('encuesta.estadistica.injeccionindicedimensionfactor')
                    ->with('titulo2',$titulo2)
                    ->with('encuestados',$encuestados)
                    ->with('encuestados2',$encuestados2)
                    ->with('cantencuest',$cantencuest)
                    ->with('ArrayOrdenID2',$ArrayOrdenID2)
                    ->with('porcentages2',$porcentages2)
                    ->with('descripcion2',$descripcion2)
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

    public function multiple($id)
    {

        $menuitem = 4;

        $titulo = 'Indice';
       
        //dd($titulo);

        $select = 'select opc.opcion as descripcion, opc.id as id, count(r.id) as cantidad';
        $from = ' from respuestamultiple r';
        $join = ' inner join opcion opc on opc.id = r.opcion_id inner join encuestado en on en.id = r.encuestado_id';
        $join2 = ' inner join sede dm on dm.id = en.sede_id';
        $where = ' where r.item_id = 54';
        $where2 = ' and dm.id = 1';
        $group = ' group by opc.id, opc.opcion';
        $order = ' order by cantidad desc';


      //$consulta = $select . $from . $join . $join2 . $where . $where2. $group . $order;
      $consulta = $select . $from . $join . $where . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $total = Encuestado::all()->count();


      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      $demograficos2 = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin

            return view('encuesta.estadistica.multiple')
                  //agregado 20201005 inicio
                    ->with('encuestas',$encuestas)
                  //agregado 20201005 fin
                    ->with('menuitem',$menuitem)
                    ->with('demograficos',$demograficos)
                    ->with('demograficos2',$demograficos2)
                    ->with('titulo',$titulo)
                    ->with('total',$total)
                    ->with('datosO1',$datosO1)
                    ->with('datos',$datos);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function injeccionmultiple()
    {

        $menuitem = 4;

        $variableDemog = 0;
        $titulo = 'Indice';

        $primario = array();
        $secundario = array();

        if (isset($_GET['demografico1'])) {
            $variableDemog = $_GET['demografico1'];
            $titulo = $variableDemog;

            //traigo los filtros secundarios
            $demog1 = $_GET['demografico1'];
            $demog3 = $_GET['demografico3'];
            $demog4 = $_GET['demografico4'];
            $demog6 = $_GET['demografico6'];
           
            //controlo que los demograficos 1 y 4 sean distintos

            if ($demog1 != $demog4 && $demog6 != "todos"){
              array_push($primario,$demog4);
              array_push($secundario,$demog6);
            }
              
        }

       
        //dd($titulo);

        //consulta para los datos

        $select = 'select opc.opcion as descripcion, opc.id as id, count(r.id) as cantidad';
        $from = ' from respuestamultiple r';
        $join = ' inner join opcion opc on opc.id = r.opcion_id inner join encuestado en on en.id = r.encuestado_id';
        $where = ' where item_id = 54';
        $where2 = ' ';
        $group = ' group by opc.id, opc.opcion';
        $order = ' order by cantidad desc';

      switch ($titulo) {
          case 'Sede':
                $join2 = ' inner join sede dm on dm.id = en.sede_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Antiguedad':
                $join2 = ' inner join antiguedad dm on dm.id = en.antiguedad_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }

              break;

          case 'Area':
                $join2 = ' inner join area dm on dm.id = en.area_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Contrato':
                $join2 = ' inner join contrato dm on dm.id = en.contrato_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Estudio':
                $join2 = ' inner join estudio dm on dm.id = en.estudio_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Genero':
                $join2 = ' inner join genero dm on dm.id = en.genero_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Puesto':
                $join2 = ' inner join puesto dm on dm.id = en.puesto_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Edad':
                $join2 = ' inner join rangoedad dm on dm.id = en.rangoedad_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;
          case 'Sector':
                $join2 = ' inner join sector dm on dm.id = en.sector_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          default:
              
              break;
      }


$max =sizeof($primario);

$join3 = ' ';
$where3 = ' ';

$countwhere = 0;

for ($i=0; $i < $max; $i++) { 

      // filtro secundario que solo agrega filtros
      switch ($primario[$i]) {
          case 'Sede':
                $join3 = $join3 .' inner join sede filt'.$i.' on filt'.$i.'.id = en.sede_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Antiguedad':
                $join3 = $join3 .' inner join antiguedad filt'.$i.' on filt'.$i.'.id = en.antiguedad_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Area':
                $join3 = $join3 .' inner join area filt'.$i.' on filt'.$i.'.id = en.area_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Contrato':
                $join3 = $join3 .' inner join contrato filt'.$i.' on filt'.$i.'.id = en.contrato_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Estudio':
                $join3 = $join3 .' inner join estudio filt'.$i.' on filt'.$i.'.id = en.estudio_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Genero':
                $join3 = $join3 .' inner join genero filt'.$i.' on filt'.$i.'.id = en.genero_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Puesto':
                $join3 = $join3 .' inner join puesto filt'.$i.' on filt'.$i.'.id = en.puesto_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Edad':
                $join3 = $join3 .' inner join rangoedad filt'.$i.' on filt'.$i.'.id = en.rangoedad_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;
          case 'Sector':
                $join3 = $join3 .' inner join sector filt'.$i.' on filt'.$i.'.id = en.sector_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          default:
              
              break;
      }

}


      $consulta = $select . $from . $join . $join2 . $join3 . $where . $where2 . $where3 . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);


      $datosO1 = $consultadb;


      $datos = json_encode($consultadb);

//correccion de total inicio


      $select2 = 'select count(en.id) as id from encuestado en ';

      //declaro un where4 que no filtra nada, para poder concatenar where2 y where3 sin problemas
      $where4 = ' where not en.id = 0';

      if ($demog3 == 'todos') {
          //no debe filtrar por el primario

        if ($demog6 == 'todos') {
          //no debe ablicar filtros
          $consulta2 = $select2 ;
          
        }else{
          $consulta2 = $select2 . $join2 . $join3 . $where4 . $where2 . $where3;

        }
        
      }else{
        $consulta2 = $select2 . $join2 . $join3 . $where4 . $where2 . $where3;
      }

      //$consulta2 = $select . $join2 . $join3 . $where4 . $where2 . $where3;

      //dd($consulta2);

      $consultadb2 = DB::select($consulta2);

      //dd($consultadb2[0]->id);

      $total = $consultadb2[0]->id;

      $encuestados = $total;

//correccion de total fin


      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      $demograficos2 = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');

      $titulo2 = $titulo;
      $datos2 = $datos;
      $datosO2 = $datosO1;
      $total2 = $total;

      //dd($total);

      $funcion = "multiple";
    
        return view('encuesta.estadistica.injeccionmultiple')
                    ->with('titulo2',$titulo2)
                    ->with('encuestados',$encuestados)
                    ->with('funcion',$funcion)
                    ->with('menuitem',$menuitem)
                    ->with('datos2',$datos2)
                    ->with('total2',$total2)
                    ->with('datosO2',$datosO2);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function preguntas($id)
    {

        $menuitem = 5;
      
        //dd($titulo);

        //quito la pregunta 54 por que es la pregunta multiple
      $where = ' where not r.item_id = 54';
      $group = ' group by sd.descripcion, opc.puntaje) fav group by fav.descripcion ,fav.favorabilidad order by fav.id';

      $select = 'select fav.descripcion as descripcion, fav.favorabilidad as favorabilidad, fav.id as id, fav.orden as orden, sum(fav.cantidad) as cantidad';
      $from = ' from (select it.contenido as descripcion, opc.puntaje as puntaje, it.id as id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad, case when (opc.puntaje < 3) then "3" when (opc.puntaje = 3) then "2" when (opc.puntaje > 3) then "1" end as orden from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id';
      $join = ' inner join sede sd on sd.id = en.sede_id ';
        //quito la pregunta 54 por que es la pregunta multiple
      $where = ' where not r.item_id = 54';
      $where2 = ' and en.sede_id = 1';
      $group = ' group by it.contenido, opc.puntaje ) fav group by fav.descripcion, fav.favorabilidad';
      $order = ' order by fav.id, fav.orden';



      //$consulta = $select . $from . $join . $where . $where2 . $group . $order;
      $consulta = $select . $from . $where . $group . $order;

      //dd($consulta);

      $consultadb = DB::select($consulta);

      $datosO1 = $consultadb;

      //dd($datosO1);

      $datos = json_encode($consultadb);

      $items = Item::all();

      $total = Encuestado::all()->count();

//nuevo orden INICIO

      $titulo = "Preguntas";

      $imtesCPorcentages = $this->porcentages($items,$total, $datosO1, $titulo);

      //dd($imtesCPorcentages);


      //$ArrayOrdenID = $this->ordenar($items,$total, $datosO1, $titulo);

//nuevo orden FIN

      $demograficos = array('Sede' => 'Sede',
        'Antiguedad' => 'Antiguedad',
        'Area' => 'Area',
        'Contrato' => 'Contrato',
        'Estudio' => 'Estudio',
        'Genero' => 'Genero',
        'Puesto' => 'Puesto',
        'Edad' => 'Edad',
        'Sector' => 'Sector');

      $demograficos2 = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');

      //dd('titulo: '. $titulo . ', Variable: '. $variableDemog);

            //dd('ruta comun');
            //dd($datosO1);

        //agregado 20201005 inicio
        $encuestas = Encuesta::orderBy('descripcion', 'DES')->lists('descripcion', 'id');
        //agregado 20201005 fin

            return view('encuesta.estadistica.preguntas')
                  //agregado 20201005 inicio
                    ->with('encuestas',$encuestas)
                  //agregado 20201005 fin
                    ->with('menuitem',$menuitem)
                    ->with('demograficos',$demograficos)
                    ->with('demograficos2',$demograficos2)
                    ->with('imtesCPorcentages',$imtesCPorcentages)
                    ->with('datosO1',$datosO1)
                    ->with('total',$total)
                    ->with('items',$items);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function injeccionpreguntas()
    {

        $menuitem = 5;

        $variableDemog = 0;
        $titulo = 'Indice';

        $primario = array();
        $secundario = array();

        if (isset($_GET['demografico1'])) {
            $variableDemog = $_GET['demografico1'];
            $titulo = $variableDemog;

            //traigo los filtros secundarios
            $demog1 = $_GET['demografico1'];
            $demog3 = $_GET['demografico3'];
            $demog4 = $_GET['demografico4'];
            $demog6 = $_GET['demografico6'];
           
            //controlo que los demograficos 1 y 4 sean distintos

            if ($demog1 != $demog4 && $demog6 != "todos"){
              array_push($primario,$demog4);
              array_push($secundario,$demog6);
            }
              
        }
       
        //dd($titulo);

        //consulta para los datos

      $select = 'select fav.descripcion as descripcion, fav.favorabilidad as favorabilidad, fav.id as id, fav.orden as orden, sum(fav.cantidad) as cantidad';
      $from = ' from (select it.contenido as descripcion, opc.puntaje as puntaje, it.id as id, count(r.id) as cantidad, case when (opc.puntaje < 3) then "Desfavorable" when (opc.puntaje = 3) then "Neutro" when (opc.puntaje > 3) then "Favorable" end as favorabilidad, case when (opc.puntaje < 3) then "3" when (opc.puntaje = 3) then "2" when (opc.puntaje > 3) then "1" end as orden from respuesta r inner join encuestado en on en.id = r.encuestado_id inner join opcion opc on opc.id = r.opcion_id inner join items it on it.id = r.item_id inner join relation rl on rl.item_id = it.id';
        //quito la pregunta 54 por que es la pregunta multiple
      $where = ' where not r.item_id = 54';
      $where2 = ' ';
      $group = ' group by it.contenido, opc.puntaje ) fav group by fav.descripcion, fav.favorabilidad';
      $order = ' order by fav.id, fav.orden';


      switch ($titulo) {
          case 'Sede':
                $join2 = ' inner join sede dm on dm.id = en.sede_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Antiguedad':
                $join2 = ' inner join antiguedad dm on dm.id = en.antiguedad_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }

              break;

          case 'Area':
                $join2 = ' inner join area dm on dm.id = en.area_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Contrato':
                $join2 = ' inner join contrato dm on dm.id = en.contrato_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Estudio':
                $join2 = ' inner join estudio dm on dm.id = en.estudio_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Genero':
                $join2 = ' inner join genero dm on dm.id = en.genero_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Puesto':
                $join2 = ' inner join puesto dm on dm.id = en.puesto_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          case 'Edad':
                $join2 = ' inner join rangoedad dm on dm.id = en.rangoedad_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;
          case 'Sector':
                $join2 = ' inner join sector dm on dm.id = en.sector_id';
                if ($demog3 != "todos") {
                  $where2 = ' and dm.id = ' . $demog3;
                }
              break;

          default:
              
              break;
      }


$max =sizeof($primario);

$join3 = ' ';
$where3 = ' ';

$countwhere = 0;

for ($i=0; $i < $max; $i++) { 

      // filtro secundario que solo agrega filtros
      switch ($primario[$i]) {
          case 'Sede':
                $join3 = $join3 .' inner join sede filt'.$i.' on filt'.$i.'.id = en.sede_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Antiguedad':
                $join3 = $join3 .' inner join antiguedad filt'.$i.' on filt'.$i.'.id = en.antiguedad_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Area':
                $join3 = $join3 .' inner join area filt'.$i.' on filt'.$i.'.id = en.area_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Contrato':
                $join3 = $join3 .' inner join contrato filt'.$i.' on filt'.$i.'.id = en.contrato_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Estudio':
                $join3 = $join3 .' inner join estudio filt'.$i.' on filt'.$i.'.id = en.estudio_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Genero':
                $join3 = $join3 .' inner join genero filt'.$i.' on filt'.$i.'.id = en.genero_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Puesto':
                $join3 = $join3 .' inner join puesto filt'.$i.' on filt'.$i.'.id = en.puesto_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          case 'Edad':
                $join3 = $join3 .' inner join rangoedad filt'.$i.' on filt'.$i.'.id = en.rangoedad_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;
          case 'Sector':
                $join3 = $join3 .' inner join sector filt'.$i.' on filt'.$i.'.id = en.sector_id ';
                if ($countwhere > 0) {
                  $where3 = $where3 . ' where filt'.$i.'.id ='.$secundario[$i];
                }else{
                  $where3 = $where3 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                $countwhere++;
                
              break;

          default:
              
              break;
      }

}



      $consulta = $select . $from . $join2 . $join3 . $where . $where2 . $where3 . $group . $order;

      $consultadb = DB::select($consulta);

      //dd($consulta);

      $datosO1 = $consultadb;

      $items = Item::all();

      $datos = json_encode($consultadb);


      $select2 = 'select count(en.id) as id from encuestado en ';

      //declaro un where4 que no filtra nada, para poder concatenar where2 y where3 sin problemas
      $where4 = ' where not en.id = 0';

      if ($demog3 == 'todos') {
          //no debe filtrar por el primario

        if ($demog6 == 'todos') {
          //no debe ablicar filtros
          $consulta2 = $select2 ;
          
        }else{
          $consulta2 = $select2 . $join2 . $join3 . $where4 . $where2 . $where3;

        }
        
      }else{
        $consulta2 = $select2 . $join2 . $join3 . $where4 . $where2 . $where3;
      }

      //$consulta2 = $select . $join2 . $join3 . $where4 . $where2 . $where3;

      //dd($consulta2);

      $consultadb2 = DB::select($consulta2);

      //dd($consultadb2[0]->id);

      $total = $consultadb2[0]->id;


//nuevo orden INICIO

      $titulo = "Preguntas";

      $imtesCPorcentages2 = $this->porcentages($items,$total, $datosO1, $titulo);

            return view('encuesta.estadistica.injeccionpreguntas')
                    ->with('imtesCPorcentages2',$imtesCPorcentages2)
                    ->with('total',$total);

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

    public function porcentages($demograficos, $demos, $datosO1, $titulo)
    {

    //<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % INICIO

      //ordenado de datos prueba 2 ordenar el objeto

      //objeto temporar para array
      
      //array de objetos con porcentajes

      //dd($demograficos);

      //dd($datosO1);

      if ($titulo == 'Preguntas') {

        $porcentualOrdenado = array();

        foreach ($demograficos as $demografico) {

          $datosOrdenados = new ObjetoOrdenDos();

          foreach ($datosO1 as $dato){

            if ($dato->id == $demografico->id) {

              //calculo el porcentaje de cada uno
              
              $porcentage = round(($dato->cantidad * 100) / $demos);

              $datosOrdenados->id = $dato->id;
              $datosOrdenados->descripcion = $dato->descripcion;
              
              if ($dato->favorabilidad == "Favorable") {

                $datosOrdenados->favorable = $porcentage;
                
              }

              if ($dato->favorabilidad == "Neutro") {

                $datosOrdenados->neutro = $porcentage;
                
              }

              if ($dato->favorabilidad == "Desfavorable") {

                $datosOrdenados->desfavorable = $porcentage;
                
              }
              
              //lo guardo en un objeto y le hago un push al array de objeto

            }

          }

          array_push($porcentualOrdenado,$datosOrdenados);
          
        }

        
      }else{

        $porcentualOrdenado = array();

        $item = 0;

        foreach ($demograficos as $demografico) {

          foreach ($datosO1 as $dato){

            if ($dato->id == $demografico->id) {

              $datosOrdenados = new ObjetoOrden();

              //calculo el porcentaje de cada uno
              
              $porcentage = round(($dato->cantidad * 100) / $demos[$item],1);

              $datosOrdenados->id = $dato->id;
              $datosOrdenados->descripcion = $dato->descripcion;
              $datosOrdenados->favorabilidad = $dato->favorabilidad;
              $datosOrdenados->cantidad = $dato->cantidad;
              $datosOrdenados->porcentage = $porcentage;

              //lo guardo en un objeto y le hago un push al array de objeto

              array_push($porcentualOrdenado,$datosOrdenados);

            }

          }
          $item++;
        }

      }
      
      //dd($porcentualOrdenado);

      if ($titulo == 'Preguntas') {
        $ArrayOrdenID = collect($porcentualOrdenado)->sortByDesc('favorable')->all();

        return $ArrayOrdenID;
      }

      //ahora debo extraer todos los datos favorables, y de no teneer, debo insertar un registro con el id y favorabilidad = 0

      //$variableDOrden = new ObjetoOrden();

      //array de objetos con porcentajes 

      $IdOrdenados = array();

      //dd($demograficos);

      //recorro demografico y porcentajeOrdenado para armar un arreglo solo de favorables por cada demografico para poder ordenarlo a posterior
      foreach ($demograficos as $demografico) {
        
        $variableDemog = new ObjetoOrdenDos();
        $variableDemog->id = $demografico->id;
        $variableDemog->descripcion = $demografico->contenido;

        foreach ($porcentualOrdenado as $orden) {
            
            if ($demografico->id == $orden->id) {

              if ($orden->favorabilidad == "Favorable") {

                $variableDemog->favorable = $orden->porcentage;
              }
              if ($orden->favorabilidad == "Neutro") {

                $variableDemog->neutro = $orden->porcentage;
              }
              if ($orden->favorabilidad == "Desfavorable") {

                $variableDemog->desfavorable = $orden->porcentage;
              }
            }
        }
          array_push($IdOrdenados,$variableDemog);
      }
       
      //dd($IdOrdenados);

      //$IdOrdenados->asort();
      
      //de los favorables con porcentaje ordeno por % de mayor a menor

      if ($titulo == 'Edad' || $titulo == 'Antiguedad' || $titulo == 'Estudio' ) {

        $ArrayOrdenID = collect($IdOrdenados)->sortBy('id')->all();
        
      }else{

      $ArrayOrdenID = collect($IdOrdenados)->sortByDesc('porcentage')->all();

      }
      //dd($ArrayOrdenID);      

//<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % FIN

      return $ArrayOrdenID;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */








    public function Ordenar($demograficos, $demos, $datosO1, $titulo)
    {

    //<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % INICIO

      //ordenado de datos prueba 2 ordenar el objeto

      //objeto temporar para array
      
      //array de objetos con porcentajes

      //dd($demograficos);

      if ($titulo == 'Preguntas') {

        $porcentualOrdenado = array();

        foreach ($demograficos as $demografico) {

          foreach ($datosO1 as $dato){

            if ($dato->id == $demografico->id) {

              $datosOrdenados = new ObjetoOrden();

              //calculo el porcentaje de cada uno
              
              $porcentage = round(($dato->cantidad * 100) / $demos,1);

              $datosOrdenados->id = $dato->id;
              $datosOrdenados->descripcion = $dato->descripcion;
              $datosOrdenados->favorabilidad = $dato->favorabilidad;
              $datosOrdenados->cantidad = $dato->cantidad;
              $datosOrdenados->porcentage = $porcentage;

              //lo guardo en un objeto y le hago un push al array de objeto

              array_push($porcentualOrdenado,$datosOrdenados);

            }

          }
          
        }
       
      }else{

        $porcentualOrdenado = array();

        $item = 0;

        foreach ($demograficos as $demografico) {

          foreach ($datosO1 as $dato){

            if ($dato->id == $demografico->id) {

              $datosOrdenados = new ObjetoOrden();

              //calculo el porcentaje de cada uno
              
              $porcentage = round(($dato->cantidad * 100) / $demos[$item],1);

              $datosOrdenados->id = $dato->id;
              $datosOrdenados->descripcion = $dato->descripcion;
              $datosOrdenados->favorabilidad = $dato->favorabilidad;
              $datosOrdenados->cantidad = $dato->cantidad;
              $datosOrdenados->porcentage = $porcentage;

              //lo guardo en un objeto y le hago un push al array de objeto

              array_push($porcentualOrdenado,$datosOrdenados);

            }

          }
          $item++;
        }

      }
      //dd($porcentualOrdenado);

      //ahora debo extraer todos los datos favorables, y de no teneer, debo insertar un registro con el id y favorabilidad = 0

      //$variableDOrden = new ObjetoOrden();

      //array de objetos con porcentajes 

      $IdOrdenados = array();

      //dd($demograficos);

      //recorro demografico y porcentajeOrdenado para armar un arreglo solo de favorables por cada demografico para poder ordenarlo a posterior
      foreach ($demograficos as $demografico) {
        $total = 0;
        foreach ($porcentualOrdenado as $orden) {
            
            if ($demografico->id == $orden->id) {

              if ($orden->favorabilidad == "Favorable") {

                $variableDemog = $orden;

                $total = $orden->porcentage;

              }
            }

        }

        if ($total == 0) {

          $variableDemog = new ObjetoOrden();
          $variableDemog->id = $demografico->id;
          $variableDemog->descripcion = $demografico->descripcion;
          $variableDemog->porcentage = 0;
          $variableDemog->favorabilidad = "Favorable";

          array_push($IdOrdenados,$variableDemog);

        }else{

          $variableDemog->porcentage = $total;
          $variableDemog->favorabilidad = "Favorable";

          array_push($IdOrdenados,$variableDemog);
        }
      }
       
      //dd($IdOrdenados);

      //$IdOrdenados->asort();
      
      //de los favorables con porcentaje ordeno por % de mayor a menor

      if ($titulo == 'Edad' || $titulo == 'Antiguedad' || $titulo == 'Estudio' ) {

        $ArrayOrdenID = collect($IdOrdenados)->sortBy('id')->all();
        
      }else{

      $ArrayOrdenID = collect($IdOrdenados)->sortByDesc('porcentage')->all();

      }
      //dd($ArrayOrdenID);      

//<<<<<<<<<<<<<<<<<<< orden de mayor a menor por % FIN

      return $ArrayOrdenID;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function demogshow()
    {

        if (isset($_GET['demografico'])) {
            $variableDemog = $_GET['demografico'];
            $funcion = $_GET['funcion'];
            $menuitem = $_GET['menuitem'];
            $parametro = $_GET['parametro'];
            //$demogId = $_GET['demografico2'];
            $titulo = $variableDemog;
        }else{
            return "demografico vino vacio";
        }

      switch ($titulo) {
          case 'Sede':
                $demog = Sede::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          case 'Antiguedad':
                $demog = Antiguedad::orderBy('rango', 'ASC')->lists('rango', 'id');
              break;

          case 'Area':
                $demog = Area::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          case 'Contrato':
                $demog = Contrato::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          case 'Estudio':
                $demog = Estudio::orderBy('nivel', 'ASC')->lists('nivel', 'id');
              break;

          case 'Genero':
                $demog = Genero::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          case 'Puesto':
                $demog = Puesto::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          case 'Edad':
                $demog = RangoEdad::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;
          case 'Sector':
                $demog = Sector::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
              break;

          default:
              
              break;
      }

      $demog2 = $demog;

        $html = view('encuesta.estadistica.filtros')
                  ->with('funcion', $funcion)
                  ->with('parametro', $parametro)
                  ->with('menuitem', $menuitem)
                  ->with('demog2', $demog2)
                  ->with('demog', $demog);

        return $html;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function Encuestados($demog1, $demog3, $demog4, $demog6)
    {

//ingresan los filtros 1 y 2
//se obtienen los encuestados
//por cada demografico a graficar se controla que no tenga menos de 3 encuestados

    $primario = array();
    $secundario = array();

    //los cargo en un arreglo
//    if ($demog3 != "todos") {

      array_push($primario,$demog1);
      array_push($secundario,$demog3);
//    }
    
    //controlo que los demograficos 1 y 4 sean distintos

    if ($demog1 != $demog4 && $demog6 != "todos"){
      array_push($primario,$demog4);
      array_push($secundario,$demog6);
      
    }

  $select = 'select filt0.id as id, count(en.id) as encuestados ';
  $from = ' from encuestado en ';
  $join =  ' ';
  //$join =  ' inner join sede sd on sd.id = en.sede_id ';
  $where2 = ' where en.encuesta_id != 0';
  $group = ' group by filt0.id ';


$max =sizeof($primario);

$join2 = ' ';
//$where2 = ' ';

$countwhere = 0;

for ($i=0; $i < $max; $i++) { 

      // filtro secundario que solo agrega filtros
      switch ($primario[$i]) {
          case 'Sede':
                $join = $join .' inner join sede filt'.$i.' on filt'.$i.'.id = en.sede_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }
                
              break;

          case 'Antiguedad':
                $join = $join .' inner join antiguedad filt'.$i.' on filt'.$i.'.id = en.antiguedad_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Area':
                $join = $join .' inner join area filt'.$i.' on filt'.$i.'.id = en.area_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Contrato':
                $join = $join .' inner join contrato filt'.$i.' on filt'.$i.'.id = en.contrato_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Estudio':
                $join2 = $join2 .' inner join estudio filt'.$i.' on filt'.$i.'.id = en.estudio_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Genero':
                $join = $join .' inner join genero filt'.$i.' on filt'.$i.'.id = en.genero_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Puesto':
                $join = $join .' inner join puesto filt'.$i.' on filt'.$i.'.id = en.puesto_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          case 'Edad':
                $join = $join .' inner join rangoedad filt'.$i.' on filt'.$i.'.id = en.rangoedad_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;
          case 'Sector':
                $join = $join .' inner join sector filt'.$i.' on filt'.$i.'.id = en.sector_id ';

                if ($secundario[$i] != "todos") {
                  $where2 = $where2 . ' and filt'.$i.'.id ='.$secundario[$i];
                }

                $countwhere++;
                
              break;

          default:
              
              break;
      }

}

      $consulta = $select . $from . $join . $join2 . $where2 .  $group ;

    //dd($consulta);

      $consultadb = DB::select($consulta);

      //dd($consultadb);

        return $consultadb;
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
