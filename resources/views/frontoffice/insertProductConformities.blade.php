@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection


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

    <form action="/frontoffice/records/insertProduct/save" method="POST">
        {{ csrf_field() }}
        <div class="container">
            <table class="table">
                <tr>
                    <th>
                        DATA
                    </th>
                </tr>
                <tr>
                    <td>
                        <label class="label-insertPro" for="report_date">DATA</label>
                        <input type="date" id="date" value="{{$today}}" class="input_insertProd" name="date">
                        <label class="label-insertPro" for="product_name">PRODUTO</label>
                        <input type="text" id="product" class="input_insertProd" name="product">
                        <label class="label-insertPro" for="provider">FORNECEDOR</label>
                        <input type="text" id="provider" class="input_insertProd" name="provider">
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
                            <input type="radio" class="btn-insert" name="temperature" value="c"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" class="btn-insert" name="temperature" value="nc"> NÃO CONFORME
                        </label>
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
                            <input type="radio" class="btn-insert" name="cleaning" value="c"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" class="btn-insert" name="cleaning" value="nc"> NÃO CONFORME
                        </label>
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
                    <td>
                        <label class="btn btn-conforme">
                            <input type="radio" class="btn-insert" name="product_status" value="c"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" class="btn-insert" name="product_status" value="nc"> NÃO CONFORME
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        EMBALAGEM
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="btn btn-conforme">
                            <input type="radio" class="btn-insert" name="package" value="c"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" class="btn-insert" name="package" value="nc"> NÃO CONFORME
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="th-insertProd">
                        ROTULAGEM
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="btn btn-conforme">
                            <input type="radio" class="btn-insert" name="label" value="c"> CONFORME
                        </label>
                        <label class="btn btn-nConforme">
                            <input type="radio" class="btn-insert" name="label" value="nc"> NÃO CONFORME
                        </label>
                    </td>
                </tr>
            </table>
            <button class="btn btn-Val" >Validar</button>
            <a class="btn-history"  href="/frontoffice/records/insertProduct/history">Histórico</a>
        </div>
    </form>

@endsection


{{--
@section('content')
    <form  method="POST" id="add-form" action="/frontoffice/records/insertProduct/save">
        {{ csrf_field() }}
        <div class="container">
            <div class="container-docs">
                <div>
                    <h4 style="text-align:left ; color:#9ac266"> REGISTOS DE ENTRADA DE PRODUTO</h4>
                </div>
                <div>
                    <label style="text-align:center" for="report_date">DATA</label>
                    <input type="date" id="date" class="add-form" name="date">
                </div>
                <div>
                    <label style="text-align:center" for="product_name">PRODUTO</label>
                    <input type="text" id="product" name="product">

                    <label style="text-align:center" for="provider">FORNECEDOR</label>
                    <input type="text" id="provider" name="provider">
                    </div>
                <div>
                    <div>
                        <label style="text-align:center">VEÍCULO</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="temperature">TEMPERATURA</label>
                    </div>
                    <div>
                        <input class="radio_prod" type="radio"  name="temperature" value="c"/>
                        <label class="radio_prod3">CONFORME</label>
                        <input class="radio_prod" type="radio"  name="temperature" value="nc" />
                        <label class="radio_prod2">NÃO CONFORME</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="cleaning">LIMPEZA</label>
                    </div>
                    <div>
                        <input class="radio_prod" type="radio" name="cleaning" value="c" >
                        <label class="radio_prod3" >CONFORME</label>
                        <input  class="radio_prod" type="radio" name="cleaning" value="nc">
                        <label class="radio_prod2" >NÃO CONFORME</label>
                    </div>
                </div>
                <div>
                    <div>
                        <label style="text-align:center">PRODUTO</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="product_status">ESTADO DO PRODUTO</label>
                    </div>
                    <div>
                        <input class="radio_prod" type="radio" name="product_status" value="c">
                        <label class="radio_prod3" >CONFORME</label>
                        <input class="radio_prod" type="radio" name="product_status" value="nc">
                        <label class="radio_prod2" >NÃO CONFORME</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="packing">EMBALAGEM</label>
                    </div>
                    <div>
                        <input class="radio_prod" type="radio" name="package" value="c">
                        <label class="radio_prod3" >CONFORME</label>
                        <input class="radio_prod" type="radio" name="package" value="nc">
                        <label class="radio_prod2" >NÃO CONFORME</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="labeling">ROTULAGEM</label>
                    </div>
                    <div>
                        <input class="radio_prod" type="radio" name="label" value="c" >
                        <label class="radio_prod3" >CONFORME</label>
                        <input class="radio_prod" type="radio" name="label" value="nc" >
                        <label class="radio_prod2" >NÃO CONFORME</label>
                    </div>
                    <div>
                        <button href="/frontoffice/insertProductConformities" class="btnNEXT"><strong>Validar</strong></button>
                        <a class="btn-history"  href="/frontoffice/records/insertProduct/history">Histórico</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection--}}
