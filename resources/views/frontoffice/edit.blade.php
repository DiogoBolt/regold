@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">{{$client->name}}</p>
        <div class="container-bar_img">
            <a href="/frontoffice/client/edit/{{$client->id}}"><img src="/img/settings.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/client">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>{{$client->name}}</strong></span>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <img class="img-responsive edit-img" src="/img/navbar/logoindexcolor.png"/>
                        </div>
                        <div class="col-sm-6">
                            <form action="/frontoffice/editclient/"  method="post">
                                {{ csrf_field() }}

                                <input value="{{$client->id}}" name="id" style="display:none">
                            <div class="form-group">
                                <b>Morada:</b><input  class="form-control" name="address" value="{{$client->address}}">
                            </div>
                            <div class="form-group">
                                <b> Cidade:</b><input class="form-control" name="city" value="{{$client->city}}">
                            </div>
                            <div class="form-group">
                                <b> NIF:</b><input class="form-control" name="nif" value="{{$client->nif}}">
                            </div>
                            <div class="form-group">
                                <b> Email Contacto:</b> <input class="form-control" name="email" value="{{$client->email}}">
                            </div>
                            <div class="form-group">
                                <b>Actividade:</b> <input class="form-control" name="activity" value="{{$client->activity}}">
                            </div>
                            <div class="form-group">
                                <b> Telefone:</b> <input class="form-control" name="telephone" value="{{$client->telephone}}">
                            </div>
                            <div class="form-group">
                                <b> Email Faturação:</b><input class="form-control" name="receipt_email" value="{{$client->receipt_email}}">
                            </div>
                            <div class="form-group">
                                <b> NIB:</b><input class="form-control" name="nib" value="{{$client->nib}}">
                            </div>
                            <button class="btn btn-edit">Editar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
