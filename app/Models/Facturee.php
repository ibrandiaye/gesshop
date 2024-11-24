<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturee extends Model
{

 protected $fillable =['depot_id','fournisseur_id'];
 public function depot(){
    return $this->belongsTo(Depot::class);
}
public function fournisseur(){
    return $this->belongsTo(Fournisseur::class);
}

public function entrees(){
    return $this->hasMany(Entree::class);
}
}
