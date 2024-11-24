<?php

namespace App\Repositories;

use App\Models\Transfert;


class TransfertRepository extends RessourceRepository{
    public function __construct(Transfert $transfert)
    {
        $this->model = $transfert;
    }
    public function tansfertForMyDepot($depot_id){
        return Transfert::where('depot_id',$depot_id)
        ->orWhere('destinataire_id',$depot_id)
        ->get();
    }
    public function tansfertForMyDepotNoValidate($depot_id){
        return Transfert::where([['destinataire_id',$depot_id],['valide',0]])
        ->count();
    }
    public function allTansfertForMyDepotNoValidate($depot_id){
        return Transfert::where([['destinataire_id',$depot_id],['valide',0]])
        ->get();
    }
}
