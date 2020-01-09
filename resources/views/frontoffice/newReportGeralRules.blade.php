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
    
    <h1 class="title">Geral</h1>
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
                @foreach($rules as $rule)
                <tr class="tableRow">
                    <th class="index">{{$rule->index}}</th>
                    <td class="tdBackground" onclick="focusObs({{$rule->index}})"><label class="rule">{{$rule->rule}}</label></td>
                    <td class="tdBackground" name="radio">
                        <input type=radio onclick="dontShowCorrective({{$rule->index}})"  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" />
                        <label class="conforme" for="c{{$rule->id}}"></label>
                    </td>
                    <td class="tdBackground" name="radio">
                        <input type=radio  onclick="showCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" />
                        <label class="naoConforme" for="nc{{$rule->id}}"></label>
                    </td>
                    <td class="tdBackground" name="radio">
                        <input type=radio  onclick="dontShowCorrective({{$rule->index}})" name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" />
                        <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h3>Medidas Corretivas</h3>
        
    <div class="tableContainer" id="divCorrectiveRules">
        <table class="table" id="correctiveRules" style="visibility:hidden">
            <tr id="reportRulesTop">
                <th id="correctiveRulesIndex">#</th>
                <th>Regra</th>
                <th>Corretiva</th>
            </tr>
            <tbody>
                @foreach($rules as $rule)
                    <tr class="tableRow" style="display:none">
                        <th id="correctiveRulesIndex" class="index">{{$rule->index}}</th>
                        <td><label class="rule">{{$rule->rule}}</label></td>
                        <td id="correctiveTd"><label class="rule">{{$rule->corrective}}</label></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h3>Observações</h3>
    <ul id="obsList">
    </ul>

    <div id="addObs">
        <select id="indexObs"> 
            <option value="" disabled selected>Regra</option>
            @foreach($rules as $rule)
                <option value="{{$rule->id}}">{{$rule->index}}</option>
            @endforeach
            </select>
        <input id="iptObs" type="text" placeholder="Insira a observação">
        <button onclick="addObsList()">Save</button>
    </div>

    <button onclick="verifyAnswer()">Teste</button>
@endsection


    