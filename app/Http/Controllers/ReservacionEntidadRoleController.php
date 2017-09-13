<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Entidade;

use Teodolinda\Role;

use Teodolinda\ReservacionEntidadRole;

class ReservacionEntidadRoleController extends Controller
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

    }

    public function createhuesped($id)
    {
        return view('reservaentidad.createhuesped',compact('id'));
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
        $huesped = new Entidade();
        $huesped->nombres = $request->nombres;
        $huesped->apellidos = $request->apellidos;
        $huesped->tipoentidade_id = 1;

        $role = Role::find(1);

        $entidadrole = $role->entidades()->save($huesped); //guarda el huesped y entidadrole

        $entr = $entidadrole->id;

        $entidadrol = Entidade::find($entr)->roles->pluck('pivot.id'); //busca el id de su entidarole

      //  dd($entidadrol[0]);

        $reservaentidad = new ReservacionEntidadRole();
        $reservaentidad->reservacion_habitacione_id = $request->reservacion_habitacione_id;
        $reservaentidad->entidade_role_id = $entidadrol[0];

        if($reservaentidad->save()){ //guarda reserva entidad
           return redirect('reservaciones')->with('msj', 'Datos guardados');
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
