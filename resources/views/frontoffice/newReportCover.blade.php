@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/report.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/personalizeSection.js') }}"></script>

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
    
    <h1 class="title">Novo Relatório</h1>

    <div class="divReportInfo">
        <div>
            <label class="lblBold">Establecimento: </label>
            <label> {{$establishName->name}} </label>
        </div>

        <div >
            <label class="lblBold">Técnico(a) de HACCP: </label>
            <label> {{$technicalInfo->name}} </label>
        </div>

        <div>
            <label class="lblBold">Data: </label>
            <label> {{$date}} </label>
        </div>

        <div>
            <label class="lblBold"> Número de Visita: </label>
            <label> {{$visitNumber}} </label>
        </div>

         <a href="/frontoffice/newReportGeralRules" id="btnNext">Próximo</a>
    </div>
    
@endsection


    