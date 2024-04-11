 <!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Gobierno del Estado de Oaxaca | Sancionados</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="imagenes/favicon.png">
        <!--sweetalert2  -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Daterangepicker css -->
        <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css')}}">
        <!-- Vector Map css -->
        <link rel="stylesheet" href="{{ asset('vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}">
        <!-- JQUERY -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <!-- Theme Config Js -->
        <script src="{{ asset('js/hyper-config.js') }}"></script>
        
        <!-- Datatables css -->
        <link href="{{ asset('vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
            rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
            rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!-- App css -->
        <link href="{{ asset('css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="{{ asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar container-fluid">
                    <div class="d-flex align-items-center gap-lg-2 gap-1">
                        <button class="button-toggle-menu">
                            <i class="mdi mdi-menu"></i>
                        </button>
                        <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                        <div class="app-search dropdown d-none d-lg-block">
                            <a href="{{ asset('dashboard') }}">
                               {{--  <span><img src="{{ asset('imagenes/COLOR.SVG') }}" alt="logo" height="60" class="grayIMG"></span> --}}
                                <span><img src="{{ asset('imagenes/COLOR.SVG') }}" alt="logo" width="auto" height="50"></span>
                            </a>
                        </div>
                    </div>
                    <!-- componetes del top  -->
                    <ul class="topbar-menu d-flex align-items-center gap-3">
                  
                        <li class="d-none d-sm-inline-block">
                            <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left" title="Theme Mode">
                                <i class="ri-moon-line font-22"></i>
                            </div>
                        </li>


                        <li class="d-none d-md-inline-block">
                            <a class="nav-link" href="" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line font-22"></i>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{asset('imagenes/perfil.jpg')}}" alt="user-image" width="32" class="rounded-circle">
                                </span>
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    @if (Auth::check())
                                   
                                    <h5 class="my-0">{{ Auth::user()->name }}</h5>
                                    <h6 class="my-0 fw-normal">({{ Auth::user()->cargo }})</h6>
                                    @endif
                                  
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== Topbar End ========== -->
            <!-- ========== Left Sidebar Start ========== -->
            <div class="leftside-menu">
                <a href="{{ asset('dashboard') }}" class="logo logo-light">
                    <span class="logo-lg">
                        <div style="text-align: center;">
                            <img src="{{ asset('imagenes/img9.png')}}" alt="logo" height="50" style="display: block; margin: 0 auto;">
                            <span style="display: block; font-size: 14px; color: white; margin-top: -20px;">Sistema De Servidores </span>
                            <span style="display: block; font-size: 14px; color: white; margin-top: -55px;">Públicos Sancionados</span>
                        </div>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('imagenes/img9.png')}}" alt="small logo">
                    </span>
                </a>
                <div class="h-100" id="leftside-menu-container" data-simplebar>
                    <ul class="side-nav">

                        <li class="side-nav-title">Menu</li>

                        @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista() or Auth::user()->consulta())
                        <li class="side-nav-item">
                            <a href="/dashboard"  class="side-nav-link">
                                <i class="ri-numbers-line"></i>
                                <span> Reporte </span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista())
                        <li class="side-nav-item">
                            <a href="{{ route('sancionados.index')}}" class="side-nav-link">
                                <i class="ri-user-add-line"></i>
                                <span> Agregar Sancionado </span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista())
                        <li class="side-nav-item">
                            <a href="{{ route('sancionados.view') }}" class="side-nav-link">
                                <i class="ri-bank-line"></i>
                                <span> Busqueda de Sancionados </span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista() or Auth::user()->consulta())
                        <li class="side-nav-item">
                            <a href="{{ route('impugnacion.view') }}" class="side-nav-link">
                                <i class="ri-file-list-3-line"></i>
                                <span> Impugnación </span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->super() or Auth::user()->administrador() or Auth::user()->capturista())
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarCatalogos" aria-expanded="false" aria-controls="sidebarCatalogos" class="side-nav-link">
                                <i class="uil-window"></i>
                                <span> Catalagos </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCatalogos">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{route('catalogo_autoridades.index')}}">Autoridades Sancionadoras</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('catalogo_sanciones.index') }}">Sanciones Impuestas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('catalogo_dependencia.index') }}">Dependencias</a>
                                    </li> 
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (Auth::user()->super())
                        <li class="side-nav-item">
                            <a class="side-nav-link" href="/impugnacion/logs/" target="_blank">
                                <i class="ri-bug-line"></i>
                                <span> Log </span>
                            </a>
                        </li>  
                        @endif                   
                        <li>
                            <a class="logo logo-light">
                                <span class="logo-lg">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="btn btn-primary rounded-pill " :href="route('logout')" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                Cerrar Sesión
                                            </button>
                                        </form>      
                                </span>
                                <span class="logo-sm"> 
                                </span>
                            </a>
                        </li>
                      
                    </ul>
                    
                </div>
            </div>
            <!-- ========== Left Sidebar End ========== -->
            @yield('content')
        </div>


        <!-- Vendor js -->
        <script src="{{ asset('js/vendor.min.js')}}"></script>

        <!-- Code Highlight js -->
        <script src="{{ asset('vendor/highlightjs/highlight.pack.min.js') }}"></script>
        <script src="{{ asset('vendor/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ asset('js/hyper-syntax.js') }}"></script>

        <!-- Datatables js -->
        <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- Datatable Demo Aapp js -->
        <script src="{{ asset('js/pages/demo.datatable-init.js') }}"></script>

        <!-- Daterangepicker js -->
        <script src="{{ asset('vendor/daterangepicker/moment.min.js')}}"></script>
        <script src=" {{ asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
        
        <!-- Apex Charts js -->
        <script src="{{ asset('vendor/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Vector Map js -->
        <script src="{{ asset('vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{ asset('vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- Dashboard App js -->
        <script src="{{ asset('js/pages/demo.dashboard.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('js/app.min.js')}}"></script>

    </body>
</html>  

