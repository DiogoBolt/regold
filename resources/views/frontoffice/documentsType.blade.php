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

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="container-docs">
            
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
        </div>
    </div>


@endsection
