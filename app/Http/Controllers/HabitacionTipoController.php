<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\HabitacionTipo;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Input;

class HabitacionTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        $habtipo = HabitacionTipo::all();
        return view('habitaciontipos.habitaciontipos',compact('habtipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin']);
        return view('habitaciontipos.create');
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
        $habtipo = new HabitacionTipo();
        $habtipo->nombre = $request->nombre;
        $habtipo->tarifainicial = $request->tarifainicial;

        if (!empty($request->urlimg)) {  // si agrego una imagen
            $img =  $request->file('urlimg');

            //nombre del archivo
            $file_route = time().'_'.$img->getClientOriginalName();

            //guarda la imagen en el disco

            Storage::disk('imgHabitaciones')->put($file_route, file_get_contents($img->getRealPath() ) );

            $habtipo->urlimg =  $file_route;
       }

        if($habtipo->save()){
            return redirect('habitaciontipos')->with('msj', 'Datos guardados');
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
        $habtipo = HabitacionTipo::find($id);
        return view('habitaciontipos.edit')
        ->with(['edit' => true, 'habtipo' => $habtipo]);
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
      /*  $habtipo = HabitacionTipo::find($id);

          if($habtipo->update($request->all())){
           return redirect('supercategorias')->with('msj', 'Datos guardados');
        } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
        } */
          $request->user()->authorizeRoles(['Admin']);
          $habtipo = HabitacionTipo::find($id);
          $habtipo->nombre = $request->nombre;
          $habtipo->tarifainicial = $request->tarifainicial;

          $file = Input::file('urlimg');
          $img = $request->file('urlimg');

         if (Input::hasFile('urlimg')) {

            $file_route = time().'_'.$img->getClientOriginalName();
        // se guarga en el disco  la imagen
          Storage::disk('imgHabitaciones')->put($file_route, file_get_contents( $img->getRealPath() ));

          // eliminar la imagen que estaba en el disco
          Storage::disk('imgHabitaciones')->delete($request->img);

          $habtipo->urlimg = $file_route;

        }

         if($habtipo->save()){
             return redirect('habitaciontipos')->with('msj', 'Datos guardados');
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
