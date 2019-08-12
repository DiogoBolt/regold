@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">{{$receiver->name}}</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="title">
                            Mensagens: <span class="messages-total"></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div id="messages-container" class="box-body">
                            @foreach($messages as $item)
                                <div class="row msg {{$item->name}}">
                                    <div class="col-xs-12 msg-title">{{$item->created_at}}<span></span></div>
                                    <div class="col-xs-12 msg-body">{{$item->text}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                @if(Auth::user()->sales_id == null)
                <div class="row messages">
                    <form action="/messages/new" method="post">
                        <div class="col-xs-12">
                            <div class="input-group" style="width:400px;">
                                {{ csrf_field() }}
                                <textarea id="messagebody" name="message" placeholder="Escreva aqui a sua mensagem..." class="form-control"></textarea>
                                <input value="{{$id}}" style="display:none" name="id">
                                <span class="input-group-btn">
                        <button type="submit" style="float:left" class="btn btn-success btn-flat">Enviar</button>
                    </span>
                            </div>
                        </div>
                    </form>

                </div>
                    @endif
            </div>
        </div></div>

    @endsection