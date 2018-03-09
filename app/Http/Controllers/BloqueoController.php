<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Razonbloqueo;

use Teodolinda\Bloqueo;

use Teodolinda\HabitacionTipo;

use Teodolinda\Entidade;

use Teodolinda\Role;

use Teodolinda\Reservacione;

use Teodolinda\ReservacionHabitacione;

use Teodolinda\ReservacionEntidadRole;

use Illuminate\Support\Facades\Input;

use DB;

class BloqueoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bloqueo = Bloqueo::where('activo', 1)->get();
       return view('bloqueos.bloqueos',compact('bloqueo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $request->user()->authorizeRoles(['Admin']);
       $razonbloqueo = Razonbloqueo::all();

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

               ->get();

              //dd($hablibres);


           $tipohab = HabitacionTipo::all();

           $tarifa = DB::table('tarifas')
             ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
             ->where('habitacion_tipos.id', '=', $valth)
             ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

       } else {
           $hablibres = [];
           $tarifa = [];
           $tipohab = HabitacionTipo::all(); $valth = 0; }


       return View('/bloqueos/create', compact(['hablibres'], 'tipohab', 'valth', 'tarifa', 'rol', 'razonbloqueo'));

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
        $bloqueo = Bloqueo::create($request->all());

        if($bloqueo->save()){
           return redirect('bloqueos')->with('msj', 'Datos guardados');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
      $request->user()->authorizeRoles(['Admin']);
      $bloqueo = Bloqueo::find($id);
      $razonbloqueo = Razonbloqueo::all();

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

            ->get();


          $tipohab = HabitacionTipo::all();

        } else {
            $hablibres = [];
            $tarifa = [];
            $tipohab = HabitacionTipo::all(); $valth = 0; }


        return view('bloqueos.edit', compact(['hablibres'], 'tipohab', 'valth', 'reservahab', 'bloqueo', 'razonbloqueo'));

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
        $bloqueo = Bloqueo::find($id);

        if($bloqueo->update($request->all())){
           return redirect('bloqueos')->with('msj', 'Datos guardados');
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
