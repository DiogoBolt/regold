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

     {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/newReport">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

     <h1 class="title">Secções</h1>
     <div class="divSection">
        <ul class="ulSectionClient">
            @foreach($clientSections as $clientSection)
                @if($clientSection->answered)
                    <li class="teste">
                        <a class="aWasPersonalized" href="/frontoffice/newReportRules/{{$idReport}}/{{$clientSection->id}}" id="{{$clientSection->id}}">{{$clientSection->designation}}</a>
                        <!--href="{{url('/frontoffice/personalizeAreasEquipments/personalizeEachSection',$clientSection->id)}}"-->
                    </li>
                @else
                    <li class="teste">
                        <a class="aNotPersonalized" href="/frontoffice/newReportRules/{{$idReport}}/{{$clientSection->id}}" id="{{$clientSection->id}}">{{$clientSection->designation}}</a>
                        <!--href="{{url('/frontoffice/personalizeAreasEquipments/personalizeEachSection',$clientSection->id)}}"-->
                    </li>
                @endif
            @endforeach     
        </ul>
    </div>
    @if(Session::has('sectionsReport'))
        @if(count(Session::get('sectionsReport')) == count($clientSections))
            <a  href="/concluedReport/{{$idReport}}" class="btn btn-success">Concluir Relatório</a>
        @endif
    @endif

@endsection