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
    
    <h1 class="title">Auditoria de Segurança Alimentar</h1>

    <div class="divReportInfo">
        <div>
            <label class="lblBold">Establecimento: </label>
            <label value="{{$establishName->id}}"> {{$establishName->name}} </label>
        </div>

        <div>
            <label class="lblBold">Área de Atividade: </label>
            <label value="{{$establishName->id}}"> {{$establishName->activity}} </label>
        </div>

        <div >
            <label class="lblBold">Auditor: </label>
            <label  value="{{$technicalInfo->id}}"> {{$technicalInfo->name}} </label>
        </div>

        <div>
            <label class="lblBold">Data: </label>
            <label> {{$date}} </label>
        </div>

        <div>
            <label class="lblBold"> Relatório Nº: </label>
            <label id="visitNumber"> {{$visitNumber}} </label>
        </div>

        <button onclick="continueReport()">Próximo</button>

    </div>
    
@endsection


    