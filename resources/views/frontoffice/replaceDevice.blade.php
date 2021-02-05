@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/pest.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">

@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Substituição Dispositivo</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    @if($control->firstServicePest==0)
    <a class="back-btn" href="/frontoffice/firstService">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>
    @else
        <a class="back-btn" href="/frontoffice/maintenance">
            <span class="back-btn__front"><strong>Voltar</strong></span>
            <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
        </a>
        @endif

    <h1 class="title">Substituição Dispositivo {{$device->number_device}}-{{$device->type_device}}</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/frontoffice/replaceDevice/save/{{$device->id}}/{{$idReport}}" method="post">
                            {{ csrf_field() }}
                            <div>
                                <label>Instalar novo dispositivo?</label>
                            </div>
                            <div class="form-group">
                                <label for="sim">Sim</label>
                                <input type="radio" onclick="showOptions2()" checked="checked" name="new_device" id="sim" value="sim" required>
                                <label for="nao">Não</label>
                                <input type="radio" onclick="notshowOptions2()"  name="new_device" id="nao" value="nao" required>
                            </div>
                            <div id="geral">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Nº Dispositivo: <input id="num_device" class="form-control" type="text"  name="num_device" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Tipo de Dispositivo:  <select class="form-control" name="type_device" {{--onchange="payType(this)"--}} >
                                            <option disabled selected value="">Selecione o dispositivo</option>
                                            <option value="P">Petit</option>
                                            <option value="G">Glue trapper</option>
                                            <option value="B">Beta</option>
                                            <option value="C">Coral</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    Código Dispositivo: <input id="cod_device" class="form-control" type="text" pattern="[a-z]{1}[0-9]{4}[a-z]{1}}" placeholder="A1234A"  name="cod_device" oninput="validateCodeDeviceExist(this)" >
                                </div>
                                <div class="form-group">
                                    Tipo de Espécie:  <select class="form-control" name="type_specie" {{--onchange="payType(this)"--}} >
                                        <option disabled selected value="">Selecione a Espécie</option>
                                        <option value="Roedores">Roedores</option>
                                        <option value="Blatídeos">Blatídeos</option>
                                        <option value="Formigas">Formigas</option>
                                        <option value="Insectos voadores">Insectos voadores</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    Tipo de Isco:  <select class="form-control" name="type_isco" {{--onchange="payType(this)"--}} >
                                        <option disabled selected value="">Selecione o Isco</option>
                                        <option value="A-Cipermetrina">A-Cipermetrina</option>
                                        <option value="Clotiamidina">Clotiamidina</option>
                                        <option value="Imidaclopride">Imidaclopride</option>
                                        <option value="Telas de cola">Telas de cola</option>
                                        <option value="Brodifacume">Brodifacume</option>
                                        <option value="Bromadiolona">Bromadiolona</option>
                                        <option value="Difenacume">Difenacume</option>
                                        <option value="Fipronil">Fipronil</option>
                                        <option value="Tiametoxam">Tiametoxam</option>
                                    </select>
                                </div>
                            </div>
                            <div id="reason"  class="form-group" hidden>
                                Justificação: <textarea name="reason" class="form-control" ></textarea>
                            </div>

                            <div>
                                <button class="btn btn-add" >Confirmar</button>
                            </div>

                            @if($idReportMain!=null)
                            <a href="/frontoffice/maintenance" type="button" class="btn btn-default" >
                                <strong>Cancelar</strong>
                            </a>
                            @else
                                <a href="/frontoffice/warranty" type="button" class="btn btn-default" >
                                    <strong>Cancelar</strong>
                                </a>
                                @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
