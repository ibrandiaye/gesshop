<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retour extends Model
{
    protected $fillable = [
        'quantite','sortie_id'
    ];

    public function sortie(){
        return $this->belongsTo(Sortie::class);
    }
}
