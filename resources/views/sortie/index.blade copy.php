@extends('layout')
@section('title', '| sortie')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES SORTIES</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('sortie.create') }}" role="button" class="btn btn-success">ENREGISTRER UNE SORTIE</a></li>
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
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES SORTIES</div>
            <div class="card-body">

                    <form action="{{ route('date.client.sortie') }}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-3">
                            <label>Client</label>

                            <div class="form-group input-group input-group-sm">

                                <select class="form-control select2" id="client_id" name="client_id" required="">
                                    <option value="">Selectionnez</option>
                                    @foreach ($clients as $client)
                                    <option value="{{$client->id}}">{{$client->nomc}}</option>
                                        @endforeach
                                </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <label>Date</label>
                            <div class="form-group input-group input-group-sm">

                               <input type="date" name="date" class="form-control" required>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default">Rechercher!</button>
                                  </span>
                            </div>
                        </div>
                    </div>
                    </form>

                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>N°Facture</th>
                            <th>Date</th>
                            <th>client</th>
                            <th>Produit</th>
                            <th>Quantite commandée</th>
                            <th>Quantite Livrée</th>
                            <th>retour</th>
                            {{--  <th>Montant</th>  --}}
                            <th>dépot</th>
                            @if(Auth::user()->role=='administrateur')<th>Ecart</th>@endif
                            <th>chauffeur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($sorties as $sortie)
                    @if(Auth::user()->role!='administrateur')
                        @if($sortie->facture->depot->id==Auth::user()->depot_id)
                        @if($client_id > 0)
                            @if($sortie->facture->client_id==$client_id)
                            <tr>
                                <td>{{ $sortie->facture->facs }}</td>
                                <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:i') }}</td>
                                <td>@if(!empty($sortie->facture->client))
                                    {{ $sortie->facture->client->nomc }}
                                @endif</td>
                                <td>@if(!empty($sortie->produit))
                                    <a href="{{ route('get.chercher.produit', ['id'=>$sortie->produit->id]) }}"> {{ $sortie->produit->nomp }}</a>
                                @endif </td>
                                <td>
                                    @if(empty($sortie->retours))
                                    {{ $sortie->quantite}}
                                @else
                                @foreach ($sortie->retours as $retour)
                                    Quantite : {{ $retour->quantite + $sortie->quantite}}
                                @endforeach
                                @endif
                                </td>
                                <td>{{ $sortie->quantite }}</td>
                                <td>@foreach ($sortie->retours as $retour)
                                    Quantite : {{ $retour->quantite }},
                                    Montant : {{ $retour->quantite * $sortie->produit->prixu }}
                                @endforeach</td>
                                {{--  <td>{{ $sortie->quantite  * $sortie->prixv }}</td>  --}}
                                <td>
                                    {{ $sortie->nomd }}

                                </td>
                                @if(Auth::user()->role=='administrateur')<td>@if(!emmpty($sortie->produit)){{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}

                                    @endif</td>@endif
                                <td> @if($sortie->facture->chauffeur)
                                    {{ $sortie->facture->chauffeur->nom }}
                                @endif</td>
                                 <td>
                                    @if(Auth::user()->depot_id== $sortie->facture->depot->id)
                                    <a href="{{ route('sortie.edit', $sortie->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{ $sortie->id }}">
                                        Retour
                                      </button>
                                    @endif
                                    @if(Auth::user()->role== 'administrateur') {!! Form::open(['method' => 'DELETE', 'route'=>['sortie.destroy', $sortie->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                    <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    {!! Form::close() !!}@endif



                                </td>

                            </tr>

                            @endif
                        @else
                        <tr>
                            <td>{{ $sortie->facture->facs }}</td>
                            <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:i') }}</td>
                            <td>@if(!empty($sortie->facture->client))

                            {{ $sortie->facture->client->nomc }}@endif</td>
                            <td>@if(!empty($sortie->produit))
                                <a href="{{ route('get.chercher.produit', ['id'=>$sortie->produit->id]) }}"> {{ $sortie->produit->nomp }}</a>
                            @endif </td>
                            <td>
                                @php
                                $quant = 0;
                                foreach ($sortie->retours as $retour){
                                    $quant = $retour->quantite + $quant;
                                }
                                $quant = $quant + $sortie->quantite;
                                if($quant > 0)
                                    echo $quant;
                                else
                                    echo $sortie->quantite;
                                @endphp

                            </td>
                            <td>{{ $sortie->quantite }}</td>
                            <td>@foreach ($sortie->retours as $retour)
                                Quantite : {{ $retour->quantite }},
                               @if(!empty($sortie->produit))
                               Montant : {{ $retour->quantite * $sortie->produit->prixu }}
                               @endif
                            @endforeach</td>
                            {{--  <td>{{ $sortie->quantite  * $sortie->prixv }}</td>  --}}
                            <td>{{ $sortie->facture->depot->nomd }}</td>
                            @if(Auth::user()->role=='administrateur')
                            <td>@if(!empty($sortie->produit))
                                {{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}
                            @endif </td>@endif
                            <td> @if($sortie->facture->chauffeur)
                                {{ $sortie->facture->chauffeur->nom }}
                            @endif</td>
                             <td>
                                @if(Auth::user()->depot_id== $sortie->facture->depot->id)
                                <a href="{{ route('sortie.edit', $sortie->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{ $sortie->id }}">
                                    Retour
                                  </button>
                                @endif
                                @if(Auth::user()->role== 'administrateur') {!! Form::open(['method' => 'DELETE', 'route'=>['sortie.destroy', $sortie->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>

                        </tr>


                        @endif

                        <div class='modal fade' id='modal-default{{ $sortie->id }}'>
                            <form action="{{ route('retour.store') }}" method="POST">
                            @csrf

                            <div class='modal-dialog'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h6 class='modal-title'> Retour :>@if(!empty($sortie->produit)) {{ $sortie->produit->nomp }}@endif,  Facture N°{{ $sortie->facture->facs }}</h6>
                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>
                                <div class='modal-body'>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Quantité</label>
                                                <input type="number" name="quantite" id="quantite"  value="{{ old('quantite') }}" step='0.01' max="{{ $sortie->quantite }}" class="calcul  form-control"  required>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $sortie->id }}" name="sortie_id">

                                </div>
                                <div class='modal-footer justify-content-between'>
                                  <button type='button' class='btn btn-default' data-dismiss='modal'>Fermer</button>
                                  <input type='submit' class='btn btn-success retour' value="Valider Retour">
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </form>
                        </div>
                        @endif
                        @else
                        <tr>
                            <td>{{ $sortie->facture->facs }}</td>
                            <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:i') }}</td>
                            <td>@if(!empty($sortie->facture->client)){{ $sortie->facture->client->nomc }}@endif</td>
                            <td>@if(!empty($sortie->produit))
                                <a href="{{ route('get.chercher.produit', ['id'=>$sortie->produit->id]) }}"> {{ $sortie->produit->nomp }}</a>
                            @endif
                        </td>
                        <td>
                            @php
                            $quant = 0;
                            foreach ($sortie->retours as $retour){
                                $quant = $retour->quantite + $quant;
                            }
                            $quant = $quant + $sortie->quantite;
                            if($quant > 0)
                                echo $quant;
                            else
                                echo $sortie->quantite;
                            @endphp

                        </td>
                            <td>{{ $sortie->quantite }}</td>
                            <td>@foreach ($sortie->retours as $retour)
                                Quantite : {{ $retour->quantite }}
                                @if(!empty($sortie->produit)) ,
                                Montant : {{ $retour->quantite * $sortie->produit->prixu }} @endif
                            @endforeach</td>
                            {{--  <td>{{ $sortie->quantite  * $sortie->prixv }}</td>  --}}
                            <td>{{ $sortie->facture->depot->nomd }}</td>
                            @if(Auth::user()->role=='administrateur')<td>@if(!empty($sortie->produit))
                                {{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}
                            @endif</td>@endif
                            <td> @if($sortie->facture->chauffeur)
                                {{ $sortie->facture->chauffeur->nom }}
                            @endif</td>
                             <td>
                                @if(Auth::user()->depot_id== $sortie->facture->depot->id)
                                <a href="{{ route('sortie.edit', $sortie->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{ $sortie->id }}">
                                    Retour
                                  </button>
                                @endif
                                @if(Auth::user()->role== 'administrateur') {!! Form::open(['method' => 'DELETE', 'route'=>['sortie.destroy', $sortie->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>

                        </tr>
                        <div class='modal fade' id='modal-default{{ $sortie->id }}'>
                            <form action="{{ route('retour.store') }}" method="POST">
                            @csrf

                            <div class='modal-dialog'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h6 class='modal-title'> Retour : {{ $sortie->produit->nomp }}, Facture N°{{ $sortie->facture->facs }}
                                    {{--   @if(!empty($sortie->produit))
                                    {{ $sortie->produit->nomp }},
                               @endif   --}} Facture N°{{ $sortie->facture->facs }}  --}}</h6>
                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>
                                <div class='modal-body'>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Quantité</label>
                                                <input type="number" name="quantite" id="quantite"  value="{{ old('quantite') }}" step='0.1' max="{{ $sortie->quantite }}" class="calcul  form-control"  required>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $sortie->id }}" name="sortie_id">

                                </div>
                                <div class='modal-footer justify-content-between'>
                                  <button type='button' class='btn btn-default' data-dismiss='modal'>Fermer</button>
                                  <input type='submit' class='btn btn-success' value="Valider Retour" data-dismiss='modal'>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </form>
                        </div>

                        @endif
                          <!-- /.modal -->
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
});

$(document).ready(function () {

    $(".retour").click(function() {
       // alert('sdf')
      //  $(".retour").prop('disabled', true);
    });
});
</script>
@endsection
