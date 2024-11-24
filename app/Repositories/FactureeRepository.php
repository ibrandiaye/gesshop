<?php

namespace App\Repositories;


use App\Models\Facturee;
use Illuminate\Support\Facades\DB;

class FactureeRepository extends RessourceRepository{
    public function __construct(Facturee $facturee)
    {
        $this->model = $facturee;
    }
    public function getFactiureeBetweenToDate($debut,$fin,$depot_id){
        return Facturee::with(['entrees','fournisseur'])
        ->where('depot_id',$depot_id)
        ->whereBetween('created_at',[$debut,$fin])
        ->get();
    }
    public function getByDepot($depot_id){
        return Facturee::where('depot_id',$depot_id)
        ->get();
    }
    public function getFactureeByDepot($depot_id){
        return Facturee::with(['fournisseur','depot'])
        ->where('depot_id',$depot_id)
        ->orderBy('id','desc')
        ->get();
    }
    public function getFactureeByClient($fournisseur_id)
    {
            return DB::table('facturees')
                ->where("fournisseur_id", $fournisseur_id)
                ->get();
    }
}
