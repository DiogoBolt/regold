@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE QUALIDADE DO OLEO
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Qualidade do óleo</li>
        </ol>
    </nav>

    <a class="back-btn" href="/frontoffice/documents/Registos">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Registos</strong></span>
    </a>

    <form action="/frontoffice/records/oil/save" method="POST">
        {{ csrf_field() }}
        <div class="container">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <table class="table">
                <tr>
                    <th>
                        DATA
                    </th>
                </tr>
                <tr>
                    <td>
                        <input class="input_insertProd" type="date" value={{$today}} id="record_date" name="record_date">
                        <label class="label-insertPro" for="equipment_name">Nome Equipamento</label>
                        <input name="equipment_name" class="input_insertProd"/>
                        <label class="label-insertPro" for="equipment_number">NºEquipamento</label>
                        <input  name="equipment_number" class="input_insertProd"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        ASPETO
                    </th>
                </tr>
                <tr>
                    <td>
                        <div class="btn-oilVal">
                                <label class="btn btn-oilRecord">
                                    <input type="radio" name="oilAspect" value="1" onclick="notShow()"> 1
                                </label>
                                <label class="btn btn-oilRecord2">
                                    <input type="radio" name="oilAspect" value="2" onclick="notShow()"> 2
                                </label>
                                <label class="btn btn-oilRecord3">
                                    <input type="radio" name="oilAspect" value="3" onclick="notShow()"> 3
                                </label>
                                <label class="btn btn-oilRecord4">
                                    <input type="radio" name="oilAspect" value="4" onclick="show()"> 4
                                </label>
                                <label class="btn btn-oilRecord5">
                                    <input type="radio" name="oilAspect" value="5" onclick="show()"> 5
                                </label>
                        </div>
                        <div class="trocarOleo" id="divTrocarOleo" style="display: none">
                            <input type="radio" name="trocaOleo" value="1">Troquei o óleo
                        </div>
                    </td>
                </tr>
            </table>
            <button class="btn btn-Val" >Validar</button>
            <a class="btn-history"  href="/frontoffice/records/oil/history">Histórico</a>
        </div>
    </form>

@endsection

<script>
    function show() {
        document.getElementById('divTrocarOleo').style.display='inline';
    }
    function notShow() {
        document.getElementById('divTrocarOleo').style.display='none';
    }

</script>