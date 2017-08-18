<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EstadiaHabitacione;

use App\HabitacionTipo;

use App\Entidade;

use Illuminate\Support\Facades\Input;

use App\Role;

use Illuminate\Support\Facades\DB;

class EstadiaHabitacionController extends Controller
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

    public function createhuesped($id)
    {
        return view('estadiaentidad.createhuesped',compact('id'));
    }

    public function move($id)
    {
         $estadiahab = DB::table('entidade_estadia_habitacione')
         ->where('entidade_estadia_habitacione.id', '=', $id)
         ->join('entidades', 'entidades.id', '=', 'entidade_estadia_habitacione.entidade_id')
         ->join('estadia_habitaciones', 'entidade_estadia_habitacione.estadia_habitacione_id', '=', 'estadia_habitaciones.id')
         ->select('entidade_estadia_habitacione.*', 'entidades.nombres', 'entidades.apellidos', 'estadia_habitaciones.habitacione_id')
         ->get();

         $idhabitacion = ($estadiahab[0]->habitacione_id);// se obtiene el id de la hab. en la que esta el huesped actualmente


         $estadia = DB::table('entidade_estadia_habitacione')
         ->where('entidade_estadia_habitacione.id', '=', $id)
         ->join('estadia_habitaciones', 'entidade_estadia_habitacione.estadia_habitacione_id', '=', 'estadia_habitaciones.id')
         ->join('estadias', 'estadias.id', '=', 'estadia_habitaciones.estadia_id')
         ->value('estadias.id');


         $habitacion = DB::table('estadias')
         ->where('estadias.id', '=', $estadia)
         ->join('estadia_habitaciones', 'estadia_habitaciones.estadia_id', '=', 'estadias.id')
         ->join('habitaciones', 'habitaciones.id', '=', 'estadia_habitaciones.habitacione_id')
         ->whereNOTIn('habitaciones.id', array($idhabitacion))
         ->select('habitaciones.numero', 'estadia_habitaciones.id') //obtiene todas las hab. de la estadia menos en la que esta actualmente el huesped
         ->get();

         $f = 0;

         return view('estadiahab.move',compact('estadiahab', 'habitacion', 'id', 'f'));

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
        $huesped = new Entidade();
        $huesped->nombres = $request->nombres;
        $huesped->apellidos = $request->apellidos;
        $huesped->tipoentidade_id = 1;
      //

        $role = Role::find(1);

        $entidadrole = $role->entidades()->save($huesped); //guarda el huesped y entidadrole

        $id = $request->estadia_habitacione_id;

        $estadiahab = EstadiaHabitacione::find($id);

        $fechaentrada = date("Y-m-d");

        $estadiahab->entidades()->save($huesped, ['fechaentrada' => $fechaentrada]);  //Guardar la Entidade - Estadia Habitacion

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
      $estadiahab = EstadiaHabitacione::find($id);
      $tipohab = HabitacionTipo::all();

      $fechaentrada = Input::has('fechaentrada') ? Input::get('fechaentrada') : null;
      $fechasalida = Input::has('fechasalida') ? Input::get('fechasalida') : null;
      $tipohab = Input::has('tipohab') ? Input::get('tipohab') : null;
      $rol = Role::find(2);

      if($fechasalida != null) {
          $valth = $tipohab;


            $hablibres2 = DB::table('habitaciones')
              ->where('habitaciones.habitacion_tipo_id', '=', $valth)
              ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
              ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
              ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                         {
                             $query->from('reservacion_habitaciones')
                             ->where('reservacion_habitaciones.fechasalida', '>=', $fechasalida)
                             ->orWhere('reservacion_habitaciones.fechasalida', '>', $fechaentrada)
                             ->select('reservacion_habitaciones.habitacione_id');
                          });
          //  dd($hablibres2);

            $hablibres = DB::table('habitaciones')
            ->where('habitaciones.habitacion_tipo_id', '=', $valth)
            ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
            ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
            ->WhereIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                  {
                       $query->from('reservacion_habitaciones')
                    //  ->where('reservacion_habitaciones.activo', '=', 0)
                        ->where('reservacion_habitaciones.fechasalida', '<=', $fechaentrada)
                       ->orWhere('reservacion_habitaciones.fechaentrada', '>=', $fechasalida)

                       ->select('reservacion_habitaciones.habitacione_id');
               } )
            ->union($hablibres2)

             ->get();

            // dd($hablibres);




          $tipohab = HabitacionTipo::all();

          $tarifa = DB::table('tarifas')
            ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
            ->where('habitacion_tipos.id', '=', $valth)
            ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

      } else {
          $hablibres = [];
          $tarifa = [];
          $tipohab = HabitacionTipo::all(); $valth = 0; }


      return view('estadiahab.edit', compact(['hablibres'], 'tipohab', 'valth', 'estadiahab', 'tarifa', 'rol'));
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
       //dd($request->all());
      // Cambia de Habitacion al Huesped (funcion move)
        if (!empty($request->identidadestadiahab)) {
          $id = $request->identidadestadiahab;
          $estadiahab= $request->estadia_habitacione_id;
          DB::table('entidade_estadia_habitacione')->where('id', $id)->update(['estadia_habitacione_id'=>$estadiahab]);
          return redirect('estadias')->with('msj', 'Datos guardados');

      //Check out del Huesped
    } elseif(!empty($request->fechasalidaout)) {
            $fechasalida= $request->fechasalida;
            DB::table('entidade_estadia_habitacione')->where('id', $id)->update(['fechasalida'=>$fechasalida, 'activo'=>0]);
            return redirect('estadias')->with('msj', 'Datos guardados');

      //Actualizacion de Estadia Habitacion
        } else {
            $estadiahab = EstadiaHabitacione::find($id);

            if($estadiahab->update($request->all())){
               return redirect('estadias')->with('msj', 'Datos guardados');
            } else {
               return back()->with('errormsj', 'Los datos no se guardaron');
            }
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

    }
}
