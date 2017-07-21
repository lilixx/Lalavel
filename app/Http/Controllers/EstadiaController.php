<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HabitacionTipo;

use App\Estadia;

use App\EstadiaHabitacione;

use App\EntidadeRole;

use App\Habitacione;

use App\Entidade;

use App\Role;

use App\Folio;

use App\Tarifa;

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

    public function GetFilmBYid($id){
       //$tipohab = HabitacionTipo::find($id);
      //  dd($tipohab->habitaciones);
        //return HabitacionTipo::where('id', $id)->with('habitacione')->get();

        return HabitacionTipo::where('id', $id)->with('habitacione')->with('tarifa')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->all());

        if (!empty($request->estadia_id)) { //si es una hab. adicional a la estadia

              $id = $request->estadia_id;

              $estadia = Estadia::find($id); // busca la estadia

        } else {

            //---------- Guardar la Estadia -------------
            $estadia = Estadia::create($request->all());

         }

        //---------- Guardar la Estadia Habitacion -------------
        $estadiahab = new EstadiaHabitacione();
        $estadiahab->fechaentrada = date("Y-m-d");
        $estadiahab->fechasalida = $request->fechasalida;
        $estadiahab->tarifa_id = $request->tarifa_id;
        $estadiahab->habitacione_id = $request->habitacione_id;
        $estadiahabitacion = $estadia->estadiahabitaciones()->save($estadiahab);

        //---------- Cambia el estado de la Habitacion -------------

         $hab = $request->habitacione_id;
         $habitacion = Habitacione::find($hab);
         $habitacion->disponible = 0;
         $habitacion->update();

        //---------- Guardar las Entidades y su rol -------------

        foreach($request->nombres as $key2=> $m) //recorre todos los email
        {
            $containers[] = new Entidade(array(
                           'nombres'=>$request->nombres[$key2],
                           'apellidos'=>$request->apellidos[$key2],
                           'tipoentidade_id'=>1,

                        ));
        }

        $role = Role::find(1);

        $role->entidades()->saveMany($containers);

        //---------- Guardar la Entidade - Estadia Habitacion -------------


         $estadiahab->entidades()->saveMany($containers);

        if (empty($request->estadia_id)) { // si es una nueva estadia

            //---------- Agregando un folio  -------------

           //---------- Obteniendo el id de la Entidad Rol  -------------
             if (empty($request->entidadrole_id)) { //si no es un folio cliente

                foreach($containers as $c){
                   $entidad1 = $c->id;
                   break;
                }

                 $entidadrol = DB::table('entidade_role')
                 ->where('entidade_role.entidade_id', '=', $entidad1)
                 ->value('entidade_role.id');

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
       ->join('estadia_habitaciones', 'entidade_estadia_habitacione.estadia_habitacione_id', '=', 'estadia_habitaciones.id')
       ->where('estadia_habitaciones.estadia_id', '=', $id)
       ->join('entidades', 'entidades.id', '=', 'entidade_estadia_habitacione.entidade_id')
       ->select('entidade_estadia_habitacione.id', 'entidade_estadia_habitacione.estadia_habitacione_id as idestadiahab',
        'entidades.nombres', 'entidades.apellidos')->get();

       return view('estadias.show',compact('estadia', 'entidades'));

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
