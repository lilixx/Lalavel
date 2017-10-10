<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Habitacione;

use Teodolinda\HabitacionTipo;

use Teodolinda\HabitacionArea;

use Teodolinda\EstadiaHabitacione;

use Teodolinda\ReservacionHabitacione;

use DB;

class HabitacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Recepcionista']);
      //  $habitacion = Habitacione::all();
        $habitacion = Habitacione::where('activo', '=', 1)->paginate(10);
    //  dd($habitacion);
        return view('habitaciones.habitaciones',compact('habitacion'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habtipo = HabitacionTipo::all();
        $habarea = HabitacionArea::all();
        return view('habitaciones.create',compact('habtipo', 'habarea'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habitacion = Habitacione::create($request->all());

        if($habitacion->save()){
           return redirect('habitaciones')->with('msj', 'Datos guardados');
        } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $habtipo = HabitacionTipo::all();
      $habarea = HabitacionArea::all();
      $habitacion = Habitacione::all();
      $mes = date('m');
      $diactual = date('d');

    /*  $count = DB::table('habitacion_areas')
      ->join('habitaciones', 'habitaciones.habitacion_area_id', '=', 'habitacion_areas.id')
      ->select(DB::raw('count(*) as count_area, habitacion_areas.id'))
      ->groupBy('habitacion_areas.id')
      ->get(); */

       foreach($habarea as $ar){
          foreach($ar->habitaciones as $hab){

                $habi[] =  [
                  'numhab'=> $hab->numero,
                  'idarea'=>$ar->id,
                ];

           }
       }


     $reserva = ReservacionHabitacione::where('cancelada', '=', 0)
     ->where(function($query) use ($mes){
        $query->whereMonth('fechasalida', '=', $mes)
              ->orWhere('fechaentrada', '=', $mes);
      })->get();

      $estadia = EstadiaHabitacione::where('activo', '=', 1)
      ->where(function($query) use ($mes){
         $query->whereMonth('fechasalida', '=', $mes)
               ->orWhere('fechaentrada', '=', $mes);
       })->get();

    // Cuenta las Reservaciones_id para saber si es una reserva en grupo
    $reservacount =  DB::table('reservacion_habitaciones')
    ->where('reservacion_habitaciones.cancelada', '=', 0)
    ->where(function($query) use ($mes){
        $query->whereMonth('fechasalida', '=', $mes)
              ->orWhere('fechaentrada', '=', $mes);
      })
    ->select(DB::raw('count(*) as count_reserva, reservacion_habitaciones.reservacione_id'))
    ->groupBy('reservacione_id')->get();

    //Cuenta las Estadias_id para saber si es una estadia de un grupo
    $estadiacount =  DB::table('estadia_habitaciones')
    ->where('estadia_habitaciones.activo', '=', 1)
    ->where(function($query) use ($mes){
        $query->whereMonth('fechasalida', '=', $mes)
              ->orWhere('fechaentrada', '=', $mes);
      })
    ->select(DB::raw('count(*) as count_estadia, estadia_habitaciones.estadia_id'))
    ->groupBy('estadia_id')->get();

    //  dd($reservacount);
      //dd($reserva);

      $dias=(date("t"));

      for($dia = 1; $dia <= $dias; $dia++) {
        $day[] = $dia;
      }



        $c = 0;



        foreach($reserva as $rs){
        foreach($reservacount as $rc){

          if($rc->reservacione_id == $rs->reservacione->id){
          $diaentrada = date("d", strtotime($rs->fechaentrada)); //dd($dia);
          $diasalida = date("d", strtotime($rs->fechasalida)); //dd($dia);
                  $c = $c+1;
                  $containers[] =  [
                    'mesentrada'=> date("m", strtotime($rs->fechaentrada)),
                    'messalida' => date("m", strtotime($rs->fechasalida)),
                    'diaentrada'=> date("d", strtotime($rs->fechaentrada)),
                    'diasalida' => date("d", strtotime($rs->fechasalida)),
                    'numero'=>$rs->reservacione->id,
                    'activo'=>$rs->reservacione->activo,
                    'numhab'=>$rs->habitacione->numero,
                    'tipo'=>$rs->habitacione->habitaciontipo->nombre,
                    'fechaentrada'=>$rs->fechaentrada,
                    'fechasalida'=>$rs->fechasalida,
                    'tarifa'=>$rs->tarifa->valor,
                    'nombretar'=>$rs->tarifa->nombre,
                    'noshow'=>$rs->reservacione->noshow,
                    'grupo'=>$rc->count_reserva,
                    'estadia'=>0,
                    'idreservahab'=>$rs->id,
                    //'reservadopor'=>$rs->reservacionentidadroles->entidade->nombres,
                  ];

           }

         }

       }

       foreach($estadia as $es){
         foreach($estadiacount as $ec){
           if($ec->estadia_id == $es->estadia->id){
             $diaentrada = date("d", strtotime($es->fechaentrada)); //dd($dia);
             $diasalida = date("d", strtotime($es->fechasalida)); //dd($dia);
             $containers[] =  [
               'mesentrada'=> date("m", strtotime($es->fechaentrada)),
               'messalida' => date("m", strtotime($es->fechasalida)),
               'diaentrada'=> date("d", strtotime($es->fechaentrada)),
               'diasalida' => date("d", strtotime($es->fechasalida)),
               'numero'=>$es->estadia->id,
               'activo'=>'',
               'numhab'=>$es->habitacione->numero,
               'tipo'=>$es->habitacione->habitaciontipo->nombre,
               'fechaentrada'=>$es->fechaentrada,
               'fechasalida'=>$es->fechasalida,
               'tarifa'=>$es->tarifa->nombre,
               'nombretar'=>$es->tarifa->nombre,
               'noshow'=>'',
               'estadia'=>'1',
               'grupo'=>$ec->count_estadia,
               'idreservahab'=>'',

               //'reservadopor'=>$rs->reservacionentidadroles->entidade->nombres,
             ];
          }
        }
      }



      //dd($containers);

      $n = 1;
      $j=1;


      return view('habitaciones.showweek',compact('habtipo', 'habarea', 'habitacion', 'day', 'reserva', 'containers', 'n', 'mes', 'lastday', 'count', 'habi', 'j', 'diactual'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habitacion = Habitacione::find($id);
        $habtipo = HabitacionTipo::all();
        $habarea = HabitacionArea::all();
        return view('habitaciones.edit')
        ->with(['edit' => true, 'habitacion' => $habitacion, 'habtipo' => $habtipo, 'habarea' => $habarea ]);
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
        $request->user()->authorizeRoles(['Admin']);
        $habitacion = Habitacione::find($id);

        if($habitacion->update($request->all())){
           return redirect('habitaciones')->with('msj', 'Datos guardados');
        } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
        }
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

    public function habmonth()
    {
      //  dd($request);
      //  $request->user()->authorizeRoles(['Admin', 'Recepcionista']);

      //
    }

}
