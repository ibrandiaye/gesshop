<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nomp', 'prixu','unite','categorie_id'
    ];

    public function depotProduits(){
        return $this->hasMany(DepotProduit::class);
    }
    public function entrees(){
        return $this->hasMany(Entree::class);
    }
    public function sorties(){
        return $this->hasMany(Sortie::class);
    }
    public function transferts(){
        return $this->hasMany(Transfert::class);
    }
    public function categorie(){

        return $this->belongsTo(Categorie::class);
    }
}
