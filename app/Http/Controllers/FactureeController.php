<?php

namespace App\Http\Controllers;

use App\Models\DepotProduit;
use App\Repositories\DepotProduitRepository;
use App\Repositories\EntreeRepository;
use App\Repositories\FactureeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactureeController extends Controller
{
    protected $factureeRepository;
    protected $entreeRepository;
    protected $depotProduitRepository;

    public function __construct(FactureeRepository $factureeRepository,EntreeRepository $entreeRepository,
    DepotProduitRepository $depotProduitRepository)
    {
        $this->middleware(['auth']);
        $this->entreeRepository = $entreeRepository;
        $this->factureeRepository = $factureeRepository;
        $this->depotProduitRepository = $depotProduitRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role=="gestionnaire"){
            $facturees = $this->factureeRepository->getFactureeByDepot(Auth::user()->depot_id);
        }else{
            $facturees = $this->factureeRepository->getAll();
        }
        return view('facturee.index',compact('facturees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $facturee = $this->factureeRepository->getById($id);
        return view('facturee.show',compact('facturee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrees = $this->entreeRepository->getByFacturee($id);

        if(sizeof($entrees) > 0){
            foreach ($entrees as $key1 => $entree) {
                $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($entree->produit_id,$entree->facturee->depot_id);
                if(   !$depotProduit){
                    return redirect()->back()->with('error','Produit non disponble dans le stock pour un retour ');
                }
                if(   $depotProduit->stock  < $entree->quantite){
                    return redirect()->back()->with('error','la quantité '.$entree->produit->nomp.' de retour est supérieur à la quantité ');
                }
        }
                foreach ($entrees as $key1 => $entree) {
                    $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($entree->produit_id,$entree->facturee->depot_id);
                    $depotProduit->stock = $depotProduit->stock  - $entree->quantite;
                    DepotProduit::find($depotProduit->id)->update(['stock' => $depotProduit->stock]);
            }
            DB::table('entrees')
            ->where('facturee_id',$id)
            ->delete();
        }
        $this->factureeRepository->destroy($id);

        return redirect()->route('facturee.index');
    }

    public function impression($facture_id){
        $facture = $this->factureeRepository->getById($facture_id);
        return view('facturee.impression',compact('facture'));
    }
}
