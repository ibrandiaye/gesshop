{{-- \resources\views\permissions\create.blade.php --}}
@extends('layout')

@section('title', '| Modifier sortie')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

    <div class="content-wrapper">

        <div class="container">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-info">GESTION DES SORTIES</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('sortie.index') }}" role="button" class="btn btn-success">RETOUR</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

        {!! Form::model($sortie, ['method'=>'PATCH','route'=>['sortie.update', $sortie->id]]) !!}
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE DE MODIFICATION D'UNE SORTIE</div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Depots</label>
                                        <select class="form-control" id="depot_id" name="depot_id" required=""  {{ Auth::user()->role=="gestionnaire" ? "disabled='true'" : ''  }} >
                                            <option value="">Selectionnez</option>
                                            @foreach ($depots as $depot)
                                            <option value="{{$depot->id}}"  {{  Auth::user()->depot_id==$depot->id ? 'selected' : '' }}>{{$depot->nomd}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Produit</label>
                                        <select class="form-control select2" id="produit_id" name="produit_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($produits as $produit)
                                            <option value="{{$produit->id}}" {{ $produit->id == $sortie->produit_id ? 'selected' : ''}}>{{$produit->nomp}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>client</label>
                                        <select class="form-control select2" id="client_id" name="client_id">
                                            <option value="">Selectionnez</option>
                                            @foreach ($clients as $client)
                                            <option value="{{$client->id}}" {{ $client->id == $sortie->facture->client_id ? 'selected' : ''}}>{{$client->nomc}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Quantité</label>
                                        <input type="number" name="quantite" id="quantite"  value="{{ $sortie->quantite }}" step='0.01' class="calcul  form-control"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix de vente</label>
                                        <input type="number" name="prixv" id="prixv"  value="{{ $sortie->prixv }}" step='0.01' class="calcul  form-control"  required>
                                    </div>
                                </div>
                               {{--   <p><strong style="color: red;" id="total"> {{  $sortie->prixv *  $sortie->quantite}} F CFA</strong></p>  --}}
                                <div>
                                    <center>
                                        <button type="submit" class="btn btn-success btn btn-lg "> MODIFIER</button>
                                    </center>
                                </div>

                            </div>
                        </div>
    {!! Form::close() !!}
                </div>
        </div>

    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> Ajouter un chauffeur</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nom chauffeur</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="form-control"  required>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <button type="button" class="btn btn-primary" id="jsonchauffeur" data-dismiss="modal">Ajouter</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection

@section('script')

    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
{{--  $(document).ready(function () {

    $(".calcul").keyup(function(){
        console.log('keuup');
       var prixv = $("#prixv").val();
       var quantite = $("#quantite").val();
       console.log(prixv * quantite);
       $("#total").html(prixv * quantite +" CFA");
      });
});  --}}
$("#jsonchauffeur").click(function () {


    var nom =  $("#nom").val();
    var chauffeur='';

        $.ajax({
            type:'POST',
               url:"{{ route('json.chauffeur.store') }}",
               data:{_token:'<?php echo csrf_token() ?>', nom:nom},
            success:function(data) {


                    chauffeur ="<option value="+data.id+" selected>"+data.nom+"</option>";

                $("#chauffeur_id").append(chauffeur);
            }
        });

    });

</script>
@endsection
