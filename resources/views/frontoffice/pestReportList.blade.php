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
            <li class="breadcrumb-item active" aria-current="page">Relatórios</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <div class="container">
        <div class="container-docs">
            @if(count($report_pest) > 0)
                <table class="table">
                    <caption>Relatório Instalação</caption>
                    <tr>
                        <th>Nº Relatório</th>
                        <th>Data/Hora</th>
                        <th></th>
                    </tr>

                    @foreach($report_pest as $reportPest)
                        <tr>
                            <td>
                                {{$reportPest->id}} Relatório
                            </td>
                            <td>{{$reportPest->updated_at}}</td>
                            <td><a href="/frontoffice/reportPestShow/{{$reportPest->id}}">Ver</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="container-docs">
            @if(count($report_maintenance) > 0)
                    <table class="table">
                        <caption>Relatório Manutenção</caption>
                        <tr>
                            <th>Nº Relatório</th>
                            <th>Data/Hora</th>
                            <th></th>
                        </tr>

                            @foreach($report_maintenance as $reportMaintenance)
                                <tr>
                                    <td>
                                        {{$reportMaintenance->id}} Relatório
                                    </td>
                                    <td>{{$reportMaintenance->updated_at}}</td>
                                    <td><a href="/frontoffice/reportMaintenanceShow/{{$reportMaintenance->id}}">Ver</a></td>
                                </tr>
                            @endforeach
                    </table>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="container-docs">
            @if(count($report_punctual) > 0)
                <table class="table">
                    <caption>Relatório Pontual</caption>
                    <tr>
                        <th>Nº Relatório</th>
                        <th>Data/Hora</th>
                        <th></th>
                    </tr>

                    @foreach($report_punctual as $reportPunctual)
                        <tr>
                            <td>
                                {{$reportPunctual->id}} Relatório
                            </td>
                            <td>{{$reportPunctual->updated_at}}</td>
                            <td><a href="/frontoffice/reportPunctualShow/{{$reportPunctual->id}}">Ver</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="container-docs">
            @if(count($report_warranty) > 0)
                <table class="table">
                    <caption>Relatório Garantia</caption>
                    <tr>
                        <th>Nº Relatório</th>
                        <th>Data/Hora</th>
                        <th></th>
                    </tr>

                    @foreach($report_warranty as $reportWarranty)
                        <tr>
                            <td>
                                {{$reportWarranty->id}} Relatório
                            </td>
                            <td>{{$reportWarranty->updated_at}}</td>
                            <td><a href="/frontoffice/reportWarrantyShow/{{$reportWarranty->id}}">Ver</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

@endsection

<?php $i=0 ?>