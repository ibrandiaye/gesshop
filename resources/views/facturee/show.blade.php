@extends('layout')
@section('title', '| facturee')


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
            <li class="breadcrumb-item active">Entree</li>
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
                   
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">

              <div class="col-sm-4 invoice-col">
                fournisseur
                <address>
                <strong>@if( $facturee->fournisseur)
                  {{ $facturee->fournisseur->nomf }} @endif </strong>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Date :</b><br>
                {{  Carbon\Carbon::parse( $facturee->created_at)->format('d-m-Y H:i') }}<br>
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
                    <th>Quantite commandée</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facturee->entrees as $entree)
                  <tr>
                    <td><a href="{{ route('get.chercher.produit', ['id'=>$entree->produit->id]) }}">{{ $entree->produit->nomp }}</a></td>
                        <td>
                           {{ $entree->quantite}}


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
                <a href="{{ route('facturee.impression', ['facture_id'=>$facturee->id]) }}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
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

