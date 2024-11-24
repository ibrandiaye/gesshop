@extends('layout')

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
                        <h1 class="m-0 text-info">GESTION DES PRODUITS</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('produit.index') }}" role="button" class="btn btn-success">LISTE D'ENREGISTREMENT DES PRODUITS</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <form id="form"  action="{{ route('produit.store') }}" method="POST">
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE D'ENREGISTREMENT D'UN PRODUIT</div>
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

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nom produit</label>
                                        <input type="text" name="nomp"  value="{{ old('nomp') }}" class="form-control"  required>
                                    </div>
                                </div>
                              @if(Auth::user()->role== 'administrateur')
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix Unitaire produit</label>
                                        <input type="number" name="prixu"  value="{{ old('prixu') }}" step='0.01' class="form-control"  required>
                                    </div>
                                </div>
                                @else
                                <input type="hidden" name="prixu"  value="0" step='0.01' class="form-control"  >
                                @endif
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Unité produit</label>
                                        <input type="text" name="unite"  value="{{ old('unite') }}" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>categories</label>
                                        <select class="form-control select2" id="categorie_id" name="categorie_id" required>
                                              <option value="">Selectionnez</option>
                                            @foreach ($categories as $categorie)
                                            <option value="{{$categorie->id}}" >{{$categorie->nomcat}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <center>
                                        <input id="btn" type="submit" class="btn btn-success btn btn-lg " value="Enregistrer">
                                    </center>
                                </div>
                            </div>

                            </div>

            </form>
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
</script>
@endsection


