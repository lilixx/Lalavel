<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ReservacionHabitacione;

use App\HabitacionTipo;

use Illuminate\Support\Facades\Input;

use App\Role;

use DB;

class ReservacionHabitacioneController extends Controller
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
      $reservahab = ReservacionHabitacione::find($id);
      $tipohab = HabitacionTipo::all();

      $fechaentrada = Input::has('fechaentrada') ? Input::get('fechaentrada') : null;
      $fechasalida = Input::has('fechasalida') ? Input::get('fechasalida') : null;
      $tipohab = Input::has('tipohab') ? Input::get('tipohab') : null;
      $rol = Role::find(2);

      if($fechasalida != null) {
          $valth = $tipohab;


            $hablibres = DB::table('habitaciones')
              ->where('habitaciones.habitacion_tipo_id', '=', $valth)
              ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
              ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
              ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                   {
                      $query->from('estadia_habitaciones')
                      ->where('estadia_habitaciones.fechasalida', '>=', $fechasalida)
                      ->orWhere('estadia_habitaciones.fechasalida', '>', $fechaentrada)
                      ->select('estadia_habitaciones.habitacione_id');
                   })
              ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                  {
                      $query->from('reservacion_habitaciones')
                      ->where('reservacion_habitaciones.fechasalida', '>=', $fechasalida)
                      ->orWhere('reservacion_habitaciones.fechasalida', '>', $fechaentrada)
                      ->select('reservacion_habitaciones.habitacione_id');
                  })

             ->get();


          $tipohab = HabitacionTipo::all();

          $tarifa = DB::table('tarifas')
            ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
            ->where('habitacion_tipos.id', '=', $valth)
            ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

      } else {
          $hablibres = [];
          $tarifa = [];
          $tipohab = HabitacionTipo::all(); $valth = 0; }


      return view('reservahab.edit', compact(['hablibres'], 'tipohab', 'valth', 'reservahab', 'tarifa', 'rol'));
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
      $reservahab = ReservacionHabitacione::find($id);

      if($reservahab->update($request->all())){
         return redirect('reservaciones')->with('msj', 'Datos guardados');
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
}
