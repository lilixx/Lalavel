<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\HabitacionTipo;

use Teodolinda\Entidade;

use Teodolinda\Role;

use Teodolinda\Reservacione;

use Teodolinda\ReservacionHabitacione;

use Teodolinda\ReservacionEntidadRole;

use Illuminate\Support\Facades\Input;

use DB;

class ReservacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reserva = Reservacione::where('activo', 1)->get();
        $datetoday = date('Y-m-d');
        $m = 0;
        return view('reservaciones.reservaciones',compact('reserva', 'datetoday', 'm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $tipohab = HabitacionTipo::all();

      $fechaentrada = Input::has('fechaentrada') ? Input::get('fechaentrada') : null;
      $fechasalida = Input::has('fechasalida') ? Input::get('fechasalida') : null;
      $tipohab = Input::has('tipohab') ? Input::get('tipohab') : null;
      $rol = Role::find(2);

      if($fechasalida != null) {
          $valth = $tipohab;


    $prueba2 = DB::table('reservacion_habitaciones')

           ->Where(function($query) use ($fechasalida, $fechaentrada)
           {
                     $query->where('reservacion_habitaciones.fechaentrada', '<=', $fechaentrada)
                     ->where('reservacion_habitaciones.fechasalida', '>', $fechaentrada);
            })
          ->orWhere(function($query) use ($fechasalida, $fechaentrada)
            {
                    $query->Where('reservacion_habitaciones.fechaentrada', '<', $fechasalida )
                    ->where('reservacion_habitaciones.fechaentrada', '>', $fechaentrada );

              })
                    //->where('reservacion_habitaciones.activo', '=', 1);

          ->get();

        //  dd($prueba2);


            $hablibres = DB::table('habitaciones')
              ->where('habitaciones.habitacion_tipo_id', '=', $valth)
              ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
              ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
              ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                   {
                      $query->from('estadia_habitaciones')
                      ->where('estadia_habitaciones.activo', '=', 1)
                      ->Where(function($query) use ($fechasalida, $fechaentrada)
                      {
                                $query->where('estadia_habitaciones.fechaentrada', '<=', $fechaentrada)
                                ->where('estadia_habitaciones.fechasalida', '>', $fechaentrada);
                       })
                     ->orWhere(function($query) use ($fechasalida, $fechaentrada)
                       {
                               $query->Where('estadia_habitaciones.fechaentrada', '<', $fechasalida )
                               ->where('estadia_habitaciones.fechaentrada', '>', $fechaentrada );

                         })
                      ->select('estadia_habitaciones.habitacione_id');
                   })
              ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                  {
                      $query->from('reservacion_habitaciones')
                       ->where('reservacion_habitaciones.activo', '=', 1)
                       ->Where(function($query) use ($fechasalida, $fechaentrada)
                       {
                                 $query->where('reservacion_habitaciones.fechaentrada', '<=', $fechaentrada)
                                 ->where('reservacion_habitaciones.fechasalida', '>', $fechaentrada);
                        })
                      ->orWhere(function($query) use ($fechasalida, $fechaentrada)
                        {
                                $query->Where('reservacion_habitaciones.fechaentrada', '<', $fechasalida )
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


      return View('/reservaciones/create', compact(['hablibres'], 'tipohab', 'valth', 'tarifa', 'rol'));
    }

    /**
    *    Agregar una habitación a la Reserva
    */

   public function createadicional($id){

     $tipohab = HabitacionTipo::all();

     $reserva = $id; // le pasa el id de la reserva

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
                    ->where('reservacion_habitaciones.activo', '=', 1)
                    ->Where(function($query) use ($fechasalida, $fechaentrada)
                    {
                      $query->where('reservacion_habitaciones.fechasalida', '>=', $fechasalida)
                             ->orWhere('reservacion_habitaciones.fechasalida', '>', $fechaentrada);
                    })
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


    return View('/reservaciones/createadicional', compact(['hablibres'], 'tipohab', 'valth', 'tarifa', 'rol', 'reserva'));

   }




    /**
    *     Pasa la Reserva a Estadia
    */

    public function movestay($id)
    {
      //$reserva = Reservacione::find($id);

      $reserva = ReservacionHabitacione::where('cancelada', '=', 0)->where('reservacione_id', '=', $id)->get();

      $rol = Role::find(2);

      $entidades = DB::table('reservaciones')
      ->where('reservaciones.id', '=', $id)
      ->join('reservacion_habitaciones', 'reservaciones.id', '=', 'reservacion_habitaciones.reservacione_id')
      ->join('reservacion_entidad_roles', 'reservacion_entidad_roles.reservacion_habitacione_id', '=', 'reservacion_habitaciones.id')
      ->join('entidade_role', 'entidade_role.id', '=', 'reservacion_entidad_roles.entidade_role_id')
      ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
      ->where('reservacion_habitaciones.cancelada', '=', 0 )
      ->select('entidades.id', 'entidades.nombres', 'entidades.apellidos',
        'reservacion_entidad_roles.encargado', 'entidade_role.role_id', 'reservacion_habitaciones.habitacione_id')->get();

      return view('reservaciones.movestay',compact('reserva', 'entidades', 'id', 'rol'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        if (!empty($request->reservacione_id)) { //si es una hab. adicional a la reserva

              $id = $request->reservacione_id;

              $reserva = Reservacione::find($id); // busca la estadia

        } else {

            //---------- Guardar la Reserva -------------
            $reserva = Reservacione::create($request->all());
        }

        //---------- Guardar la Reservacion Habitacion -------------
        $reservacionhab = new ReservacionHabitacione();
        $reservacionhab->fechaentrada = $request->fechaentrada;
        $reservacionhab->fechasalida = $request->fechasalida;
        $reservacionhab->tarifa_id = $request->tarifa_id;
        $reservacionhab->habitacione_id = $request->habitacione_id;

        $reserva->reservacionhabitaciones()->save($reservacionhab);

        //dd($reservacionhab);

        //---------- Guardar las Entidades y su rol -------------

          if (!empty($request->nombres)) {
              foreach($request->nombres as $key2=> $m) //recorre todos los email
              {
                  $containers[] = new Entidade(array(
                                 'nombres'=>$request->nombres[$key2],
                                 'apellidos'=>$request->apellidos[$key2],
                                 'tipoentidade_id'=>1,

                              ));
              }
          }

              $role = Role::find(1);

              $entidadrole = $role->entidades()->saveMany($containers);

        //---------- Si es una reserva de un Cliente -------------
            if (!empty($request->entidadrole_id)) {
                 $containers2[] = [
                                    'entidade_role_id'=>$request->entidadrole_id,
                                    'reservacion_habitacione_id'=> $reservacionhab->id,
                                    'encargado'=> 1,

                                 ];

             }
        //dd($containers2);

        //---------- Busca la EntidadRole -------------

              foreach($entidadrole as $en){
                     $entr = $en->id;
                     $entidadrol[] = Entidade::find($entr)->roles->pluck('pivot.id')->all();

              }

      //---------- Guardar la Reservacion - EntidadRole-------------

              foreach($entidadrol as $key3=> $n) //recorre todas las entidadesRol de la Reserva
              {

                  $identidadrol = implode($entidadrol[$key3]);
                  if (!empty($request->entidadrole_id)) {
                      $encargado = 0;
                  } elseif($key3 == 0 && empty($request->reservacione_id)) { // el encargado es el primero que se ingreso
                      $encargado = 1;
                  } else{
                      $encargado = 0;
                  }
                  //dd($key3);
                  $containers2[] = [
                                 'entidade_role_id'=>$identidadrol,
                                 //'reservacione_id'=> $reserva->id,
                                 'encargado'=> $encargado,
                                 'reservacion_habitacione_id'=> $reservacionhab->id,

                              ];
                }

              //dd($containers2);

             $reservacionentidadrol = ReservacionEntidadRole::insert($containers2);

             return redirect()->to("reservaciones")->with('msj', 'Datos guardados');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reserva = Reservacione::where('activo', 1)->find($id);

        //$reserva = Reservacione::whereIn('id', $id)->get();
        //dd($reserva);

        $datetoday = date('Y-m-d');

        $entidades = DB::table('reservaciones')
        ->where('reservaciones.id', '=', $id)
        ->join('reservacion_habitaciones', 'reservaciones.id', '=', 'reservacion_habitaciones.reservacione_id')
        ->join('reservacion_entidad_roles', 'reservacion_entidad_roles.reservacion_habitacione_id', '=', 'reservacion_habitaciones.id')
        ->join('entidade_role', 'entidade_role.id', '=', 'reservacion_entidad_roles.entidade_role_id')
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->select('entidades.nombres', 'entidades.apellidos', 'entidades.id',
         'reservacion_entidad_roles.encargado', 'reservacion_entidad_roles.reservacion_habitacione_id')->get();

        return view('reservaciones.show',compact('reserva', 'entidades', 'datetoday'));
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

    /* Cancelar una Reserva - Habitacion, dar de baja reserva */

    public function baja(Request $request, $id)
    {
        //busca la Reserva-habitacion a cancelar
        $reservahab = ReservacionHabitacione::find($id);
        $reservaid = $reservahab->reservacione_id; //obtiene el id de la reserva

        //cuenta las Rerseva-habitacion que sean de la misma reserva y que no esten canceladas
        $count = ReservacionHabitacione::where('reservacione_id', '=', $reservaid)->where('cancelada', '=', '0')->count();

        if($count == 1){ // si solo hay una Reserva-Habitacion que no este cancelada
           $reserva = Reservacione::find($reservaid);
           $reserva->activo=0; // Reserva pasa a Inactiva
           $reserva->update();
        }

        $reservahab->activo=0; //pasa a inactiva la Reserva-Habitacion
        $reservahab->cancelada=1;

        if($reservahab->update($request->all())){
             return redirect()->to("reservaciones")->with('msj', 'Datos guardados');
        } else {
            return back()->with('errormsj', 'Los datos no se guardaron');
        }
    }

    /* Dar de Baja*/

    public function noshow(Request $request, $id)
    {
        $reserva = Reservacione::find($id);
        // obtiene todas las reserva habitaciones de la reserva y las pasa a inactivo
        $reservahab = ReservacionHabitacione::where('reservacione_id', $id)
                                            ->update(['activo' => 0]);

        $reserva->activo=0; //pasa a inactivo la reserva
        $reserva->noshow=1; // pasa a true el campo no show

        if($reserva->update($request->all())){
             return redirect()->to("reservaciones")->with('msj', 'Datos guardados');
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
