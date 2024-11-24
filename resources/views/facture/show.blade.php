@extends('layout')
@section('title', '| facture')


@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Facture</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">



          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <img class="img float-right" src="{{ asset('assets/img/logo.png') }}" style="width: 20%;">
                    
                  <img class="float-center">
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">

              <div class="col-sm-4 invoice-col">
                Client
                <address>
                <strong>@if( $facture->client)
                  {{ $facture->client->nomc }} @endif </strong>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Date:  <address>{{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</b><br>
                </address>
                    {{--      <br>
                <b>Numéro de commande:</b> N°{{ $facture->id }}<br>
                <b>Date Facture:</b> {{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}<br>
                <b>Compte:</b> @if( $facture->client){{ $facture->client->telc }}  @endif  --}}
              </div>
              <div class="col-sm-4 invoice-col">
                INfOLINE
                <address>
                <strong> 77 274 91 91 </strong>
                </address>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>

                  <tr>
                    <th>Article</th>
                    <th>Quantite </th>
                    <th>Prix Unitaire</th>
                    <th>Prix Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facture->sorties as $sortie)
                  <tr>
                    <td><a href="{{ route('get.chercher.produit', ['id'=>$sortie->produit->id]) }}">{{ $sortie->produit->nomp }}</a></td>
                    <td>{{ $sortie->quantite }} </td>
                    <td>{{ $sortie->prixv }}</td>
                <td>{{ $sortie->quantite *  $sortie->prixv }} FCFA
                </td>
                  </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">


              </div>
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{ route('facture.impression', ['facture_id'=>$facture->id]) }}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection

