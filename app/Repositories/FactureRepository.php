<?php

namespace App\Repositories;

use App\Models\Facture;
use Illuminate\Support\Facades\DB;

class FactureRepository extends RessourceRepository{
    public function __construct(Facture $facture)
    {
        $this->model = $facture;
    }

    public function getFactureByDepot($depot_id){
        /*return Facture::with(['client','depot'])
        ->where('depot_id',$depot_id)
        ->orderBy('id','desc')
        ->get();*/

        return DB::table('factures')
        ->leftJoin("clients","factures.client_id","=","clients.id")
        ->select("factures.*","clients.nomc")
        ->where('factures.depot_id',$depot_id)
        ->orderBy("id", "desc")
        ->get();
    }
    public function getFactureBetweenToDate($debut,$fin,$depot_id){
        return Facture::with(['client','depot'])
        ->where('depot_id',$depot_id)
        ->whereBetween('created_at',[$debut,$fin])
        ->get();
    }
    public function getFactureByClient($client_id)
    {
            return DB::table('factures')
                ->where("client_id", $client_id)
                ->get();
    }
    public function getAllFacture()
    {
            return DB::table('factures')
            ->leftJoin("clients","factures.client_id","=","clients.id")
            ->select("factures.*","clients.nomc")
            ->orderBy("id", "desc")
            ->get();
    }
    public function getCreance()
    {
            return DB::table('factures')
            ->leftJoin("clients","factures.client_id","=","clients.id")
            ->select("factures.*","clients.nomc")
            ->where('factures.restant','>', 0)
            ->orderBy("id", "desc")
            ->get();
    }
}
