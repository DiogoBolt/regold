@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/pest.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">

@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Dispositivo {{$devices->number_device}}</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/warranty">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Dispositivo {{$devices->number_device}}</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/frontoffice/saveDeviceWarranty/{{$devices->id}}" method="post">
                            {{ csrf_field() }}
                            <div>
                                <label class="lblBold">Código Dispositivo: </label>
                                <label> {{$devices->cod_device}} </label>
                            </div>

                            <div>
                                <label>Estado do Dispositivo:</label>
                            </div>
                            <div class="form-group">
                                <label for="intacto">Intacto</label>
                                <input type="radio" name="device_status" id="intacto" value="intacto">
                                <label for="picado">Picado</label>
                                <input type="radio" name="device_status" id="picado" value="picado">
                                <label for="consumido">Consumido</label>
                                <input type="radio" name="device_status" id="consumido" value="consumido">
                                <label for="em falta">Em falta</label>
                                <input type="radio" name="device_status" id="em falta" value="em falta">
                                <label for="inacessivel">Inacessivel</label>
                                <input type="radio" name="device_status" id="inacessivel" value="inacessivel">
                                <label for="deteriorado">Deteriorado</label>
                                <input type="radio" name="device_status" id="deteriorado" value="deteriorado">
                            </div>

                            <div>
                                <button class="btn btn-add" >Concluir</button>
                            </div>

                            <a type="button" class="btn btn-default" href="/frontoffice/warranty">
                                <strong>Cancelar</strong>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection