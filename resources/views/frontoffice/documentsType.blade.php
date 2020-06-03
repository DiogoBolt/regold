@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Documentos {{$type}}</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></img>
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

    @if($type==28)
        <form  method="GET" id="add-form">

            <div class="container">
                <div class="container-docs">
                    <div>
                        <h4 style="text-align:left ; color:#9ac266"> REGISTOS DE ENTRADA DE PRODUTO</h4>
                        <label style="text-align:center" for ="report_date">DATA</label>
                        <input type="date" id="report_date" class="add-form" name="report_date">
                    </div>
                    <div>
                        <label style="text-align:center" for="product_name">PRODUTO</label>
                        <select class="form-control" id="product_name" name="product_name">
                            <option value="" selected disabled>Seleccione produto</option>
                            <option value="Fiambre">Fiambre</option>
                            <option value="Queijo">Queijo</option>
                            <option value="Leite">Leite</option>
                        </select>

                        <label style="text-align:center" for="provider">FORNECEDOR</label>
                        <select class="form-control" id="provider" name="provider">
                            <option value="" selected disabled>Seleccione fornecedor</option>
                            <option value="Rei das carnes">REI DAS CARNES</option>
                            <option value="Rei das carnes222">REI DAS CARNES222</option>
                            <option value="Rei das carnes333">REI DAS CARNES333</option>
                        </select>

                        <div>
                            <a href="/frontoffice/insertProductConformities" class="btnNEXT"><strong>Seguinte</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

@endsection
{{--<script type="text/javascript">
    function reply_click($clicked_id)
    {
       var x= document.getElementById($clicked_id);
       x.style.borderColor="red";
    }
</script>--}}


