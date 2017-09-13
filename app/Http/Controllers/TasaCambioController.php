<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\TasaCambio;

class TasaCambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Recepcionista']);
        $tasa = TasaCambio::where('activo', 1)->get();
        return view('tasacambios.tasacambios',compact('tasa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        return view('tasacambios.create');
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
       /* Pasa a inactivo la tasa anterior */
        $tasaanterior = TasaCambio::where('activo', 1)->first();
        if (!empty($tasaanterior)){ // si hay una tasa activa
          $tasaanterior->activo = 0;
          $tasaanterior->update();
        }

        $tasa = TasaCambio::create($request->all()); //crea la tasa

       if($tasa->save()){
         return redirect('tasacambios')->with('msj', 'Datos guardados');
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
