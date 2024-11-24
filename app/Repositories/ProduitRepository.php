<?php

namespace App\Repositories;

use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class ProduitRepository extends RessourceRepository{
    public function __construct(Produit $produit)
    {
        $this->model = $produit;
    }

    public function getProduitsWithRelation(){
        Produit::with(['entrees','sorties','sorties.client','entrees.fournisseur',
        'entrees.depot','sorties.depot'])
        ->get();
    }
    public function getProduitByDepotId($depot_id){
        return DB::table('produits')
            ->join('depot_produits', 'produits.id', '=', 'depot_produits.produit_id')
            ->where('depot_produits.depot_id', $depot_id)
            ->select('produits.*', 'depot_produits.stock')
            ->get();
    }
    public function getProduitByCategorie($categorie_id){
        return DB::table('produits')
            ->where('categorie_id', $categorie_id)
            ->get();
    }
}
