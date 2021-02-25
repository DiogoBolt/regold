<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Regolfood</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5cd186372846b90c57ad50ba/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    @yield('styles')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <img style="height: 20px;" src="{{ URL::to('/') }}/img/navbar/iconmenu.png" alt="menu">
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img src="{{ URL::to('/') }}/img/navbar/logoRegolfood.png" alt="logo">
                    </a>

                    @auth
                        <a class="navbar-message" href="/frontoffice/messages">
                            <img src="{{ URL::to('/') }}/img/msgs.png" alt="mensagens" />
                            <span id="messages" class="notification nav-msg">0</span>
                        </a>

                        <a class="navbar-cart" href="/frontoffice/cart">
                            <img src="{{ URL::to('/') }}/img/navbar/carrinhocompras.png" alt="carrinho de compras">
                        </a><span id="cartvalue">(€)</span>
                    @endauth
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li>
                                <a href="{{ route('invoices') }}">Facturas</a>
                            </li>
                            <li>
                                <a href="/frontoffice/favorites">Favoritos</a>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="/frontoffice/client">Definições</a></li>
                                    <li><a href="/frontoffice/staff">Utilizadores</a></li>
                                    <li>
                                        @if(Session::has('impersonated'))
                                            <a href="/impersonate/leaveuser">
                                                Voltar
                                            </a>
                                        @else
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                        @endif
                                            <a href="/frontoffice/thermo">
                                                Gestão Termos(BETA)
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
        <script>
                $.get( "/frontoffice/cartValue", function( data ) {
                    $( "#cartvalue" ).html( data+'€' );
                });

                $.get( "/frontoffice/unreadMessages", function( data ) {
                    $( "#messages" ).html( data );
                });
        </script>


        @yield('content')
    </div>

    <!-- Scripts -->

</body>
</html>
