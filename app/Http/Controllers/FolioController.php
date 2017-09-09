<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use DB;
use App\Factura;
use App\FolioRestrinccionCategoria;

use App\Folio;

use Illuminate\Support\Facades\Input;

use Session;

use App\EntidadRole;

use App\Entidade;

use App\Estadia;

use App\Habitacione;

use App\FolioCargo;

use App\TasaCambio;

use App\EntidadeEstadiaHabitacione;

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
        // Se obtiene el id de la Tasa de Cambio
        $tasaid = TasaCambio::where('activo', 1)->value('id');

        // Se guarda la Factura
         $factura = new Factura();
         $factura->folio_id = $request->folio_id;
         $factura->tasacambio_id = $tasaid;
         $factura->save();

        /* Pasa a Inactivo al Folio */
         $folio = Folio::find($request->folio_id);
         $folio->activo = 0;
         $folio->update();

         // Se obtiene el valor de la Tasa de Cambio
          $tasa = TasaCambio::where('activo', 1)->value('valorventa');

         $equivalente = $request->total / $tasa;
         $equivalente= number_format((float)$equivalente, 2, '.', '');

         //dd(Input::get('contado'));

         if(Input::get('contado') == 1) {
           //dd($request->all());
           $pdf = PDF::loadView('factcontadopdf', ['request' => $request, 'tasa' => $tasa, 'equivalente'=>$equivalente]);
           return $pdf->stream('factcontadopdf.pdf',array('Attachment'=>0));
         } elseif (Input::get('credito') == 1) {
           $pdf = PDF::loadView('factcreditopdf', ['request' => $request, 'tasa' => $tasa, 'equivalente'=>$equivalente]);
           return $pdf->stream('factcreditopdf.pdf',array('Attachment'=>0));
         }

    }

    public function out(Request $request)
     {
        //dd($request->all());
        $estadia = Estadia::find($request->estadia_id);
        $estadia->activo = 0;
        $estadia->update();

        foreach($request->habitacion_id as $key=> $v) //recorre todos los cargos a moverse
         {
              $habitacion = Habitacione::find($request->habitacion_id[$key]);
              $habitacion->disponible = 1;
              $habitacion->limpia = 0;
              $habitacion->update();
         }

         foreach($request->estadia_hab_id as $key2=> $v2) //recorre todos los cargos a moverse
          {
               $estadiahab = EstadiaHabitacione::find($request->estadia_hab_id[$key2]);
               $estadiahab->activo = 0;
               $estadiahab->update();
          }

          foreach($request->entidad_id as $key3=> $v3) //recorre todos los cargos a moverse
           {
                DB::table('entidades')
                ->where('id', $request->entidad_id[$key3])
                ->update(['activo' => 0]);
           }

           foreach($request->estadia_hab_entidad_id as $key4=> $v4) //recorre todos los cargos a moverse
            {
                DB::table('entidade_estadia_habitacione')
                ->where('id', $request->estadia_hab_entidad_id[$key4])
                ->update(['activo' => 0]);
            }

          return redirect('folios')->with('msj', 'Datos Actualizados');
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

        $foliohijo = Folio::where('foliopadre_id', '=', $id)->where('activo', 1)->get();

        $entidadhijo = DB::table('entidade_role')
        ->join('folios', 'entidade_role.id', '=', 'folios.entidadrole_id')
        ->where('folios.foliopadre_id', '=', $id)
        ->join('entidades', 'entidades.id', '=', 'entidade_role.entidade_id')
        ->select('entidade_role.id', 'entidades.nombres', 'entidades.apellidos')->get();

        $categoria = FolioRestrinccionCategoria::where('folio_id', '=', $id)->where('activo', 1)->get();

        $cargo = FolioCargo::where('folio_id', '=', $id)->where('cubeta', 0)->get();

        $entidad = DB::table('entidade_role')
        ->join('folios', 'entidade_role.id', '=', 'folios.entidadrole_id')
        ->where('folios.id', '=', $id)
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
         } elseif($car->servicio->categoria->id == 1){
           $precio = $car->estadiahabitacion->tarifa->valor;
           //dd($precio);
         } else{
            $precio = $car->servicio->precio;
         }
         //dd($precio);
         $subtotal = $subtotal + ($precio * $car->cantidad);
        // dd($subtotal);
         if($car->servicio->categoria->id != 4){ //dd($precio);
            $iva = $iva + ($precio * $car->cantidad) * 0.15;
          //dd($iva);

        } if($car->servicio->categoria->id == 1){
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
        //dd($folio->activo);

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
        ->orderBy('id', 'asc')
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
        ->orderBy('categorias.id', 'asc')
        ->groupBy('categorias.nombre')
        ->get();

      //  dd($cate);


       $sum = 0;

       //dd($cate);

    //   $cargo = FolioCargo::where('folio_id', '=', $id)->where('cubeta', 0)->get();

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
                   ->where('servicios.categoria_id', '!=', 1)
                   ->sum(DB::raw('servicios.precio * folio_cargos.cantidad'));

                   $import3 = DB::table('folio_cargos')
                   ->where('folio_cargos.folio_id', '=', $id)
                   ->where('folio_cargos.cubeta', '=', 0)
                   ->join('servicios', 'servicios.id', '=', 'folio_cargos.servicio_id')
                   ->where('servicios.categoria_id', '=', $id2)
                   ->join('categorias', 'categorias.id', '=', 'servicios.categoria_id')
                   ->where('folio_cargos.descuento_id', '=', NULL)
                   ->where('servicios.categoria_id', '=', 1)
                   ->join('tarifas', 'tarifas.id', '=', 'folio_cargos.tarifa_id')
                   ->sum(DB::raw('tarifas.valor * folio_cargos.cantidad'));


                    $importe = $import2+$import+$import3;

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

       $tasa = TasaCambio::where('activo', 1)->value('valorventa');

       foreach($categoria as  $d=> $ct){
         $fecha = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sumtotal[$d]["date"])->format('Y-m-d');
         $ct->total = $sumtotal[$d]["total"]*$tasa;
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
        ->select('entidade_role.role_id', 'entidades.nombres', 'entidades.apellidos')->get();

        $subtotal=0;
        $iva=0;
        $intur=0;
        $total= 0;

       foreach ($cargo as $car){

        // Si el cargo tiene descuento se le aplica el descuento
         if($car->descuento_id != NULL) {
           $precio = $car->servicio->precio -($car->servicio->precio * ($car->descuento->porcentaje /100));
         } elseif ($car->servicio->categoria->id == 1) {
            $precio = $car->estadiahabitacion->tarifa->valor;
         }  else{
            $precio = $car->servicio->precio;
         }
         //dd($precio);
         $subtotal = $subtotal + ($precio * $car->cantidad);
        // dd($subtotal);
         if($car->servicio->categoria->id != 4){ //dd($precio);
            $iva = $iva + ($precio * $car->cantidad) * 0.15;
          //dd($iva);

        } if($car->servicio->categoria->id == 1){
            $intur=$intur+($precio *0.02);
        }
       }

       //dd($tasa);



       $subtotal = $subtotal * $tasa;
       $iva = $iva * $tasa;
       $intur = $intur * $tasa;


      // dd($intur);

       $subtotal= number_format((float)$subtotal, 2, '.', '');
       $intur= number_format((float)$intur, 2, '.', '');
       $iva=number_format((float)$iva, 2, '.', '');
       $total = $subtotal+$iva+$intur;
       $total=number_format((float)$total, 2, '.', '');  
       //dd($intur);

       return view('folios.showinvoice')->with(['edit' => true, 'folio' => $folio, 'foliohijo' => $foliohijo, 'categoria' => $categoria,
              'cargo' => $cargo, 'entidad' => $entidad, 'subtotal' => $entidad,'subtotal' =>$subtotal,
               'iva' => $iva, 'sumtotal' => $sumtotal, 'supercategoria' => $supercategoria, 'intur' => $intur,
               'count' => $count, 'total' => $total, 'valor' => $valor, 'importe' => $importe, 'id' =>$id]);


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
     * check out
     */
     public function checkout($id)
     {
        $folio = Folio::find($id);

        $idestadia = $folio->estadia_id;

        $estadia = Estadia::find($idestadia);

        if($estadia->activo == 1) {

        $entidades = DB::table('entidade_estadia_habitacione')
        ->where('entidade_estadia_habitacione.activo', '=', 1)
        ->join('estadia_habitaciones', 'entidade_estadia_habitacione.estadia_habitacione_id', '=', 'estadia_habitaciones.id')
        ->where('estadia_habitaciones.estadia_id', '=', $idestadia)
        ->join('entidades', 'entidades.id', '=', 'entidade_estadia_habitacione.entidade_id')
        ->select('entidade_estadia_habitacione.id as identidadesthab', 'entidade_estadia_habitacione.estadia_habitacione_id as idestadiahab',
         'entidades.nombres', 'entidades.apellidos', 'entidades.id as identidad')->get();

         return view('checkout.out',compact('folio', 'entidades', 'idestadia'));

        }

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

    /* Dar de Baja*/

    public function baja(Request $request, $id)
    {
        $folio = Folio::find($id);
        $folio->activo=0;

        if($folio->update($request->all())){
             return redirect()->to("folios")->with('msj', 'Datos guardados');
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
