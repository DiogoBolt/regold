@extends('layouts.app')
   
@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>
<div class="container-bar">
    <p class="container-bar_txt">Novo Staff</p>
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
                    <form action="/frontoffice/staff/add" method="post" >
                        {{ csrf_field() }}
                        <div id="ownerRegister" style="display:block">
                            <label class="add-label">Dados do Utilizador</label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    Nome:<input class="form-control" placeholder="Nome" id='ownerName'  name="ownerName" required>
                                </div>
                                <div class="form-group">
                                    PIN: <input class="form-control" placeholder="****" type="password" id="pin" name="pin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    E-Mail: <input class="form-control" placeholder="Insira o E-mail" type="email" id="loginMail" name="loginMail" required>
                                </div>
                                <div class="form-group">
                                    Password: <input class="form-control" type="password" placeholder="*********" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                @foreach($types as $type)
                                <label>{{$type->name}}</label>
                                <input type="checkbox" class="radio-inline" name="type[]" id="type" value="{{$type->id}}">
                                @endforeach
                                <label>Produtos</label>
                                <input type="checkbox" class="radio-inline" name="type[]" id="type" value="5">
                                <label>Encomendas</label>
                                <input type="checkbox" class="radio-inline" name="type[]" id="type" value="6">
                            </div>
                        </div>
                        <div>
                        <button class="btn btn-add" >Criar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
