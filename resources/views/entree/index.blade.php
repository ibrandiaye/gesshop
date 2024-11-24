@extends('layout')
@section('title', '| entree')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES ENTREES</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('entree.create') }}" role="button" class="btn btn-success">ENREGISTRER EUN ENTREE</a></li>
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

<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES ENTREES</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            {{--  <th>Montant</th>  --}}
                            <th>Depot</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($entrees as $entree)
                    @if(Auth::user()->role!='administrateur')
                        @if($entree->facturee->depot->id==Auth::user()->depot_id)
                        <tr>

                           <td> {{  Carbon\Carbon::parse( $entree->created_at)->format('d-m-Y H:i') }}</td>
                            <td>@if(!empty( $entree->facturee->fournisseur))

                             {{ $entree->facturee->fournisseur->nomf }} @endif</td>
                            <td>@if(!empty($entree->produit))
                                <a href="{{ route('get.chercher.produit', ['id'=>$entree->produit->id]) }}">{{ $entree->produit->nomp }}</a>
                            @endif
                                </td>
                            <td>{{ $entree->quantite }}</td>
                            {{--  <td>{{ $entree->quantite  * $entree->prixu }}</td>  --}}
                            <td>{{ $entree->facturee->depot->nomd }}</td>

                             <td>
                                @if(Auth::user()->depot_id== $entree->facturee->depot->id)


                                <a href="{{ route('entree.edit', $entree->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a> @endif
                                @if(Auth::user()->role== 'administrateur')  {!! Form::open(['method' => 'DELETE', 'route'=>['entree.destroy', $entree->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>

                        </tr>
                        @endif
                        @else
                        <tr>

                           <td> {{  Carbon\Carbon::parse( $entree->created_at)->format('d-m-Y H:i') }}</td>
                            <td>@if(!empty( $entree->facturee->fournisseur)){{ $entree->facturee->fournisseur->nomf }}@endif</td>
                            <td>@if(!empty($entree->produit))
                                <a href="{{ route('get.chercher.produit', ['id'=>$entree->produit->id]) }}">{{ $entree->produit->nomp }}</a>
                            @endif
                            </td>
                            <td>{{ $entree->quantite }}</td>
                            {{--  <td>{{ $entree->quantite  * $entree->prixu }}</td>  --}}
                            <td>{{ $entree->facturee->depot->nomd }}</td>
                             <td>
                                @if(Auth::user()->depot_id== $entree->facturee->depot->id)


                                <a href="{{ route('entree.edit', $entree->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a> @endif
                                @if(Auth::user()->role== 'administrateur')  {!! Form::open(['method' => 'DELETE', 'route'=>['entree.destroy', $entree->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>

                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

