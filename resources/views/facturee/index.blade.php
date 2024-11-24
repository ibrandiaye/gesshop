@extends('layout')
@section('title', '| facturee')


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
                                <li class="breadcrumb-item active"><a href="{{ route('facturee.index') }}" role="button" class="btn btn-success">ENTREE</a></li>
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
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES factureeS</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>

                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facturees as $facturee)
                            <tr>
                                <td>{{ $facturee->created_at }}</td>
                                <td>@if( $facturee->fournisseur)
                                    {{ $facturee->fournisseur->nomf }}
                                @endif</td>
                                <td>
                                    <a href="{{ route('facturee.show', ['facturee'=>$facturee->id]) }}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                    {!! Form::open(['method' => 'DELETE', 'route'=>['facturee.destroy', $facturee->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
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

