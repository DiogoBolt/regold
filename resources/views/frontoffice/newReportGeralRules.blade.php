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

    <table class="table" id="areasTable">
        <tr>
            <th>Regra</th>
            <th>Conforme</th>
            <th>Não Conforme</th>
            <th>Não Aplicável</th>
        </tr>
        <tbody>
            @foreach($rules as $rule)
            <tr class="tableRow">
                <td><label>{{$rule->rule}}</label></td>
                <td name="radio">
                    <input type=radio  name="radio{{$rule->id}}" value="c" id="c{{$rule->id}}" />
                    <label class="conforme" for="c{{$rule->id}}"></label>
                </td>
                <td name="radio">
                    <input type=radio name="radio{{$rule->id}}" value="nc" id="nc{{$rule->id}}" />
                    <label class="naoConforme" for="nc{{$rule->id}}"></label>
                </td>
                <td name="radio">
                    <input type=radio name="radio{{$rule->id}}" value="na" id="na{{$rule->id}}" />
                    <label class="naoAplicavel" for="na{{$rule->id}}"></label>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button onclick="teste()">Teste</button>
@endsection


    