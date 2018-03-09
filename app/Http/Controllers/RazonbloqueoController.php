<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\Razonbloqueo;

class RazonbloqueoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $request->user()->authorizeRoles(['Admin']);
      $razonbloqueo = Razonbloqueo::all();
      return view('razonbloqueos.razonbloqueos', compact('razonbloqueo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $request->user()->authorizeRoles(['Admin']);
      return view('razonbloqueos.create');
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
        $razonbloqueo = Razonbloqueo::create($request->all());

        if($razonbloqueo->save()){
           return redirect('razonbloqueos')->with('msj', 'Datos guardados');
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
        $razonbloqueo = Razonbloqueo::find($id);
        return view('razonbloqueos.edit')
        ->with(['edit' => true, 'razonbloqueo' => $razonbloqueo]);
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
        $razonbloqueo = Razonbloqueo::find($id);
        $razonbloqueo->nombre = $request->nombre;

        if($razonbloqueo->save()){
           return redirect('razonbloqueos')->with('msj', 'Datos guardados');
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
