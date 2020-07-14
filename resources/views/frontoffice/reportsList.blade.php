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
            <li class="breadcrumb-item active" aria-current="page">Documento</li>
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
                @foreach($reports as $report)
                    <div class="file">
                        <div class="file-head">
                           Relatório {{$report->updated_at->toDateString()}}
                        </div>
                        <div class="file-body" href="/frontoffice/reportShow/{{$report->id}}">
                            <a href="/frontoffice/reportShow/{{$report->id}}">
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
