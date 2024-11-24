<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    protected $fillable = [
        'produit_id', 'quantite','prixv','facture_id'
    ];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    public function retours(){
        return $this->hasMany(Retour::class);
    }
    public function facture(){
        return $this->belongsTo(Facture::class);
    }
}
