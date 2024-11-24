<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    protected $fillable = [
        'produit_id','quantite','prixu','facturee_id'
    ];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    public function facturee(){
        return $this->belongsTo(Facturee::class);
    }

}
