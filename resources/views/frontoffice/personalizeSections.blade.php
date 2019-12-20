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
     <h1 class="title">Selecione as secções do cliente</h1>
     <div class="divSection">
        <ul id='ulSections' class="ks-cboxtags">
            @foreach($sections as $section)
                <li><input type="checkbox" id="{{$section->name}}1" name="sections[]" value="{{$section->id}}" checked>
                <label for="{{$section->name}}1">{{$section->name}}</label></li>
            @endforeach
        
        <hr id="line">
            <li><input type="checkbox" id="teste" name="sections[]" value="teste" checked>
                <label for="teste">teste</label></li>
        </ul>
    </div>
   

    <button id="newSections" class="btn-del" data-toggle="modal" data-target="#addSection">Nova Secção</button>

     <!-- Modal -->
     <div class="modal fade" id="addSection" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Adicionar Nova Secção</h4>
                </div>
                <div class="modal-body">
                    <div id="allNewSections">
                        <div class="newSections" id="newSection">
                            <select class="form-control" id="selectSection">
                                <option value="" selected disabled>Secção</option>
                                    @foreach($sections as $section)
                                        <option  class="form-control" value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                            </select>
                            <input type="text" id="fname" name="firstname" placeholder="Your name..">  
                        </div>
                        <div class="newSections" id="newSection">
                            <select class="form-control" id="selectSection">
                                <option value="" selected disabled>Secção</option>
                                    @foreach($sections as $section)
                                        <option  class="form-control" value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                            </select>
                            <input type="text" id="fname" name="firstname" placeholder="Your name..">  
                        </div>
                        
                    </div>
                    <button id="btnAddNewSection"><i class="fa fa-plus"></i></button>   
                </div>
                <div class="modal-footer">
                    <button class="btn modal-del" id="addSections" onclick="myFunction()">
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
    