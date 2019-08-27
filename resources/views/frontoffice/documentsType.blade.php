@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Documentos {{$type}}</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos {{ $super }}</li>
            <li class="breadcrumb-item active" aria-current="page">Documento</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/{{ $super }}">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos {{ $super }}</strong></span>
    </a>

    <div class="container">
        <div class="container-docs">
            
            @if(count($receipts) > 0)
                @foreach($receipts as $receipt)
                    <div class="file">
                        <div class="file-head">
                            {{$receipt->file}}
                        </div>
                        <div class="file-body">
                            <a href="/uploads/{{$client->id}}/{{$receipt->file}}">
                                <img class="file-body__img" src="/uploads/{{$client->id}}/{{$receipt->file}}" />
                            </a>
                        </div>
                    </div>
                @endforeach      
            @else 
                <h2>Sem documentos associados.</h2>
            @endif
        </div>
    </div>


@endsection
