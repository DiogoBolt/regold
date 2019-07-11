@extends('layouts.frontoffice')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Mensagens do Sistema</div>
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
                            </div>
                        </div>


                </div>


    @endsection