@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$client->name}} <div style="float:right"><a href="/frontoffice/client/edit/{{$client->id}}"><img src="/img/settings.png" style="margin-top:-7px;width:33px"></a></div></div>

                <div class="panel-body">

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
                        <button class="btn btn-primary">Editar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
