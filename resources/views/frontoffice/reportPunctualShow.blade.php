<!-- Custom CSS -->
<link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
<link href="{{ asset('css/documents/reportPrint.css') }}" rel="stylesheet">

<script src="{{ URL::asset('/js/report.js') }}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">

                    <img class="logoReport" src="{{ URL::to('/') }}/img/navbar/RegolfoodLogin.png" alt="logo">

                    <div id="divBtns">
                        <a class="btn btn-warning" href="/frontoffice/pestReports">
                            Voltar
                        </a>
                        <button class="btn btn-warning" onclick="printReport()">Imprimir</button>
                    </div>

                    {{--<div style="text-align: center; margin-bottom: 20px;">
                        <img src="\img\regolfoodSmall.png" style="width:100px">
                    </div>--}}

                    <h1 class="title">Relatório Pontual</h1>

                    <div id="reportInfo">
                        <div id="divFloatLeft">
                            <div>
                                <label class="lblBold">Estabelecimento: </label>
                                <label> {{$report_punctual->clientName}} </label>
                            </div>
                            <div >
                                <label class="lblBold">Técnico Controlo de Pragas: </label>
                                <label > {{$report_punctual->technicalName}} </label>
                            </div>
                            <div>
                                <label class="lblBold"> Número de Visita: </label>
                                <label id="visitNumber"> {{$report_punctual->numberVisit}} </label>
                            </div>
                        </div>

                        <div id="divFloatRigth">
                            <div>
                                <label class="lblBold">Data: </label>
                                <label id="date"> {{$report_punctual->updated_at->toDateString()}} </label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Início: </label>
                                <label>{{$report_punctual->created_at->format('H:i')}}</label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Fim: </label>
                                <label> {{$report_punctual->updated_at->format('H:i')}}</label>
                            </div>
                        </div>
                    </div>
                    <h1 class="title">Ações Desenvolvidas</h1>
                    <div id="reportInfo">
                        <div id="divFloatLeft">
                            <div>
                                <label class="lblBold">Espécie a controlar: </label>
                                <label>{{$report_punctual->specie}}</label>

                            </div>
                            <div >
                                <label class="lblBold">Ação Desenvolvida: </label>
                                <label>{{$report_punctual->action}}</label>
                            </div>
                            <div >
                                <label class="lblBold">Substâncias Activas: </label>
                                <label>{{$report_punctual->sub_active}}</label>
                            </div>
                            <div>
                                <label class="lblBold" >Recomendações: </label>
                                <label> {{$report_punctual->note}}</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <footer id="footer" style="display:none" >
                <img class="report_footer" src="{{ URL::to('/') }}/img/footer.png" alt="logo">
            </footer>
        </div>
    </div>
</div>
