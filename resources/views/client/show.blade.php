@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">{{ $client->name }}</p>
    <div class="container-bar_img">
        <a href="/messages/{{$user->id}}"><img style="margin-top: -3px"  src="{{ URL::to('/') }}/img/message.png"></a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <img class="salesman-img img-responsive" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b>Morada:</b> {{$client->address}}
                        </div>
                        <div class="form-group">
                            <b>Morada Faturação:</b> {{$client->invoice_address}}
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
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b> Vendedor:</b> {{$client->salesman}}
                        </div>
                        <div class="form-group">
                            <b>Tipo Cliente:</b> {{$client->client_type}}
                        </div>
                        <div class="form-group">
                            <b> Email Faturação:</b> {{$client->receipt_email}}
                        </div>
                        <div class="form-group">
                            <b> NIB:</b> {{$client->nib}}
                        </div>
                        <div class="form-group">
                            <b> Id Regoldi:</b> {{$client->regoldiID}}
                        </div>
                        <div class="form-group">
                            <b> Valor Contrato:</b> {{$client->contract_value}}
                        </div>
                        <div class="form-group">
                            <b> Nota Transporte:</b> {{$client->transport_note}}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
