<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\FolioRestrinccionCategoria;

use App\Folio;

use App\EntidadRole;

use App\Entidade;

use App\FolioCargo;

use App\EstadiaHabitacione;

class FolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     //  $folio = Folio::where('activo', 1)->where('foliopadre_id', '=', NULL)->get();
       $folio = DB::table('folios')
      ->where('folios.foliopadre_id', '=', NULL)
      ->where('folios.activo', 1)
      ->join('entidade_role', 'entidade_role.id', '=', 'folios.entidadrole_id')
      ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
      ->select('folios.*', 'entidades.nombres', 'entidades.apellidos')->get();

      $habitaciones = EstadiaHabitacione::where('activo', 1)->get();

      $foliohijo = DB::table('folios')
     ->where('folios.foliopadre_id', '!=', NULL)
     ->where('folios.activo', 1)
     ->join('entidade_role', 'entidade_role.id', '=', 'folios.entidadrole_id')
     ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
     ->select('folios.*', 'entidades.nombres', 'entidades.apellidos')->get();

    //  $foliohijo = Folio::where('foliopadre_id', '!=', NULL)->where('activo', 1)->get();

      return view('folios.folios',compact('folio', 'foliohijo', 'habitaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $huesped = DB::table('entidades')
      ->where('entidades.activo', 1)
      ->join('entidade_role', 'entidade_role.entidade_id', '=', 'entidades.id')
      ->where('entidade_role.role_id', '=', 1)
      ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();


      $cliente = DB::table('entidades')
      ->where('entidades.activo', 1)
      ->join('entidade_role', 'entidade_role.entidade_id', '=', 'entidades.id')
      ->where('entidade_role.role_id', '=', 2)
      ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

      //  $cliente = EntidadRole::where('role_id', 2)->get();
      //  $huesped = EntidadRole::where('role_id', 1)->get();
        $folioextra = '';
        //dd($cliente);
        return view('folios.create',compact('entidadrol', 'cliente', 'huesped', 'entidad', 'folioextra'));
    }

    public function createchild($id)
    {
       $folio = Folio::find($id);
       if($folio->foliopadre_id == NULL) {
         $folioextra = $id;
         $huesped = DB::table('entidades')
         ->where('entidades.activo', 1)
         ->join('entidade_role', 'entidade_role.entidade_id', '=', 'entidades.id')
         ->where('entidade_role.role_id', '=', 1)
         ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

         $cliente = DB::table('entidades')
         ->where('entidades.activo', 1)
         ->join('entidade_role', 'entidade_role.entidade_id', '=', 'entidades.id')
         ->where('entidade_role.role_id', '=', 2)
         ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();
         return view('folios.create',compact('entidadrol', 'cliente', 'huesped', 'entidad', 'folioextra'));
      }
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

        $folio = Folio::create($request->all());

        if($folio->save()){
           return redirect('folios')->with('msj', 'Datos guardados');
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
        $folio = Folio::find($id);

        //dd($folio->entidadrole->entidade->nombres);
        $foliohijo = Folio::where('foliopadre_id', '=', $id)->where('activo', 1)->get();

        $categoria = FolioRestrinccionCategoria::where('folio_id', '=', $id)->where('activo', 1)->get();

        $cargo = FolioCargo::where('folio_id', '=', $id)->where('cubeta', 0)->get();


        $entidad = DB::table('entidade_role')
        ->join('folios', 'entidade_role.id', '=', 'folios.entidadrole_id')
        ->where('folios.id', '=', $id)
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

        $entidadhijo = DB::table('entidade_role')
        ->join('folios', 'entidade_role.id', '=', 'folios.entidadrole_id')
        ->where('folios.foliopadre_id', '=', $id)
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();


        return view('folios.show',compact('folio', 'foliohijo', 'categoria', 'cargo', 'entidad', 'entidadhijo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $folio = Folio::find($id);

        $entidadactual = DB::table('entidade_role')
        ->join('folios', 'entidade_role.id', '=', 'folios.entidadrole_id')
        ->where('folios.id', '=', $id)
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

        $entidad = DB::table('entidade_role')
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->where('entidades.activo', 1)
        ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

        return view('folios.edit')->with(['edit' => true, 'folio' => $folio, 'entidad' => $entidad, 'entidadactual' => $entidadactual]);
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
       $folio = Folio::find($id);

       if($folio->update($request->all())){
          return redirect()->to("folios/$id/show")->with('msj', 'Datos guardados');
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
