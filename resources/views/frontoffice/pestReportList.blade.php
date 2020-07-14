@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Relatórios Controlo Pragas</p>
        <div class="container-bar_img">
            <img src="/img/reportPest.png"></a>
        </div>
    </div>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Controlo Pragas</li>
            <li class="breadcrumb-item active" aria-current="page">Documento</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Relatório Instalação</h1>

    <div class="container">
        <div class="container-docs">
            @if(count($report_pest) > 0)
                @foreach($report_pest as $reportPest)
                    <div class="file">
                        <div class="file-head">
                            Relatório {{$reportPest->updated_at->toDateString()}}
                        </div>
                        <div class="file-body" href="/frontoffice/reportPestShow/{{$reportPest->id}}">
                            <a href="/frontoffice/reportPestShow/{{$reportPest->id}}">
                                <img class="file-body__img" src="{{asset('uploads\reports\Report.png')}}">
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Sem Relatórios Realizados.</h2>
            @endif
        </div>
    </div>

    <h1 class="title">Relatório Manutenção/Garantia</h1>

    <div class="container">
        <div class="container-docs">
            @if(count($report_maintenance) > 0)
                @foreach($report_maintenance as $reportMaintenance)
                    <div class="file">
                        <div class="file-head">
                            Relatório {{$reportMaintenance->updated_at->toDateString()}}
                        </div>
                        <div class="file-body" href="/frontoffice/reportMaintenanceShow/{{$reportMaintenance->id}}">
                            <a href="/frontoffice/reportMaintenanceShow/{{$reportMaintenance->id}}">
                                <img class="file-body__img" src="{{asset('uploads\reports\Report.png')}}">
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Sem Relatórios Realizados.</h2>
            @endif
        </div>
    </div>

    <h1 class="title">Relatório Pontual</h1>

    <div class="container">
        <div class="container-docs">
            @if(count($report_punctual) > 0)
                @foreach($report_punctual as $reportPunctual)
                    <div class="file">
                        <div class="file-head">
                            Relatório {{$reportPunctual->updated_at->toDateString()}}
                        </div>
                        <div class="file-body" href="/frontoffice/reportPunctualShow/{{$reportPunctual->id}}">
                            <a href="/frontoffice/reportPunctualShow/{{$reportPunctual->id}}">
                                <img class="file-body__img" src="{{asset('uploads\reports\Report.png')}}">
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Sem Relatórios Realizados.</h2>
            @endif
        </div>
    </div>

@endsection