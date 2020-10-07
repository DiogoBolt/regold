@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Relatórios HACCP</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos HACCP</li>
            <li class="breadcrumb-item active" aria-current="page">Relatórios</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/HACCP">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos HACCP</strong></span>
    </a>

    <div class="container">
        <div class="container-docs">
            @if(count($reports) > 0)
                <table class="table">
                    <caption>Relatórios</caption>
                    <tr>
                        <th>Nº Relatório</th>
                        <th>Data/Hora</th>
                        <th></th>
                    </tr>

                    @foreach($reports as $report)
                        <tr>
                            <td>
                                {{$report->id}} Relatório
                            </td>
                            <td>{{$report->updated_at}}</td>
                            <td><a href="/frontoffice/reportShow/{{$report->id}}">Ver</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h1>Sem Relatórios Realizados.</h1>
            @endif
        </div>
    </div>

@endsection
