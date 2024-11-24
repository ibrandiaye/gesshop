<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'nomcat'
    ];

    public function produits(){
        return $this->hasMany(Produit::class);
    }

}
