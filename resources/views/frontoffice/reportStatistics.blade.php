@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/statistics.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">
    
@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Estatísticas</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>

     {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/HACCP">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>
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
     <h1 class="title">Estatísticas</h1>

    <select onchange="changeChart(2)">
        <option>Total</option>
        <option>Geral</option>
        <option>Talho</option>
        <option>Charcutaria</option>
        <option>Peixaria</option>
        <option>Frutas e Legumes</option>
        <option>Cafetaria</option>
        <option>Restauração</option>
        <option>Take-Away</option>
        <option>Padaria e Pastelaria</option>
    </select>

     <div id="chart">
         @foreach($reports as $report)
             {{$report->created_at->format('d-m-y')}}
         @endforeach
     </div>


     <script>
        changeChart(1);
     </script>
@endsection


    