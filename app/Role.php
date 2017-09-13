<?php

namespace Teodolinda;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public function entidades()
  {
      return $this->belongsToMany(Entidade::class)->withTimestamps()->withPivot('id');
  }

  public function users()
  {
    return $this
      ->belongsToMany(‘Teodolinda\User’)
      ->withTimestamps();
  }
}
