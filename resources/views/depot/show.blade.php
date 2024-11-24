@extends('layout')
@section('title', '| produit')
@section('css')
<link rel="stylesheet" href="{!! asset('assets/plugins/daterangepicker/daterangepicker.css') !!}">
@endsection
@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">{{ $depot->nomd }} </h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                </ol>
                            </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
            </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                   <form action="{{ route('entree.sortie.between.date') }}" method="POST">
                       @csrf
                       <div class="row">
                       <div class="col-lg-5">
                           <div class="form-group">
                               <label>Début</label>
                               <input type="date" name="debut"  value="{{ old('debut') }}" class="form-control"  required>
                           </div>
                       </div>
                       <div class="col-lg-5">
                           <div class="form-group">
                               <label>Fin</label>
                               <input type="date" name="fin"  value="{{ old('fin') }}" class="form-control"  required>
                           </div>
                       </div>
                     <input id="depot_id" type="hidden" value="{{ $depot->id }}" name="depot_id">

                   </div>

                   <button type="submit" class="btn btn-success btn btn-sm "> ENREGISTRER</button>
                   </form>
               </div>
                   </div>
                   <br>
<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center"><h5>Liste des entrées </h5></div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            @if(Auth::user()->role== 'administrateur')       <th>Montant</th> @endif
                            <th>Depot</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($depot->facturees as $facturees)
                    @foreach ($facturees ->entrees as $entree)
                        <tr>
                            <td>{{  Carbon\Carbon::parse($entree->created_at)->format('d-m-Y H:m') }}</td>
                            <td>{{ $entree->produit->nomp }}</td>
                            <td>{{ $entree->quantite }}</td>
                            @if(Auth::user()->role== 'administrateur')<td>{{ $entree->prixu * $entree->quantite }}</td>@endif
                            <td>{{ $facturees->depot->nomd }}</td>
                        </tr>
                        @endforeach
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="card border-danger border-0">
            <div class="card-header bg-success text-center"><h5>Liste des Sorties </h5></div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Quantite</th>
                                <th>Montant</th>
                                <th>Dépot</th>
                                @if(Auth::user()->role=='administrateur')<th>Bénéfice</th>@endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($depot->factures as $factures)
                        @foreach ($factures->sorties as $sortie)
                            <tr>
                                <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:m') }}</td>
                                <td>{{ $sortie->produit->nomp }}</td>
                                <td>{{ $sortie->quantite }}</td>
                                <td>{{ $sortie->prixv * $sortie->quantite }}</td>
                                <td>{{ $factures->depot->nomd }}</td>
                                @if(Auth::user()->role=='administrateur')<td>{{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}</td>@endif
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>



                </div>

            </div>
        </div>
        </div>
    </section>
</div>

@endsection
