<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Regoldi</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('styles')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/clients') }}">
                        <img src="{{ URL::to('/') }}/img/navbar/logoindexcolor.png" alt="logo">
                    </a>

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
            
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                                <li>
                                    <a href="{{ url('/messages/'.Auth::user()->id)}}">
                                        <img style="margin-top:-15px;width:50px" src="{{ URL::to('/') }}/img/message.png">
                                    </a>
                                </li>
                            @if(Auth::user()->sales_id == null)
                            <li>
                                <a href="/salesman">
                                    Vendedores
                                </a>
                            </li>
                                @else
                                <li>
                                    <a href="/salesman/{{Auth::user()->sales_id}}">
                                        Conta Corrente
                                    </a>
                                </li>
                            @endif

                                <li>
                                    <a href="/orders">
                                        Encomendas 
                                    </a>
                                </li>

                            <li>
                                <a href="/processedOrders">
                                    Encomendas Processadas
                                </a>
                            </li>

                            <li>
                                <a href="/historyOrders">
                                    Historico Encomendas
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">

                                    @if(Auth::user()->sales_id == null)
                                        <li>
                                            <a href="/documents">
                                                Tipos Documento
                                            </a>
                                        </li>
                                    @endif
                                    @if(Auth::user()->sales_id == null)
                                        <li>
                                            <a href="/salesman/new">
                                                Novo Vendedor
                                            </a>

                                        </li>
                                    @endif

                                    @if(Auth::user()->sales_id == null)
                                        <li>
                                            <a href="/products">
                                                Produtos
                                            </a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->sales_id == null)
                                        <li>
                                            <a href="/categories">
                                                Categorias
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
