{{-- \resources\views\permissions\create.blade.php --}}
@extends('layout')

@section('title', '| Modifier produit')
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
                        <li class="breadcrumb-item active"><a href="{{ route('produit.index') }}" role="button" class="btn btn-success">RETOUR</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

        {!! Form::model($produit, ['method'=>'PATCH','route'=>['produit.update', $produit->id]]) !!}
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE DE MODIFICATION D'UN PRODUIT</div>
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
                                        <input type="text" name="nomp"  value="{{ $produit->nomp}}" class="form-control"  required>
                                    </div>
                                </div>

                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix Unitaire produit</label>
                                        <input type="number" name="prixu"  value="{{ $produit->prixu }}" step='0.01' class="form-control"  >
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Unité produit</label>
                                        <input type="text" name="unite"  value="{{ $produit->unite }}" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>categories</label>
                                        <select class="form-control select2" id="categorie_id" name="categorie_id" required="" {{ Auth::user()->role=="gestionnaire" ? "disabled='true'" : ''  }} >
                                              <option value="">Selectionnez</option>
                                            @foreach ($categories as $categorie)
                                            <option value="{{$categorie->id}}" {{ $produit ->categorie_id==$categorie->id ? 'selected' : '' }}>{{$categorie->nomcat}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
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
