<?php

namespace App\Http\Controllers;

use App\Models\DepotProduit;
use App\Repositories\DepotRepository;
use App\Repositories\FactureeRepository;
use App\Repositories\FactureRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepotController extends Controller
{
    protected $depotRepository;
    protected $produitRepository;
    protected $factureRepository;
    protected $factureeRepository;


    public function __construct(DepotRepository $depotRepository,
    ProduitRepository $produitRepository, FactureeRepository $factureeRepository,FactureRepository $factureRepository){
         $this->middleware(['auth']);
        $this->depotRepository =$depotRepository;
        $this->produitRepository = $produitRepository;
        $this->factureeRepository = $factureeRepository;
        $this->factureRepository = $factureRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depots = $this->depotRepository->getAll();
        return view('depot.index',compact('depots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('depot.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produits = $this->produitRepository->getAll();
        $depot = $this->depotRepository->store($request->all());
        foreach ($produits as $produit) {
            $depotProduit = new DepotProduit();
            $depotProduit->produit_id= $produit->id;
            $depotProduit->depot_id = $depot->id;
            $depotProduit->stock = 0;
            $depotProduit->save();
        }
        return redirect('depot');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $depot = $this->depotRepository->getById($id);
        return view('depot.show',compact('depot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depot = $this->depotRepository->getById($id);
        return view('depot.edit',compact('depot'));
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
        $this->depotRepository->update($id, $request->all());
        return redirect('depot');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrees = $this->factureeRepository->getByDepot($id);
        $sorties = $this->factureeRepository->getByDepot($id);
        if (sizeof($entrees)> 0 or sizeof($sorties)> 0) {
            return redirect('depot')->withErrors("Suppression Impossible");
        }
        DB::table('depot_produits')
        ->where('depot_id',$id)
        ->delete();
        $this->depotRepository->destroy($id);
        return redirect('depot');
    }
    public function getEntreeAndSortieBetweenDate(Request $request){
        $request['fin'] = date("Y-m-d", strtotime( $request['fin'].'+ 1 days'));
        $factures = $this->factureRepository->getFactureBetweenToDate($request['debut'],$request['fin'],$request['depot_id']);
        $facturees = $this->factureeRepository->getFactiureeBetweenToDate($request['debut'],$request['fin'],$request['depot_id']);
        $depot = $this->depotRepository->getById($request['depot_id']);
        $total =0;
        $totalv = 0;
        $totalb = 0;
            foreach ($factures as $key => $facture) {
                foreach($facture->sorties as $sortie){
                    $totalv = $totalv + ($sortie->quantite * $sortie->prixv);
                    $diff = ($sortie->prixv - $sortie->produit->prixu) * $sortie->quantite;
                    $totalb = $totalb + $diff;
                }
            }
            foreach ($facturees as $key => $facturee) {
                foreach($facturee->entrees as $entree){
                    $total = $total + ($entree->quantite * $entree->produit->prixu);

                }
            }
        return view('depot.between',compact('factures','facturees','depot','total','totalv','totalb'));

    }
}
