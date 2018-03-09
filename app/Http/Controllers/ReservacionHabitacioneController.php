<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\ReservacionHabitacione;

use Teodolinda\HabitacionTipo;

use Illuminate\Support\Facades\Input;

use Teodolinda\Role;

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
                   ->where(function($query) use ($fechasalida, $fechaentrada)
                    {
                              $query->where('estadia_habitaciones.activo', '=', 1)
                              ->where('estadia_habitaciones.fechaentrada', '<=', $fechaentrada)
                              ->where('estadia_habitaciones.fechasalida', '>', $fechaentrada);
                     })
                   ->orWhere(function($query) use ($fechasalida, $fechaentrada)
                     {
                             $query->where('estadia_habitaciones.activo', '=', 1)
                             ->Where('estadia_habitaciones.fechaentrada', '<', $fechasalida )
                             ->where('estadia_habitaciones.fechaentrada', '>', $fechaentrada );

                       })
                    ->select('estadia_habitaciones.habitacione_id');
                 })
             ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                {
                    $query->from('reservacion_habitaciones')
                    ->Where(function($query) use ($fechasalida, $fechaentrada)
                     {
                               $query->where('reservacion_habitaciones.activo', '=', 1)
                               ->where('reservacion_habitaciones.fechaentrada', '<=', $fechaentrada)
                               ->where('reservacion_habitaciones.fechasalida', '>', $fechaentrada);
                      })
                    ->orWhere(function($query) use ($fechasalida, $fechaentrada)
                      {
                              $query->where('reservacion_habitaciones.activo', '=', 1)
                              ->Where('reservacion_habitaciones.fechaentrada', '<', $fechasalida )
                              ->where('reservacion_habitaciones.fechaentrada', '>', $fechaentrada );

                        })
                    ->select('reservacion_habitaciones.habitacione_id');
                })
                ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                   {
                       $query->from('bloqueos')
                       ->Where(function($query) use ($fechasalida, $fechaentrada)
                        {
                                  $query->where('bloqueos.activo', '=', 1)
                                  ->where('bloqueos.fechainicio', '<=', $fechaentrada)
                                  ->where('bloqueos.fechafin', '>', $fechaentrada);
                         })
                       ->orWhere(function($query) use ($fechasalida, $fechaentrada)
                         {
                                 $query->where('bloqueos.activo', '=', 1)
                                 ->Where('bloqueos.fechainicio', '<', $fechasalida )
                                 ->where('bloqueos.fechafin', '>', $fechaentrada );

                           })
                       ->select('bloqueos.habitacione_id');
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
     * Editar comentario y tarifa */
     
    public function editcomentari(Request $request, $id)
    {
        $request->user()->authorizeRoles(['Admin', 'Recepcionista']);
        $reservahab = ReservacionHabitacione::find($id);
        $valth = $reservahab->habitacione->habitaciontipo->id;
        $tarifa = DB::table('tarifas')
          ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
          ->where('habitacion_tipos.id', '=', $valth)
          ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();
        return view('reservahab.editcomentari')
        ->with(['edit' => true, 'reservahab' => $reservahab, 'tarifa' => $tarifa]);//
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
