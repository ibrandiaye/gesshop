@extends('layout')


@section('content')

    <div class="content-wrapper">

        <div class="container">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-info">GESTION DES RETOURS</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('facture.fac') }}" role="button" class="btn btn-success">LISTE  DES FACTURES</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <form action="{{ route('facture.retour.store') }}" method="POST">
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE D'ENREGISTREMENT D'UN Retour</div>
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
                                    <div class="col-lg-12">
                                        <table class="table table2 table-bordered" id="ta">
                                            <thead>

                                            <tr>
                                                <th>Article</th>
                                                <th>Quantité livré</th>
                                                <th>Quantité rétourné</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sorties as $sortie)
                                                <tr>
                                                    <td>{{ $sortie->produit->nomp }}</td>
                                                    <td> {{ $sortie->quantite }}</td>
                                                    <td>

                                                            <input type="number" name="quantite[]" value="0" id="quantite"  value="{{ old('quantite') }}" step='0.1' max="{{ $sortie->quantite }}" class="calcul  form-control"  required>
                                                    <input type="hidden" value="{{ $sortie->id }}" name="sortie_id[]">

                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>



                                </div>
                                <center>
                                    <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>
                                </center>

                            </div>

                            </div>


            </form>
            </div>
        </div>




@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
$(document).ready(function(){
    //alert('keuup');
    $(".calcul").keyup(function(){
        console.log('keuup');
       var prixu = $("#prixv").val();
       var quantite = $("#quantite").val();
       console.log(prixu * quantite);
      });
});
$("#jsonchauffeur").click(function () {


    var nom =  $("#nom").val();
    var chauffeur='';

        $.ajax({
            type:'POST',
               url:"{{ route('json.chauffeur.store') }}",
               data:{_token:'<?php echo csrf_token() ?>', nom:nom},
            success:function(data) {


                    chauffeur ="<option value="+data.id+" selected>"+data.nom+"</option>";

                $("#chauffeur_id").append(chauffeur);
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
            //find content of different elements inside a row.
            var nameTxt = $(this).closest('tr').find('.name').text();
            var id = $(this).closest('tr').find('.id').text();
            $(".conteneur").append("<tr> <td><input type='hidden' value="+id+" name='sortie_id[]' required>"+nameTxt+"</td>"+
            "<td><input type='number' name='quantite[]' class='form-control quant'  step='0.1' required> </td>"+
            "<td><button type='button' class='btn btn-danger remove-tr'><i class='fas fa-trash'></i></button></td>");
            $("#btnenreg").removeAttr("disabled");
            //alert(nameTxt);
        });
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



