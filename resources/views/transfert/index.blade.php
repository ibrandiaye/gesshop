@extends('layout')
@section('title', '| transfert')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES TRANSFERTS</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('transfert.create') }}" role="button" class="btn btn-success">ENREGISTRER UNE TRANSFERT</a></li>
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
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES TRANSFERTS</div>
            <div class="card-body">
                <table id="example1" class="table table-bordered tables table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            <th>Dépot Expéditeur</th>
                            <th>Dépot Destinataire</th>
                            @if(Auth::user()->role=='administrateur')<th>Ecart</th>@endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($transferts as $transfert)
                        <tr>
                            <td>{{ $transfert->id }}</td>
                            <td>{{  Carbon\Carbon::parse( $transfert->created_at)->format('d-m-Y H:i') }}</td>
                            <td><a href="{{ route('get.chercher.produit', ['id'=>$transfert->produit->id]) }}">{{ $transfert->produit->nomp }}</a></td>
                            <td>{{ $transfert->quantite }}</td>
                            <td>{{ $transfert->depot->nomd }}</td>
                            <td>{{ $transfert->destinataire }}</td>
                            @if(Auth::user()->role=='administrateur')<td>{{( $transfert->quantite  * $transfert->prixv) - ($transfert->quantite  * $transfert->produit->prixu) }}</td>@endif
                             <td>
                                @if(Auth::user()->depot_id== $transfert->depot->id  &&  $transfert->valide==0)
                                <a href="{{ route('transfert.edit', $transfert->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                               {{--   <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{ $transfert->id }}">
                                    Retour
                                  </button>  --}}
                                @endif
                                @if(Auth::user()->role== 'administrateur' &&  $transfert->valide==0) {!! Form::open(['method' => 'DELETE', 'route'=>['transfert.destroy', $transfert->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif
                                @if(Auth::user()->depot_id== $transfert->destinataire_id &&  $transfert->valide==0)
                                <a class="btn btn-success" href="{{ route('valider.transfert', ['id'=>$transfert->id]) }}">Valider le transfert</i></a>
                                  @endif


                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

