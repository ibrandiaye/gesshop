<?php

namespace App\Repositories;

use App\Models\Fournisseur;


class FournisseurRepository extends RessourceRepository{
    public function __construct(Fournisseur $fournisseur)
    {
        $this->model = $fournisseur;
    }
}
