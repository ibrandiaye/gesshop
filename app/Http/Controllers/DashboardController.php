<?php

namespace App\Http\Controllers;

use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\EntreeRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SortieRepository;
use App\Repositories\TransfertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;

    protected $entreeRepository;
    protected $sortieRepository;
    protected $transfertRepository;
    public function __construct(ProduitRepository $produitRepository,
    DepotRepository $depotRepository,DepotProduitRepository $depotProduitRepository,EntreeRepository $entreeRepository,
    SortieRepository $sortieRepository, TransfertRepository $transfertRepository)
    {
        $this->middleware('auth');
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
        $this->entreeRepository = $entreeRepository;
        $this->sortieRepository = $sortieRepository;
        $this->transfertRepository = $transfertRepository;
    }

    public function  listProduit(){
        $produits = $this->produitRepository->getAll();
        foreach ($produits as $key => $produit) {
            $totalEntre = 0;
            $totalSortie = 0;
            foreach ($produit->entrees as $key1 => $entree) {
                if($produit->id == $entree->produit_id){
                    $totalEntre = $totalEntre + $entree->quantite;
                }
            }
            foreach ($produit->sorties as $key2 => $sortie) {
                if($produit->id == $sortie->produit_id){
                    $totalSortie = $totalSortie + $sortie->quantite;
                }
            }
            $produits[$key]->stocke = $totalEntre;
            $produits[$key]->stocks = $totalSortie;
        }
      // dd($produits);
      return view('welcome');
    }
    public function home(){
        $depots = $this->depotRepository->getDepotWithRelation();
        $stocks = $this->depotRepository->getStockByDepots();
        $produits = $this->produitRepository->getAll();
       // $nbTransfert = $this->transfertRepository->tansfertForMyDepotNoValidate(Auth::user()->depot_id);
        //dd($stocks);
        $total =0;
        $totalv = 0;
        $totalb = 0;
        $sorties = $this->sortieRepository->getAll();
        foreach ($depots as $key => $depot) {
            foreach ($depot->depotProduits as $key1 => $depotProduit) {
                $total = $total + ($depotProduit->stock * $depotProduit->produit->prixu);
            }
        }
        foreach($sorties as $sortie){
            $totalv = $totalv + ($sortie->quantite * $sortie->prixv);
            $diff = ($sortie->prixv - $sortie->produit->prixu) * $sortie->quantite;
            $totalb = $totalb + $diff;
        }
        $produitsOutOfStock = $this->depotProduitRepository->getDepotProduitOutOfStcok();
        return view('welcome',compact('depots','stocks','produits','total','totalv','totalb','produitsOutOfStock'));
    }
    public function getProduitDepotById($produit_id){
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($produit_id);
        $produit = $this->produitRepository->getById($produit_id);
        $entrees = $this->entreeRepository->getByProduitId($produit_id);
        $sorties = $this->sortieRepository->getByProduitId($produit_id);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
    public function getProduitDepotByIdBetweenToDate(Request $request){
        //dd($request['produit_id']);
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($request['produit_id']);
        $produit = $this->produitRepository->getById($request['produit_id']);
        $entrees = $this->entreeRepository->getByProduitIdBetweenToDate($request['produit_id'],$request['from'],$request['to']);
        $sorties = $this->sortieRepository->getByProduitIdBetweenToDate($request['produit_id'],$request['from'],$request['to']);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
    public function  getByDepot($id){
        $depot = $this->depotRepository->getByDepot($id);
        return view('depot.show',compact('depot'));
    }
    public function chercherProduit(Request $request){
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($request['produit_id']);
        $produit = $this->produitRepository->getById($request['produit_id']);
        $entrees = $this->entreeRepository->getByProduitId($request['produit_id']);
        $sorties = $this->sortieRepository->getByProduitId($request['produit_id']);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
    public function chercherProduitGet($id){
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($id);
        $produit = $this->produitRepository->getById($id);
        $entrees = $this->entreeRepository->getByProduitId($id);
        $sorties = $this->sortieRepository->getByProduitId($id);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
}
