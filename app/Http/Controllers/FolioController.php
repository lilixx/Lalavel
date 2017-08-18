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

use Barryvdh\DomPDF\Facade as PDF;

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

    public function invoicepdf(Request $request)
     {
       //dd($request->all());

       $folio = Folio::find(1);
       //dd($folio);
       $pdf = PDF::loadView('pruebaparapdf', ['request' => $request]);
       return $pdf->stream('pruebaparapdf.pdf');

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
     * Show the status account
     **/

    public function showstatus($id)
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

        $subtotal=0;
        $iva=0;
        $intur=0;
        $total= 0;

       foreach ($cargo as $car){

        // Si el cargo tiene descuento se le aplica el descuento
         if($car->descuento_id != NULL) {
           $precio = $car->servicio->precio -($car->servicio->precio * ($car->descuento->porcentaje /100));
         } else{
            $precio = $car->servicio->precio;
         }
         //dd($precio);
         $subtotal = $subtotal + ($precio * $car->cantidad);
        // dd($subtotal);
         if($car->servicio->categoria->id != 4){ //dd($precio);
            $iva = $iva + ($precio * $car->cantidad) * 0.15;
          //dd($iva);

        } if($car->servicio->categoria->id == 6){
            $intur=$intur+($precio *0.02);
         }
       }

       $total = $subtotal+$iva+$intur;
       $total= number_format((float)$total, 2, '.', '');
       $intur= number_format((float)$intur, 2, '.', '');
       $iva=number_format((float)$iva, 2, '.', '');

        return view('folios.showstatus',compact('folio', 'foliohijo', 'categoria', 'cargo', 'entidad', 'entidadhijo', 'subtotal', 'iva', 'intur', 'total'));
    }

    /**
     * Show the Invoice
     **/

    public function showinvoice($id)
    {
        $folio = Folio::find($id);

        $foliohijo = Folio::where('foliopadre_id', '=', $id)->where('activo', 1)->get();

        $supercategoria = DB::table('folio_cargos')
        ->where('folio_cargos.folio_id', '=', $id)
        ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
        ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
        ->join('super_categorias', 'super_categorias.id', '=', 'categorias.supercategoria_id')
        ->select('super_categorias.nombre', 'super_categorias.id', 'categorias.supercategoria_id');

        $categoria = DB::table('folio_cargos')
        ->where('folio_cargos.folio_id', '=', $id)
        ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
        ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
        ->where('categorias.supercategoria_id', '=', NULL)
        ->select('categorias.nombre', 'categorias.id', 'categorias.supercategoria_id')
        ->union($supercategoria)
        ->orderBy('supercategoria_id', 'asc')
        ->get();

      //  dd($categoria);


        $cate = DB::table('folio_cargos')
        ->where('folio_cargos.folio_id', '=', $id)
        ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
        ->join('descuentos', 'descuentos.id', '=', 'folio_cargos.descuento_id', 'left outer')
        ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
        ->join('super_categorias', 'super_categorias.id', '=', 'categorias.supercategoria_id', 'left outer')
        ->select('categorias.id', 'super_categorias.id as scat', 'folio_cargos.created_at')
        ->orderBy('scat', 'asc')
        ->groupBy('categorias.nombre')
        ->get();


       $sum = 0;

       //dd($cate);

       $cargo = FolioCargo::where('folio_id', '=', $id)->where('cubeta', 0)->get();

          foreach($cate as $cat){

                $id2 = $cat->id;

                 $idcat = $cat->id;

                 $idscat = $cat->scat;

                 $date = $cat->created_at;

                  $import2 = DB::table('folio_cargos')
                  ->where('folio_cargos.folio_id', '=', $id)
                  ->where('folio_cargos.cubeta', '=', 0)
                  ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
                  ->join('descuentos', 'descuentos.id', '=', 'folio_cargos.descuento_id')
                  ->where('servicios.categoria_id', '=', $id2)
                  ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
                  ->where('folio_cargos.descuento_id', '!=', NULL)
                  ->sum(DB::raw('folio_cargos.cantidad * (servicios.precio -(servicios.precio * (descuentos.porcentaje /100)))'));

                   $import = DB::table('folio_cargos')
                   ->where('folio_cargos.folio_id', '=', $id)
                   ->where('folio_cargos.cubeta', '=', 0)
                   ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
                   ->where('servicios.categoria_id', '=', $id2)
                   ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
                   ->where('folio_cargos.descuento_id', '=', NULL)
                   ->sum(DB::raw('servicios.precio * folio_cargos.cantidad'));

                    $importe = $import2+$import;

                    $datos[] = array("idcat"=>$idcat,"total"=>$importe, "idscat"=>$idscat, "date"=>$date);

           }

        $val = 0;

        $c = 0;

        $lastElement = end($datos);


         foreach($datos as $v=>$k){

            if($k["idscat"] != null){

               if($c == 0){
                 $val = $k["idscat"];
                 $c=$c+1;
               }

               if($val == $k["idscat"]){
                 $sum = $sum + $k["total"];
                 $val = $k["idscat"];

               } else{
                 $sumatoria = $sum;
                 $sumtotal[] = array("total"=>$sumatoria, "idscat"=>$val, "date"=>$k["date"]);
                 $sum = 0;
                 $sum = $sum + $k["total"];
                 $val = $k["idscat"];
               }

            } else{
               $sumatoria = $k["total"];
               $sumtotal[] = array("idcat"=>$k["idcat"],"total"=>$sumatoria, "idscat"=>$k["idscat"], "date"=>$k["date"]);
            }

            if($k == $lastElement){
               $sumatoria = $sum;
               $sumtotal[] = array("idcat"=>$k["idcat"],"total"=>$sumatoria, "idscat"=>$k["idscat"], "date"=>$k["date"]);
            }
          }

       foreach($categoria as  $d=> $ct){
         $fecha = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sumtotal[$d]["date"])->format('Y-m-d');
         $ct->total = $sumtotal[$d]["total"];
         $ct->total = number_format((float)$ct->total, 2, '.', '');
         $ct->date = $fecha;

        }

      // dd($categoria);

        $valor = 0;

        $count = 0;

        $resultado = count($categoria);

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

        $subtotal=0;
        $iva=0;
        $intur=0;
        $total= 0;

       foreach ($cargo as $car){

        // Si el cargo tiene descuento se le aplica el descuento
         if($car->descuento_id != NULL) {
           $precio = $car->servicio->precio -($car->servicio->precio * ($car->descuento->porcentaje /100));
         } else{
            $precio = $car->servicio->precio;
         }
         //dd($precio);
         $subtotal = $subtotal + ($precio * $car->cantidad);
        // dd($subtotal);
         if($car->servicio->categoria->id != 4){ //dd($precio);
            $iva = $iva + ($precio * $car->cantidad) * 0.15;
          //dd($iva);

        } if($car->servicio->categoria->id == 6){
            $intur=$intur+($precio *0.02);
         }
       }

       $total = $subtotal+$iva+$intur;
       $total= number_format((float)$total, 2, '.', '');
       $intur= number_format((float)$intur, 2, '.', '');
       $iva=number_format((float)$iva, 2, '.', '');

    //   dd($datos2);

       return view('folios.showinvoice')->with(['edit' => true, 'folio' => $folio, 'foliohijo' => $foliohijo, 'categoria' => $categoria,
              'cargo' => $cargo, 'entidad' => $entidad, 'entidadhijo' => $entidadhijo, 'subtotal' => $entidad, 'entidadhijo' => $entidadhijo,
               'subtotal' =>$subtotal, 'iva' => $iva, 'sumtotal' => $sumtotal, 'supercategoria' => $supercategoria, 'intur' => $intur,
               'count' => $count, 'total' => $total, 'valor' => $valor, 'importe' => $importe]);
    //  return view('folios.showinvoice',compact('folio', 'foliohijo', 'categoria', 'cargo', 'entidad', 'entidadhijo', 'subtotal', 'iva', 'intur', 'total'));
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
