@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/personalizeSection.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">
@endsection

@section('content')

    <script src="{{ URL::asset('/js/personalizeSection.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Personalizar Secções </p>
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
     <h1 class="title">Secções</h1>
     <div class="divSection">
        <ul class="ulSectionClient">
            @foreach($clientSections as $clientSection)
                @if($clientSection->wasPersonalized==1)
                    <li class="teste">
                        <a class="aWasPersonalized" href="{{url('/frontoffice/personalizeAreasEquipments/personalizeEachSection',$clientSection->id)}}" id="{{$clientSection->id}}">{{$clientSection->designation}}</a>
                    </li>
                @else
                    <li class="teste">
                        <a class="aNotPersonalized" href="{{url('/frontoffice/personalizeAreasEquipments/personalizeEachSection',$clientSection->id)}}" id="{{$clientSection->id}}">{{$clientSection->designation}}</a>
                    </li>
                @endif
            @endforeach     
        </ul>
    </div>
@endsection


    