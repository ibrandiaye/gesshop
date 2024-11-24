<?php

namespace App\Http\Controllers;

use App\Models\DepotProduit;
use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\TransfertRepository;
use App\Models\Transfert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransfertController extends Controller
{

    protected $transfertRepository;
    protected $clientRepository;
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;

    public function __construct(TransfertRepository $transfertRepository,
    ProduitRepository $produitRepository, DepotRepository $depotRepository,
    DepotProduitRepository $depotProduitRepository){
         $this->middleware(['auth']);
        $this->transfertRepository =$transfertRepository;
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferts = $this->transfertRepository->tansfertForMyDepot(Auth::user()->depot_id);
        return view('transfert.index',compact('transferts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produits = $this->produitRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('transfert.add',compact('produits','depots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id'=> 'required|integer',
            'destinataire_id'=> 'required|integer',
            'quantite'=> 'required|integer',

        ],[
            'produit_id.required' => 'Produit Obligatoire',
            'destinataire_id.required' => 'Destinataire Obligatoire',
            'quantite.required' => 'Quantite Obligatoire ',
        ]);
       // $transfert = $this->transfertRepository->getById($id);
       // dd($transfert->quantite);
       $request['depot_id']=Auth::user()->depot_id;
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
       // dd($request['produit_id'].$request['depot_id']);
        if($depotProduit->stock  >= $request['quantite'])
        {

            $request->merge(['valide'=>0]);
            $depot = $this->depotRepository->getById($request['destinataire_id']);
            $request->merge(['destinataire'=>$depot->nomd]);
            $this->transfertRepository->store($request->all());
           // $depotProduit->stock = ($depotProduit->stock + $transfert->quantite ) - $request['quantite'] ;
           // DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->route('transfert.add')->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }
        return redirect('transfert');
       /*  $request['depot_id']=Auth::user()->depot_id;
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
        $depotProduitd = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['destinataire_id']);

        if($depotProduit->stock >= $request['quantite'])
        {
            $depot =$this->depotRepository->getById($depotProduitd->depot_id);
            $request->merge(['destinataire->id'=>$depotProduitd->depot_id,'destinataire'=>$depot->nomd]);
            $transferts = $this->transfertRepository->store($request->all());

            $depotProduit->stock = $depotProduit->stock - $request['quantite'] ;
            $depotProduitd->stock = $depotProduitd->stock + $request['quantite'];
            DepotProduit::find($depotProduitd->id)->update(['stock' =>  $depotProduitd->stock]);
            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }

        return redirect('transfert'); */

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfert = $this->transfertRepository->getById($id);
        return view('transfert.show',compact('transfert'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfert = $this->transfertRepository->getById($id);
        $produits = $this->produitRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('transfert.edit',compact('transfert','produits','depots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['depot_id']=Auth::user()->depot_id;
        $request->merge(['valide'=>0]);
        $transfert = $this->transfertRepository->getById($id);
       // dd($transfert->quantite);
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
        if($depotProduit->stock + $transfert->quantite >= $request['quantite'])
        {
            $this->transfertRepository->update($id, $request->all());
           // $depotProduit->stock = ($depotProduit->stock + $transfert->quantite ) - $request['quantite'] ;
           // DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->route('transfert.edit',['transfert'=>$id])->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }
        return redirect('transfert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->transfertRepository->destroy($id);
        return redirect('transfert');
    }
    public function valide($id){

        $transfert = $this->transfertRepository->getById($id);
        $depotProduitSource = $this->depotProduitRepository->getByProduitAndDepot($transfert->produit_id,$transfert->depot_id);
        $depotProduitDestination = $this->depotProduitRepository->getByProduitAndDepot($transfert->produit_id,$transfert->destinataire_id);
        $depotProduitSource->stock = $depotProduitSource->stock - $transfert->quantite;
        $depotProduitDestination->stock = $depotProduitDestination->stock +  $transfert->quantite;;
        DepotProduit::find($depotProduitDestination->id)->update(['stock' =>  $depotProduitDestination->stock]);
        DepotProduit::find($depotProduitSource->id)->update(['stock' =>  $depotProduitSource->stock]);
        Transfert::find($id)->update(['valide' =>  1]);
        return redirect('transfert');
    }
    public function allTansfertForMyDepotNoValidate(){
        //dd('dd');
        $transferts = $this->transfertRepository->allTansfertForMyDepotNoValidate(Auth::user()->depot_id);

        return view('transfert.index',compact('transferts'));

    }
}
