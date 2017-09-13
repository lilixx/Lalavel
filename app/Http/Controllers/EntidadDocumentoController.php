<?php

namespace Teodolinda\Http\Controllers;

use Illuminate\Http\Request;

use Teodolinda\EntidadDocumento;

use Teodolinda\TipoDocumento;

class EntidadDocumentoController extends Controller
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
      $tipodoc = TipoDocumento::all();
      return view('dochuespedes.create',compact('tipodoc', 'huespedid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        if($dochuespede = EntidadDocumento::create($request->all())){
           return redirect()->to("huespedes/$dochuespede->entidade_id/show")->with('msj', 'Datos guardados');
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
        $dochuespede = EntidadDocumento::find($id);
        $tipodoc = TipoDocumento::all();
        return view('dochuespedes.edit')
        ->with(['edit' => true, 'dochuespede' =>$dochuespede, 'tipodoc' => $tipodoc]);
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
        $dochuespede = EntidadDocumento::find($id);

        if($dochuespede->update($request->all())){
           return redirect()->to("huespedes/$dochuespede->entidade_id/show")->with('msj', 'Datos guardados');
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
