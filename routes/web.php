<?php
use App\Categoria;
use Illuminate\Support\Facades\Input;
use App\HabitacionTipo;
use App\EstadiaHabitacion;
use App\Habitacione;
use App\ReservacionHabitacione;
use App\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Entidade
Route::resource('/entidades', 'EntidadeController');

//Huespedes
Route::get('/huespedes/create', 'EntidadeController@createhuesped');
Route::resource('/huespedadd', 'EntidadeController');
Route::get('/huespedes', 'EntidadeController@indexhuesped');
Route::get('/huespedes/{huespede_id}/show', 'EntidadeController@showhuesped');
Route::get('/huespedes/{huespede_id}/edit', 'EntidadeController@edithuesped');

//clientes
Route::get('/clientes/create', 'EntidadeController@createcliente');
Route::resource('/clienteadd', 'EntidadeController');
Route::get('/clientes', 'EntidadeController@indexcliente');
Route::get('/clientes/{cliente_id}/show', 'EntidadeController@showcliente');
Route::get('/clientes/{cliente_id}/edit', 'EntidadeController@editcliente');

//Clientes contacto
Route::resource('/contactoclientes', 'EntidadContactoController');
Route::get('/contactoclientes/{cliente_id}/create', 'EntidadContactoController@create');

//Entidad documentos
Route::resource('/dochuespedes', 'EntidadDocumentoController');
Route::get('/dochuespedes/{huespede_id}/create', 'EntidadDocumentoController@create');

// Entidad medio comunicaciones
Route::resource('/mediocomunicaciones', 'EntidadMedioComunicacioneController');
Route::get('/mediocomunicaciones/{entidad_id}/create', 'EntidadMedioComunicacioneController@create');

//Paises
Route::resource('/paises', 'PaiseController');
Route::resource('/paiseadd', 'PaiseController');

//Super Categorias
Route::resource('/supercategorias', 'SuperCategoriaController');
Route::resource('/scategoriaadd', 'SuperCategoriaController');

//Super Categorias
Route::resource('/categorias', 'CategoriaController');
Route::resource('/categoriaadd', 'CategoriaController');

//Servicios
Route::resource('/servicios', 'ServicioController');
Route::resource('/servicioadd', 'ServicioController');

//Habitacion Tipo
Route::resource('/habitaciontipos', 'HabitacionTipoController');
Route::resource('/habtipoadd', 'HabitacionTipoController');

//Habitaciones
Route::resource('/habitaciones', 'HabitacioneController');
Route::resource('/habitacionadd', 'HabitacioneController');

//folios
Route::resource('/folios', 'FolioController');
Route::resource('/folioadd', 'FolioController');
Route::get('/folios/{folio_id}/show', 'FolioController@show');
Route::get('/folios/{folio_id}/createchild', 'FolioController@createchild');

//Folio Restrinccion Categoria
Route::resource('/restrinccioncat', 'FolioRestrinccionCategoriaController');
Route::get('/restrinccioncat/{folio_id}/create', 'FolioRestrinccionCategoriaController@create');

//Folio Cargos
Route::resource('/foliocargos', 'FolioCargoController');
Route::get('/foliocargos/{folio_id}/create', 'FolioCargoController@create');
Route::get('/foliocargos/{folio_id}/move', 'FolioCargoController@move');
Route::get('/foliocargos/{folio_id}/cubeta', 'FolioCargoController@cubeta');

//Descuentos
Route::resource('/descuentos', 'DescuentoController');
Route::resource('/descuentoadd', 'DescuentoController');

//Estadias
Route::resource('/estadias', 'EstadiaController');
Route::resource('/estadiaadd', 'EstadiaController');
Route::get('/estadias/{estadia_id}/show', 'EstadiaController@show');
Route::get('film/{id}', 'EstadiaController@GetFilmBYid');
Route::resource('/estadiahab', 'EstadiaHabitacionController');
Route::get('/estadiahab/{reservahab_id}/edit', 'EstadiaHabitacionController@edit');
Route::resource('/estadiaentidad', 'EstadiaHabitacionController');
Route::get('/estadiaentidad/{estadiahabitacion}/createhuesped', 'EstadiaHabitacionController@createhuesped');
Route::resource('/estadiaentidadadd', 'EstadiaHabitacionController');
Route::get('/estadiahab/{id}/move/', 'EstadiaHabitacionController@move');

Route::get('/estadias/{estadia_id}/createadicional', 'EstadiaController@createadicional');

//Tarifas
Route::resource('/tarifas', 'TarifaController');
Route::resource('/tarifaadd', 'TarifaController');

