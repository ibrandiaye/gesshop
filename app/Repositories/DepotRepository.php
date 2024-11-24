<?php

namespace App\Repositories;

use App\Models\Depot;
use Illuminate\Support\Facades\DB;

class DepotRepository extends RessourceRepository{
    public function __construct(Depot $depot)
    {
        $this->model = $depot;
    }
    public function getDepotWithRelation(){
        return Depot::with(['depotProduits','depotProduits.produit'])
        ->get();
    }
    public function getStockByDepots(){
        return DB::table('depots')
        ->join('depot_produits','depots.id','=','depot_produits.depot_id')
        ->select('depots.nomd', 'depots.id as id',DB::raw('sum(depot_produits.stock) as stock'))
        ->groupBy('depots.nomd','depots.id')
        ->get();
    }
    public function getByDepot($id){
        return Depot::with(['depotProduits','depotProduits.produit','facturees','facturees.entrees', 'factures','factures.sorties',
        'facturees.entrees.produit','factures.sorties.produit'])
        ->where('id',$id)
        ->first();
    }
}
