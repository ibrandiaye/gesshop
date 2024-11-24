<?php

namespace App\Http\Controllers;

use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected $produitRepository;
    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }
    public function createJson($id){
        $depotProduits = $this->produitRepository->getProduitByDepotId($id);
        return response()->json($depotProduits);
    }
}
