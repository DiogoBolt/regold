@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/personalizeSection.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/personalizeSection.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Personalizar Secções </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png">
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
       {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/HACCP">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>
    
    <h1 class="title">Selecione as secções do cliente</h1>



     <div class="divSection">
        <ul id='ulSections' class="ks-cboxtags">
            <input  type="checkbox" onClick="toggle(this)" /> Selecionar tudo<br/>
            @if($control->personalizeSections==0)
                @foreach($sections as $section)
                    <li><input type="checkbox" id="{{$section->name}}1" name="sections[]" value='{"idSection":{{$section->id}},"idClientSection":{{$section->idClientSection}},"activityClientId":{{$section->activityClientId}}}' >
                    <label for="{{$section->name}}1">{{$section->name}}</label></li>
                @endforeach
            @else
                @foreach($sections as $section)
                    @if($section->checked)
                        <li>
                            <input checked type="checkbox" id="{{$section->name}}1" name="sections[]" value='{"idSection":{{$section->id}},"idClientSection":{{$section->idClientSection}},"activityClientId":{{$section->activityClientId}}}' >
                            <label for="{{$section->name}}1">{{$section->name}}</label>
                        </li>
                    @else
                        <li>
                            <input type="checkbox" id="{{$section->name}}1" name="sections[]" value='{"idSection":{{$section->id}},"idClientSection":{{$section->idClientSection}},"activityClientId":{{$section->activityClientId}}}'>
                            <label for="{{$section->name}}1">{{$section->name}}</label>
                        </li>
                    @endif
                @endforeach 
            @endif
            @if(count($clientSections)>0)
                @foreach($clientSections as $clientSection)
                    <li>
                        @if($clientSection->active==1)
                        <input checked type="checkbox" id="{{$clientSection->designation}}" name="sections[]" value='{"idSection":{{$clientSection->id}},"idClientSection":{{$clientSection->id}},"activityClientId":{{$section->activityClientId}}}' >
                        <label for="{{$clientSection->designation}}">{{$clientSection->designation}}</label>
                        @else
                            <input checked type="checkbox" id="{{$clientSection->designation}}" name="sections[]" value='{"idSection":{{$clientSection->id}},"idClientSection":{{$clientSection->id}},"activityClientId":{{$section->activityClientId}}}' >
                            <label for="{{$clientSection->designation}}">{{$clientSection->designation}}</label>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
   
    <button id="newSections" class="btn-del" onclick="showModal('addSection')">Nova Secção</button>
    <button id="saveSections" class="btn-del" onclick="saveSections()">Guardar</button>

     <!-- Modal -->
     <div class="modal fade" id="addSection" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Adicionar Nova Secção</h4>
                </div>
                <div class="modal-body">
                    <div id="allNewsSections">
                        <div class="news" id="oneNew">
                            {{--<select class="form-control" id="selectSection" >
                                <option value="" selected disabled>Secção</option>
                                    @foreach($sections as $section)
                                        <option  class="form-control" value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                            </select>--}}
                            <input type="text" id="idDesignation" name="designation" placeholder="Designação">
                            <i class="fa fa-trash fa-lg" style="display:none" onclick="deleteNewSection(parentNode)"></i>
                        </div>
                    </div>
                    <button id="btnAddNewSection" onclick="clone('addSection')"><i class="fa fa-plus"></i></button>
                </div>
                <div class="modal-footer">
                    <button class="btn modal-del" id="btnAddSections" onclick="addSections()">
                        <strong>Adicionar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script >
    function toggle(oInput) {
        var aInputs = document.getElementsByTagName('input');
        for (var i=0;i<aInputs.length;i++) {
            if (aInputs[i] !== oInput) {
                aInputs[i].checked = oInput.checked;
            }
        }
    }
</script>




    