<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $fillable = [
        'nomd'
    ];

    public function depotProduits(){
        return $this->hasMany(DepotProduit::class);
    }
    /* public function entrees(){
        return $this->hasMany(Entree::class);
    }
    public function sorties(){
        return $this->hasMany(Sortie::class);
    }*/
    public function users(){
        return $this->hasMany(User::class);
    }
    public function transferts(){
        return $this->hasMany(Transfert::class);
    }
    public function facturees(){
        return $this->hasMany(Facturee::class);
    }
    public function factures(){
        return $this->hasMany(Facture::class);
    }
}
