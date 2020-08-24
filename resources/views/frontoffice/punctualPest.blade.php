@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/pest.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">

@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Relatório Pontual</p>
        <div class="container-bar_img">
            <img src="/img/reportPest.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Pontual</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/frontoffice/savePunctual" method="post">
                            {{ csrf_field() }}
                            <div>
                                <label>Espécie a controlar:</label>
                            </div>
                            <div class="form-group">
                                <label for="ratos">Ratos</label>
                                <input type="radio" name="specie" id="ratos" value="ratos">
                                <label for="baratas">Baratas</label>
                                <input type="radio" name="specie" id="baratas" value="baratas">
                                <label for="moscas/mosquitos">Moscas/Mosquitos</label>
                                <input type="radio" name="specie" id="moscas/mosquitos" value="moscas/mosquitos">
                                <label for="pulgas">Pulgas</label>
                                <input type="radio" name="specie" id="pulgas" value="pulgas">
                                <label for="traça/gorgulho">Traça/Gorgulho</label>
                                <input type="radio" name="specie" id="traça/gorgulho" value="traça/gorgulho">
                                <label for="outro">Outro</label>
                                <input type="radio" name="specie" id="outro" value="outro">
                            </div>

                            <div id="typeSpecie" class="form-group" >
                                Ação Desenvolvida:  <select class="form-control" name="action" {{--onchange="payType(this)"--}} required>
                                    <option disabled selected value="">Selecione a Ação</option>
                                    <option value="Foi efetivada pulverização localizada">Foi efetivada pulverização localizada</option>
                                    <option value="Foi efetivada pulverização em locais apropriados">Foi efetivada pulverização em locais apropriados</option>
                                    <option value="Foi aplicado gel insecticida em locais apropriados">Foi aplicado gel insecticida em locais apropriados</option>
                                    <option value="Foi susbtituida a tela">Foi susbtituída a tela</option>
                                    <option value="Outra">Outra</option>
                                </select>
                            </div>

                            <div id="subActiva" class="form-group" >
                                Substância Activa:  <select class="form-control" name="subs_active" {{--onchange="payType(this)"--}}required>
                                    <option disabled selected value="">Selecione o Isco</option>
                                    <option value="A-Cipermetrina">A-Cipermetrina</option>
                                    <option value="Clotiamidina">"Clotiamidina</option>
                                    <option value="Imidaclopride">Imidaclopride</option>
                                    <option value="Telas de cola">Telas de cola</option>
                                    <option value="Brodifacume">Brodifacume</option>
                                    <option value="Bromadiolona">Bromadiolona</option>
                                    <option value="Difenacume">Difenacume</option>
                                    <option value="Fipronil">Fipronil</option>
                                    <option value="Tiametoxam">Tiametoxam</option>
                                </select>
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