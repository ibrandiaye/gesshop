<?php

namespace App\Http\Controllers;

use App\Models\DepotProduit;
use App\Repositories\ClientRepository;
use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\FactureRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SortieRepository;
use App\Models\Sortie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LDAP\Result;

class FactureController extends Controller
{
    protected $factureRepository;
    protected $sortieRepository;
    protected $depotProduitRepository;
    protected $produitRepository;
    protected $clientRepository;
    protected $depotRepository;

    public function __construct(FactureRepository $factureRepository, SortieRepository $sortieRepository,
    DepotProduitRepository $depotProduitRepository,ProduitRepository $produitRepository,
    ClientRepository $clientRepository,DepotRepository $depotRepository)
    {
        $this->middleware(['auth']);
        $this->factureRepository = $factureRepository;
        $this->sortieRepository = $sortieRepository;
        $this->depotProduitRepository = $depotProduitRepository;
        $this->produitRepository = $produitRepository;
        $this->clientRepository =$clientRepository;
        $this->depotRepository =$depotRepository;
    }

    public function fac(){
        //dd('kh');
        if(Auth::user()->role=="gestionnaire"){
            $factures = $this->factureRepository->getFactureByDepot(Auth::user()->depot_id);
        }else{
            $factures = $this->factureRepository->getAll();
        }
        return view('facture.index',compact('factures'));
    }

    public function getById($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        return view('facture.show',compact('facture'));
    }
    public function impression($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        return view('facture.impression',compact('facture'));
    }
    public function destroy($id){
      /*   $sorties = $this->sortieRepository->getByFacture($id);
        if(sizeof($sorties) > 0){
                foreach ($sorties as $key1 => $sortie) {
              //  dd($sortie);
                    $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($sortie->produit_id,$sortie->facture->depot_id);
                    if($depotProduit) {
                        $depotProduit->stock = $depotProduit->stock  + $sortie->quantite;
                        DepotProduit::find($depotProduit->id)->update(['stock' => $depotProduit->stock]);
                    }else {
                    $depotProduit = new DepotProduit();
                    $depotProduit->stock =  $sortie->quantite;
                    $depotProduit->produit_id = $sortie->produit_id;
                    $depotProduit->depot_id = $sortie->facture->depot_id;
                    $depotProduit->save();
                    }
                    DB::table('retours')
                    ->where('sortie_id',$sortie->id)
                    ->delete();
            }

            DB::table('sorties')
            ->where('facture_id',$id)
            ->delete();
        }
        $this->factureRepository->destroy($id); */
        $this->supprimerFacture($id);

        return redirect()->route('facture.fac');
    }
    public function updateSortie(Request $request){
        $this->supprimerFacture($request->facture_id);


        //dd(Auth::user()->depot_id);

        if(Auth::user()->role=="gestionnaire"){
            $request['depot_id']=Auth::user()->depot_id;
           // dd(Auth::user()->depot_id);
        }
        $arrlength = count($request['produit_id']);
        $produits = $request['produit_id'];
        $quantites = $request['quantite'];
        $prixs = $request['prix'];
         //control if table quantite contains value null
         for($x = 0; $x < $arrlength; $x++) {
            var_dump(is_double($quantites[$x]));
            if(is_numeric($quantites[$x])==false && is_double($quantites[$x])==false){

                return redirect()->back()->with('error','la quantité doit etre un nombre')->withInput();
            }
            if($quantites[$x]==null){
                return redirect()->back()->with('error','Vous avez oublier de renseigner une quantite')->withInput();
            }

        }
       // die($request['depot_id']);
        for($x = 0; $x < $arrlength; $x++) {
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x],$request['depot_id']);
            if($depotProduit->stock < $quantites[$x])
            {
                $depot = $this->depotRepository->getById($request['depot_id']);
                $produit = $this->produitRepository->getById($produits[$x]);
                return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
            }

    }
    $facture =  $this->factureRepository->store($request->only(['depot_id','chauffeur_id','client_id','facs']));
    for($x = 0; $x < $arrlength; $x++) {
        $sortie = new Sortie();
        $sortie->produit_id = $produits[$x];
        $sortie->quantite = $quantites[$x];
        $sortie->prixv = $prixs[$x];//$quantites[$x] * $prixs[$x];
        $sortie->facture_id = $facture->id;
        $sortie->save();
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x],$request['depot_id']);
        $depotProduit->stock = $depotProduit->stock - $quantites[$x];
        DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);

    }


    return redirect()->route('facture.show',['facture_id'=>$facture->id]);
}

    public function supprimerFacture($id){
        $sorties = $this->sortieRepository->getByFacture($id);
        if(sizeof($sorties) > 0){
                foreach ($sorties as $key1 => $sortie) {
              //  dd($sortie);
                    $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($sortie->produit_id,$sortie->facture->depot_id);
                    if($depotProduit) {
                        $depotProduit->stock = $depotProduit->stock  + $sortie->quantite;
                        DepotProduit::find($depotProduit->id)->update(['stock' => $depotProduit->stock]);
                    }else {
                    $depotProduit = new DepotProduit();
                    $depotProduit->stock =  $sortie->quantite;
                    $depotProduit->produit_id = $sortie->produit_id;
                    $depotProduit->depot_id = $sortie->facture->depot_id;
                    $depotProduit->save();
                    }
                    DB::table('retours')
                    ->where('sortie_id',$sortie->id)
                    ->delete();
            }

            DB::table('sorties')
            ->where('facture_id',$id)
            ->delete();
        }
        $this->factureRepository->destroy($id);
    }
    public function update($id){
        $facture = $this->factureRepository->getById($id);
        $produits = $this->produitRepository->getAll();
        $clients = $this->clientRepository->getAll();
        $depots = $this->depotRepository->getAll();
        $depotProduits = $this->depotProduitRepository->getByProduitAndDepotByDeport($facture->depot_id);
        return view('facture.edit',compact('facture','id','produits','clients','depots','depotProduits'));
    }
}
