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
                            <th>Total</th>
                            <th>Restant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($factures as $facture)
                            <tr>

                                <td>{{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</td>
                                <td>
                                    {{ $facture->nomc }}
                                </td>
                                <td>
                                    {{ $facture->total }}
                                </td>
                                <td>
                                   @if($facture->restant > 0) <span class="badge badge-danger">{{ $facture->restant }} CFA  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default{{ $facture->id }}">Completer</button></span> @else  <span class="badge badge-success">{{ $facture->restant }} CFA</span> @endif
                                </td>
                                <td>{{--  <a href="{{ route('get.by.facture', ['facture_id'=>$facture->id]) }}" class="btn btn-warning">Retour</a>  --}}
                                    <a href="{{ route('facture.show', ['facture_id'=>$facture->id]) }}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                     <a href="{{ route('modifier.facture',$facture->id) }}" role="button" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE', 'route'=>['factur.destroy', $facture->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                    <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    {!! Form::close() !!}
                                </td>


          <div class="modal fade" id="modal-default{{ $facture->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Complement Facture   {{ $facture->nomc }} Montant :   {{ $facture->total }} CFA | Restant : {{ $facture->restant }} CFA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('completer') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{  $facture->id }}" name="id">
                        <input type="hidden" value="{{  $facture->total }}" name="total">
                        <input type="hidden" value="{{  $facture->restant }}" name="restant">
                        <input type="hidden" value="{{  $facture->recu }}" name="recu">
                        <div class="modal-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Montant Restant </label>
                                    <input type="text" name="complement" id="complement"  value="{{ $facture->restant }} " class="form-control"  required>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" >Valider</button>
                        </div>
                    </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

                            </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

