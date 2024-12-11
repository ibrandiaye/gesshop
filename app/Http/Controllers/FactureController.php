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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            $factures = $this->factureRepository->getAllFacture();
        }
        return view('facture.index',compact('factures'));
    }

    public function getById($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        return view('facture.show',compact('facture'));
    }
    public function impression($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        $qrcode = QrCode::size(50)->generate(config('app.url')."/facture/".$facture->id);
        return view('facture.impression',compact('facture','qrcode'));
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

try{

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
           // var_dump(is_double($quantites[$x]));
            if(is_numeric($quantites[$x])==false && is_double($quantites[$x])==false){

                return redirect()->back()->with('error','la quantité doit etre un nombre')->withInput();
            }
            if($quantites[$x]==null){
                return redirect()->back()->with('error','Vous avez oublier de renseigner une quantite')->withInput();
            }

        }
       // die($request['depot_id']);
       $this->supprimerFacture($request->facture_id);

        for($x = 0; $x < $arrlength; $x++) {
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x],$request['depot_id']);
            if($depotProduit->stock < $quantites[$x])
            {
                $depot = $this->depotRepository->getById($request['depot_id']);
                $produit = $this->produitRepository->getById($produits[$x]);
                return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
            }

    }

    $restant = $request->total - $request->recu;

    if($restant < 0)
    {
        $restant = 0;
    }
    $request->merge(["restant"=>$restant]);


    $facture =  $this->factureRepository->store($request->only(['depot_id','client_id','facs','total','recu','restant']));
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
   // dd($facture->id);

    return redirect('facture/'.$facture->id);//->route('facture.show',['facture_id'=>$facture->id]);
     } catch (\Exception $e) {
        dd( $e->getMessage());
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
    }

}

/*public function updateSortie(Request $request) {
    if (Auth::user()->role == "gestionnaire") {
        $request['depot_id'] = Auth::user()->depot_id;
    }

    $produits = $request['produit_id'];
    $quantites = $request['quantite'];
    $prixs = $request['prix'];
    $arrlength = count($produits);

    // Contrôle des quantités
    for ($x = 0; $x < $arrlength; $x++) {
        if (!is_numeric($quantites[$x])) {
            return redirect()->back()->with('error', 'La quantité doit être un nombre')->withInput();
        }
    }

    $this->supprimerFacture($request->facture_id);

    for ($x = 0; $x < $arrlength; $x++) {
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x], $request['depot_id']);
        if (!$depotProduit) {
            return redirect()->back()->with('error', 'Produit introuvable dans le dépôt sélectionné.');
        }
        if ($depotProduit->stock < $quantites[$x]) {
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($produits[$x]);
            return redirect()->back()->with('error', 'Stock insuffisant pour le produit ' . $produit->nomp . ' dans le dépôt ' . $depot->nomd);
        }
    }

    $restant = max(0, ($request->total ?? 0) - ($request->recu ?? 0));
    $request->merge(["restant" => $restant]);

    try {
        $facture = $this->factureRepository->store($request->only(['depot_id', 'client_id', 'facs', 'total', 'recu', 'restant']));

        for ($x = 0; $x < $arrlength; $x++) {
            $sortie = new Sortie();
            $sortie->produit_id = $produits[$x];
            $sortie->quantite = $quantites[$x];
            $sortie->prixv = $prixs[$x];
            $sortie->facture_id = $facture->id;
            $sortie->save();

            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x], $request['depot_id']);
            $depotProduit->stock -= $quantites[$x];
            $depotProduit->save();
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
    }

    return redirect('facture/' . $facture->id);
}*/


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

    public function completer(Request $request)
    {
        $recu = $request->recu + $request->complement;
        $restant = $request->total - $recu;
        if($restant<0)
        {
                $restant = 0;
        }

        DB::table("factures")->where("id",$request->id)->update(["restant"=>$restant,"recu"=>$recu]);
        DB::table("complements")->insert(["montant"=>$request->complement,"facture_id"=>$request->id,'created_at'=>today()]);
        return redirect()->back()->with('success','Operation avec succée');
    }
}
