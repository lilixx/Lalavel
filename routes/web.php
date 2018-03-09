<?php
use Teodolinda\Categoria;
use Illuminate\Support\Facades\Input;
use Teodolinda\HabitacionTipo;
use Teodolinda\EstadiaHabitacion;
use Teodolinda\TasaCambio;
use Teodolinda\Habitacione;
use Teodolinda\ReservacionHabitacione;
use Teodolinda\Role;
use Teodolinda\User;

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

Route::get('/search2', function(){
  $queryString = Input::get('queryString');
  $users = User::where('name', 'like', '%'.$queryString.'%')->get();
  return response()->json($users);
});

Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'ServicioController@autocomplete'));

Route::get('/', array('before' => 'auth', function () {
    return view('welcome');
}));

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//User
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/users', 'UserController');
});

//Route::resource('/users', 'UserController', ['before' => 'auth']);
Route::get('/users/{user_id}/show', 'UserController@show')->middleware('auth');
Route::get('/users/{user_id}/edit', 'UserController@edit')->middleware('auth');
Route::get('/users/{user_id}/editprofile', 'UserController@editprofile')->middleware('auth');
Route::put('/users/{user_id}/updateprofile', 'UserController@updateprofile')->name('users.updateprofile');
Route::put('/users/{user_id}/out', 'UserController@out')->name('users.out');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/useradd', 'UserController');
});


//Entidade
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/entidades', 'EntidadeController');
});

//Huespedes
Route::get('/huespedes/create', 'EntidadeController@createhuesped')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/huespedadd', 'EntidadeController');
});
Route::get('/huespedes', 'EntidadeController@indexhuesped')->middleware('auth');
Route::get('/huespedes/{huespede_id}/show', 'EntidadeController@showhuesped')->middleware('auth');
Route::get('/huespedes/{huespede_id}/edit', 'EntidadeController@edithuesped')->middleware('auth');;

//clientes
Route::get('/clientes/create', 'EntidadeController@createcliente')->middleware('auth');
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/clienteadd', 'EntidadeController');
});
Route::get('/clientes', 'EntidadeController@indexcliente')->middleware('auth');
Route::get('/clientes/{cliente_id}/show', 'EntidadeController@showcliente')->middleware('auth');
Route::get('/clientes/{cliente_id}/edit', 'EntidadeController@editcliente')->middleware('auth');

//Clientes contacto
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/contactoclientes', 'EntidadContactoController');
});
Route::get('/contactoclientes/{cliente_id}/create', 'EntidadContactoController@create')->middleware('auth');

//Entidad documentos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/dochuespedes', 'EntidadContactoController');
});
Route::get('/dochuespedes/{huespede_id}/create', 'EntidadDocumentoController@create')->middleware('auth');

// Entidad medio comunicaciones
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/mediocomunicaciones', 'EntidadMedioComunicacioneController');
});
Route::get('/mediocomunicaciones/{entidad_id}/create', 'EntidadMedioComunicacioneController@create')->middleware('auth');

//Paises
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/paises', 'PaiseController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/paiseadd', 'PaiseController');
});


//Super Categorias
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/supercategorias', 'SuperCategoriaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/scategoriaadd', 'SuperCategoriaController');
});


//Categorias
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/categorias', 'CategoriaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/categoriaadd', 'CategoriaController');
});


//Servicios
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/servicios', 'ServicioController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/servicioadd', 'ServicioController');
});
Route::get('/servicios/{servicio_id}/editprecio', 'ServicioController@editprecio')->middleware('auth');
Route::put('/servicios/{servicio_id}/storeprecio', 'ServicioController@storeprecio')->name('servicios.storeprecio');

//Bloqueos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/bloqueos', 'BloqueoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/bloqueoadd', 'BloqueoController');
});

//Razon Bloqueos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/razonbloqueos', 'RazonbloqueoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/razonadd', 'RazonbloqueoController');
});


//Habitacion Tipo
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habitaciontipos', 'HabitacionTipoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habtipoadd', 'HabitacionTipoController');
});

//Habitacion Area
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habitacionareas', 'HabitacionAreaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habareaadd', 'HabitacionAreaController');
});


//Habitaciones
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habitaciones', 'HabitacioneController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/habitacionadd', 'HabitacioneController');
});
Route::get('/dirty', 'HabitacioneController@dirty')->middleware('auth');
Route::get('/month', 'HabitacioneController@habmonth')->middleware('auth');



