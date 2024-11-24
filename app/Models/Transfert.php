<?php

namespace App;namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
     protected $fillable = [
        'produit_id', 'depot_id','quantite','destinataire','destinataire_id','valide'
    ];
    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    public function depot(){
        return $this->belongsTo(Depot::class);
    }
    public function destinataire(){
        return $this->belongsTo(Depot::class,'destinataire_id');
    }
}
