<link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
<link href="{{ asset('css/documents/reportPrint.css') }}" rel="stylesheet">

<script src="{{ URL::asset('/js/report.js') }}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">

                    <div id="divBtns">
                        <a class="btn btn-warning" href="/frontoffice/pestReports">
                            Voltar
                        </a>
                        <button class="btn btn-warning" onclick="printReport()">Imprimir</button>
                    </div>

                    {{--<div style="text-align: center; margin-bottom: 20px;">
                        <img src="\img\regolfoodSmall.png" style="width:100px">
                    </div>--}}

                    <h1 class="title">Relatório Manutenção</h1>

                    <div id="reportInfo">
                        <div id="divFloatLeft">
                            <div>
                                <label class="lblBold">Estabelecimento: </label>
                                <label> {{$report_maintenance->clientName}} </label>
                            </div>
                            <div >
                                <label class="lblBold">Técnico Controlo de Pragas: </label>
                                <label > {{$report_maintenance->technicalName}} </label>
                            </div>
                            <div>
                                <label class="lblBold"> Número de Visita: </label>
                                <label id="visitNumber"> {{$report_maintenance->numberVisit}} </label>
                            </div>
                        </div>

                        <div id="divFloatRigth">
                            <div>
                                <label class="lblBold">Data: </label>
                                <label id="date"> {{$report_maintenance->updated_at->toDateString()}} </label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Início: </label>
                                <label>{{$report_maintenance->created_at->format('H:i')}}</label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Fim: </label>
                                <label> {{$report_maintenance->updated_at->format('H:i')}}</label>
                            </div>
                        </div>

                    </div>
                    <h1 class="title">Ações Desenvolvidas</h1>

                    <div>
                        <label>Foram revistos todos os dispositivos. </label>

                        @if($report_maintenance->pest_presence=='sim')
                        <label>Foi detetada a presença da praga {{$report_maintenance->specie}} e aplicada a substância activa {{$report_maintenance->sub_active}}.  </label>
                        @else
                            <label>Não foi detetada a presença de pragas.  </label>
                            @endif
                    </div>

                    <div class="tableContainer">
                        <table class="table" id="reportRules">
                            <tr id="reportRulesTop">
                                <th class="thBackground">Dispositivo</th>
                                <th class="thBackground">Nº Dispositivo</th>
                                <th class="thBackground">Espécie</th>
                                <th class="thBackground">Isco</th>
                                <th class="thBackground">Estado</th>
                            </tr>
                            <tbody>
                            @foreach($answerDevices as $device)
                                <tr class="tableRow">
                                    <td class="tdBackground tdRule"><label class="rule">{{$device->index}}</label></td>
                                    <td class="tdBackground tdRule"><label class="rule">{{$device->number_device}}</label></td>
                                    <td class="tdBackground tdRule"><label class="rule">{{$device->specie}}</label></td>
                                    <td class="tdBackground tdRule"><label class="rule">{{$device->isco}}</label></td>
                                    <td class="tdBackground tdRule"><label class="rule">{{$device->status}}</label></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            <label class="lblBold" >Recomendações: </label>
                            <label> {{$report_maintenance->note}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>