//folios
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/folios', 'FolioController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/folioadd', 'FolioController');
});
Route::get('/folios/{folio_id}/show', 'FolioController@show')->middleware('auth');
Route::get('/folios/{folio_id}/showstatus', 'FolioController@showstatus')->middleware('auth');
Route::put('/folios/{folio_id}/invoicepdf', 'FolioController@invoicepdf')->name('folios.invoicepdf');
Route::get('/folios/{folio_id}/showinvoice', 'FolioController@showinvoice')->middleware('auth');
Route::get('/folios/{folio_id}/checkout', 'FolioController@checkout')->middleware('auth');
Route::put('/folios/{folio_id}/out', 'FolioController@out')->name('folios.out');
Route::put('/folios/{folio_id}/baja', 'FolioController@baja')->name('folios.baja');
Route::get('/folios/{folio_id}/createchild', 'FolioController@createchild')->middleware('auth');

//Folio Restrinccion Categoria
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/restrinccioncat', 'FolioRestrinccionCategoriaController');
});
Route::get('/restrinccioncat/{folio_id}/create', 'FolioRestrinccionCategoriaController@create')->middleware('auth');

//Folio Cargos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/foliocargos', 'FolioCargoController');
});
Route::get('/foliocargos/{folio_id}/create', 'FolioCargoController@create')->middleware('auth');
Route::get('/foliocargos/{folio_id}/move', 'FolioCargoController@move')->middleware('auth');
Route::get('/foliocargos/{folio_id}/cubeta', 'FolioCargoController@cubeta')->middleware('auth');

//Descuentos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/descuentos', 'DescuentoController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/descuentoadd', 'DescuentoController');
});

//Estadias
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/estadias', 'EstadiaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/estadiaadd', 'EstadiaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/estadiahab', 'EstadiaHabitacionController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/estadiaentidad', 'EstadiaHabitacionController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/estadiaentidadadd', 'EstadiaHabitacionController');
});
Route::get('/estadias/{estadia_id}/show', 'EstadiaController@show')->middleware('auth');
Route::get('film/{id}', 'EstadiaController@GetFilmBYid')->middleware('auth');
Route::get('film/{id}/{date}', 'EstadiaController@GetFilmBYid')->middleware('auth');
Route::get('/estadiahab/{estadiahab_id}/editcomentari', 'EstadiaHabitacionController@editcomentari')->middleware('auth');
Route::get('/estadiahab/{estadiahab_id}/edit', 'EstadiaHabitacionController@edit')->middleware('auth');
Route::get('/estadiaentidad/{estadiahabitacion}/createhuesped', 'EstadiaHabitacionController@createhuesped')->middleware('auth');
Route::get('/estadiahab/{id}/move/', 'EstadiaHabitacionController@move')->middleware('auth');
Route::get('/estadias/{estadia_id}/createadicional', 'EstadiaController@createadicional')->middleware('auth');

//Tarifas
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tarifas', 'TarifaController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tarifaadd', 'TarifaController');
});


//Tasa de TasaCambio
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambios', 'TasaCambioController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/tasacambioadd', 'TasaCambioController');
});

//Reservaciones
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/reservaciones', 'ReservacioneController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/reservacionesadd', 'ReservacioneController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/reservahab', 'ReservacionHabitacioneController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/reservaentidad', 'ReservacionEntidadRoleController');
});
Route::group(['middleware' => 'auth'], function() {
    Route::resource('/reservaentidadadd', 'ReservacionEntidadRoleController');
});
Route::put('/reservaciones{reserva_id}/baja', 'ReservacioneController@baja')->name('reservaciones.baja');
Route::put('/reservaciones{reserva_id}/noshow', 'ReservacioneController@noshow')->name('reservaciones.noshow');
Route::get('/reservaciones/{reserva_id}/show', 'ReservacioneController@show')->middleware('auth');
Route::get('/reservaciones/{reserva_id}/estadia', 'ReservacioneController@movestay')->middleware('auth');
Route::get('/reservaentidad/{reservahabitacion}/createhuesped', 'ReservacionEntidadRoleController@createhuesped')->middleware('auth');
Route::get('/reservahab/{reservahab_id}/edit', 'ReservacionHabitacioneController@edit')->middleware('auth');
Route::get('/reservahab/{reservahab_id}/editcomentari', 'ReservacionHabitacioneController@editcomentari')->middleware('auth');
Route::get('/reservaciones/{reserva_id}/createadicional', 'ReservacioneController@createadicional')->middleware('auth');
