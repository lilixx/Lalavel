<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Habitacione;

use Teodolinda\HabitacionTipo;

use Teodolinda\HabitacionArea;

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

    //  dd($count);

  /*    foreach($count as $co){
        foreach($habarea as $ha){
          if($ha->id == $co->id){
          $counts[] =  [
            'cantidad' => $co,
          ];
        }
       }
      }
      dd($counts); */


      //dd($count);
      //dd($mes);
      $reserva = ReservacionHabitacione::where(function($query) use ($mes){
        $query->whereMonth('fechaentrada', '=', $mes)
              ->orWhere('fechasalida', '=', $mes);
      })->get();

      $dias=(date("t"));

      for($dia = 1; $dia <= $dias; $dia++) {
        $day[] = $dia;
      }

      foreach($day as $di){
      //  $containers[] = ['dia'=>$di,];
        $c = 0;
        $lastday = 0;
        foreach($reserva as $rs){
          $diaentrada = date("d", strtotime($rs->fechaentrada)); //dd($dia);
          $diasalida = date("d", strtotime($rs->fechasalida)); //dd($dia);
          if($di == $diaentrada || $di == $diasalida && ($di>=$diaentrada && $di<=$diasalida)) {
              $c = $c+1;
              $containers[] =  [
                'dia'=> $di,
                'mesentrada'=> date("m", strtotime($rs->fechaentrada)),
                'messalida' => date("m", strtotime($rs->fechasalida)),
                'diaentrada'=> date("d", strtotime($rs->fechaentrada)),
                'diasalida' => date("d", strtotime($rs->fechasalida)),
                'numreserva'=>$rs->reservacione->id,
                'numhab'=>$rs->habitacione->numero,
                'tipo'=>$rs->habitacione->habitaciontipo->nombre,
                'fechaentrada'=>$rs->fechaentrada,
                'fechasalida'=>$rs->fechasalida,
                'tarifa'=>$rs->tarifa->valor,
                //'reservadopor'=>$rs->reservacionentidadroles->entidade->nombres,
              ];
          }
          $lasday=$diaentrada;
        }

        if($c == 0){
          $containers[] = [
            'dia'=>$di,
            'mesentrada'=>'',
            'messalida'=>'',
            'diaentrada'=>'',
            'diasalida'=>'',
            'numreserva'=>'',
            'numhab'=>'',
            'tipo'=>'',
            'fechaentrada'=>'',
            'fechasalida'=>'',
            'tarifa'=>'',
          ];
        }

      }

      //dd($containers);

      $n = 1;


      return view('habitaciones.showweek',compact('habtipo', 'habarea', 'habitacion', 'day', 'reserva', 'containers', 'n', 'mes', 'lastday'));

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
