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

    <form action="/frontoffice/saveOilRecords" method="POST">
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
                        <input class="date" type="date" id="record_date"  name="record_date">
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
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-oilRecord">
                                    <input type="radio" name="oilAspect" value="1"> 1
                                </label>
                                <label class="btn btn-oilRecord2">
                                    <input type="radio" name="oilAspect" value="2"> 2
                                </label>
                                <label class="btn btn-oilRecord3">
                                    <input type="radio" name="oilAspect" value="3"> 3
                                </label>
                                <label class="btn btn-oilRecord4">
                                    <input type="radio" name="oilAspect" value="4"> 4
                                </label>
                                <label class="btn btn-oilRecord5">
                                    <input type="radio" name="oilAspect" value="5"> 5
                                </label>

                            </div>
                            {{--<input type="radio" class="btn btn-oilRecord2" name="oilAspect" onclick="jQuery(this).toggleClass('active')" id="2" value="2">
                            <input type="radio" class="btn btn-oilRecord3" name="oilAspect" onclick="jQuery(this).toggleClass('active')" id="3" value="3">
                            <input type="radio" class="btn btn-oilRecord4" name="oilAspect" onclick="jQuery(this).toggleClass('active')" id="4" value="4">
                            <input type="radio" class="btn btn-oilRecord5" name="oilAspect" onclick="jQuery(this).toggleClass('active')" id="5" value="5">--}}
                        </div>
                    </td>
                </tr>
            </table>
            <button class="btn btn-Val" >Validar</button>
            <a class="btn-history"  href="/frontoffice/records/oil/history">Histórico</a>
        </div>
    </form>









   {{-- <script type="text/javascript">
    function reply_click($clicked_id)
    {
       var x= document.getElementById($clicked_id);
       x.style.borderColor="red";
    }
</script>--}}

@endsection