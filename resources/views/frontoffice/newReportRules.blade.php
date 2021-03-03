@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/report.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Novo Relatório</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png">
        </div>
    </div>

    <!--
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home</li>
                <li class="breadcrumb-item " aria-current="page">Documentos </li>
                <li class="breadcrumb-item active" aria-current="page">Documento</li>
            </ol>
        </nav>
     -->
       {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/HACCP">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>
    
    <h1 id="sectionTitle" class="title">{{$section->designation}}</h1>

    <input type="hidden" id="idSection" value="{{$section->id}}">

    @if($section->id==0)

        <div class="tableContainer">
            <table class="table" id="reportRules">
                <tr id="reportRulesTop">
                    <th>#</th>
                    <th>Regra</th>
                    <th onclick="setOptionAll('c')"  ondblclick="forceAll('c')">Conforme</th>
                    <th onclick="setOptionAll('nc')" ondblclick="forceAll('nc')">Não Conforme</th>
                    <th onclick="setOptionAll('na')" ondblclick="forceAll('na')">Não Aplicável</th>
                    <th class="severity">Severidade</th>
                </tr>
                <tbody>
                <?php $i=1 ?>
                @foreach($types as $type)
                    @if(sizeof($type->rules)>0)
                        <tr>
                            <td>{{$type->name}}</td>
                        </tr>
                    @endif
                    @foreach($type->rules as $rule)
                    <tr class="tableRow" id="{{$rule->idAnswerReport}}">
                        <th class="index" value="{{$rule->id}}">{{$i}}</th>
                        <td class="tdBackground tdRule" onclick="focusObs({{$i}})"><label class="rule">{{$rule->rule}}</label></td>
                        <td class="tdBackground" name="radio">
                            @if($rule->answer == 'c')
                                <input type=radio onclick="dontShowCorrective({{$i}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" checked/>
                                <label class="conforme" for="c{{$rule->id}}"></label>
                            @else
                                <input type=radio onclick="dontShowCorrective({{$i}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" />
                                <label class="conforme" for="c{{$rule->id}}"></label>
                            @endif
                        </td>
                        <td class="tdBackground" name="radio">
                            @if($rule->answer == 'nc')
                                <input type=radio  onclick="showCorrective({{$i}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" checked />
                                <label class="naoConforme" for="nc{{$rule->id}}"></label>
                            @else
                                <input type=radio  onclick="showCorrective({{$i}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" />
                                <label class="naoConforme" for="nc{{$rule->id}}"></label>
                            @endif
                        </td>
                        <td class="tdBackground" name="radio">
                            @if($rule->answer == 'na')
                                <input type=radio  onclick="dontShowCorrective({{$i}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" checked />
                                <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                            @else
                                <input type=radio  onclick="dontShowCorrective({{$i}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" />
                                <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                            @endif
                        </td>
                        <td>
                            <div class="divSeverity">
                                <div class="range-slider">
                                    <input class="range-slider__range"  onchange="rangeValue(this)" type="range" value="{{$rule->severityValue}}" min="1" max="5">
                                </div>
                                <input class="inputRangeValue"  type="number" min="1" max="5" value="{{$rule->severityValue}}"/>
                            </div>
                            <label class="lblSeverityStatus">{{$rule->severityText}}</label>
                        </td>
                    </tr>
                    <?php $i++ ?>
                @endforeach
                @endforeach
                </tbody>
            </table>
        </div>

    @else

    <div class="tableContainer">
        <table class="table" id="reportRules">
            <tr id="reportRulesTop">
                <th>#</th>
                <th>Regra</th>
                <th onclick="setOptionAll('c')"  ondblclick="forceAll('c')">Conforme</th>
                <th onclick="setOptionAll('nc')" ondblclick="forceAll('nc')">Não Conforme</th>
                <th onclick="setOptionAll('na')" ondblclick="forceAll('na')">Não Aplicável</th>
                <th class="severity">Severidade</th>
            </tr>
            <tbody>
            <?php $i=1 ?>
            @foreach($types as $type)
                @if(sizeof($type->rules)>0)
                <tr >
                    <td>{{$type->name}}</td>
                </tr>
                @endif
                @foreach($type->rules as $rule)
                <tr class="tableRow" id="{{$rule->idAnswerReport}}">
                    <th class="index" value="{{$rule->id}}">{{$i}}</th>
                    <td class="tdBackground tdRule" onclick="focusObs({{$i}})"><label class="rule">{{$rule->rule}}</label></td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'c')
                            <input type=radio onclick="dontShowCorrective({{$i}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" checked/>
                            <label class="conforme" for="c{{$rule->id}}"></label>
                        @else
                          <input type=radio onclick="dontShowCorrective({{$i}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" />
                          <label class="conforme" for="c{{$rule->id}}"></label>
                        @endif
                    </td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'nc')
                            <input type=radio  onclick="showCorrective({{$i}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" checked />
                            <label class="naoConforme" for="nc{{$rule->id}}"></label>
                        @else 
                            <input type=radio  onclick="showCorrective({{$i}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" />
                            <label class="naoConforme" for="nc{{$rule->id}}"></label>
                        @endif
                    </td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'na')
                            <input type=radio  onclick="dontShowCorrective({{$i}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" checked />
                            <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                        @else
                            <input type=radio  onclick="dontShowCorrective({{$i}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" />
                            <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                        @endif
                    </td>
                    <td> 
                        <div class="divSeverity">
                            <div class="range-slider">
                                <input class="range-slider__range"  onchange="rangeValue(this)" type="range" value="{{$rule->severityValue}}" min="1" max="5">
                            </div>
                            <input class="inputRangeValue"  type="number" min="1" max="5" value="{{$rule->severityValue}}"/>
                        </div>
                        <label class="lblSeverityStatus">{{$rule->severityText}}</label>
                    </td>
                </tr>
                    <?php $i++ ?>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

    @endif

    @if($showTableCorrective==1)
        <h2 id="titleCorrective" class="subTitle">Medidas Corretivas</h2>
    @else
        <h2 id="titleCorrective" style="display:none" class="subTitle">Medidas Corretivas</h2>
    @endif

    <!--<label>{{$showTableCorrective}}</label>-->
    @if($showTableCorrective==1)
        <div class="tableContainer" id="divCorrectiveRules">
    @else
        <div class="tableContainer" id="divCorrectiveRules" style="visibility:hidden">
    @endif

        <table class="table" id="correctiveRules">
            <tr id="reportRulesTop">
                <th id="correctiveRulesIndex">#</th>
                <th>Regra</th>
                <th>Corretiva</th>
                @if($showColumnRecidivist==0)
                    <th style="display:none" class="recidivist">Reincidente</th>
                @else
                    <th class="recidivist">Reincidente</th>
                @endif
            </tr>
            <tbody>
            <?php $i=1 ?>
                @foreach($types as $type)
                    @foreach($type->rules as $rule)
                    @if($rule->showCorrective==1)
                        <tr class="tableRow" style="display:table-row">
                            <th id="correctiveRulesIndex" class="index" value="{{$rule->id}}">{{$i}}</th>
                            <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                            <td id="correctiveTd"><label class="corrective" value="{{$rule->corrective}}">{{$rule->corrective}}</label></td>
                            @if($showColumnRecidivist==0)
                                <td style="display:none" id="recidivistCount" value="{{$rule->recidivistCount}}" ><label>R{{$rule->recidivistCount}}</label></td>
                            @else
                                <td id="recidivistCount" value="{{$rule->recidivistCount}}" ><label>R{{$rule->recidivistCount}}</label></td>
                            @endif
                        </tr>
                    @else
                        <tr class="tableRow" style="display:none">
                            <th id="correctiveRulesIndex" class="index" value="{{$rule->id}}">{{$i}}</th>
                            <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                            <td id="correctiveTd"><label class="corrective" value="{{$rule->corrective}}">{{$rule->corrective}}</label></td>
                            @if($showColumnRecidivist==0)
                                <td style="display:none" id="recidivistCount" value="{{$rule->recidivistCount}}"><label>R{{$rule->recidivistCount}}</label></td>
                            @else
                                <td id="recidivistCount" value="{{$rule->recidivistCount}}" ><label>R{{$rule->recidivistCount}}</label></td>
                            @endif
                        </tr>
                    @endif
                    <?php $i++ ?>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="titleObservations" class="subTitle" style="display:none">Observações</h2>

    @if(count($reportSectionObs)>0)
    <div class="tableContainer" id="divObservationsRules">
    @else
    <div class="tableContainer" id="divObservationsRules" style="visibility:hidden">
    @endif
        <table class="table" id="observations" >
            <tr id="reportRulesTop">
                <th id="correctiveRulesIndex">#</th>
                <th class="tdRuleBackground">Observação</th>
                <th class="trashTd">...</th>
            </tr>
            <tbody>
                @if(count($reportSectionObs)>0)
                    @foreach($reportSectionObs as $reportSectionOb)
                        <tr class="tableRow">
                            @if($reportSectionOb->idRule==0)
                            <th id="correctiveRulesIndex" class="index" value="{{$reportSectionOb->idRule}}">Geral</th>
                            @else
                                <th id="correctiveRulesIndex" class="index" value="{{$reportSectionOb->idRule}}">{{$reportSectionOb->index}}</th>
                            @endif
                            <td class="tdRuleBackground">
                                <textarea class="corrective" value="{{$reportSectionOb->observation}}">{{$reportSectionOb->observation}}</textarea>
                                <input type="hidden" id="idObs" value="{{$reportSectionOb->id}}" />
                            </td>
                            <td class="trashTd">
                                <i class="fas fa-trash" onclick="deleteObs(this)"></i>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div id="addObs">
        <label>Nova Observação</label>
        <br/>
        <select id="indexObs" onchange="verifySelected(this)" >
            <option value="Geral">Geral</option>
            <?php $i=1 ?>
            @foreach($types as $type)
                @foreach($type->rules as $rule)
                <option value="{{$rule->id}}">{{$i}}</option>
                    <?php $i++ ?>
            @endforeach
            @endforeach
        </select>
        <input id="iptObs" oninput="verifyTextInput(this)" type="text" placeholder="Insira a observação">
        <button class="btn-del" onclick="addObsList()">Save</button>
    </div>

    <script>
        var wage = document.getElementById("iptObs");
        wage.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            addObsList();
        }
        });
    </script>

    <div id="divBtns">
        <button class="btn-del" onclick="continueAnswerReport({{$idReport}})" id="continue">Continuar</button>
    </div>
@endsection


    