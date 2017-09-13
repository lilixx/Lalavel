<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mansión Teodolinda') }}</title>

    <link rel="icon" href="{{{ asset('img/favicon.png') }}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/menu.css" rel="stylesheet">
    <link href="/css/general.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
          window.Laravel = {!! json_encode([
              'csrfToken' => csrf_token(),
          ]) !!};
      </script>

</head>
<body>

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Mansión Teodolinda') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                 Hola,   {{ Auth::user()->name }} <span class="caret"></span>
                              </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>

                                      <a href="{{ url('/users/editprofile') }}">
                                          Editar mi perfil
                                      </a>

                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
              @if (Auth::guest())
                <div class="col-md-12">
                   @yield('content')
                </div>
              @else
                  <div class="col-md-2">
                      @foreach (Auth::user()->roles as $rl)
                        @if($rl->nombre != 'Admin')
                          @include('layouts.menurecep')
                        @else
                          @include('layouts.menu')
                        @endif
                      @endforeach

                  </div>

                    <div class="col-md-9 col-md-offset-1">
                       @yield('content')
                    </div>
              @endif
            </div>
        </div>




    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/vue.min.js"></script>
    <script src="/js/vue-resource.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/bootstrap.min.js"></script>



</body>
</html>
