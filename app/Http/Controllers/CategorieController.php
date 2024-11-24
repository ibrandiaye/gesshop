<?php

namespace App\Http\Controllers;

use App\Repositories\CategorieRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    protected $categorieRepository;
    protected $produitRepository;

    public function __construct(CategorieRepository $categorieRepository, ProduitRepository $produitRepository){
        $this->middleware('auth');
        $this->categorieRepository =$categorieRepository;
        $this->produitRepository = $produitRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categorieRepository->getAll();
        return view('categorie.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorie.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = $this->categorieRepository->store($request->all());
        return redirect('categorie');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorie = $this->categorieRepository->getById($id);
        return view('categorie.show',compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorie = $this->categorieRepository->getById($id);
        return view('categorie.edit',compact('categorie'));
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
        $this->categorieRepository->update($id, $request->all());
        return redirect('categorie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produits = $this->produitRepository->getProduitByCategorie($id);
        if (sizeof($produits)> 0 ) {
            return redirect('categorie')->withErrors("Supprimer d'abord les produits appartenant à cette catégorie");
        }
        $this->categorieRepository->destroy($id);
        return redirect('categorie');
    }
    public function storeJson(Request $request){
        $categorie = $this->categorieRepository->store($request->all());
        return response()->json($categorie);
    }
}
