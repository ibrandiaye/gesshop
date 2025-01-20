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
  <style>
  .table  {
        border: 1px solid;
       text-align: center;
    }
</style>
</head>
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
                
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <table style="width: 100%;">
                    <tr>
                        <td>  Client
                            <address>
                            <strong>@if( $facture->client)
                              {{ $facture->client->nomc }} @endif </strong>
                            </address></td>
                        <td>  Date:  <address> <strong>{{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</strong><br>
                        </address></td>
                        <td>  INfOLINE
                            <address>
                            <strong> 77 274 91 91 </strong>
                            </address></td>
                    </tr>
                </table>
               
              </div>
              <br>
              <br>
              <!-- /.row -->
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped" style="width: 100%; border: 1px solid;" c>
                  <thead>

                  <tr class="table">
                    <th class="table">Article</th>
                    <th class="table">Quantite </th>
                    <th class="table">Prix Unitaire</th>
                    <th class="table">Prix Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facture->sorties as $sortie)
                  <tr class="table">
                    <td class="table">{{ $sortie->produit->nomp }}</td>
                        <td class="table">{{ $sortie->quantite }} </td>
                        <td class="table">{{ $sortie->prixv }}</td>
                    <td class="table">{{ $sortie->quantite *  $sortie->prixv }} FCFA
                    </td>
                  </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
 <center>{!! $qrcode !!}</center>
            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">


              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

</body>
</html>
