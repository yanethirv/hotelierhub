<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Registro</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->
    
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/semi-dark-layout.css') }}">
    
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-10 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                    <img src="{{ asset('images/pages/register.jpg') }}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 p-2">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">{{ __('Crear Cuenta') }}</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">{{ __('Complete el siguiente formulario para crear una nueva cuenta.') }}</p>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <form method="POST" action="{{ route('register') }}">
                                                    @csrf
                                                    <div class="form-label-group">
                                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nombre Completo" required autocomplete="name" autofocus>
                                                        @error('name')
                                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                                <i class="feather icon-info mr-1 align-middle"></i>
                                                                <span>{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                        <label for="name">{{ __('Nombre Completo') }}</label>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required autocomplete="email" autofocus>
                                                        @error('email')
                                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                                <i class="feather icon-info mr-1 align-middle"></i>
                                                                <span>{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                        <label for="email">{{ __('Correo Electrónico') }}</label>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" placeholder="Número Móvil" required autocomplete="mobile" autofocus>
                                                        @error('mobile')
                                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                                <i class="feather icon-info mr-1 align-middle"></i>
                                                                <span>{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                        <label for="mobile">{{ __('Número Móvil') }}</label>
                                                    </div>
                                                    @if(!$tenantName)
                                                    <div class="form-label-group">
                                                        <input id="fqdn" type="text" class="form-control @error('fqdn') is-invalid @enderror" name="fqdn" value="{{ old('fqdn') }}" placeholder="Hostname" required autocomplete="fqdn" autofocus>
                                                        @error('fqdn')
                                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                                <i class="feather icon-info mr-1 align-middle"></i>
                                                                <span>{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                        <label for="fqdn">{{ __('Hostname') }}</label>
                                                    </div>
                                                    @endif
                                                    <div class="form-label-group">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                                        @error('password')
                                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                                <i class="feather icon-info mr-1 align-middle"></i>
                                                                <span>{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                        <label for="password">{{ __('Password') }}</label>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Password" required autocomplete="new-password">
                                                        <label for="password-confirm">{{ __('Confirmar Password') }}</label>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox" checked>
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">{{ __('Acepto los términos y condiciones.') }} </span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('login') }}" class="btn btn-outline-primary float-left btn-inline mb-50">{{ __('Ingresar') }}</a>
                                                    <button type="submit" class="btn btn-primary float-right btn-inline mb-50">{{ __('Registrar') }}</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('js/core/app-menu.js') }}"></script>
    <script src="{{ asset('js/core/app.js') }}"></script>
    <script src="{{ asset('js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->
</body>
<!-- END: Body-->

</html>