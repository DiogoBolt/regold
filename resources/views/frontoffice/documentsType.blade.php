@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Documentos {{$type}}</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos {{ $super }}</li>
            <li class="breadcrumb-item active" aria-current="page">Documento</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/{{ $super }}">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos {{ $super }}</strong></span>
    </a>

    @if($type==3)

    <div class="container">
        <div class="container-docs">

            @if(count($receipts) > 0)
                @foreach($receipts as $receipt)
                    <div class="file">
                        <div class="file-head">
                            {{$receipt->file}}
                        </div>
                        <div class="file-body">
                            <a href="/uploads/{{$client->id}}/{{$receipt->file}}">
                                <img class="file-body__img" src="/uploads/{{$client->id}}/{{$receipt->file}}" />
                            </a>
                        </div>
                    </div>
                @endforeach      
            @else 
                <h2>Sem documentos associados.</h2>
            @endif
        </div>
    </div>
    @endif
    @if($type==29)
        <form action="/frontoffice/documents/{super}/{type}" method="GET" id="add-form">

            <div class="container">
                <div class="container-docs">
                    <div>
                        <h4 style="text-align:left ; color:#9ac266"> REGISTOS DE MUDANÇA DE ÓLEO</h4>
                        <label style="text-align:center" for ="report_date">DATA</label>
                        <input type="date" id="report_date" class="add-form" name="report_date">
                    </div>
                    <div>
                        <h2 style="text-align:center" >ASPETO</h2>
                        <button class="btn btn-oilRecord" id="1"><strong>1</strong></button>
                        <button class="btn btn-oilRecord2" id="2"><strong>2</strong></button>
                        <button class="btn btn-oilRecord3" id="3"><strong>3</strong></button>
                        <button class="btn btn-oilRecord4" id="4"><strong>4</strong></button>
                        <button class="btn btn-oilRecord5" id="5"><strong>5</strong></button>

                        <div>
                            <button class="btn" type="submit" form="add-form">Validar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

@endsection
<script>$("button").click(function() {
        alert(this.id); // or alert($(this).attr('id'));
    });</script>

