@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/messages/messages.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">mensagens do sistema</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/mensagens.jpg') }}" />
        </div>
    </div>
    <div class="container">
        <div id="messages-container" class="box-body">
            @foreach($messages as $item)
                <div class="row msg {{$item->name}}">
                    <div class="msg-img">
                        <img src="/img/message.png" />
                    </div>
                    <div class="msg-info">
                        <div class="msg-title"><strong>{{$item->created_at}}</strong><span></span></div>
                        <div class="msg-body">{{$item->text}}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>


@endsection