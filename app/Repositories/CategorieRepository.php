<?php

namespace App\Repositories;

use App\Models\Categorie;



class CategorieRepository extends RessourceRepository
{
    public function __construct(Categorie $categorie)
    {
        $this->model = $categorie;
    }

}
