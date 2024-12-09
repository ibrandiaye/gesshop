<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ulul Albab</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<style>

  th,td {
    border: solid 1px;
  }
</style>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <div class="row">
        <div class="col-12">



          <!-- Main content -->
          <div class="invoice p-3 mb-3">
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
                  <b>Date:  <address>{{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</b><br>
                    <br>
                  Client
                  <address>
                  <strong>@if( $facture->client)
                    {{ $facture->client->nomc }} @endif </strong>
                  </address>
                  INfOLINE
                  <address>
                  <strong> 77 199 88 85 </strong>
                  </address>
                </div>
                <!-- /.col -->
                
             
                <!-- /.col -->
              </div>
              <!-- /.row -->
            <!-- /.row -->

            <!-- Table row -->
            @php
               $total = 0 ; 
            @endphp
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="">
                  <thead>

                  <tr>
                    <th>Article</th>
                    <th>  Qtite </th>
                    <th>Prix Unitaire</th>
                    <th>Prix Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facture->sorties as $sortie)
                  <tr >
                    <td style="border: solid 1px;">{{ $sortie->produit->nomp }}</td>
                        <td>{{ $sortie->quantite }} </td>
                        <td>{{ $sortie->prixv }}</td>
                    <td>{{ $sortie->quantite *  $sortie->prixv }} FCFA
                    </td>
                  </tr>
                  @php
                  $total = $total + ( $sortie->quantite *  $sortie->prixv)  ; 
               @endphp
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <strong>Total : {{$total}}</strong>
            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">


              </div>
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
  window.addEventListener("load", window.print());
</script>
</body>
</html>
