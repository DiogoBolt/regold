@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$client->name}} <div style="float:right"> <a href="/messages/{{$user->id}}"><img style="width:50px; margin-top:-15px"  src="{{ URL::to('/') }}/img/message.png"></a></div></div>

                <div class="panel-body">

                    <div class="col-sm-6">

                        <div class="form-group">
                            <b>Morada:</b>{{$client->address}}
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


                        @foreach($types as $type)
                            <h4>{{$type->name}}</h4>
                            @foreach($receipts as $receipt)
                                @if($receipt->document_type_id == $type->id)
                            <div class="form-group">
                                <a href="/uploads/{{$client->id}}/{{$receipt->file}}">{{$receipt->file}}</a>
                            </div>
                                @endif
                                @endforeach
                        @endforeach

                        <form action="/clients/addreceipt"  method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                Tipo : <select class="form-control" name="type">
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        <input class="form-control" type="file" name="receipt">
                        <input style="display:none" name="client" value="{{$client->id}}">

                            <button class="btn btn-success">Novo Documento</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
