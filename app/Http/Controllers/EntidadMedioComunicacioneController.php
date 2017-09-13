<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\MedioComunicacione;

use Teodolinda\EntidadRole;

use Teodolinda\EntidadMedioComunicacione;

class EntidadMedioComunicacioneController extends Controller
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
    public function create($id)
    {
        $huespedid = $id;

        $rol = EntidadRole::where('entidade_id', $id)->value('role_id');


      /*  $rol = DB::table('entidad_roles')->select('entidad_roles.role_id')
        ->where('entidade_id', '=', $id)->get();*/

        $medio = Mediocomunicacione::all();
        return view('mediocomunicaciones.create',compact('medio', 'huespedid', 'rol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($medioc = EntidadMedioComunicacione::create($request->all())){
          if($request->rol == 1) {
           return redirect()->to("huespedes/$medioc->entidade_id/show")->with('msj', 'Datos guardados');
          } else {
           return redirect()->to("clientes/$medioc->entidade_id/show")->with('msj', 'Datos guardados');
          }
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
      $entidadmedio = EntidadMedioComunicacione::find($id);

      $id2 = $entidadmedio->entidade_id; //se obtiene el id de la entidad

      $rol = EntidadRole::where('entidade_id', $id2)->value('role_id');
      $medio = Mediocomunicacione::all();
      return view('mediocomunicaciones.edit')
      ->with(['edit' => true, 'entidadmedio' =>$entidadmedio, 'medio' => $medio, 'rol' => $rol]);
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
        $entidadmedio = EntidadMedioComunicacione::find($id);

        if($entidadmedio->update($request->all())){
            if($request->rol == 1) {
              return redirect()->to("huespedes/$entidadmedio->entidade_id/show")->with('msj', 'Datos guardados');
             } else {
               return redirect()->to("clientes/$entidadmedio->entidade_id/show")->with('msj', 'Datos guardados');
             }
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
