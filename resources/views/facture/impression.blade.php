<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ALIMENTATION NDIAYE ET FRERES</title>
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
   /* border: solid 1px;*/
   /* text-align: center;*/
    font-weight: bold;
  }
  table {

                border-collapse: collapse;
                font-size: 17px;
            }
            body
            {
                font-size: 20px;
            }
            .wrapper
            {
                width: 110mm; /* Largeur pour l'impression */
            }
            .invoice
            {
                width: 110mm; /* Largeur pour l'impression */
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
                 {{--    <img class="img float-right" src="{{ asset('assets/img/logo.png') }}" style="width: 20%;"> --}}


                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <img class="img " src="{{ asset('assets/img/logo.png') }}" style="width: 90%;"><br>
              <center>Dakar, Keur Massar, PA U2, Près de Phramacie 24 h</center><br>
             <center> ---------------------------------------------------------</center>

             <table style="width: 100%;border: none;">
                <tr>
                    <td><b>N° Facture </b></td>
                    <td class="float-right"><b>{{ $facture->id }}</b></td>
                </tr>
                <tr>
                    <td><b> Client</b></td>
                    <td class="float-right"><b><strong>@if ( $facture->client)
                    {{ $facture->client->nomc }} @endif </strong></b></td>
                </tr>
                <tr>
                    <td><b>  Date</b></td>
                    <td class="float-right"><b> {{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</b></td>
                </tr>
                <tr>
                    <td><b>  INfOLINE</b></td>
                    <td class="float-right"><b> 77 199 88 85</b></td>
                </tr>

             </table>

                <!-- /.col -->

              <!-- /.row -->
            <!-- /.row -->

            <!-- Table row -->
          {{--   @php
               $total = 0 ;
            @endphp --}}

            <center> ---------------------------------------------------------</center>

            <table style="width: 100%;border: none;">

                @foreach ($facture->sorties as $key => $sortie)
                    <tr>
                        <td colspan="2"><b> {{ $sortie->produit->nomp }}</b></td>

                    </tr>
                    <tr>
                        <td colspan="2"><b> {{ $sortie->quantite }} * {{ $sortie->prixv }}  cfa</b></td>
                        <td class="float-right"><b>{{ $sortie->quantite *  $sortie->prixv }} cfa</b></td>
                    </tr>
                @endforeach


             </table>
               {{--<div class="row">
              <div class="col-12 table-responsive">
                <table class="">
                  <thead>

                  <tr>
                    <th>Article</th>
                    <th>  Qte </th>
                    <th>Prix Unitaire</th>
                    <th>Prix Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facture->sorties as $sortie)
                  <tr >
                    <td style="text-align: center;font-weight: bold;"><strong>{{ $sortie->produit->nomp }}</strong></td>
                        <td><strong>{{ $sortie->quantite }}</strong></td>
                        <td>{{ $sortie->prixv }}  cfa</td>
                    <td>{{ $sortie->quantite *  $sortie->prixv }} cfa
                    </td>
                  </tr>
                 {{--  @php
                  $total = $total + ( $sortie->quantite *  $sortie->prixv)  ;
               @endphp
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>--}}
            <!-- /.row -->
            <center> ---------------------------------------------------------</center>
            <strong>Total : {{$facture->total}} CFA</strong><br>
            <strong>Reçu : {{$facture->recu}} CFA</strong><br>
            <strong>Restant : {{$facture->restant}} CFA</strong><br>
            <center> ---------------------------------------------------------</center>
            <center>{{ $qrcode }}</center>

          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      <br><br>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
  window.addEventListener("load", window.print());
</script>
</body>
</html>
