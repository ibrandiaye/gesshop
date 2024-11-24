@extends('layout')
@section('title', '| produit')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES PRODUITS</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('produit.create') }}" role="button" class="btn btn-success">ENREGISTRER UN PRODUIT</a></li>
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
    @if(Session::has('errors'))
    <div class="alert alert-danger">
        <p>
 	{{Session::get('errors')->first()}}</p>
</div>
 @endif


<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES PRODUITS</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du produit</th>
                            <th>catégorie</th>
                             <th>Prix Unitaire</th>
                            <th>Unité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($produits as $produit)
                        <tr>
                            <td>{{ $produit->id }}</td>
                            <td><a href="{{ route('get.chercher.produit', ['id'=>$produit->id]) }}">{{ $produit->nomp }}</a></td>
                            <td>{{ $produit->categorie ?  $produit->categorie->nomcat : '' }}</td>
                            <td>{{ $produit->prixu }}</td>
                            <td>{{ $produit->unite }}</td>
                             <td>
                                <a href="{{ route('produit.edit', $produit->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                               {!! Form::open(['method' => 'DELETE', 'route'=>['produit.destroy', $produit->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}



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

