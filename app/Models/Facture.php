<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
 protected $fillable =['depot_id','client_id'];

 public function depot(){
    return $this->belongsTo(Depot::class);
}
public function client(){
    return $this->belongsTo(Client::class);
}

public function sorties(){
    return $this->hasMany(Sortie::class);
}
}

