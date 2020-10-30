@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE HIGIENE
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Higiene</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Registos">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Registos</strong></span>
    </a>

    <div class="container">
        @if($errors->any())
            <h4 class="high">{{$errors->first()}}</h4>
        @endif
        <div class="register-info">
            <p> registos de higiene </p>
            <p> {{$today}} </p>
        </div>

        <div class="register-container">

        </div>
        <a class="btn btn-history" href="/frontoffice/records/temperatures/history">histórico</a>
    </div>


@endsection

