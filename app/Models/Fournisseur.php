<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'nomf', 'telf'
    ];
    public function entrees(){
        return $this->hasMany(Entree::class);
    }
}
