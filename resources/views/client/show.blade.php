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
                    <div class="col-sm-12">
                        <img class="salesman-img img-responsive" src="/img/navbar/logoindexcolor.png"/>
                        
                        <button class="btn">
                            <a href="/clients/edit/{{$client->id}}" style="color: #fff;">Editar</a>
                        </button>                    
                    </div>
                    <br/>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b>Designação Comercial:</b> {{$client->comercial_name}}
                        </div>
                        <div class="form-group">
                            <b>Morada de Entrega</b>
                            <br/>
                            {{$client->district}}, {{$client->city}}, {{$client->address}}
                            <br/>
                            Codigo Postal: {{$client->postal_code}}
                        </div>
                        <div class="form-group">
                            <b>Morada Faturação</b>
                            <br/>
                            {{$client->invoice_district}}, {{$client->invoice_city}}, {{$client->address}}
                            <br/>
                            Codigo Postal: {{$client->invoice_postal_code}}
                        </div>
                        <div class="form-group">
                            <b> NIF:</b> {{$client->nif}}
                        </div>
                        <div class="form-group">
                            <b> Email Contacto:</b> {{$user->email}}
                        </div>
                        <div class="form-group">
                            <b>Actividade:</b> {{$client->activity}}
                        </div>
                        <div class="form-group">
                            <b> Telefone:</b> {{$client->telephone}}
                        </div>
                        <div class="form-group">
                            <b> Método de Pagamento:</b> {{$client->payment_method}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b> Vendedor:</b> {{$client->salesman}}
                        </div>
                        <div class="form-group">
                            <b>Tipo Cliente:</b> 
                            @foreach($client->client_type as $type)
                                {{$type}} 
                            @endforeach
                            
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

                    <form action="/clients/addreceipt" class="order-form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input value="{{$client->id}}" type="hidden" name="client">
                        <select name="type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                        </select>

                        <label for="{{$client->id}}" class="btn"><strong>Adicionar Documento</strong></label>
                        <input id="{{$client->id}}" class="input-order" type="file" name="receipt">

                        <button class="btn" style="margin-top: 10px">Associar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
