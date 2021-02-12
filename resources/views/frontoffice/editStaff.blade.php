@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/validations.js') }}"></script>
    <div class="container-bar">
        <p class="container-bar_txt">Editar Utilizadores</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/add-user.png') }}" />
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">{{$client->name}}</li>
        </ol>
    </nav>

    <a class="back-btn" href="/frontoffice/staff">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/frontoffice/staff/edit/{{$userStaff->id}}" method="post" >
                            {{ csrf_field() }}
                                <div class="form-group">
                                    Nome:<input class="form-control" placeholder="Nome" id='ownerName'  value="{{$userStaff->name}}" name="name">
                                </div>
                                <div id="EmailInvoice" class="form-group">
                                    Email Registo: <input class="form-control" value="{{$userStaff->email}}" placeholder="Insira o E-mail de Registo" type="email" name="email" required >
                                </div>
                                <label>Nova Password</label>
                                <div class="form-group">
                                    Password: <input class="form-control"  type="password" name="password">
                                </div>
                                <label>Novo Pin</label>
                                <div class="form-group">
                                    Pin: <input class="form-control"  type="password" name="pin">
                                </div>

                                <div class="form-group">
                                   <label>HACCP</label>
                                   @if($permissions[1])
                                     <input type="checkbox" class="radio-inline" name="type[haccp]" id="type" value="1" checked>
                                   @else
                                     <input type="checkbox" class="radio-inline" name="type[haccp]" id="type" value="1">
                                    @endif

                                    <label>Contabilistico</label>
                                   @if($permissions[2])
                                     <input type="checkbox" class="radio-inline" name="type[contabilistico]" id="type" value="2" checked>
                                   @else
                                     <input type="checkbox" class="radio-inline" name="type[contabilistico]" id="type" value="2">
                                   @endif

                                   <label>Controlo de Pragas</label>
                                   @if($permissions[3])
                                     <input type="checkbox" class="radio-inline" name="type[controlo de Pragas]" id="type" value="3" checked>
                                   @else
                                     <input type="checkbox" class="radio-inline" name="type[controlo de Pragas]" id="type" value="3">
                                   @endif

                                   <label>Registos</label>
                                   @if($permissions[4])
                                     <input type="checkbox" class="radio-inline" name="type[registos]" id="type" value="4" checked>
                                   @else
                                     <input type="checkbox" class="radio-inline" name="type[registos]" id="type" value="4" >
                                   @endif

                                   <label>Produtos</label>
                                   @if($permissions[5])
                                      <input type="checkbox" class="radio-inline" name="type[produtos]" id="type" value="5" checked>
                                   @else
                                      <input type="checkbox" class="radio-inline" name="type[produtos]" id="type" value="5" >
                                   @endif

                                   <label>Encomendas</label>
                                   @if($permissions[6])
                                      <input type="checkbox" class="radio-inline" name="type[encomendas]" id="type" value="6" checked>
                                   @else
                                      <input type="checkbox" class="radio-inline" name="type[encomendas]" id="type" value="6" >
                                   @endif
                                </div>
                            <div>
                                <button class="btn btn-add" >Editar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

