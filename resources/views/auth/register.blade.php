<!DOCTYPE html>
<html lang="en" data-layout="topnav" data-topbar-color="dark" >

    <head>
        <meta charset="utf-8" />
        <title>Iniciar Sesión|Honestidad</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="imagenes/favicon.png">
        <!-- Theme Config Js -->
        <script src="{{ asset('js/hyper-config.js')}}"></script>
        <!-- App css -->
        <link href="{{ asset('css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="{{ asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg">
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-5 col-lg-5">
                        <div class="card">

                            <div class="card-header py-4 text-center bg-primary">
                                <a>
                                    <span><img src="{{ asset('imagenes/COLOR.svg') }}" alt="logo" height="auto" class="whiteIMG"></span>                          
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold">Registro De Usuario</h4>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus class="form-control"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input id="email" class="form-control" type="email" name="email" :value="old('email')" required class="form-control"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cargo</label>
                                        <select id="cargo" class="selectpicker form-control" name="cargo" required>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Capturista">Capturista</option>
                                            <option value="Consulta">Consulta</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group input-group-merge">
                                        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" class="form-control"/>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirma Contraseña</label>
                                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                                    </div>              

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                    </div>
                                    <div class="mb-3">
                                        @if (Route::has('register'))
                                            <p class="mt-4 text-sm text-center">
                                                <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline font-weight-bold">¿Ya Estas Registrado?</a>
                                            </p>
                                        @endif
                                    </div>
                                </form>
                          </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <footer class="footer footer-alt">
          Gobierno del Estado de Oaxaca | webadmin@oaxaca.gob.mx
        </footer>
        <!-- Vendor js -->
        <script src="{{ asset('js/vendor.min.js')}}"></script>
        <!-- App js -->
        <script src="{{ asset('js/app.min.js')}}"></script>

    </body>
