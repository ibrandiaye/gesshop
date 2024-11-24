<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepotProduit extends Model
{
    protected $fillable = [
        'produit_id', 'depot_id','stock'
    ];
    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    public function depot(){
        return $this->belongsTo(Depot::class);
    }
}
