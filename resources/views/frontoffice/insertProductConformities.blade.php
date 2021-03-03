@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

<script src="{{ URL::asset('/js/records.js') }}"></script>


@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE ENTRADA DE PRODUTO
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Entrada Produto</li>
        </ol>
    </nav>

    <a class="back-btn" href="/frontoffice/documents/Registos">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Registos</strong></span>
    </a>

    <form id="aaa" action="/frontoffice/records/insertProduct/save" method="POST">
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
                        <label class="label-insertPro" for="report_date">DATA</label>
                        <input type="date" id="date" value="{{$today}}" class="input_insertProd" name="date" required>

                        <label class="label-insertPro" for="product_name">PRODUTO</label>
                            <input list="clientProducts" name="product" class="input_insertProd" required />
                        <datalist id="clientProducts">
                            <option value="" disabled>Produto</option>
                                @foreach($client_insertProducts as $product)
                                    <option value="{{$product->name}}"></option>
                                @endforeach
                        </datalist>

                        <label class="label-insertPro" for="provider_name">FORNECEDOR</label>
                        <input list="clientProviders" name="provid" class="input_insertProd" required />
                        <datalist id="clientProviders">
                            <option value="" disabled>Fornecedor</option>
                            @foreach($client_providers as $provider)
                                <option value="{{$provider->name}}"></option>
                            @endforeach
                        </datalist>

                        <label class="label-insertPro" for="fatura_guia">FATURA/GUIA</label>
                        <input name="fatura" class="input_insertProd" required />
                    </td>
                </tr>
                <tr>
                    <th>
                        VEÍCULO
                    </th>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        TEMPERATURA
                    </td>
                </tr>
                <tr>
                    <td class="td-insertProd">
                        <label class="btn btn-conforme">
                            <input type="radio" id="1" class="btn-insert" name="temperature" value="c" onclick="dontShowInput(1)"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" id="2" class="btn-insert" name="temperature" value="nc" onclick="showInput(2)"> NÃO CONFORME
                        </label>
                        <div id="divTemp" style="display: none">
                            Corretiva:<input type="text" id="provider" class="input_insertProd" name="obsTemperature" >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        LIMPEZA
                    </td>
                </tr>
                <tr>
                    <td class="td-insertProd">
                        <label class="btn btn-conforme">
                            <input type="radio" id="3" class="btn-insert" name="cleaning" value="c" onclick="dontShowInput(3)"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" id="4" class="btn-insert" name="cleaning" value="nc" onclick="showInput(4)"> NÃO CONFORME
                        </label>
                        <div id="divClean" style="display: none">
                            Corretiva:<input type="text" id="provider" class="input_insertProd" name="obsClean">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        PRODUTO
                    </th>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        ESTADO DO PRODUTO
                    </td>
                </tr>
                <tr>
                    <td class="td-insertProd">
                        <label class="btn btn-conforme">
                            <input type="radio" id="5" class="btn-insert" name="product_status" value="c" onclick="dontShowInput(5)"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" id="6" class="btn-insert" name="product_status" value="nc" onclick="showInput(6)"> NÃO CONFORME
                        </label>
                        <div id="divStatus" style="display: none">
                            Corretiva:<input type="text" id="provider" class="input_insertProd" name="obsStatus">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        EMBALAGEM
                    </td>
                </tr>
                <tr>
                    <td class="td-insertProd">
                        <label class="btn btn-conforme">
                            <input type="radio" id="7" class="btn-insert" name="package" value="c" onclick="dontShowInput(7)"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" id="8" class="btn-insert" name="package" value="nc" onclick="showInput(8)"> NÃO CONFORME
                        </label>
                        <div id="divPackage" style="display: none">
                            Corretiva:<input type="text" id="provider" class="input_insertProd" name="obsPackage">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        ROTULAGEM
                    </td>
                </tr>
                <tr>
                    <td class="td-insertProd">
                        <label class="btn btn-conforme">
                            <input type="radio" id="8" class="btn-insert" name="label" value="c" onclick="dontShowInput(9)"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" id="9" class="btn-insert" name="label" value="nc" onclick="showInput(10)"> NÃO CONFORME
                        </label>
                        <div id="divLabel" style="display: none">
                            Corretiva:<input type="text" id="provider" class="input_insertProd" name="obsLabel">
                        </div>
                    </td>
                </tr>
            </table>
            <button class="btn btn-Val" >Validar</button>
            <a class="btn-history"  href="/frontoffice/records/insertProduct/history">Histórico</a>
        </div>

        <input type="file" accept="image/*" name="image">

    </form>


{{--    <button id="snap" onclick="TirarFoto()">Tirar foto</button>

    <div id="container">
        <video autoplay="false" id="videoElement">

        </video>
    </div>--}}


    <button type="button" onclick="init()">Abrir Camera</button>
    <div class="controller">
        <button id="snap">CAPTURE</button>
    </div>
    <button type="button" onclick="LimparFoto()">Limpar Foto</button>

    <div class="video-wrap">
        <video id="video" playsinline autoplay></video>
        <canvas id="canvasvideo" width="640" height="480"></canvas>
    </div>

    <script>

        'use strict';

        const video=document.getElementById('video');
        const canvasvideo=document.getElementById('canvasvideo');
        const snap=document.getElementById('snap');

        const constraints={
            audio: false,
            video:{
                width:640,height:480
            }
        };

        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {

            }
        }

        function handleSuccess(stream){
            window.stream=stream;
            video.srcObject=stream;
        }

        var context=canvasvideo.getContext('2d');
        snap.addEventListener("click",function(){
            context.drawImage(video,0,0,640,480);
        })

        function LimparFoto()
        {
            context.clearRect(0, 0, canvasvideo.width, canvasvideo.height);
        }

    </script>




@endsection
