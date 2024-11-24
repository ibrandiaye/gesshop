@extends('layout')
@section('title', '| facture')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES factureS</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('facture.fac') }}" role="button" class="btn btn-success">facture</a></li>
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
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES factureS</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($factures as $facture)
                            <tr>
                                
                                <td>{{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</td>
                                <td>@if( $facture->client)
                                    {{ $facture->client->nomc }}
                                @endif</td>
                                <td>{{--  <a href="{{ route('get.by.facture', ['facture_id'=>$facture->id]) }}" class="btn btn-warning">Retour</a>  --}}
                                    <a href="{{ route('facture.show', ['facture_id'=>$facture->id]) }}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                     <a href="{{ route('modifier.facture',$facture->id) }}" role="button" class="btn btn-warning"><i class="fas fa-edit"></i></a>  
                                    {!! Form::open(['method' => 'DELETE', 'route'=>['factur.destroy', $facture->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
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

