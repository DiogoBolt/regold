@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/pest.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">

@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Relatório Instalação</p>
        <div class="container-bar_img">
            <img src="/img/reportPest.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Instalação 1ºServiço</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="form" action="/frontoffice/savefirstService" method="post">
                            {{ csrf_field() }}
                            <div>
                                <label>Espécie a controlar:</label>
                            </div>
                            <div class="form-group">
                                <label for="roedores">Roedores</label>
                                <input type="radio" name="specie" id="rato" value="Roedores" required>
                                <label for="blatídeos">Blatídeos</label>
                                <input type="radio" name="specie" id="barata" value="Blatídeos" required>
                                <label for="barata">Roedores e Blatídeos</label>
                                <input type="radio" name="specie" id="rato e barata" value="Roedores e Blatídeos" required>
                            </div>

                            @foreach($devices as $device)
                                <div class="file">
                                    <div >
                                        <a>
                                            <img class="img-responsive" src="{{ URL::to('/') }}/img/reportPest.png">
                                        </a>
                                    </div>
                                    <div>
                                        Disp. {{$device->type_device}}-{{$device->number_device}}
                                    </div>
                                </div>
                            @endforeach

                            <a href="/frontoffice/newDevice" class="btn btn-add"><strong>Novo Dispositivo</strong></a>

                            <div>
                                <label>Avaliação das instalações:</label>
                            </div>
                            <div class="form-group">
                                <label for="bom">Bom</label>
                                <input type="radio" name="rating" id="b" value="Bom" required>
                                <label for="satisfatorio">Satisfatório</label>
                                <input type="radio" name="rating" id="s" value="Satisfatório" required>
                                <label for="bom">Não satisfatório</label>
                                <input type="radio" name="rating" id="ns" value="Não satisfatório" required>
                            </div>

                            <div class="form-group">
                                <label>Recomendações: </label>
                                <textarea class="form-control"  name="note"></textarea>
                            </div>
                            @if(count($devices)!=0)
                            <div>
                                <button {{--type="button"--}} {{--data-toggle="modal" data-target="#myModal"--}}  class="btn btn-add" >Concluir</button>
                            </div>
                            @else
                                <div>
                                    <button disabled {{--type="button"--}} {{--data-toggle="modal" data-target="#myModal"--}}  class="btn btn-add" >Concluir</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title" >PIN Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="codes" id="oneCode">
                        <div class="form-group">
                            Insira o Pin:
                            <input name="pin" class="form-control" type="password" placeholder="****" id="pin">
                            <label class="labelError" id="error" style="display: none">Pin Errado!</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="{{$client->ownerID}}" class="btn modal-del" onclick="verifyPin(this.id)">
                        <strong>Confirmar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>--}}

@endsection

