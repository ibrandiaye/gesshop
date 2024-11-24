<?php

namespace App\Http\Controllers;

use App\Repositories\FactureeRepository;
use App\Repositories\FactureRepository;
use App\Repositories\FournisseurRepository;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{

    protected $fournisseurRepository;
    protected $factureeRepositoy;
    protected $factureRepositoy;

    public function __construct(FournisseurRepository $fournisseurRepository,FactureRepository $factureRepository,
    FactureeRepository $factureeRepository){
        $this->middleware('auth');
        $this->fournisseurRepository =$fournisseurRepository;
        $this->factureeRepositoy = $factureeRepository;
        $this->factureRepositoy = $factureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = $this->fournisseurRepository->getAll();
        return view('fournisseur.index',compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fournisseur.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fournisseurs = $this->fournisseurRepository->store($request->all());
        return redirect('fournisseur');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fournisseur = $this->fournisseurRepository->getById($id);
        return view('fournisseur.show',compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fournisseur = $this->fournisseurRepository->getById($id);
        return view('fournisseur.edit',compact('fournisseur'));
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
        $this->fournisseurRepository->update($id, $request->all());
        return redirect('fournisseur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factures = $this->factureRepositoy->getFactureByClient($id);
        $facturees = $this->factureeRepositoy->getFactureeByClient($id);
        if (sizeof($factures)> 0 or sizeof($facturees)> 0) {
            return redirect('fournisseur')->withErrors("Supprimer d'abord les entrées et les sorties qui concernent cet fournisseur");
        }
        $this->fournisseurRepository->destroy($id);
        return redirect('fournisseur');
    }

    public function storeJson(Request $request){
        $fournisseur = $this->fournisseurRepository->store($request->all());
        return response()->json($fournisseur);
    }
}
