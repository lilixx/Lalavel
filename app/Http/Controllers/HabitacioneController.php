<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Habitacione;

use Teodolinda\HabitacionTipo;

class HabitacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Recepcionista']);
        $habitacion = Habitacione::all();
    //  dd($habitacion);
        return view('habitaciones.habitaciones',compact('habitacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habtipo = HabitacionTipo::all();
        return view('habitaciones.create',compact('habtipo'));
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
        $habitacion = Habitacione::create($request->all());

        if($habitacion->save()){
           return redirect('habitaciones')->with('msj', 'Datos guardados');
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
    public function edit($id, Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habitacion = Habitacione::find($id);
        $habtipo = HabitacionTipo::all();
        return view('habitaciones.edit')
        ->with(['edit' => true, 'habitacion' => $habitacion, 'habtipo' => $habtipo]);
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
        $habitacion = Habitacione::find($id);

        if($habitacion->update($request->all())){
           return redirect('habitaciones')->with('msj', 'Datos guardados');
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
