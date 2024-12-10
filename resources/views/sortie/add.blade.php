@extends('layout')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .clignote {
      color:green;
      animation: clignote 2s linear infinite;
    }
    @keyframes clignote {
      50% { opacity: 0; }
    }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="container">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-info">GESTION DES SORTIES</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('produit.index') }}" role="button" class="btn btn-success">LISTE D'ENREGISTREMENT DES SORTIES</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <form id="form" action="{{ route('sortie.store') }}" method="POST">
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE D'ENREGISTREMENT D'UNE SORTIE</div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Depots</label>
                                        <select class="form-control " id="depot_id" name="depot_id" required=""  {{ Auth::user()->role=="gestionnaire" ? "disabled='true'" : ''  }} >
                                            <option value="">Selectionnez</option>
                                            @foreach ($depots as $depot)
                                            @if(Auth::user()->role=="gestionnaire" )
                                            <option value="{{$depot->id}}" {{  Auth::user()->depot_id==$depot->id ? 'selected' : '' }}>{{$depot->nomd}}</option>
                                            @else
                                            <option value="{{$depot->id}}">{{$depot->nomd}}</option>
                                            @endif
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                        <label>Client</label>
                                        <div class="form-group input-group input-group-sm">
                                        <select class="form-control select2" id="client_id" name="client_id" s>
                                            <option value="">Selectionnez</option>
                                            @foreach ($clients as $client)
                                            <option value="{{$client->id}}"  {{old('client_id')==$client->id ? 'selected' : ''}}>{{$client->nomc}} {{ $client->telc }}</option>
                                                @endforeach

                                        </select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default1">Nouveau client!</button>
                                          </span>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" id="searchInput" placeholder="Rechercher..." style=" width: 100%;" class="form-control"><br>
                                        <table id="myTable" class="table  table-bordered" >
                                            <thead>

                                            <tr>
                                                <th>#</th>
                                                <th>Article</th>
                                                <th>stock</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tbody id="prod">
                                                @if(Auth::user()->role=='gestionnaire')


                                             @foreach($produits as $produit)
                                                <tr>
                                                    <td class="id">{{ $produit->id }}</td>
                                                    <td class="name"> {{ $produit->nomp }}</td>
                                                    <td class=""> @foreach ($depotProduits as $depotProduit )
                                                        @if($produit->id== $depotProduit->produit_id)
                                                        {{ $depotProduit->stock }}
                                                        @endif
                                                    @endforeach </td>
                                                    <td><button type="button"  class="btn btn-success addRow">AJOUTER</button></td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-lg-6">
                                        <br><br><br>
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Article</th>
                                                    <th>Quantite</th>
                                                    <th>prix Unitaire</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="conteneur">

                                            </tbody>
                                        </table>
                                        <div>
                                            Total: <input type="text" name="total" id="total" readonly value="0" class="form-control">
                                            Montant Reçu: <input type="number" name="recu" id="total"  value="0" class="form-control" required >

                                        </div>
                                        <center>
                                            <button id="btn" type="submit" id="btnenreg" class="btn  btn-success btn btn-lg "> ENREGISTRER</button>
                                        </center>
                                    </div>

                                </div>

                            </div>

                            </div>

            </form>
            </div>
        </div>


          <div class="modal fade" id="modal-default1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ajouter un client</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom client</label>
                            <input type="text" name="nomc" id="nomc"  value="{{ old('nomc') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Numéro Téléphone</label>
                            <input type="text" name="telc" id="telc"  value="{{ old('telc') }}" class="form-control"  >
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                  <button type="button" class="btn btn-primary" id="jsonclient" data-dismiss="modal">Ajouter</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>


