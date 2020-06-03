@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <form  method="GET" id="add-form">

        <div class="container">
            <div class="container-docs">
                <div>
                    <h4 style="text-align:left ; color:#9ac266"> REGISTOS DE ENTRADA DE PRODUTO</h4>
                </div>
                <div>
                    <div>
                        <label style="text-align:center">VEÍCULO</label>
                    </div>
                    <div>
                        <label style="text-align:center" for="temperature">TEMPERATURA</label>
                    </div>
                    <div>
                        <button class="btn btn-conformities" id="c"><strong>CONFORME</strong></button>
                        <button class="btn btn-nconformities" id="nc"><strong>NÂO CONFORME</strong></button>
                    </div>
                    <div>
                        <label style="text-align:center" for="cleaning">LIMPEZA</label>
                    </div>
                    <div>
                        <button class="btn btn-conformities" id="c"><strong>CONFORME</strong></button>
                        <button class="btn btn-nconformities" id="nc"><strong>NÂO CONFORME</strong></button>
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
                        <button class="btn btn-conformities" id="c"><strong>CONFORME</strong></button>
                        <button class="btn btn-nconformities" id="nc"><strong>NÂO CONFORME</strong></button>
                    </div>
                    <div>
                        <label style="text-align:center" for="packing">EMBALAGEM</label>
                    </div>
                    <div>
                        <button class="btn btn-conformities" id="c"><strong>CONFORME</strong></button>
                        <button class="btn btn-nconformities" id="nc"><strong>NÂO CONFORME</strong></button>
                    </div>
                    <div>
                        <label style="text-align:center" for="labeling">ROTULAGEM</label>
                    </div>
                    <div>
                        <button class="btn btn-conformities" id="c"><strong>CONFORME</strong></button>
                        <button class="btn btn-nconformities" id="nc"><strong>NÂO CONFORME</strong></button>
                    </div>
                    <div>
                        <a href="/frontoffice/insertProductConformities" class="btnNEXT"><strong>Seguinte</strong></a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection