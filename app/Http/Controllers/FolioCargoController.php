<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Folio;

use App\Servicio;

use App\FolioCargo;

use App\BitacoraFolioCargo;

use App\Descuento;

use Illuminate\Support\Facades\Auth;

use DB;

use App\Events\Enviocubetafoliocargo;

use App\Events\Creaciondefoliocargo;

use App\Events\Cambiodefoliocargo;

use App\Events\Revisiondecubetafoliocargo;

use Illuminate\Support\Facades\Event;

class FolioCargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foliocargo = FolioCargo::where('cubeta', 1)->where('activo', 1)->get();
        return view('foliocargos.foliocargos',compact('foliocargo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
          $folioid = $id;

          $folio = Folio::find($id);

          $credito = $folio->credito;

          if ($credito == 1) {

                $restrinccion = DB::table('folio_restrinccion_categorias')
                ->where('folio_restrinccion_categorias.folio_id', '=', $id )
                ->join('categorias', 'categorias.id', '=', 'folio_restrinccion_categorias.categoria_id')
                ->select('categorias.nombre')
                ->get();

                if(count($restrinccion) > 0){ //si hay ciertas categorias no permitidas

                        $cargo=DB::table('servicios')->whereNotIn('servicios.categoria_id', function($query) use ($folioid){
                            $query->select('folio_restrinccion_categorias.categoria_id')
                                ->from('folio_restrinccion_categorias')
                                ->where('folio_restrinccion_categorias.activo', '=', 1)
                                ->whereRaw('servicios.categoria_id=folio_restrinccion_categorias.categoria_id')
                                ->where('folio_restrinccion_categorias.folio_id', '=', $folioid);
                        })->get();

                }  else {
                   $cargo = Servicio::all();
                }

                $descuento = Descuento::where('activo', 1)->get();

                return view('foliocargos.create',compact('cargo', 'folioid', 'credito', 'descuento'));
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
          $idfolio= $request->folio_id;
          $now = \Carbon\Carbon::now();
          foreach($request->servicio_id as $key=> $v) //recorre todos los email
          {
              $containers[] =  [
                           'servicio_id'=>$request->servicio_id[$key],
                           'folio_id'=>$idfolio,
                           'cantidad' =>$request->cantidad[$key],
                           'descuento_id'=>$request->descuento_id[$key],
                           'created_at' => $now,
                           'updated_at' => $now,
                  
                         ];
          }

          $cargofolio = FolioCargo::insert($containers);

          Event::fire(new Creaciondefoliocargo($idfolio));

          return redirect()->to("folios/$idfolio/show")->with('msj', 'Datos guardados');

    }

    /** Move Cargo other Folio */

    public function move($id)
    {
         $foliocargo = Folio::find($id);

         $tipofolio = $foliocargo->foliopadre_id;

         if($tipofolio == null) { //Folio Principal
            $folio = Folio::where('foliopadre_id', '=', $id)->orWhere('foliopadre_id', '=', NULL)
            ->where('id', '!=', $id)->where('activo', 1)->where('credito', 1)->get();
         } else {
            $folio = Folio::where('id', '!=', $id)->where('foliopadre_id', '=', $tipofolio) //folio hijo
            ->orWhere('foliopadre_id', '=', NULL)
            ->where('credito', 1)
            ->where('activo', 1)
            ->get();
         }

         $f = 0;

         $cargo = FolioCargo::where('folio_id', '=', $id)->where('cubeta', 0)->get();

          return view('foliocargos.move')
          ->with(['edit' => true, 'folio' => $folio, 'cargo' => $cargo, 'f' =>$f, 'id' => $id]);

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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function cubeta($id)
    {
        $foliocargo = Foliocargo::find($id);
        return view('foliocargos.cubeta')
        ->with(['edit' => true, 'foliocargo' => $foliocargo]);

    }

    public function update(Request $request, $id)
    {
      //update de mover cargos a otro folio
        //dd($request->all());
        $now = \Carbon\Carbon::now();

        //id del folio anterior
         $folioanterior = $request->folio_anterior;

        //mover cargo a otro folio
          $foliodestino = $request->folio_id;

            if (!empty($foliodestino)) {
                   foreach($request->id as $key=> $v) //recorre todos los cargos a moverse
                    {
                         $id = $request->id[$key];
                         $foliocargo = FolioCargo::find($id);

                         $idfoliocargo = $foliocargo->id;

                          $foliocargo->update(array(
                                       'folio_id'=>$foliodestino,
                                       'updated_at' => $now,
                                     )
                               );

                          Event::fire(new Cambiodefoliocargo($folioanterior, $foliodestino, $idfoliocargo));

                    }

               return redirect()->to("folios/$foliodestino/show")->with('msj', 'Datos guardados');
            }

          //Update envio de cargos a cubeta y revision de cubeta

            $foliocargo = FolioCargo::find($id);

            $idfolio = $foliocargo->folio->id;

            if($foliocargo->update($request->all())){

                if (!empty($request->comentariocubeta)) { // Verifica que es un cargo enviado a cubeta

                     Event::fire(new Enviocubetafoliocargo($foliocargo));

                    return redirect()->to("folios/$idfolio/show")->with('msj', 'Datos guardados');

                } else { // Es un cargo revisado desde cubeta, pasando a inactivo

                      Event::fire(new Revisiondecubetafoliocargo($foliocargo));
                      return back()->with('msj', 'Cargo revisado');
                }

            } else {

               return back()->with('errormsj', 'Los datos no se actualizarón');

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
