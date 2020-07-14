<!-- Custom CSS -->
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

                    <h1 class="title">Relatório 1ª Instalação</h1>

                    <div id="reportInfo">
                        <div id="divFloatLeft">
                            <div>
                                <label class="lblBold">Estabelecimento: </label>
                                <label> {{$report_pest->clientName}} </label>
                            </div>
                            <div >
                                <label class="lblBold">Técnico Controlo de Pragas: </label>
                                <label > {{$report_pest->technicalName}} </label>
                            </div>
                            <div>
                                <label class="lblBold"> Número de Visita: </label>
                                <label id="visitNumber"> {{$report_pest->numberVisit}} </label>
                            </div>
                        </div>

                        <div id="divFloatRigth">
                            <div>
                                <label class="lblBold">Data: </label>
                                <label id="date"> {{$report_pest->updated_at->toDateString()}} </label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Início: </label>
                                <label>{{$report_pest->created_at->format('H:i')}}</label>
                            </div>
                            <div>
                                <label class="lblBold">Hora de Fim: </label>
                                <label> {{$report_pest->updated_at->format('H:i')}}</label>
                            </div>
                        </div>
                    </div>
                    <h1 class="title">Ações Desenvolvidas</h1>
                    <div id="reportInfo">
                           <div id="divFloatLeft">
                               <div>
                                   <label class="lblBold">Espécie a controlar: </label>
                                   @if($report_pest->specie == 'barata')
                                       <label>Baratas</label>
                                       @else
                                       <label>Ratos</label>
                                       @endif
                               </div>
                               <div >
                                   <label class="lblBold">Avaliação das instalações: </label>
                                   @if($report_pest->rating=='b')
                                       <label>Bom</label>
                                       @elseif($report_pest->rating=='s')
                                       <label>Satisfatório</label>
                                       @else
                                       <label>Não Satisfatório</label>
                                       @endif
                               </div>
                               <div>
                                   <label>Foi efetuado um serviço de desinsfestação ao local, foram instalados <strong>{{$device->index}}</strong> dispositivos no local. </label>
                               </div>
                           </div>
                       </div>

                    <div class="tableContainer">
                        <table class="table" id="reportRules">
                            <tr id="reportRulesTop">
                                <th class="thBackground">Dispositivo</th>
                                <th class="thBackground">Nº Dispositivo</th>
                                <th class="thBackground">Código Dispositivo</th>
                                <th class="thBackground">Espécie</th>
                                <th class="thBackground">Isco</th>
                            </tr>
                            <tbody>
                            @foreach($devices as $device)
                                    <tr class="tableRow">
                                        <td class="tdBackground tdRule"><label class="rule">{{$device->index}}</label></td>
                                        <td class="tdBackground tdRule"><label class="rule">{{$device->number_device}}</label></td>
                                        <td class="tdBackground tdRule"><label class="rule">{{$device->cod_device}}</label></td>
                                        <td class="tdBackground tdRule"><label class="rule">{{$device->specie}}</label></td>
                                        <td class="tdBackground tdRule"><label class="rule">{{$device->isco}}</label></td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <label class="lblBold" style="color: red">Recomendações: </label>
                        <label> {{$report_pest->note}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
