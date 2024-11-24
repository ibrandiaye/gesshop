<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use App\Repositories\FactureeRepository;
use App\Repositories\FactureRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientRepository;
    protected $factureRepositoy;

    protected $factureeRepositoy;
    public function __construct(ClientRepository $clientRepository,FactureRepository $factureRepository,
    FactureeRepository $factureeRepository){
        $this->middleware('auth');
        $this->clientRepository =$clientRepository;
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
        $clients = $this->clientRepository->getAll();
        return view('client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clients = $this->clientRepository->store($request->all());
        return redirect('client');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clientRepository->getById($id);
        return view('client.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->clientRepository->getById($id);
        return view('client.edit',compact('client'));
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
        $this->clientRepository->update($id, $request->all());
        return redirect('client');
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
            return redirect('client')->withErrors("Supprimer d'abord les entrées et les sorties qui concernent cet client");
        }
        $this->clientRepository->destroy($id);
        return redirect('client');
    }
    public function storeJson(Request $request){
        $client = $this->clientRepository->store($request->all());
        return response()->json($client);
    }
}
