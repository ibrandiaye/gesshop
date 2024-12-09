<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>PAPE MODOU NDIAYE BISINESS</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <script src="{!! asset('assets/plugins/jquery/jquery.min.js') !!}"></script>
    <link rel="stylesheet" href="{!! asset('assets/plugins/fontawesome-free/css/all.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/jqvmap/jqvmap.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('assets/dist/css/adminlte.min.css') !!}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}">
    <!-- Daterange picker -->
   {{--   <link rel="stylesheet" href="{!! asset('assets/plugins/daterangepicker/daterangepicker.css') !!}">
    <!-- summernote -->
    <link rel="stylesheet" href="{!! asset('assets/plugins/summernote/summernote-bs4.css') !!}">  --}}
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>

    <script src=https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json></script>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed" >
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-success ">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">TABLEAU DE BORD</a>
            </li>

        </ul>

        <!-- SEARCH FORM -->


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->



            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="dropdown-item" href="#"
                   onclick="event.preventDefault();
               document.getElementById('logout-form').submit();" style="color: red;">
                    {{ __('Déconnexion') }}
                </a>
                @auth


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endauth


            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-lime">
        <!-- Brand Logo -->
        <a href="#" class="brand-link ">

            <span class="brand-text font-weight-light"><img class="img" src="{{ asset('assets/img/logo.png') }}" style="width: 40%;" ></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            {{--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('assets/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">

                    <a href="#" class="d-block"> {{ Auth::user()->name }}</a>

                </div>
            </div>  --}}

            <!-- Sidebar Menu -->
             <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{ route('home') }}" class="nav-link active" style="color:floralwhite;">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Tableau de bord
                            </p>
                        </a>

                    </li>
                   <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-users"></i>

                            <p>
                                Fournisseur
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('fournisseur.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('fournisseur.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-database"></i>

                            <p>
                                Categorie
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categorie.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categorie.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-database"></i>

                            <p>
                                Article
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('produit.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('produit.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-archive"></i>

                            <p>
                                Depot
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('depot.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('depot.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class='fas fa-arrow-right'></i>

                            <p>
                                Entree Stock
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('entree.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('facturee.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-users"></i>

                            <p>
                                Client
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('client.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('client.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class='fas fa-arrow-left'></i>

                            <p>
                                Vente
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('sortie.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('facture.fac') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('retour.index') }}" class="nav-link">
                            <i class='fas fa-arrows-alt-h'></i>

                            <p>
                                Retour
                            </p>
                        </a>

                    </li>
                 {{--     <li class="nav-item">
                        <a href="{{ route('facture.fac') }}" class="nav-link">

                            <i class='fas fa-exchange-alt'></i>
                            <p>
                            Facture
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                    </li>  --}}
                    @if(Auth::user()->role=='administrateur')
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-users"></i>

                            <p>
                            Utilisateur
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ajouter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>lister</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @yield('content')

    <!-- Content Wrapper. Contains page content -->
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <!-- <strong>Copyright &copy; 2014-2019 <a href="https://www.linkedin.com/in/ibra-ndiaye-164a18109/">SDIS</a>.</strong> -->
        <strong>Copyright &copy; 2022 | <a href="">Ibra Ndiaye</a> | </strong>

        Tous droits réservés.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 00.0.2020
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('assets/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{!! asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<!-- ChartJS -->
<script src="{!! asset('assets/plugins/chart.js/Chart.min.js') !!}"></script>
<!-- Sparkline -->
<script src="{!! asset('assets/plugins/sparklines/sparkline.js') !!}"></script>
<!-- JQVMap -->
{{--  <script src="{!! asset('assets/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script>  --}}
<!-- jQuery Knob Chart -->
<script src="{!! asset('assets/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
<!-- daterangepicker -->
<script src="{!! asset('assets/plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('assets/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- Summernote -->
<script src="{!! asset('assets/plugins/summernote/summernote-bs4.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script src="{!! asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('assets/dist/js/adminlte.js') !!}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{!! asset('assets/dist/js/pages/dashboard.js') !!}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! asset('assets/dist/js/demo.js') !!}"></script>


<!-- DataTables -->
<script src="{!! asset('assets/plugins/datatables/jquery.dataTables.js') !!}"></script>
<script src="{!! asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') !!}"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script>
    $(function () {

        $('.tables').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
           "paging": true,
            "lengthChange": true,
            "searching": true,
           // "ordering": true,
           "info": false,
            "autoWidth": false,
            "scrollX": true,
           order: [[1, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $('#exemple1').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
           "paging": true,
            "lengthChange": true,
            "searching": true,
           // "ordering": true,
           "info": false,
            "autoWidth": false,
            "scrollX": true,
           order: [[1, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $('.exemple2').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
            },
           "paging": true,
            "lengthChange": true,
            "searching": true,
           // "ordering": true,
           "info": false,
            "autoWidth": false,
            "scrollX": true,
           order: [[1, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
{{--  </script>
  <script type="text/javascript">
    var links = document.getElementsByClassName('btn');
for (var i=0;i<links.length;i++) {
    links[i].addEventListener('dblclick', function(e) {//Pour empêcher le double-clic sur href !
        e.preventDefault();
    }, false);
    links[i].onclick=function() {//pour autoriser qu'un seul clique
        this.onclick=function(e) {
            e.preventDefault();
        }
    }
} --}}


        document.getElementById('btn').addEventListener('click', function(event) {

            var form = document.getElementById('form'); // Remplacez 'votreFormulaire' par l'ID de votre formulaire
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                this.setAttribute('disabled', 'disabled');
                this.innerText = 'Enregistrement en cours...';
                form.submit();
            }
            form.classList.add('was-validated');
        });
    </script>

@yield('script')
</body>
</html>
