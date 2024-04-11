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
                    <div class="col-xxl-7 col-lg-5">
                        <div class="card">

                            <div class="card-header py-4 text-center bg-primary">
                                <a>
                                    <span><img src="{{ asset('imagenes/COLOR.svg') }}" alt="logo" height="auto" class="whiteIMG"></span>                          
                                </a>
                            </div>

                            <div class="card-body p-4">

                              <div class="text-center w-75 m-auto">
                                  <h4 class="text-dark-50 text-center pb-0 fw-bold">Iniciar Sesión</h4>
                                  <p class="text-muted mb-4">Ingrese su dirección de correo electrónico y contraseña para
                                      acceder al panel de administración.</p>
                              </div>
  
  
                              <form method="POST" action="{{ route('login') }}">
                                  @csrf
  
                                  <div class="mb-3">
                                      <label for="emailaddress" class="form-label">Correo electronico</label>
                                      <input class="form-control" type="email" id="email" required=""
                                          placeholder="ejemplo@gmail.com" @error('email') is-invalid @enderror"
                                          name="email" value="{{ old('email') }}" required autocomplete="email"
                                          autofocus>
                                      @error('email')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
  
                                  <div class="mb-3">
  
                                      <label for="password" class="form-label">Contraseña</label>
                                      <div class="input-group input-group-merge">
                                          <input type="password" id="password" class="form-control"
                                              @error('password') is-invalid @enderror" name="password" required
                                              autocomplete="current-password">
                                          <div class="input-group-text" data-password="false">
                                              <span class="password-eye"></span>
                                          </div>
                                          @error('password')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>
  
                                  <div class="mb-3 mb-3">
                                      <div class="form-check">
                                          <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                              {{ old('remember') ? 'checked' : '' }}>
                                          <label class="form-check-label" for="remember">Recordarme</label>
                                      </div>

                                      <p class="mt-4 text-sm text-center">
                                        No tienes cuenta?
                                        <a  class="text-primary text-gradient font-weight-bold">Contacta al Administrador</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline font-weight-bold">Registrate</a>         
                                        @endif
                                      </p>
                                      
                                  </div>
  
  
  
                                  <div class="row mb-0">
                                      <div class="col-md-5 offset-md-5">
                                          <button type="submit" class="btn btn-primary">
                                              {{ __('Login') }}
                                          </button>
                                      </div>
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
</html>

 