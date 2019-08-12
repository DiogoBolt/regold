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
                            <img class="img-responsive edit-img" src="/img/navbar/logoindexcolor.png"/>
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
                                <b>Actividade:</b> {{$client->activity}}
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
