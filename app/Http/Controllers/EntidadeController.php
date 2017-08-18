<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Entidade;

use App\Paise;

use App\TipoDocumento;

use App\MedioComunicacione;

use App\EntidadRole;

use App\EntidadMedioComunicacione;

use App\EntidadDocumento;

use App\EntidadContacto;

use App\Role;

class EntidadeController extends Controller
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

    public function indexhuesped()
    {
        $huespede = DB::table('entidade_role')
        ->where('entidade_role.role_id', '=', 1)
        ->join('entidades', 'entidades.id', '=', 'entidade_id')
        ->join('paises', 'entidades.paise_id', '=', 'paises.id', 'left outer')
        ->select('entidades.*', 'paises.nombre')->get();
        return view('huespedes.huespedes',compact('huespede'));
    }

    public function indexcliente()
    {
        $cliente = DB::table('entidade_role')
        ->where('entidade_role.role_id', '=', 2)
        ->join('entidades', 'entidades.id', '=', 'entidade_id')
        ->join('paises', 'entidades.paise_id', '=', 'paises.id', 'left outer')
        ->select('entidades.*', 'paises.nombre')->get();
        return view('clientes.clientes',compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createhuesped()
    {
        $medio = MedioComunicacione::all();
        $tipodoc = TipoDocumento::all();
        $pais = Paise::all();
        return view('huespedes.create',compact('medio', 'tipodoc', 'pais'));
    }

    public function createcliente()
    {
        $medio = MedioComunicacione::all();
        $tipodoc = TipoDocumento::all();
        $pais = Paise::all();
        return view('clientes.create',compact('medio', 'tipodoc', 'pais'));
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


        //---------- Guardar al Huesped -------------
        $entidad = Entidade::create($request->all());

        //dd($entidad);

        //---------- Guardar Entidad Rol -------------

          $idrol = $request->role_id;
          $rol = Role::find($idrol);

          $rol->entidades()->attach($entidad);

        //---------- Documentos -------------

            if (!empty($request->tipodocumento_id)) {

              foreach($request->tipodocumento_id as $key=> $v) //recorre todos los email
              {
                  $containers[] =  new EntidadDocumento([
                                 'tipodocumento_id'=>$request->tipodocumento_id[$key],
                                 'valordocumento'=>$request->valordocumento[$key]
                              ]);
              }
               $entidad->entidaddocumentos()->saveMany($containers); //Guarda los documentos con ayuda de la relacion en el modelo Entidade
            }

         //---------- Medios de Comunicaciones -------------

           if (!empty($request->valormediocomunicacion)) {

           foreach($request->mediocomunicacione_id as $key2=> $m) //recorre todos los email
           {
               $containers2[] =  new EntidadMedioComunicacione([
                              'mediocomunicacione_id'=>$request->mediocomunicacione_id[$key2],
                              'valormediocomunicacion'=>$request->valormediocomunicacion[$key2]
                           ]);
           }

           $entidad->entidadmediocomunicaciones()->saveMany($containers2); //Guarda los documentos con ayuda de la relacion en el modelo Entidade
         }

         //------------- Contactos de la empresa------------
         if (!empty($request->nombrec)) {
         foreach($request->nombrec as $key3=> $d) //recorre todos los email
         {
             $containers3[] =  new EntidadContacto([
                          'nombres'=>$request->nombrec[$key3],
                          'email'=>$request->emailc[$key3],
                          'telefono'=>$request->telefonoc[$key3],
                          'cargo'=>$request->cargo[$key3]
                         ]);
         }
          $entidad->entidadcontactos()->saveMany($containers3); //Guarda los contactos
        }

        if($request->role_id == 1) {
          return redirect('huespedes')->with('msj', 'Datos guardados');
       } else {
          return redirect('clientes')->with('msj', 'Datos guardados');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showhuesped($id)
    {
        $huespede = Entidade::find($id);

        $pais = DB::table('paises')->where('id', '=', $huespede->paise_id)->get();

        $medio = DB::table('entidad_medio_comunicaciones')
        ->join('medio_comunicaciones',
          'entidad_medio_comunicaciones.mediocomunicacione_id', '=', 'medio_comunicaciones.id')
        ->select('entidad_medio_comunicaciones.*', 'medio_comunicaciones.nombre')
        ->where('entidade_id', '=', $id)->get();

        $doc = DB::table('entidad_documentos')
        ->join('tipo_documentos', 'tipo_documentos.id', '=', 'entidad_documentos.tipodocumento_id')
        ->select('entidad_documentos.*', 'tipo_documentos.nombre')
        ->where('entidade_id', '=', $id)->get();

        return view('huespedes.show')
        ->with(['huespede' => $huespede, 'pais' => $pais, 'medio' => $medio, 'doc' => $doc]);

    }

    public function showcliente($id)
    {
        $cliente = Entidade::find($id);

        $pais = DB::table('paises')->where('id', '=', $cliente->paise_id)->get();

        $medio = DB::table('entidad_medio_comunicaciones')
        ->join('medio_comunicaciones',
          'entidad_medio_comunicaciones.mediocomunicacione_id', '=', 'medio_comunicaciones.id')
        ->select('entidad_medio_comunicaciones.id', 'entidad_medio_comunicaciones.valormediocomunicacion', 'medio_comunicaciones.nombre')
        ->where('entidade_id', '=', $id)->get();

        $contacto = DB::table('entidad_contactos')
        ->select('entidad_contactos.*')
        ->where('entidade_id', '=', $id)->get();

        return view('clientes.show')
        ->with(['cliente' => $cliente, 'pais' => $pais, 'medio' => $medio, 'contacto' => $contacto]);

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

    public function edithuesped($id)
    {
        $huespede = Entidade::find($id);
        $pais = Paise::all();
        return view('huespedes.edit')
        ->with(['edit' => true, 'huespede' => $huespede, 'pais' => $pais]);
    }

    public function editcliente($id)
    {
        $cliente = Entidade::find($id);
        $pais = Paise::all();
        return view('clientes.edit')
        ->with(['edit' => true, 'cliente' => $cliente, 'pais' => $pais]);
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
        $entidad = Entidade::find($id);

         if($entidad->update($request->all())){
           if($request->role_id==2) {
              return redirect()->to("clientes/$id/show")->with('msj', 'Datos guardados');
           } else {
              return redirect()->to("huespedes/$id/show")->with('msj', 'Datos guardados');
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
