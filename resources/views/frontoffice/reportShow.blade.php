    <!-- Custom CSS -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ asset('css/documents/reportPrint.css') }}" rel="stylesheet">

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                        <table class="tableContainer">
                            <thead class="report-header">
                                <tr>
                                    <th class="report-header-cell">
                        <img class="logoReport" src="{{ URL::to('/') }}/img/navbar/logoRegolfood.png" alt="logo">
                        
                        <div id="divBtns">
                            <a class="btn btn-warning" href="/frontoffice/reports">
                                Voltar
                            </a>
                            <button class="btn btn-warning" onclick="printReport()">Imprimir</button>
                        </div>

{{--                        <h1 class="title">Relatório HACCP</h1>--}}
                        <div id="reportInfo">
                          <div id="divFloatRigth">
                                <div>
                                    <label class="lblBold">Estabelecimento: </label>
                                    <label class="lblBold"> {{$report->clientName}} </label>
                                </div>
                                <div >
                                    <label class="lblBold">Auditor: </label>
                                    <label class="lblBold"> {{$report->technicalName}} </label>
                                </div>
                                <div>
                                    <label class="lblBold"> Número de Visita: </label>
                                    <label class="lblBold" id="visitNumber"> {{$report->numberVisit}} </label>
                                </div>

                          </div>
                            <div id="divFloatRigth">
                                    <label class="lblBold">Relatório Segurança Alimentar</label>
                                <div>
                                    <label class="lblBold">Data: </label>
                                    <label class="lblBold" id="date"> {{$report->updated_at->toDateString()}} </label>
                                </div>
                                <div>
                                    <label class="lblBold">Hora de Início: </label>
                                    <label class="lblBold">{{$report->created_at->format('H:i')}}</label>
                                </div>
                                <div>
                                    <label class="lblBold">Hora de Fim: </label>
                                    <label class="lblBold"> {{$report->updated_at->format('H:i')}}</label>
                                </div>
                            </div>
                        </div>
                                    </th>
                                </tr>
                            </thead>

                <tbody class="report-content">
                    <tr>
                        <td class="report-content-cell">
                        @foreach($arraySections as $section)
{{--                            <h1 class="title">Relatório HACCP</h1>--}}

                            <h1 id="sectionTitle" class="title">{{$section->designation}}</h1>

                            <p class="tableLegend">Legenda: <b>C-</b> Conforme <b>C- </b>Não Conforme <b>NA-</b> Não Aplicavél</p>
                        
                            <div class="tableContainer">
                                <table class="table" id="reportRules">
                                    <tr id="reportRulesTop">
                                        <th id="correctiveRulesIndex">#</th>
                                        <th class="thBackground">Regra</th>
                                        <th class="thBackground">C</th>
                                        <th class="thBackground">NC</th>
                                        <th class="thBackground">NA</th>
                                        <th class="severity">Severidade</th>
                                    </tr>
                                    <tbody>
                                        @foreach($reportsAnswers as $rule)
                                            @if($section->id==$rule->idClientSection)
                                                <tr class="tableRow"> 
                                                    <th class="index">{{$rule->index}}</th>
                                                    <td class="tdBackground tdRule"><label class="rule">{{$rule->rule}}</label></td>
                                                    <td class="tdBackground" name="radio">
                                                        @if($rule->answer == 'c')
                                                            <input type=radio  checked/>
                                                            <label class="conforme" ></label>
                                                        @else
                                                            <input type=radio />
                                                            <label class="conforme" ></label>
                                                        @endif
                                                    </td>
                                                    <td class="tdBackground" name="radio">
                                                        @if($rule->answer == 'nc')
                                                            <input type=radio checked />
                                                            <label class="naoConforme"></label>
                                                        @else 
                                                            <input type=radio />
                                                            <label class="naoConforme"></label>
                                                        @endif
                                                    </td>
                                                    <td class="tdBackground" name="radio">
                                                        @if($rule->answer == 'na')
                                                            <input type=radio  checked />
                                                            <label class="naoAplicavel" ></label>
                                                        @else
                                                            <input type=radio />
                                                            <label class="naoAplicavel"></label>
                                                        @endif
                                                    </td>
                                                    <td> @if($rule->answer== 'nc')
                                                        <div class="divSeverity">
                                                            <div class="range-slider">
                                                                <input class="range-slider__range" type="range" value="{{$rule->severityAnswer}}" min="1" max="5" disabled>
                                                            </div>
                                                            <label class="lblRangeValue">{{$rule->severityAnswer}}</label>
                                                        </div>
                                                        <label class="lblSeverityStatus">{{$rule->severityText}}</label>
                                                        @else
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="page-break-after:always;"></div>
                            @if($section->showCorrective==1)
                                <h2 id="titleCorrective" class="subTitle">Medidas Corretivas</h2>
                            @else
                                <h2 id="titleCorrective" style="display:none" class="subTitle">Medidas Corretivas</h2>
                            @endif

                            @if($section->showCorrective == 1)
                                <div class="tableContainer" id="divCorrectiveRules">
                            @else
                                <div class="tableContainer" id="divCorrectiveRules" style="visibility:hidden">
                            @endif
                                <table class="table" id="correctiveRules">
                                    <tr id="reportRulesTop">
                                        <th id="correctiveRulesIndex">#</th>
                                        <th id="correctiveRule">Regra</th>
                                        <th id="correctiveRuleCorrective">Corretiva</th>
                                    </tr>
                                    <tbody>
                                        @if($section->showCorrective == 1)
                                            @foreach($reportsAnswers as $rule)
                                                @if($rule->answer=='nc' && $section->id==$rule->idClientSection)
                                                    <tr class="tableRow" style="display:table-row">
                                                        <th class="index" >{{$rule->index}}</th>
                                                        <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                                                        <td id="correctiveTd"><label class="corrective">{{$rule->corrective}}</label></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($section->showObs==1)
                                <h2 id="titleObservations" class="subTitle" >Observações</h2>
                            @else
                                <h2 id="titleObservations" class="subTitle" style="display:none">Observações</h2>
                            @endif

                            @if($section->showObs==1)
                                <div class="tableContainer" id="divObservationsRules">
                            @else
                                <div class="tableContainer" id="divObservationsRules" style="visibility:hidden">
                            @endif
                                <table class="table" id="observations" >
                                    <tr id="reportRulesTop">
                                        <th id="correctiveRulesIndex">#</th>
                                        <th class="tdRuleBackground">Observação</th>
                                    </tr>
                                    <tbody>
                                        @if($section->showObs==1)
                                            @foreach($reportSectionObs as $reportSectionOb)
                                                @if($section->id==$reportSectionOb->idClientSection)
                                                    <tr class="tableRow">
                                                        @if($reportSectionOb->index==0)
                                                        <th class="index">Geral</th>
                                                        @else
                                                            <th class="index">{{$reportSectionOb->index}}</th>
                                                        @endif
                                                        <td class="tdRuleBackground">
                                                            <label class="corrective">{{$reportSectionOb->observation}}</label>
                                                            <input type="hidden" id="idObs" value="{{$reportSectionOb->id}}" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                                        <div style="page-break-after:always;"></div>
                            <div id="chartBar">
                                <h2 id="titleObservations" class="subTitle">Estatísticas</h2>

                                <label>Conforme</label>
                                <div class="progress">
                                        <div class="progress-bar conformeBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$section->conforme}}%">
                                            {{$section->conforme}}%
                                        </div>
                                    </div>

                                <label>Não Conforme</label>
                                <div class="progress">
                                    <div class="progress-bar nConformeBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$section->nConforme}}%">
                                        {{$section->nConforme}}%
                                    </div>
                                </div>

                                <label>Não Aplicavél</label>
                                <div class="progress">
                                    <div class="progress-bar nAplicavelBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$section->nApply}}%">
                                        {{$section->nApply}}%
                                    </div>
                                </div>
                            </div>
                            </div>

                            <hr class="line">
                            <div style="page-break-after:always;"></div>
                        @endforeach

                        <div id="chartBar">
                                
                                <h2 id="titleObservations" class="subTitle">Estatísticas Finais</h2>

                                <label>Conforme</label>
                                <div class="progress">
                                        <div class="progress-bar conformeBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$statiscsGeral->confGeral}}%">
                                            {{$statiscsGeral->confGeral}}%
                                        </div>
                                    </div>

                                <label>Não Conforme</label>
                                <div class="progress">
                                    <div class="progress-bar nConformeBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$statiscsGeral->nConfGeral}}%">
                                        {{$statiscsGeral->nConfGeral}}%
                                    </div>
                                </div>

                                <label>Não Aplicavél</label>
                                <div class="progress">
                                    <div class="progress-bar nAplicavelBar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{$statiscsGeral->nAplly}}%">
                                        {{$statiscsGeral->nAplly}}%
                                    </div>
                                </div>
                            </div>
                    </div>

                        </td>
                    </tr>
                </tbody>
                <tfoot class="report-footer">
                    <tr>
                        <td class="report-content-cell">
                  <footer class="footer_1"id="footer" style="display:none" >
                       <img class="report_footer" src="{{ URL::to('/') }}/img/footer3.png" alt="logo">
                  </footer>
                        </td>
                    </tr>
                </tfoot>
                    </table>
                    <div id="voltarTopo">
                        <a href="#" class="btn btn-warning" id="subir">Voltar ao topo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#subir').click(function(){
                $('html, body').animate({scrollTop:0}, 'slow');
                return false;
            });
        });
    </script>
{{--<script>--}}
{{--/*--}}
{{--window.onload = function () {--}}

{{--    setTimeout(window.print, 500);--}}
{{--    setTimeout(function () {--}}
{{--        window.close();--}}
{{--    }, 500);--}}
{{--};*/--}}

{{--</script>--}}
