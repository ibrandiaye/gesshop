@extends('layout')
@section('title', '| retour')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES RETOURS</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('retour.create') }}" role="button" class="btn btn-success">ENREGISTRER UN RETOUR</a></li>
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
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES RETOURS</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            <th>Depot</th>
                            <th>Facture</th>
                            {{--  <th>Actions</th>  --}}
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($retours as $retour)
                    @if(Auth::user()->role!='administrateur')
                    @if($retour->sortie->facture->depot->id==Auth::user()->depot_id)
                        <tr>
                            <td>{{ $retour->id }}</td>
                           <td> {{  Carbon\Carbon::parse( $retour->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $retour->sortie->facture->client->nomc }}</td>
                            <td><a href="{{ route('get.chercher.produit', ['id'=>$retour->sortie->produit->id]) }}">{{ $retour->sortie->produit->nomp }}</a></td>
                            <td>{{ $retour->quantite }}</td>
                            <td>{{ $retour->sortie->facture->depot->nomd }}</td>
                            <td>{{ $retour->sortie->facture->facs }}</td>
                             {{--  <td>
                                @if(Auth::user()->depot_id== $retour->sortie->depot->id)


                                <a href="{{ route('retour.edit', $retour->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a> @endif
                                @if(Auth::user()->role== 'administrateur')  {!! Form::open(['method' => 'DELETE', 'route'=>['retour.destroy', $retour->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>  --}}

                        </tr>
                        @endif
                        @else
                        <tr>
                            <td>{{ $retour->id }}</td>
                           <td> {{  Carbon\Carbon::parse( $retour->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $retour->sortie->facture->client->nomc }}</td>
                            <td><a href="{{ route('get.chercher.produit', ['id'=>$retour->sortie->produit->id]) }}">{{ $retour->sortie->produit->nomp }}</a></td>
                            <td>{{ $retour->quantite }}</td>
                            <td>{{ $retour->sortie->facture->depot->nomd }}</td>
                            <td>{{ $retour->sortie->facture->facs }}</td>
                        @endif
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

