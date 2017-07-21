<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HabitacionTipo;

use App\Entidade;

use App\Role;

use App\Reservacione;

use App\ReservacionHabitacione;

class ReservacioneController extends Controller
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
      $tipohab = HabitacionTipo::all();
      $cliente = new Entidade;
      $rol = Role::find(2);
      //$cliente = $cliente->roles()->wherePivot('role_id', '=', 2);
      return view('reservaciones.create',compact('tipohab', 'rol', 'cliente'));
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

        //---------- Guardar la Reserva -------------
        $reserva = Reservacione::create($request->all());

        //---------- Guardar la Reservacion Habitacion -------------
        $reservacionhab = new ReservacionHabitacione();
        $reservacionhab->fechaentrada = $request->fechaentrada;
        $reservacionhab->fechasalida = $request->fechasalida;
        $reservacionhab->tarifa_id = $request->tarifa_id;
        $reservacionhab->habitacione_id = $request->habitacione_id;
        $reserva->reservacionhabitaciones()->save($reservacionhab);

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

              $role = Role::find(1);

              $entidadrole = $role->entidades()->saveMany($containers);

              dd($entidadrole);
         }

         if (!empty($request->entidadrole_id)) {

         }

       //---------- Guardar la Entidade Role - Reservacione -------------

       $reservacionhab->entidades()->saveMany($containers);


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
