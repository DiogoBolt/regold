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
            <img src="/img/haccp_icon.png"></a>
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

        {{-- Go Back Button --}}
        <a class="back-btn" href="/frontoffice/documents/">
            <span class="back-btn__front"><strong>Voltar</strong></span>
            <span class="back-btn__back"><strong>Documentos </strong></span>
        </a>
     -->
       {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/HACCP">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>
    
    <h1 id="sectionTitle" class="title">{{$section->designation}}</h1>
    <input type="hidden" id="idSection" value="{{$section->id}}">

    
    <div class="tableContainer">
        <table class="table" id="reportRules">
            <tr id="reportRulesTop">
                <th>#</th>
                <th>Regra</th>
                <th>Conforme</th>
                <th>Não Conforme</th>
                <th onclick="allNotAplly()">Não Aplicável</th>
            </tr>
            <tbody>
                @foreach($rules as $rule)
                <tr class="tableRow" id="{{$rule->idAnswerReport}}"> 
                    <th class="index" value="{{$rule->id}}">{{$rule->index}}</th>
                    <td class="tdBackground tdRule" onclick="focusObs({{$rule->index}})"><label class="rule">{{$rule->rule}}</label></td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'c')
                            <input type=radio onclick="dontShowCorrective({{$rule->index}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" checked/>
                            <label class="conforme" for="c{{$rule->id}}"></label>
                        @else
                          <input type=radio onclick="dontShowCorrective({{$rule->index}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" />
                          <label class="conforme" for="c{{$rule->id}}"></label>
                        @endif
                    </td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'nc')
                            <input type=radio  onclick="showCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" checked />
                            <label class="naoConforme" for="nc{{$rule->id}}"></label>
                        @else 
                            <input type=radio  onclick="showCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" />
                            <label class="naoConforme" for="nc{{$rule->id}}"></label>
                        @endif
                    </td>
                    <td class="tdBackground" name="radio">
                        @if($rule->answer == 'na')
                            <input type=radio  onclick="dontShowCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" checked />
                            <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                        @else
                            <input type=radio  onclick="dontShowCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" />
                            <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($showTableCorrective==1)
        <h3 id="titleCorrective">Medidas Corretivas</h3>
    @else
        <h3 id="titleCorrective" style="display:none">Medidas Corretivas</h3>
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
            </tr>
            <tbody>
                @foreach($rules as $rule)
                    @if($rule->showCorrective==1)
                        <tr class="tableRow" style="display:table-row">
                            <th id="correctiveRulesIndex" class="index" value="{{$rule->id}}">{{$rule->index}}</th>
                            <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                            <td id="correctiveTd"><textarea class="corrective" value="{{$rule->corrective}}">{{$rule->corrective}}</textarea></td>
                        </tr>
                    @else
                        <tr class="tableRow" style="display:none">
                            <th id="correctiveRulesIndex" class="index" value="{{$rule->id}}">{{$rule->index}}</th>
                            <td class="tdRuleBackground"><label class="rule">{{$rule->rule}}</label></td>
                            <td id="correctiveTd"><textarea class="corrective" value="{{$rule->corrective}}">{{$rule->corrective}}</textarea></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <h3 id="titleObservations" style="display:none">Observações</h3>

    <label>{{count($reportSectionObs)}}</label>

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
                            <th id="correctiveRulesIndex" class="index" value="{{$reportSectionOb->idRule}}">{{$reportSectionOb->index}}</th>
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
        <label>Nova Observação:</label>
        <select id="indexObs"> 
            <option value="" disabled selected>Regra</option>
            @foreach($rules as $rule)
                <option value="{{$rule->id}}">{{$rule->index}}</option>
            @endforeach
            </select>
        <input id="iptObs" type="text" placeholder="Insira a observação">
        <button onclick="addObsList()">Save</button>
    </div>
    <button onclick="testarLink({{$section->id}})" id="continue">ContinueLink</button>
    <a href="/frontoffice/forgetSession">Continuar</a>
    <button onclick="addAnswerArray()">ContinuarAddArray</button>
    <button onclick="verifyAnswer()">Teste</button>
@endsection


    