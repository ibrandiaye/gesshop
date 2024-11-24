@extends('layout')
@section('title', '| produit')
@section('css')
<link rel="stylesheet" href="{!! asset('assets/plugins/daterangepicker/daterangepicker.css') !!}">
@endsection
@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">{{ $produit->nomp }} </h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
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
    <section class="content">
        <div class="container-fluid">
    <div class="row">
@foreach ($depotProduits as $depotProduit)
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{ $depotProduit->depot->nomd }}</span>
        <span class="info-box-number">{{ $depotProduit->stock }} {{ $depotProduit->produit->unite }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
@endforeach
</div>


<div class="row">
    <div class="col-md-8">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</div>
<div class="row">
 <div class="col-sm-12">
    <form action="{{ route('detail.produit.between.to.date') }}" method="POST">
        @csrf
        <div class="form-group">
    <div class="col-sm-6">


    <input type="hidden" id="from" name="from"  value="{{ old('from') }}"  required>
    <input type="hidden" id="to" name="to"  value="{{ old('to') }}"  required>


        <div class="input-group">
          <div class="input-group-prepend">
            <label> Periode:</label>
            <span class="input-group-text">
              <i class="far fa-calendar-alt"></i>
            </span>
          </div>
          <input type="text" name="daterange" class="form-control float-right" id="reservation">
          <button type="submit" class="btn btn-success btn  "> Rechercher</button>
        </div>
        <!-- /.input group -->
      </div>


      <input id="produit_id" type="hidden" value="{{ $produit->id }}" name="produit_id">
    </div>
    </form>
</div>
    </div>
<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center"><h5>Liste des entrées du produit: {{ $produit->nomp }}</h5></div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            <th>fournisseur </th>
                            <th>Depot</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($entrees as $entree)
                        <tr>
                            <td>{{  Carbon\Carbon::parse( $entree->created_at)->format('d-m-Y H:m') }}  </td>
                            <td>
                                @if ($entree->produit)
                                {{ $entree->produit->nomp }}
                                @endif
                                </td>
                            <td>{{ $entree->quantite }}</td>
                            <td>
                                @if ($entree->facturee->fournisseur)
                                {{ $entree->facturee->fournisseur->nomf }}
                                @endif
                               </td>
                            <td>
                                @if ($entree->facturee->depot)
                                {{ $entree->facturee->depot->nomd }}
                                @endif</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="card border-danger border-0">
            <div class="card-header bg-success text-center"><h5>Liste des Sorties du produit: {{ $produit->nomp }}</h5></div>
                <div class="card-body">
                    <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Quantite</th>
                                <th>client</th>
                                <th>Stock</th>
                                <th>Dépot</th>
                                @if(Auth::user()->role=='administrateur')<th>Ecart</th>@endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($sorties as $sortie)
                            <tr>
                                <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:m') }}</td>
                                <td>
                                    @if ($sortie->produit)
                                    {{ $sortie->produit->nomp }}
                                    @endif
                                    </td>
                                <td>{{ $sortie->quantite }}</td>
                                <td>
                                    @if ($sortie->facture->client)
                                    {{ $sortie->facture->client->nomc }}
                                    @endif
                                    </td>
                                <td> @foreach ( $sortie->produit->depotProduits as $depotProduit )
                                    @if( $depotProduit->produit_id== $sortie->produit->id and $sortie->facture->depot->id==$depotProduit->depot_id)
                                        {{ $depotProduit->stock }}
                                    @endif
                                @endforeach</td>
                                <td>{{ $sortie->facture->depot->nomd }}</td>
                                @if(Auth::user()->role=='administrateur')<td>{{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}</td>@endif
                            </tr>
                            @endforeach

                        </tbody>
                    </table>



                </div>

            </div>
        </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script>
    let label = [];
    let donnee=[];
    var color = [];

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        var e = 1;

        return "rgba(" + r + "," + g + "," + b + ","+e + ")";
    };

    @foreach($depotProduits as $depotProduit)
        label.push('{{ $depotProduit->depot->nomd }}');
        donnee.push({{ $depotProduit->stock }});
        color.push(dynamicColors());
    @endforeach
const ctx= document.getElementById('myChart').getContext('2d');
const myChart= new Chart(ctx, {
    type: 'bar',
    data: {
        labels: label,
        datasets: [{
            label: '# Stock',
            data: donnee,
            borderWidth: 1,
            backgroundColor: color
        }]
    },
    options: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            fontColor: "#000080",
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
});

</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function() {
        const currentDate = new Date();
        const currentDayOfMonth = currentDate.getDate();
        const currentMonth = currentDate.getMonth(); // Be careful! January is 0, not 1
        const currentYear = currentDate.getFullYear();

        $('#from').val( currentYear + "-" + (currentMonth + 1) + "-" + currentDayOfMonth  );
        $('#to').val(currentYear+ "-" + (currentMonth + 1) + "-" +  currentDayOfMonth  );
      $('input[name="daterange"]').daterangepicker({
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "A",
            "customRangeLabel": "Custom",
            "weekLabel": "S",
            "daysOfWeek": [
                "Di",
                "Lu",
                "Ma",
                "Me",
                "Je",
                "Ve",
                "Sa"
            ],
            "monthNames": [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Août",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
            ]},
        opens: 'left'
      }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#from').val(start.format('YYYY-MM-DD'));
        $('#to').val(end.format('YYYY-MM-DD'));
      });


    });
    </script>
@endsection
