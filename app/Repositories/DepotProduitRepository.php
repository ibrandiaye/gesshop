<?php

namespace App\Repositories;

use App\Models\DepotProduit;
use Illuminate\Support\Facades\DB;

class DepotProduitRepository extends RessourceRepository{
    public function __construct(DepotProduit $depotProduit)
    {
        $this->model = $depotProduit;
    }
    public function getByProduitAndDepot($produit_id,$depot_id){
        return DB::table('depot_produits')
        ->join('produits','depot_produits.produit_id','=','produits.id')
        ->join('depots','depot_produits.depot_id','=','depots.id')
        ->where([['depot_produits.produit_id',$produit_id],['depot_produits.depot_id',$depot_id]])
        ->select('depot_produits.*','depots.nomd as nomd','produits.nomp as nomp')
        ->first();
    }
    public function getDepotProduitByProduit($produit_id){
        return DepotProduit::with(['produit','depot','depot.facturees.entrees','depot.factures.sorties'])
        ->where('produit_id',$produit_id)
        ->get();
    }
    public function getByProduitAndDepotByDeport($depot_id){
        return DB::table('depot_produits')
        ->where('depot_id',$depot_id)
        ->get();
    }
    public function getDepotProduitByDepotId($depot_id){
        return DepotProduit::with(['produit'])
        ->where('depot_id',$depot_id)
        ->get();
    }

    public function getDepotProduitOutOfStcok(){
        return DepotProduit::with(['produit','depot'])
        ->where('stock','<',4)
        ->get();
    }

}
