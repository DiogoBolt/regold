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
                        <form action="/frontoffice/savefirstService" method="post">
                            {{ csrf_field() }}
                            <div>
                                <label>Espécie a controlar:</label>
                            </div>
                            <div class="form-group">
                                <label for="rato">Ratos</label>
                                <input type="radio" name="specie" id="rato" value="rato" required>
                                <label for="barata">Baratas</label>
                                <input type="radio" name="specie" id="barata" value="barata" required>
                            </div>

                            @foreach($devices as $device)
                                <div class="file">
                                    <div  {{--href="/frontoffice/reportPestShow/{{$device->id}}"--}}>
                                        <a{{-- href="/frontoffice/reportPestShow/{{$device->id}}"--}}>
                                            <img class="img-responsive" src="{{ URL::to('/') }}/img/reportPest.png">
                                        </a>
                                    </div>
                                    <div>
                                        Dispositivo {{$device->number_device}}
                                    </div>
                                </div>
                            @endforeach

                            <a href="/frontoffice/newDevice" class="btn btn-add"><strong>Novo Dispositivo</strong></a>

                            <div>
                                <label>Avaliação das instalações:</label>
                            </div>
                            <div class="form-group">
                                <label for="bom">Bom</label>
                                <input type="radio" name="rating" id="b" value="b" required>
                                <label for="satisfatorio">Satisfatório</label>
                                <input type="radio" name="rating" id="s" value="s" required>
                                <label for="bom">Não satisfatório</label>
                                <input type="radio" name="rating" id="ns" value="ns" required>
                            </div>

                            <div class="form-group">
                                <label>Recomendações: </label>
                                <textarea class="form-control"  name="note"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-add" >Concluir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection