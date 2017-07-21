<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\FolioRestrinccionCategoria;

use App\Categoria;

class FolioRestrinccionCategoriaController extends Controller
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
          $folioid = $id;
          //dd($folioid);

         $categoria=DB::table('categorias')->whereNotIn('categorias.id', function($query) use ($folioid){
                $query->select('folio_restrinccion_categorias.categoria_id')
                    ->from('folio_restrinccion_categorias')
                    ->where('folio_restrinccion_categorias.activo', '=', 1)
                    ->whereRaw('categorias.id=folio_restrinccion_categorias.categoria_id')
                    ->where('folio_restrinccion_categorias.folio_id', '=', $folioid);
            })->get();

          return view('restrinccioncat.create',compact('categoria', 'folioid'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idfolio= $request->folio_id;
        $now = \Carbon\Carbon::now();
        foreach($request->categoria_id as $key=> $v) //recorre todos los email
        {
            $containers[] =  [
                         'categoria_id'=>$request->categoria_id[$key],
                         'folio_id'=>$idfolio,
                         'created_at' => $now,
                         'updated_at' => $now,
                       ];
        }

        if($categoriafolio = FolioRestrinccionCategoria::insert($containers)){
           return redirect()->to("folios/$idfolio/show")->with('msj', 'Datos guardados');
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
        $categoria = FolioRestrinccionCategoria::find($id);
        $categoria->activo=2;

        if($categoria->update($request->all())){
           return back()->with('msj', 'Datos guardados');
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
