@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

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
@endsection