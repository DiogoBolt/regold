
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/documents/report.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <div id="reportInfo">
        <div id="divFloatLeft">
            <div>
                <label class="lblBold">Establecimento: </label>
                <label> {{$report->clientName}} </label>
            </div>

            <div >
                <label class="lblBold">Técnico(a) de HACCP: </label>
                <label > {{$report->technicalName}} </label>
            </div>

              <div>
                <label class="lblBold"> Número de Visita: </label>
                <label id="visitNumber"> {{$report->numberVisit}} </label>
            </div>

        </div>
        
        <div id="divFloatRigth">  
             <div>
                <label class="lblBold">Data: </label>
                <label> {{$report->updated_at->toDateString()}} </label>
            </div>

            <div>
                <label class="lblBold">Hora de Início: </label>
                <label>{{$report->created_at->format('H:i')}}</label>
            </div>
    
            <div>
                <label class="lblBold">Hora de Fim: </label>
                <label> {{$report->updated_at->format('H:i')}}</label>
            </div>
        </div>
    </div>
   

    @foreach($arraySections as $section)

        <h1 id="sectionTitle" class="title">{{$section->designation}}</h1>
        
        <div class="tableContainer">
            <table class="table" id="reportRules">
                <tr id="reportRulesTop">
                    <th>#</th>
                    <th>Regra</th>
                    <th>Conforme</th>
                    <th>Não Conforme</th>
                    <th>Não Aplicável</th>
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
                                    <label class="conforme"></label>
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
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
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
                    <th>Regra</th>
                    <th>Corretiva</th>
                </tr>
                <tbody>
                    @if($section->showCorrective == 1)
                        @foreach($reportsAnswers as $rule)
                            @if($rule->corrective!=null && $section->id==$rule->idClientSection)
                                <tr class="tableRow" style="display:table-row">
                                    <th id="correctiveRulesIndex" class="index" value="{{$rule->id}}">{{$rule->index}}</th>
                                    <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                                    <td id="correctiveTd"><label class="corrective" value="{{$rule->corrective}}">{{$rule->corrective}}</label></td>
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
                                    <th id="correctiveRulesIndex" class="index" value="{{$reportSectionOb->idRule}}">{{$reportSectionOb->index}}</th>
                                    <td class="tdRuleBackground">
                                        <label class="corrective" value="{{$reportSectionOb->observation}}">{{$reportSectionOb->observation}}</label>
                                        <input type="hidden" id="idObs" value="{{$reportSectionOb->id}}" />
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

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

        <hr class="line">
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
            </div>
        </div>
    </div>
</div>

<script>

    window.onload = function () {

        setTimeout(window.print, 500);
        setTimeout(function () {
            window.close();
        }, 500);
    };

</script>


    