@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        url_app = '{{ config('app.url') }}';
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
$(document).ready(function(){
    //alert('keuup');
   /* $(".calcul").keyup(function(){
        console.log('keuup');
       var prixu = $("#prixv").val();
       var quantite = $("#quantite").val();
       console.log(prixu * quantite);
      });*/
      function calculerTotal() {
        let total = 0;

        // Parcourir chaque ligne du tableau
        $('.conteneur tr').each(function () {
            const quantite = parseFloat($(this).find('.quant').val()) || 0;
            const prix = parseFloat($(this).find('.prix').val()) || 0;

            total += quantite * prix;
        });

        // Mettre à jour l'input readonly avec le total
        $('#total').val(total.toFixed(0));
    }

    // Écouter les changements sur les inputs quantité et prix
    $('.conteneur').on('input', '.quant, .prix', calculerTotal);

    // Supprimer une ligne
    $('.conteneur').on('click', '.remove-tr', function () {
        $(this).closest('tr').remove();
        calculerTotal(); // Recalcul du total après suppression
    });

    // Calcul initial
    calculerTotal();

});

    $("#depot_id").change(function () {
        var id = $("#depot_id").val();

        var userURL = url_app +"/api/json/entree/"+id;
        var content = '';

        $.ajax({
            url: userURL,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                $.each(data,function(index,row){
                    console.log(data);
                    //if(row.stock>0){
                        content = content +  "<tr>"
                          +"  <td class='id'>"+row.id+" </td>"
                          +"<td class='name'> "+row.nomp+" </td>"
                          +" <td class=''>"+row.stock+"</td>"
                          +" <td><button type='button'  class='btn btn-success addRow'>AJOUTER</button></td>"
                          +"</tr>"
                //    }

                });
                $("#prod").empty();
                $("#prod").append(content);
                $(".addRow").click(function() {
                   // alert('click');
                    //find content of different elements inside a row.
                    var nameTxt = $(this).closest('tr').find('.name').text();
                    var id = $(this).closest('tr').find('.id').text();
                    $(".conteneur").append("<tr> <td><input type='hidden' value="+id+" name='produit_id[]' required>"+nameTxt+"</td>"+
                    "<td><input type='number' name='quantite[]' class='form-control quant'  step='0.1' required> </td>"+
                    "<td><input type='number' name='prix[]' class='form-control prix' required> </td>"+
                    "<td><button type='button' class='btn btn-danger remove-tr'><i class='fas fa-trash'></i></button></td>");
                    $("#btnenreg").removeAttr("disabled");
                    //alert(nameTxt);
                });
            }
        });

    });
    $("#jsonclient").click(function () {


        var nomc =  $("#nomc").val();
        var telc =  $("#telc").val();
        var client='';

            $.ajax({
                type:'POST',
                   url:"{{ route('json.client.store') }}",
                   data:{_token:'<?php echo csrf_token() ?>', nomc:nomc,telc:telc},
                success:function(data) {


                        client ="<option value="+data.id+" selected>"+data.nomc+"</option>";

                    $("#client_id").append(client);
                }
            });

        });
</script>

<script>
    $(document).ready(function () {
        $("#btnenreg").prop("disabled","true");
        $(".addRow").click(function() {
            alert('click');
            //find content of different elements inside a row.
            var nameTxt = $(this).closest('tr').find('.name').text();
            var id = $(this).closest('tr').find('.id').text();
            $(".conteneur").append("<tr> <td><input type='hidden' value="+id+" name='produit_id[]' required>"+nameTxt+"</td>"+
            "<td><input type='number' name='quantite[]' class='form-control quant'  step='0.1' required> </td>"+
            "<td><input type='number' name='prix[]' class='form-control prix'  step='0.1' required> </td>"+
            "<td><button type='button' class='btn btn-danger remove-tr'><i class='fas fa-trash'></i></button></td>");
            $("#btnenreg").removeAttr("disabled");
            //alert(nameTxt);
        });
      {{--    $(".btnenreg").click(function() {
            $("#btnenreg").prop("disabled","true");
        });  --}}
    });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
        var quant = $('.quant').val();
        if(quant==null)
            $("#btnenreg").prop("disabled","true");
        else
            $("#btnenreg").removeAttr("disabled");

    });


    $('.table2').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
       "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
       "info": false,
        "autoWidth": false,
        "scrollX": true,
    });
    $('.table1').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
       "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
       "info": false,
        "autoWidth": false,
        "scrollX": true,
    });

</script>
@endsection



