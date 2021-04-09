@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">{{$user->name}}</p>
        <div class="container-bar_img">
            <a href="/frontoffice/client/edit/{{$client->id}}"><img src="/img/settings.png"></a>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">{{$user->name}}</li>
        </ol>
    </nav>
    

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="col-sm-6">
                            <img class="img-responsive edit-img" src="{{ URL::to('/') }}/img/navbar/logoRegolfood.png"/>

                            <form action="/frontoffice/client/save"  method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input value="{{$client->id}}" style="display:none" name="id">
                                <div class="form-group">
                                    Nova Password: <input class="form-control" value="" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    Novo Pin: <input class="form-control" value="" type="password" name="pin">
                                </div>
                                <div>
                                    <button class="btn btn-Val" >Editar</button>
                                </div>
                            </form>

                        </div>

                        <div class="col-sm-6">

                            <div class="form-group">
                                <b>Morada:</b> {{$client->address}}
                            </div>
                            <div class="form-group">
                                <b> Cidade:</b> {{$client->city}}
                            </div>
                            <div class="form-group">
                                <b> NIF:</b> {{$client->nif}}
                            </div>
                            <div class="form-group">
                                <b> Email Contacto:</b> {{$client->email}}
                            </div>
                            <div class="form-group">
                                <b> Telefone:</b> {{$client->telephone}}
                            </div>
                            <div class="form-group">
                                <b> Metodo Pagamento:</b> {{$client->payment_method}}
                            </div>
                            <div class="form-group">
                                <b> Email Faturação:</b> {{$client->receipt_email}}
                            </div>
                            <div class="form-group">
                                <b> NIB:</b> {{$client->nib}}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
