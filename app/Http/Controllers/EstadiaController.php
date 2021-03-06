<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\HabitacionTipo;

use Teodolinda\Estadia;

use Teodolinda\EstadiaHabitacione;

use Teodolinda\EntidadeRole;

use Teodolinda\Reservacione;

use Teodolinda\ReservacionHabitacione;

use Teodolinda\Habitacione;

use Teodolinda\Entidade;

use Teodolinda\Role;

use Teodolinda\Folio;

use Teodolinda\Tarifa;

use Teodolinda\EntidadeEstadiaHabitacione;

use DB;

class EstadiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estadia = Estadia::where('activo', 1)->get();
        return view('estadias.estadias',compact('estadia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipohab = HabitacionTipo::all();
        $cliente = new Entidade;
        $rol = Role::find(2);
        //$cliente = $cliente->roles()->wherePivot('role_id', '=', 2);
        return view('estadias.create',compact('tipohab', 'rol'));

    }

    public function createadicional($id)
    {
        $estadia = $id;
        $tipohab = HabitacionTipo::all();
        $cliente = new Entidade;
        $rol = Role::find(2);
        return view('estadias.createadicional',compact('tipohab', 'rol', 'estadia'));

    }

    public function GetFilmBYid($id, $date){

      //dd($date);
      $fechaentrada = date('Y-m-d');
      $fechasalida = $date;
      $tipohab = $id;

      $habitacione = DB::table('habitaciones')
        ->where('habitaciones.habitacion_tipo_id', '=', $tipohab)
        ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
        ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
        ->where('habitaciones.limpia', '=', 1)
        ->where('habitaciones.disponible', '=', 1)
        ->whereNotIn('habitaciones.id', function($query) use ($fechaentrada, $fechasalida)
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
         ->whereNotIn('habitaciones.id', function($query) use ($fechaentrada, $fechasalida)
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
            ->whereNotIn('habitaciones.id', function($query) use ($fechaentrada, $fechasalida)
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

       $tarifa = DB::table('tarifas')
         ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
         ->where('habitacion_tipos.id', '=', $tipohab)
         ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

        return compact(['habitacione', 'tarifa']);

      //  return HabitacionTipo::habitacione($fechaentrada, $fechasalida)->get();


      //return HabitacionTipo::with('habitacione')->with('tarifa')->get();
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

        if (!empty($request->estadia_id)) { //si es una hab. adicional a la estadia

              $id = $request->estadia_id;

              $estadia = Estadia::find($id); // busca la estadia

        } else {

            //---------- Guardar la Estadia -------------
            $estadia = Estadia::create($request->all());

         }


        //----------  Estadia Walking -------------

         if (empty($request->reservacione_id)) { // si es una estadia walking

          //---------- Guardar la Estadia Habitacion -------------
            $estadiahab = new EstadiaHabitacione();
            $estadiahab->fechaentrada = date("Y-m-d");
            $estadiahab->fechasalida = $request->fechasalida;
            $estadiahab->comentario = $request->comentario;
            $estadiahab->tarifa_id = $request->tarifa_id;
            $estadiahab->habitacione_id = $request->habitacione_id;
            $estadiahabitacion = $estadia->estadiahabitaciones()->save($estadiahab);

            //---------- Cambia el estado de la Habitacion -------------

             $hab = $request->habitacione_id;
             $habitacion = Habitacione::find($hab);
             $habitacion->disponible = 0;
             $habitacion->update();

           //----------Guarda las Entidades Roles -------------

             foreach($request->nombres as $key2=> $m) //recorre todos los email
             {
                 $containers[] = new Entidade(array(
                                'nombres'=>$request->nombres[$key2],
                                'apellidos'=>$request->apellidos[$key2],
                                'tipoentidade_id'=>1,
                                'fechaentrada' => date("Y-m-d"),

                             ));
             }

             $role = Role::find(1);

             $role->entidades()->saveMany($containers); //Guarda las entidades y su rol

             $estadiahab->entidades()->saveMany($containers);  //Guardar la Entidade - Estadia Habitacion
         }

        //----------  Estadia Reserva -------------

        else { //es una estadia desde Reserva

              foreach($request->habitacione_id as $key6=> $m) //recorre todos los email
              {
                  $containers6[] = new EstadiaHabitacione(array(
                                 'fechaentrada'=> date("Y-m-d"),
                                 'fechasalida'=> $request->fechasalida[$key6],
                                 'tarifa_id'=> $request->tarifa_id[$key6],
                                 'habitacione_id' => $request->habitacione_id[$key6],


                              ));
              }

              $estadiahabitacion = $estadia->estadiahabitaciones()->saveMany($containers6); //Guarda la estadia habitacione

            //dd($estadiahabitacion[0]->habitacione_id);

            //---------- Cambia el estado de la Habitacion -------------
              foreach($estadiahabitacion as $esh){
                 $hab = $esh->habitacione_id;
                 $habitacion = Habitacione::find($hab);
                 $habitacion->disponible = 0;
                 $habitacion->update();

              }

            //---------- Entidad Estadia Habitacion -------------

              $now = \Carbon\Carbon::now();

                foreach($request->habhuesped_id as $key=> $v) //recorre todas las hab. de cada entidad definidas en reserva
                 {
                     $eshab2 = $request->habhuesped_id[$key];
                     foreach($estadiahabitacion as $eh){
                        $eshab = $eh->habitacione_id;
                        if($eshab == $eshab2){ // si el id de la hab. de la entidad es igual al id de la hab. de estadiahabitacion
                           $idestadiahab = $eh->id; // se obtiene el id de estadiahabitacion
                        }
                     }

                      $containers[] = ([
                                          'entidade_id'=>$request->entidade_id[$key],
                                          'estadia_habitacione_id'=>$idestadiahab,
                                          'fechaentrada' => date("Y-m-d"),
                                          'created_at' => $now,
                                          'updated_at' => $now,

                                      ]);
                 }

             DB::table('entidade_estadia_habitacione')->insert($containers); // Guardar la Entidade - Estadia Habitacion

             //---------- Cambia el estado de la Reserva a Inactiva -------------

              $res = $request->reservacione_id;
              $reserva = Reservacione::find($res);
              $reserva->activo = 0;
              $reserva->update();

              //---------- Pasa a Inactiva la reservacion_habitaciones -------------

              $reservahab = DB::table('reservacion_habitaciones')
              ->where('reservacion_habitaciones.reservacione_id', '=', $res)
              ->get();

              foreach($reservahab as $rh){
                 $hab = $rh->id;
                 $reshab = ReservacionHabitacione::find($hab);
                 $reshab->activo = 0;
                 $reshab->update();

              }

        }


       //---------- Nueva Estadia -------------


        if (empty($request->estadia_id)) { // si es una nueva estadia

            //---------- Agregando un folio  -------------

           //---------- Obteniendo el id de la Entidad Rol  -------------
             if (empty($request->entidadrole_id) && empty($request->reservacione_id) ) { // folio huesped y Estadia walking

                foreach($containers as $c){
                   $entidad1 = $c->id;
                   break;
                }

                 $entidadrol = DB::table('entidade_role')
                 ->where('entidade_role.entidade_id', '=', $entidad1)
                 ->value('entidade_role.id');

            } elseif(empty($request->entidadrole_id) && !empty($request->reservacione_id)) { // folio huesped y estadia desde una reserva

                  $entidadrol = $request->entidade_id[0];

            } else { // es un folio cliente

                  $entidadrol = $request->entidadrole_id;
            }

            //---------- Guardar el folio -------------
             $folio = new Folio();
             $folio->entidadrole_id = $entidadrol;
             $folio->credito = $request->credito;
             $estadia->folio()->save($folio);

        } //fin de folio

         return redirect('estadias')->with('msj', 'Datos guardados');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $estadia = Estadia::find($id);

       $entidades = DB::table('entidade_estadia_habitacione')
       ->where('entidade_estadia_habitacione.activo', '=', 1)
       ->join('estadia_habitaciones', 'entidade_estadia_habitacione.estadia_habitacione_id', '=', 'estadia_habitaciones.id')
       ->where('estadia_habitaciones.estadia_id', '=', $id)
       ->join('entidades', 'entidades.id', '=', 'entidade_estadia_habitacione.entidade_id')
       ->select('entidade_estadia_habitacione.id as identidadesthab', 'entidade_estadia_habitacione.estadia_habitacione_id as idestadiahab',
        'entidades.nombres', 'entidades.apellidos', 'entidades.id as identidad')->get();

       if($estadia->activo == 1){
         return view('estadias.show',compact('estadia', 'entidades'));
       }

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
