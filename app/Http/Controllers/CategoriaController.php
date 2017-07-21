<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;

use App\Categoria;

use App\SuperCategoria;

use Illuminate\Support\Facades\Input;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $categoria = DB::table('categorias')
         ->join('super_categorias', 'super_categorias.id', '=', 'categorias.supercategoria_id', 'left outer')
         ->select('categorias.*', 'super_categorias.nombre as nombresuper')->get();

          return view('categorias.categorias',compact('categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supercategoria = SuperCategoria::all();
        return view('categorias.create',compact('supercategoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = Categoria::create($request->all());

        if($categoria->save()){
           return redirect('categorias')->with('msj', 'Datos guardados');
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
        $categoria = Categoria::find($id);
        $supercategoria = SuperCategoria::all();
        return view('categorias.edit')
        ->with(['edit' => true, 'categoria' => $categoria, 'supercategoria' => $supercategoria]);
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
        $categoria = Categoria::find($id);

        if($categoria->update($request->all())){
           return redirect('categorias')->with('msj', 'Datos guardados');
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
