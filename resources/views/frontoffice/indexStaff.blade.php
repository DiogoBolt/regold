@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">utilizadores</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">{{$client->name}}</li>
        </ol>
    </nav>

    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/frontoffice/staff/new" class="btn btn-add"><strong>Novo Utilizador</strong></a>

                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Apagar</th>
                            </tr>
                            @foreach($userStaff as $user)
                                <tr>
                                    <td><a href="/frontoffice/staff/edit/{{$user->id}}">{{$user->id}}</a></td>
                                    <td><a href="/frontoffice/staff/edit/{{$user->id}}">{{$user->name}}</a></td>
                                    <td><a href="/frontoffice/deletestaff/{{$user->id}}">X</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

