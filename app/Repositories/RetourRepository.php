<?php

namespace App\Repositories;

use App\Models\Retour;


class RetourRepository extends RessourceRepository{
    public function __construct(Retour $retour)
    {
        $this->model = $retour;
    }


}
