<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nomc', 'telc'
    ];
    public function sorties(){
        return $this->hasMany(Sortie::class);
    }
}
