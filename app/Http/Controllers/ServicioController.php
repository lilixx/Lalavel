<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Servicio;

use Teodolinda\Tarifa;

use Teodolinda\Categoria;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $request->user()->authorizeRoles(['Admin', 'Recepcionista']);
       $servicio = Servicio::where('activo', '=', 1)->paginate(10);

       return view('servicios.servicios',compact('servicio'));
    }

    public function autocomplete(Request $request)
    {
        $data = Servicio::select("id", "nombreservicio as name")->where("nombreservicio","LIKE","%{$request->input('term')}%")->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $categoria = Categoria::all();
        return view('servicios.create',compact('categoria'));
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
        $request->user()->authorizeRoles(['Admin']);
        $servicio = Servicio::create($request->all());

        //---------- Guarda la tarifa -------------
         $tarifa = new Tarifa();
         $tarifa->valor = $request->precio;
         $servicio->tarifa()->save($tarifa);

        if($servicio->save()){
           return redirect('servicios')->with('msj', 'Datos guardados');
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
        $servicio = Servicio::find($id);
        $categoria = Categoria::all();
        return view('servicios.edit')
        ->with(['edit' => true, 'servicio' => $servicio, 'categoria' => $categoria]);
    }

    /**
     * Modificar precio
     */

     public function editprecio(Request $request, $id)
     {
         $request->user()->authorizeRoles(['Admin']);
         $servicio = Servicio::find($id);
          return view('servicios.editprecio')
         ->with(['editprecio' => true, 'servicio' => $servicio]);
     }

    /**
     * Guardar nuevo precio
     */
     public function storeprecio(Request $request, $id)
     {
       $request->user()->authorizeRoles(['Admin']);
       /* Pasa a inactivo el precio anterior */
        $precioanterior = Tarifa::where('servicio_id', $id)->first();
        if (!empty($precioanterior)){ // si encontro un precio para el servicio
          $precioanterior->activo = 0; //lo pasa a inactivo
          $precioanterior->update();
        }

        $precio = new Tarifa();
        $precio->valor = $request->precio;
        $precio->servicio_id = $id;
        $precio->save(); // guarda la nueva tarifa

       if($precio->save()){
         return redirect('servicios')->with('msj', 'Datos guardados');
       } else {
         return back()->with('errormsj', 'Los datos no se guardaron');
       }
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
        $servicio = Servicio::find($id);
        //$servicio->nombreservicio = $request->nombreservicio;

        if($servicio->update($request->all())){
           return redirect('servicios')->with('msj', 'Datos guardados');
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
