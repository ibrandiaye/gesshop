<?php

namespace App\Repositories;

use App\Models\Sortie;
use Carbon\Carbon;

class SortieRepository extends RessourceRepository{
    public function __construct(Sortie $sortie)
    {
        $this->model = $sortie;
    }
    public function getByProduitId($produit_id){
        return Sortie::with(['produit','facture','facture.depot','facture.client'])
        ->where('produit_id',$produit_id)
        ->orderBy('id','desc')
        ->get();
    }

    public function getByProduitIdBetweenToDate($produit_id,$debut,$fin){
        return Sortie::with(['produit','facture','facture.depot','facture.client'])
        ->where('produit_id',$produit_id)
        ->whereBetween('created_at',[$debut,$fin])
        ->orderBy('id','desc')
        ->get();
    }
    public function getByDateAndClient($date){
        return Sortie::with(['produit','facture','facture.depot','facture.client'])
        ->whereDate('created_at',$date)
        ->get();
    }
    public function getByFacture($facture_id){
        return Sortie::with(['produit','facture','facture.client'])
        ->where('facture_id',$facture_id)
        ->get();
    }
}
