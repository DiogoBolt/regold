@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-4">
            <a title="Produtos" href="/frontoffice/produtos"><img style="width:100%" src="{{ URL::to('/') }}/img/produtos.jpg"></a>
        </div>

        <div class="col-xs-4">
            <a title="Encomendas" href="/frontoffice/orders"><img style="width:100%" src="{{ URL::to('/') }}/img/encomendas.jpg"></a>
        </div>

        <div class="col-xs-4">
            <a title="Mensagens" href="/frontoffice/messages"><img style="width:100%" src="{{ URL::to('/') }}/img/mensagens.jpg"></a>
        </div>


    </div>

    <div class="row" style="margin-top:30px">

        <div class="col-xs-4">
            <a title="Documentos Contabilisticos" href="/frontoffice/documents/Contabilistico"><img style="width:100%" src="{{ URL::to('/') }}/img/relatorios.jpg"></a>
        </div>
        <div class="col-xs-4">
            <a title="Documentos Pragas" href="/frontoffice/documents/Controlopragas"><img style="width:100%" src="{{ URL::to('/') }}/img/controlodepragas.jpg"></a>
        </div>

        <div class="col-xs-4">
            <a title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img style="width:100%" src="{{ URL::to('/') }}/img/HACCP.jpg"></a>
        </div>
    </div>
        </div>

@endsection
