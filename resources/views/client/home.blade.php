@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/index/client-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container index-box">
    <div class="box">
        <a title="Encomendas" href="/frontoffice/orders">
            <img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon1.png">
        </a>
        <div class="desc">ENCOMENDAS</div>
    </div>

    <div class="box">
        <a title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon2.png"></a>
        <div class="desc">DOCUMENTOS HACCP</div>
    </div>

    <div class="box">
        <a title="Controlo de Pragas" href="/frontoffice/documents/Controlopragas"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon3.png"></a>
        <div class="desc">CONTROLO DE PRAGAS</div>
    </div>

    <div class="box">
        <a title="Agenda" href="#"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon4.png"></a>
        <div class="desc">AGENDA</div>
    </div>

    <div class="box">
        <a title="Pagamentos" href="#"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon5.png"></a>
        <div class="desc">PAGAMENTOS</div>
    </div>

    <i class="box" aria-hidden="true"></i>

{{-- <a title="Produtos" href="/frontoffice/produtos"><img style="width:100%" src="{{ URL::to('/') }}/img/produtos.jpg"></a>
<a title="Mensagens" href="/frontoffice/messages"><img style="width:100%" src="{{ URL::to('/') }}/img/mensagens.jpg"></a>
<a title="Documentos Contabilisticos" href="/frontoffice/documents/Contabilistico"><img style="width:100%" src="{{ URL::to('/') }}/img/relatorios.jpg"></a> --}}

@endsection