//Reservaciones
Route::resource('/reservaciones', 'ReservacioneController');
Route::get('/reservaciones/{reserva_id}/show', 'ReservacioneController@show');
Route::get('/reservaciones/{reserva_id}/estadia', 'ReservacioneController@movestay');
Route::resource('/reservacionesadd', 'ReservacioneController');
Route::resource('/reservahab', 'ReservacionHabitacioneController');
Route::resource('/reservaentidad', 'ReservacionEntidadRoleController');
Route::get('/reservaentidad/{reservahabitacion}/createhuesped', 'ReservacionEntidadRoleController@createhuesped');
Route::resource('/reservaentidadadd', 'ReservacionEntidadRoleController');

Route::get('/reservahab/{reservahab_id}/edit', 'ReservacionHabitacioneController@edit');

Route::get('/reservaciones/create', function(){
    $tipohab = HabitacionTipo::all();

    $fechaentrada = Input::has('fechaentrada') ? Input::get('fechaentrada') : null;
    $fechasalida = Input::has('fechasalida') ? Input::get('fechasalida') : null;
    $tipohab = Input::has('tipohab') ? Input::get('tipohab') : null;
    $rol = Role::find(2);

    if($fechasalida != null) {
        $valth = $tipohab;


          $hablibres = DB::table('habitaciones')
            ->where('habitaciones.habitacion_tipo_id', '=', $valth)
            ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
            ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
            ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                 {
                    $query->from('estadia_habitaciones')
                    ->where('estadia_habitaciones.fechasalida', '>=', $fechasalida)
                    ->orWhere('estadia_habitaciones.fechasalida', '>', $fechaentrada)
                    ->select('estadia_habitaciones.habitacione_id');
                 })
            ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                {
                    $query->from('reservacion_habitaciones')
                    ->where('reservacion_habitaciones.fechasalida', '>=', $fechasalida)
                    ->orWhere('reservacion_habitaciones.fechasalida', '>', $fechaentrada)
                    ->select('reservacion_habitaciones.habitacione_id');
                })

           ->get();


        $tipohab = HabitacionTipo::all();

        $tarifa = DB::table('tarifas')
          ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
          ->where('habitacion_tipos.id', '=', $valth)
          ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

    } else {
        $hablibres = [];
        $tarifa = [];
        $tipohab = HabitacionTipo::all(); $valth = 0; }


    return View::make('/reservaciones/create', compact(['hablibres'], 'tipohab', 'valth', 'tarifa', 'rol'));
});

//Habitación adicional a la Reserva

Route::get('/reservaciones/{reserva_id}/createadicional', function($id){
    $tipohab = HabitacionTipo::all();

    $reserva = $id; // le pasa el id de la reserva

    $fechaentrada = Input::has('fechaentrada') ? Input::get('fechaentrada') : null;
    $fechasalida = Input::has('fechasalida') ? Input::get('fechasalida') : null;
    $tipohab = Input::has('tipohab') ? Input::get('tipohab') : null;
    $rol = Role::find(2);

    if($fechasalida != null) {
        $valth = $tipohab;


          $hablibres = DB::table('habitaciones')
            ->where('habitaciones.habitacion_tipo_id', '=', $valth)
            ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'habitaciones.habitacion_tipo_id')
            ->select('habitaciones.id', 'habitaciones.numero', 'habitacion_tipos.nombre')
            ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                 {
                    $query->from('estadia_habitaciones')
                    ->where('estadia_habitaciones.fechasalida', '>=', $fechasalida)
                    ->orWhere('estadia_habitaciones.fechasalida', '>', $fechaentrada)
                    ->select('estadia_habitaciones.habitacione_id');
                 })
            ->whereNotIn('habitaciones.id', function($query) use ($valth, $fechaentrada, $fechasalida)
                {
                    $query->from('reservacion_habitaciones')
                    ->where('reservacion_habitaciones.fechasalida', '>=', $fechasalida)
                    ->orWhere('reservacion_habitaciones.fechasalida', '>', $fechaentrada)
                    ->select('reservacion_habitaciones.habitacione_id');
                })

           ->get();


        $tipohab = HabitacionTipo::all();

        $tarifa = DB::table('tarifas')
          ->join('habitacion_tipos', 'habitacion_tipos.id', '=', 'tarifas.habitaciontipo_id')
          ->where('habitacion_tipos.id', '=', $valth)
          ->select('tarifas.id', 'tarifas.valor', 'tarifas.nombre')->get();

    } else {
        $hablibres = [];
        $tarifa = [];
        $tipohab = HabitacionTipo::all(); $valth = 0; }


    return View::make('/reservaciones/createadicional', compact(['hablibres'], 'tipohab', 'valth', 'tarifa', 'rol', 'reserva'));
});
