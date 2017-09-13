<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    protected $fillable = [
        'paise_id', 'tipoentidade_id', 'nombres', 'apellidos', 'direccion', 'profesion', 'fecha_nac', 'sexo',
        'estado_civil', 'num_ruc', 'comentario',
    ];

    public function entidaddocumentos()
    {
       return $this->hasMany(EntidadDocumento::class);
    }

    public function entidadroles()
    {
       return $this->hasMany(EntidadRole::class);
    }

    public function entidades()
    {
       return $this->belongsToMany('Teodolinda\EstadiaHabitacione', 'estadia_habitacion_entidade', 'entidade_id', 'estadiahabitacione_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Teodolinda\Role')->withPivot('id');
    }

    public function entidadmediocomunicaciones()
    {
       return $this->hasMany(EntidadMediocomunicacione::class);
    }

    public function entidadcontactos()
    {
       return $this->hasMany(EntidadContacto::class);
    }

}
