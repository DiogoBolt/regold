@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Mensagens de Sistema</div>
            <div class="panel-body">
                <div class="row messages">
                    <form action="/messages/newmassmessage" method="post">
                        <div class="col-xs-12">
                            <div class="input-group" style="width:400px;">
                                <select name="target" class="form-control">
                                    <option value="clients">Clientes</option>
                                    <option value="sales">Vendedores</option>
                                </select>
                                {{ csrf_field() }}
                                <textarea id="messagebody" name="message" placeholder="Escreva aqui a sua mensagem..." class="form-control"></textarea>
                                <span class="input-group-btn">
                        <button type="submit" style="float:left" class="btn btn-success btn-flat">Enviar</button>
                    </span>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div></div>

    @endsection