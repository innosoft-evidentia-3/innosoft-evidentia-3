<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Evidentia</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    @auth
        @if(Request::is('/') || Request::is('admin/*'))
            <x-navbaradmin/>
        @else
            <x-navbarcommon/>
        @endif
    @endauth

        @guest
            <x-navbarguest/>
        @endguest

    {{---------------------------------------------------}}
    {{-- MAIN MENU --}}
    {{---------------------------------------------------}}

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <x-lilogo/>

        <div class="sidebar">

            <x-menuguest/>

            @auth

                <x-liavatar/>

                @if(Request::is('/') || Request::is('admin/*'))

                    <x-menuadmin/>

                @else

                    <x-menucommon/>
                    <x-menustudent/>
                    <x-menusecretary/>
                    <x-menucoordinator/>
                    <x-menuregistercoordinator/>
                    <x-menupresident/>
                    <x-menulecture/>

                    <x-menuoptions/>

                @endif

            @endauth

        </div>

    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><i class="@yield('title-icon')"></i>&nbsp;&nbsp;@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @section('breadcrumb')
                            @show
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
             Hecho con <i class="fas fa-heart"></i>
        </div>
        <!-- Default to the left -->
        GNU/GPL 3.0 · <a href="https://github.com/drorganvidez/evidentia"><i class="fab fa-github"></i> Repositorio en GitHub</a>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<!-- Selectors -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- File Input -->
<link href="{{asset('dist/css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css" />
<link href="{{asset('dist/themes/explorer/theme.css')}}" media="all" rel="stylesheet" type="text/css" />
<script src="{{asset('dist/js/plugins/piexif.min.js')}}" type="text/javascript"></script>
<script src="{{asset('dist/js/plugins/sortable.min.js')}}" type="text/javascript"></script>
<script src="{{asset('dist/js/plugins/purify.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="{{asset('dist/js/fileinput.js')}}"></script>
<script src="{{asset('dist/themes/fas/theme.js')}}"></script>
<script src="{{asset('dist/themes/explorer/theme.js')}}"></script>
<script src="{{asset('dist/js/fileinput_locales/es.js')}}"></script>


<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>

    $("#files").fileinput({
        theme: "explorer",
        language: "es",
        showUpload: false,
        overwriteInitial: false,
        maxFileSize: 10000,
        uploadUrl: "/file-upload-batch/2",
        autoReplace: true,
        deleteUrl: "/site/file-delete",
        browseClass: "btn btn-primary btn-block",
        showCaption: false,
        showRemove: false,
        showUpload: false
    });

    $(document).ready(function(){

        $(function () {
            // Summernote
            $('.textarea').summernote()
        })


        $('#summernote').summernote({
            //placeholder: 'Incluye una breve descripción de tu evidencia',
            height: 300,
            minHeight: 300
        });

    });

</script>

</body>

</html>
