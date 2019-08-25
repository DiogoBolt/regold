@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/messages/messages-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Mensagens de Sistema</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/mensagens.jpg') }}" />
        </div>
    </div>

    <div class="container">
       
        <div class="row messages">
            <form action="/messages/newmassmessage" method="post">
                <div class="messages-box" style="width: 400px; margin: 0 auto;">

                    {{ csrf_field() }}

                    <select name="target" class="message-select">
                        <option value="clients">Clientes</option>
                        <option value="sales">Vendedores</option>
                    </select>
                    
                    <textarea id="messagebody" name="message" rows="10" placeholder="Escreva aqui a sua mensagem..." class="form-control"></textarea>
                        
                    <button type="submit" class="btn-send"><strong>Enviar</strong></button>
        
                </div>
            </form>
        </div>
    </div>

    @endsection